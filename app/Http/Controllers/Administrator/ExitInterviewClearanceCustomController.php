<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExitInterview;
use App\Models\ExitInterviewAssets;
use App\Models\StructureOrganizationCustom; 
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;

class ExitInterviewClearanceCustomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        //
        $data = ExitInterview::select('exit_interview.*')->orderBy('id', 'DESC')->join('users','users.id','=','exit_interview.user_id');

        $params['structure'] = getStructureName();
        $params['division'] = OrganisasiDivision::all();
        $params['position'] = OrganisasiPosition::all();

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
                $this->downloadExcel($data->get());
            }
        }

        $params['data'] = $data->get();


        return view('administrator.exitcustom.index')->with($params);

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
    public function detail($id)
    {   
        $params['data'] = ExitInterview::where('id', $id)->first();
        return view('administrator.exitcustom.detail')->with($params);
    }

    public function clearance($id)
    {
        $params['data']      = ExitInterviewAssets::where('exit_interview_id', $id)->get();
        return view('administrator.exitcustom.clearance')->with($params);
    }

    public function downloadExcel($data)
    {
        $params = [];

        $total_loop_header = [];
        $total = 0;
        foreach($data as $no =>  $item)
        {
            foreach($item->assets as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }

         foreach($data as $no =>  $item)
        {
            $params[$no]['No']               = $no+1;
            $params[$no]['Nik)'] = $item->user->nik;
            $params[$no]['Employee Name']    = $item->user->name;
            $params[$no]['Position']         = (isset($item->user->structure->position) ? $item->user->structure->position->name:'').'-'.(isset($item->user->structure->division) ? $item->user->structure->division->name:'');
            $params[$no]['Email']    = $item->user->email;
            $params[$no]['Contact Number']    = $item->user->telepon.'-'.$item->user->mobile_1.'-'.$item->user->mobile_2;
            $params[$no]['Resign Date']    = $item->resign_date;
            $params[$no]['Date Last Work'] = $item->last_work_date;
            $reason='';
            if($item->exit_interview_reason == "")
                $reason = $item->other_reason;
            else
                $reason = $item->exitInterviewReason->label;
            $params[$no]['Reason For Leaving'] = $reason;
            
            $header_aset = max($total_loop_header);
            for($v=0; $v < $header_aset; $v++)
            {
                $params[$no]['ASSET NUMBER '.($v+1)]                = '-';
                $params[$no]['ASSET NAME '.($v+1)]                  = '-';
                $params[$no]['ASSET TYPE '.($v+1)]                  = '-';
                $params[$no]['SERIAL/PLAT NUMBER '.($v+1)]          = '-';
                $params[$no]['ASSET EMPLOYEE CHECKED '.($v+1)]      = '-';
                $params[$no]['ASSET APPROVAL CHECKED '.($v+1)]      = '-';
                $params[$no]['ASSET APPROVAL NAME '.($v+1)]         = '-';
                $params[$no]['ASSET APPROVAL DATE '.($v+1)]         = '-';
            }
            foreach($item->assets as $type => $form)
            {     
                $params[$no]['ASSET NUMBER '.($type+1)]           = $form->asset->asset_number;
                $params[$no]['ASSET NAME '.($type+1)]             = $form->asset->asset_name;
                $params[$no]['ASSET TYPE '.($type+1)]             = isset($form->asset->asset_type->name) ? $form->asset->asset_type->name : '';
                $params[$no]['SERIAL/PLAT NUMBER '.($type+1)]     = $form->asset->purchase_date;
                $params[$no]['ASSET EMPLOYEE CHECKED '.($type+1)] = $form->user_check;
                $params[$no]['ASSET APPROVAL CHECKED '.($type+1)] = $form->approval_check;
                $params[$no]['ASSET APPROVAL NAME '.($type+1)]    = isset($form->userApproved) ? $form->userApproved->name:'';
                $params[$no]['ASSET APPROVAL DATE '.($type+1)]    = $form->date_approved != NULL ? date('d F Y', strtotime($form->date_approved)) : '';       
                 
            }

            // SET HEADER LEVEL APPROVAL
            $level_header = get_exit_header();
            for($a=0; $a < $level_header  ; $a++)
            {
                $params[$no]['APPROVAL STATUS '. ($a+1)]           = '-';
                $params[$no]['APPROVAL NAME '. ($a+1)]           = '-';
                $params[$no]['APPROVAL DATE '. ($a+1)]           = '-';
            }
            foreach ($item->historyApproval as $key => $value) {
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
            }

        }

        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            ''
        ];

        return \Excel::create('Report-Exit-and-Clearance',  function($excel) use($params, $styleHeader){

              $excel->sheet('mysheet',  function($sheet) use($params){

                $sheet->fromArray($params);
                
              });

            $excel->getActiveSheet()->getStyle('A1:IV1')->applyFromArray($styleHeader);

        })->download('xls');
    }
}
