<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Training;
use App\User;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;

class TrainingCustomController extends Controller
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
        $params['division'] = OrganisasiDivision::all();
        $params['position'] = OrganisasiPosition::all();

        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $data = Training::orderBy('id', 'DESC')->select('training.*')->join('users', 'users.id', '=', 'training.user_id')->where('users.project_id', $user->project_id);
        } else
        {
            $data = Training::orderBy('id', 'DESC')->select('training.*')->join('users', 'users.id', '=', 'training.user_id');
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
                $this->downloadExcel($data->get());
            }
        }
        $params['data'] = $data->paginate(50);
        return view('administrator.trainingcustom.index')->with($params);
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
        $params['data'] = Training::where('id', $id)->first();
        return view('administrator.trainingcustom.detail')->with($params);
    }

    public function claim($id)
    {   
        $params['data'] = Training::where('id', $id)->first();
        return view('administrator.trainingcustom.biaya')->with($params);
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        $total_acomodation_header = [];
        $total_meal_header = [];
        $total_daily_header = [];
        $total_other_header = [];

          $total1 = 0;
          $total2 = 0;
          $total3 = 0;
          $total4 = 0;

        foreach($data as $no =>  $item)
        {
            foreach($item->training_acomodation as $type1 => $form1)
            {
                $total1++;
            }
            $total_acomodation_header[] = $total1;
            
            foreach($item->training_allowance as $type2 => $form2)
            {
                $total2++;
            }
            $total_meal_header[] = $total2;

            foreach($item->training_daily as $type3 => $form3)
            {
                $total3++;
            }
            $total_daily_header[] = $total3;

            foreach($item->training_other as $type4 => $form4)
            {
                $total4++;
            }
            $total_other_header[] = $total4;
            
        }
        //dd(max($total_acomodation_header));


        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']                     = $item->user->nik;
            $params[$no]['NAME']                    = $item->user->name;
            $params[$no]['POSITION']                = (isset($item->user->structure->position) ? $item->user->structure->position->name:'').'-'.(isset($item->user->structure->division) ? $item->user->structure->division->name:'');
            $params[$no]['ACTIVITY START DATE']   = date('d F Y', strtotime($item->tanggal_kegiatan_start));
            $params[$no]['ACTIVITY END DATE']     = date('d F Y', strtotime($item->tanggal_kegiatan_end));
            $params[$no]['ACTIVITY TYPE']      = isset($item->training_type)? $item->training_type->name:'';
             $params[$no]['ACTIVITY TOPIC']      = $item->topik_kegiatan;
            $params[$no]['SUBMISSION']     = date('d F Y', strtotime($item->created_at));
            $params[$no]['CLAIM']        = $item->date_submit_actual_bill;

            // SET HEADER ACOMODATION
            $header_acomodation = max($total_acomodation_header);
            for($a=0; $a < $header_acomodation  ; $a++)
            {
                $params[$no]['Acommodation & Transportation Date '. ($a+1)]           = '-';
                $params[$no]['Acommodation & Transportation Description '. ($a+1)]    = '-';
                $params[$no]['Acommodation & Transportation Claimed '. ($a+1)]        = '-';
                $params[$no]['Acommodation & Transportation Approved '. ($a+1)]        = '-';
                $params[$no]['Acommodation & Transportation Note '. ($a+1)]        = '-';
            }
            foreach ($item->training_acomodation as $key => $value) {
                $params[$no]['Acommodation & Transportation Date '. ($key+1)]           = $value->date;
                $params[$no]['Acommodation & Transportation Description '. ($key+1)]    = isset($value->transportation_type)? $value->transportation_type->name:'';
                $params[$no]['Acommodation & Transportation Claimed '. ($key+1)]        = $value->nominal;
                $params[$no]['Acommodation & Transportation Approved '. ($key+1)]        =  $value->nominal_approved;
                $params[$no]['Acommodation & Transportation Note '. ($key+1)]        = $value->note;
            }
            // SET HEADER MEAL ALLOWANCE
            $header_meal = max($total_meal_header);
            for($a=0; $a < $header_meal  ; $a++)
            {
                $params[$no]['Meal Allowance Date '.($a+1)]    = '-';
                $params[$no]['Plafond Meal Allowance '.($a+1)] = '-';
                $params[$no]['Morning Claimed '.($a+1)]     = '-';
                $params[$no]['Morning Approved '.($a+1)]    = '-';
                $params[$no]['Afternoon Claimed '.($a+1)]     = '-';
                $params[$no]['Afternoon Approved '.($a+1)]    = '-';
                $params[$no]['Evening Claimed '.($a+1)]     = '-';
                $params[$no]['Evening Approved '.($a+1)]    = '-';
                $params[$no]['Meal Allowance Note '.($a+1)]    = '-';
            }
            foreach ($item->training_allowance  as $key => $value) {
                $params[$no]['Meal Allowance Date '.($key+1)]    = $value->date;
                $params[$no]['Plafond Meal Allowance '.($key+1)] = $value->meal_plafond;
                $params[$no]['Morning Claimed '.($key+1)]     = $value->morning;
                $params[$no]['Morning Approved '.($key+1)]    = $value->morning_approved;
                $params[$no]['Afternoon Claimed '.($key+1)]     = $value->afternoon;
                $params[$no]['Afternoon Approved '.($key+1)]    = $value->afternoon_approved;
                $params[$no]['Evening Claimed '.($key+1)]     = $value->evening;
                $params[$no]['Evening Approved '.($key+1)]    = $value->evening_approved;
                $params[$no]['Meal Allowance Note '.($key+1)]    = $value->note;
            }
             // SET HEADER DAILY ALLOWANCE
            $header_daily = max($total_daily_header);
            for($a=0; $a < $header_daily  ; $a++)
            {
                $params[$no]['Daily Allowance Date '.($a+1)]       = '-';
                $params[$no]['Plafond Daily Allowance '.($a+1)]    = '-';
                $params[$no]['Daily Claimed '.($a+1)]           = '-';
                $params[$no]['Daily Approved '.($a+1)]          = '-';
                $params[$no]['Daily Allowance Note '.($a+1)]       = '-';
            }
            foreach ($item->training_daily   as $key => $value) {
                $params[$no]['Daily Allowance Date '.($key+1)]    = $value->date;
                $params[$no]['Plafond Daily Allowance '.($key+1)] = $value->daily_plafond;
                $params[$no]['Daily Claimed '.($key+1)]     = $value->daily;
                $params[$no]['Daily Approved '.($key+1)]    = $value->daily_approved;
                $params[$no]['Daily Allowance Note '.($key+1)]    = $value->note;
            }
            // SET HEADER OTHER 
            $header_other = max($total_other_header);
            for($a=0; $a < $header_other  ; $a++)
            {
               $params[$no]['Other Date '.($a+1)]        = '-';
                $params[$no]['Other Description '.($a+1)] = '-';
                $params[$no]['Other Claimed '.($a+1)]     = '-';
                $params[$no]['Other Approved '.($a+1)]    = '-';
                $params[$no]['Other Note '.($a+1)]        = '-';

            }
            foreach ($item->training_other    as $key => $value) {
                $params[$no]['Other Date '.($key+1)]    = $value->date;
                $params[$no]['Other Description '.($key+1)] = $value->daily_plafond;
                $params[$no]['Other Claimed '.($key+1)]     = $value->daily;
                $params[$no]['Other Approved '.($key+1)]    = $value->daily_approved;
                $params[$no]['Other Note '.($key+1)]    = $value->note;
            }

            // SET HEADER LEVEL APPROVAL
            $level_header = get_training_header();
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
                }elseif($value->is_approved == NULL || empty($value->is_approved) || $value->is_approved =="")
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
                }elseif($value->is_approved_claim == NULL || empty($value->is_approved_claim) || $value->is_approved_claim =="")
                {
                    $params[$no]['APPROVAL CLAIM STATUS '. ($key+1)]           = '-';
                }

                $params[$no]['APPROVAL CLAIM NAME '. ($key+1)]           = isset($value->userApprovedClaim) ? $value->userApprovedClaim->name:'';

                $params[$no]['APPROVAL CLAIM DATE '. ($key+1)]           = $value->date_approved_claim != NULL ? date('d F Y', strtotime($value->date_approved_claim)) : ''; 
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

        return \Excel::create('Report-Training-dan-Perjalanan-Dinas-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:IV1')->applyFromArray($styleHeader);
        })->download('xls');
    }
    
}
