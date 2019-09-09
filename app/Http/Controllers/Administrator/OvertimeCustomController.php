<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\OvertimeSheetForm;
use App\User;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;

class OvertimeCustomController extends Controller
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
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data = OvertimeSheet::select('overtime_sheet.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'overtime_sheet.user_id')->where('users.project_id', $user->project_id);
            $params['division'] = OrganisasiDivision::join('users','users.id','=','organisasi_division.user_created')->where('users.project_id', $user->project_id)->select('organisasi_division.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        } else
        {
            $data = OvertimeSheet::select('overtime_sheet.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'overtime_sheet.user_id');
            $params['division'] = OrganisasiDivision::all();
            $params['position'] = OrganisasiPosition::all();
        }

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
        $params['data'] = $data->paginate(50);
        return view('administrator.overtimecustom.index')->with($params);
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
        $params['data'] = OvertimeSheet::where('id', $id)->first();
        return view('administrator.overtimecustom.proses')->with($params);
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
            foreach($item->overtime_form as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }
        
        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']                      = $no+1;
            $params[$no]['NIK']                     = $item->user->nik;
            $params[$no]['NAME']                    = $item->user->name;
            $params[$no]['POSITION']                = (isset($item->user->structure->position) ? $item->user->structure->position->name:'').'-'.(isset($item->user->structure->division) ? $item->user->structure->division->name:'');
            $params[$no]['OVERTIME SUBMISSION']     = $item->created_at;
            $params[$no]['OVERTIME CLAIM']        = $item->date_claim;

            $total=0;
            foreach($item->overtime_form as $type => $form)
            {   
                $type = $type+1;   
                $params[$no]['OVERTIME DATE '.$type]            = $form->tanggal;
                $params[$no]['DESCRIPTION '.$type]              = $form->description;
                $params[$no]['START PRE '.$type]                = $form->awal;
                $params[$no]['END PRE '.$type]                  = $form->akhir;
                $params[$no]['OT (HOURS) PRE '.$type]           = $form->total_lembur;
                $params[$no]['START PRE APPROVED '.$type]       = $form->pre_awal_approved;
                $params[$no]['END PRE APPROVED '.$type]         = $form->pre_akhir_approved;
                $params[$no]['OT (HOURS) PRE APPROVED '.$type]  = $form->pre_total_approved;
                $params[$no]['START CLAIM '.$type]              = $form->awal_claim;
                $params[$no]['END CLAIM '.$type]                = $form->akhir_claim;
                $params[$no]['OT (HOURS) CLAIM '.$type]         = $form->total_lembur_claim;
                $params[$no]['START APPROVED '.$type]           = $form->awal_approved;
                $params[$no]['END APPROVED '.$type]             = $form->akhir_approved;
                $params[$no]['OT (HOURS) APPROVED '.$type]      = $form->total_lembur_approved;
                $params[$no]['OT APPROVED CALCULATED '.$type]   = $form->overtime_calculate;
                $total++;       
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['OVERTIME DATE '.($v+1)]               = '-';
                $params[$no]['DESCRIPTION '.($v+1)]                 = '-';
                $params[$no]['START PRE '.($v+1)]                   = '-';
                $params[$no]['END PRE '.($v+1)]                     = '-';
                $params[$no]['OT (HOURS) PRE '.($v+1)]              = '-';
                $params[$no]['START PRE APPROVED '.($v+1)]          = '-';
                $params[$no]['END PRE APPROVED '.($v+1)]            = '-';
                $params[$no]['OT (HOURS) PRE APPROVED '.($v+1)]     = '-';
                $params[$no]['START CLAIM '.($v+1)]                 = '-';
                $params[$no]['END CLAIM '.($v+1)]                   = '-';
                $params[$no]['OT (HOURS) CLAIM '.($v+1)]            = '-';
                $params[$no]['START APPROVED '.($v+1)]              = '-';
                $params[$no]['END APPROVED '.($v+1)]                = '-';
                $params[$no]['OT (HOURS) APPROVED '.($v+1)]         = '-';
                $params[$no]['OT APPROVED CALCULATED '.($v+1)]      = '-';
            }

            // SET HEADER LEVEL APPROVAL
            $level_header = get_overtime_header();
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
                }elseif($value->is_approved == NULL)
                {
                    $params[$no]['APPROVAL STATUS '. ($key+1)]           = '-';
                }

                $params[$no]['APPROVAL NAME '. ($key+1)]           = isset($value->userApproved) ? $value->userApproved->name:'';

                $params[$no]['APPROVAL DATE '. ($key+1)]           = $value->date_approved != NULL ? date('d F Y', strtotime($value->date_approved)) : ''; 
            }

            for($a=0; $a < $level_header  ; $a++)
            {
                $params[$no]['APPROVAL CLAIM STATUS '. ($a+1)]           = '-';
                $params[$no]['APPROVAL CLAIM NAME '. ($a+1)]             = '-';
                $params[$no]['APPROVAL CLAIM DATE '. ($a+1)]             = '-';

            }

            foreach ($item->historyApproval as $key => $value) {
                //$params[$no]['Approval '. ($key+1)]           = $value->id;

                if($value->is_approved_claim == 1)
                {
                    $params[$no]['APPROVAL CLAIM STATUS '. ($key+1)]           = 'Approved';
                }elseif($value->is_approved_claim == 0)
                {
                    $params[$no]['APPROVAL CLAIM STATUS '. ($key+1)]           = 'Rejected';
                }elseif($value->is_approved_claim == NULL)
                {
                    $params[$no]['APPROVAL CLAIM STATUS '. ($key+1)]           = '-';
                }

                $params[$no]['APPROVAL CLAIM NAME '. ($key+1)]           = isset($value->userApprovedClaim) ? $value->userApprovedClaim->name:'';

                $params[$no]['APPROVAL CLAIM DATE '. ($key+1)]           = $value->date_approved_claim != NULL ? date('d F Y', strtotime($value->date_approved_claim)) : ''; 
            }
        }
        
        return (new \App\Models\KaryawanExport($params, 'Report Overtime Employee ' ))->download('EM-HR.Report-Overtime-'.date('d-m-Y') .'.xlsx');
    }

    public function claim($id)
    {   
        $params['data'] = OvertimeSheet::where('id', $id)->first();
        return view('administrator.overtimecustom.claim')->with($params);
    }
}
