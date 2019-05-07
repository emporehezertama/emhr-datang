<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\User;
use App\Models\StructureOrganizationCustom; 
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;

class MedicalCustomController extends Controller
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
        //
        $data = MedicalReimbursement::select('medical_reimbursement.*')->orderBy('id', 'DESC')->join('users','users.id','=','medical_reimbursement.user_id');
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


        return view('administrator.medicalcustom.index')->with($params);
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
        $params['data'] = MedicalReimbursement::where('id', $id)->first();;
        $params['form'] = MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
        return view('administrator.medicalcustom.edit')->with($params);
    }

    public function downloadExcel($data)
    {
        $params = [];

        $total_loop_header = [];
        foreach($data as $no =>  $item)
        {
            $total = 0;
            foreach($item->form as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['EMPLOYEE ID(NIK)']              = $item->user->nik;
            $params[$no]['EMPLOYEE NAME']    = $item->user->name;
            $params[$no]['POSITION']         = (isset($item->user->structure->position) ? $item->user->structure->position->name:'').'-'.(isset($item->user->structure->division) ? $item->user->structure->division->name:'');
            $params[$no]['DATE OF SUBMITTED']    = date('d F Y', strtotime($item->tanggal_pengajuan));

            $total=0;
            $total_klaim    = 0;
            $total_approve  = 0;
            foreach($item->form as $type => $form)
            {   
                $type = $type+1;
                $params[$no]['RECEIPT DATE '.$type]     = $form->tanggal_kwitansi;
                if($item->user->id == $form->user_family_id)
                {
                    $hubungan = 'My Self';
                }
                else
                {
                    $hubungan = $form->UserFamily->nama;
                }

                $params[$no]['RELATIONSHIP '.$type]         = $hubungan;

                if($item->user->id == $form->user_family_id)
                {
                    $nama_pasien =  isset($form->user_family->name) ? $form->user_family->name : '';
                }
                else
                {
                    $nama_pasien = isset($form->UserFamily->nama) ? $form->UserFamily->nama : '';
                }

                $params[$no]['PATIENT NAME '.$type]      = $nama_pasien;
                $params[$no]['CLAIM TYPE '.$type]        = isset($form->medicalType)? $form->medicalType->name:'' ;
                $params[$no]['RECEIPT NO/ KWITANSI NO '.$type]    = $form->no_kwitansi;
                $params[$no]['QTY '.$type]           = $form->jumlah;
                $total++;       
                $total_klaim    += $form->jumlah;
                $total_approve  += $form->nominal_approve;
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['RECEIPT DATE '.($v+1)]    = "-";
                $params[$no]['RELATIONSHIP '.($v+1)]        = "-";
                $params[$no]['PATIENT NAME '.($v+1)]     = "-";
                $params[$no]['CLAIM TYPE '.($v+1)]     = "-";
                $params[$no]['RECEIPT NO/ KWITANSI NO '.($v+1)]    = "-";
                $params[$no]['QTY '.($v+1)]          = "-";
            }
            $params[$no]['TOTAL CLAIM']      = $total_klaim;
            $params[$no]['TOTAL APPROVED']= $total_approve;

            // SET HEADER LEVEL APPROVAL
            $level_header = get_medical_header();
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

        return \Excel::create('Report-Medical-Reimbursement-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:IV1')->applyFromArray($styleHeader);
        })->download('xls');
    }

}
