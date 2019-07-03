<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\PaymentRequestForm;
use App\User;
use App\Models\StatusApproval;
use App\Models\StructureOrganizationCustom; 
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;

class PaymentRequestCustomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data = PaymentRequest::select('payment_request.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'payment_request.user_id')->where('users.project_id', $user->project_id);
            $params['division'] = OrganisasiDivision::join('users','users.id','=','organisasi_division.user_created')->where('users.project_id', $user->project_id)->select('organisasi_division.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        } else
        {
            $data = PaymentRequest::select('payment_request.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'payment_request.user_id');
            $params['division'] = OrganisasiDivision::all();
            $params['position'] = OrganisasiPosition::all();
        }
        $params['structure'] = getStructureName();
        
        if(request())
        {
            if(!empty(request()->employee_status))
            {
                $data = $data->where('users.organisasi_status', request()->employee_status);
            }

            if((!empty(request()->division_id)) and (empty(request()->position_id))) 
            {   
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_division_id',request()->division_id);
            }
            if((!empty(request()->position_id)) and (empty(request()->division_id)))
            {   
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',request()->position_id);
            }
            if((!empty(request()->position_id)) and (!empty(request()->division_id)))
            {
                $data = $data->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',request()->position_id)->where('structure_organization_custom.organisasi_division_id',request()->division_id);
            }

            if(request()->action == 'download')
            {
                return $this->downloadExcel($data->get());
            }
        }

        $params['data'] = $data->get();

        return view('administrator.paymentrequestcustom.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function proses($id)
    {   

        $params['data'] = PaymentRequest::where('id', $id)->first();
        $params['karyawan']     = User::where('access_id', 2)->get();
        $params['form']         = PaymentRequestForm::where('payment_request_id', $id)->get();

        return view('administrator.paymentrequestcustom.proses')->with($params);
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        $total_loop_header = [];
        foreach($data as $no =>  $item)
        {
            $total = 0;
            foreach($item->payment_request_form as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']              = $item->user->nik;
            $params[$no]['NAME']    = $item->user->name;
            $params[$no]['POSITION']         = (isset($item->user->structure->position) ? $item->user->structure->position->name:'').'-'.(isset($item->user->structure->division) ? $item->user->structure->division->name:'');
            $params[$no]['DATE REQUEST']    = date('d F Y', strtotime($item->created_at));
            $params[$no]['PURPOSE']           = $item->tujuan;
            $params[$no]['PAYMENT METHOD']  = $item->payment_method;
           

            $total=0;
            $total_amount = 0;
            $total_amount_approved = 0;
            foreach($item->payment_request_form as $type => $form)
            {   
                $type = $type+1;
                $params[$no]['TYPE '.$type]             = $form->type_form;
                $params[$no]['DESCRIPTION '.$type]      = $form->description;
                $params[$no]['QUANTITY '.$type]         = $form->quantity;
                $params[$no]['AMOUNT '.$type]           = $form->amount;
                $params[$no]['AMOUNT APPROVED '.$type]  = $form->nominal_approved;
                $params[$no]['NOTE '.$type]  = $form->note;
                $total++; 

                $total_amount +=$form->amount;
                $total_amount_approved +=$form->nominal_approved;      
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['TYPE '. ($v+1)]             = "-";
                $params[$no]['DESCRIPTION '.($v+1)]      = "-";
                $params[$no]['QUANTITY '.($v+1)]         = "-";
                $params[$no]['AMOUNT '.($v+1)]           = "-";
                $params[$no]['AMOUNT APPROVED '.($v+1)]  = "-";
                $params[$no]['NOTE '.($v+1)]  = "-";
            }
            $params[$no]['TOTAL AMOUNT']  = $total_amount;
            $params[$no]['TOTAL AMOUNT APPROVED']  = $total_amount_approved;

            // SET HEADER LEVEL APPROVAL
            $level_header = get_payment_header();
            for($a=0; $a < $level_header  ; $a++)
            {
                $params[$no]['APPROVAL STATUS '. ($a+1)]           = '-';
                $params[$no]['APPROVAL NAME '. ($a+1)]           = '-';
                $params[$no]['APPROVAL DATE '. ($a+1)]           = '-';

            }

            foreach ($item->historyApproval as $key => $value) {
                //$params[$no]['Approval '. ($key+1)]           = $value->id;

                if($value->is_approved == 1)
                {
                    $params[$no]['APPROVAL STATUS '. ($key+1)]           = 'Approved';
                }elseif($value->is_approved == 0)
                {
                    $params[$no]['APPROVAL STATUS '. ($key+1)]           = 'Rejected';
                }else
                {
                    $params[$no]['APPROVAL STATUS '. ($key+1)]           = '-';
                }

                $params[$no]['APPROVAL NAME '. ($key+1)]           = isset($value->userApproved) ? $value->userApproved->name:'';

                $params[$no]['APPROVAL DATE '. ($key+1)]           = $value->date_approved != NULL ? date('d F Y', strtotime($value->date_approved)) : ''; 
                //Status Approval
               //Nama Approval
               //Tanggal Approval
            }
            
        }

        return (new \App\Models\KaryawanExport($params, 'Report Payment Request Employee ' ))->download('EM-HR.Report-Payment-Request-'.date('d-m-Y') .'.xlsx');


        // $styleHeader = [
        //     'font' => [
        //         'bold' => true,
        //     ],
        //     'alignment' => [
        //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        //     ],
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => ['argb' => '000000'],
        //         ],
        //     ],
        //     'fill' => [
        //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        //         'rotation' => 90,
        //         'startColor' => [
        //             'argb' => 'FFA0A0A0',
        //         ],
        //         'endColor' => [
        //             'argb' => 'FFFFFFFF',
        //         ],
        //     ],
        //     ''
        // ];

        // return \Excel::create('Report-Payment-Request-Karyawan',  function($excel) use($params, $styleHeader){
        //       $excel->sheet('mysheet',  function($sheet) use($params){
        //         $sheet->fromArray($params);
        //       });
        //     $excel->getActiveSheet()->getStyle('A1:CA1')->applyFromArray($styleHeader);
        // })->download('xls');
    }

}
