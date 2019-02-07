<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PayrollNet;
use App\Models\Bank;
use App\Models\PayrollNetHistory;
use App\User;
use App\Models\PayrollOthers;
use App\Models\PayrollPtkp;

class PayrollNetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(\Maatwebsite\Excel\Excel $excel)
    {
        $this->excel = $excel;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $result = PayrollNet::select('payrollnet.*')->join('users', 'users.id','=', 'payrollnet.user_id')->orderBy('payrollnet.id', 'DESC');

        if(request())
        {
            if(!empty(request()->is_calculate))
            {
                $result = $result->where('is_calculate', request()->is_calculate );
            }

            if(!empty(request()->jabatan))
            {   
                if(request()->jabatan == 'Direktur')
                {
                    $result = $result->whereNull('users.empore_organisasi_staff_id')->whereNull('users.empore_organisasi_manager_id')->where('users.empore_organisasi_direktur', '<>', '');
                }

                if(request()->jabatan == 'Manager')
                {
                    $result = $result->whereNull('users.empore_organisasi_staff_id')->where('users.empore_organisasi_manager_id', '<>', '');
                }

                if(request()->jabatan == 'Staff')
                {
                    $result = $result->where('users.empore_organisasi_staff_id', '<>', '');
                }
            }

            if(request()->action == 'download')
            {
                $this->downloadExcel($result->get());
            }
        }

        $params['data'] = $result->get();

        return view('administrator.payrollnet.index')->with($params);
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        foreach($data as $k =>  $item)
        {
            $bank = Bank::where('id', $item->bank_id)->first();

            // cek data payroll
            $params[$k]['No']               = $k+1;
            $params[$k]['Employee ID']      = $item->user->nik;
            $params[$k]['Fullname']         = $item->user->name;
            $params[$k]['Status']           = $item->user->organisasi_status ;
            $params[$k]['NPWP']             = $item->user->npwp_number ;
            $params[$k]['Position']         = empore_jabatan($item->user_id);
            $params[$k]['Joint Date']       = $item->user->join_date;
            $params[$k]['Resign Date']      = $item->user->resign_date;

            $params[$k]['Basic Salary']                         = $item->basic_salary;
            $params[$k]['Actual Salary']                        = $item->salary;
            $params[$k]['Call Allowance']                       = $item->call_allowance;
            $params[$k]['Transport Allowance']                  = $item->transport_allowance;
             $params[$k]['Meal Allowance']                      = $item->meal_allow;
            $params[$k]['Homebase Allowance']                   = $item->homebase_allowance;
            $params[$k]['Laptop Allowance']                     = $item->laptop_allowance;
            $params[$k]['Overtime']                             = $item->overtime;
            $params[$k]['Bonus']                                = $item->bonus;
            $params[$k]['Medical']                              = $item->medical_claim ;
            $params[$k]['Remark Medical']                       = $item->remark_medical;
            $params[$k]['Other Income 1']                       = $item->other_income ;
            $params[$k]['Remark Other Income1']                 = $item->remark_other_income;
            $params[$k]['Other Income 2']                       = $item->other_income2 ;
            $params[$k]['Remark Other Income2']                 = $item->remark_other_income2;
            $params[$k]['Total Income']                         = $item->total_income;
            $params[$k]['Deduction 1']                          = $item->deduction1;
            $params[$k]['Remark Deduction1']                    = $item->remark_deduction1;
            $params[$k]['Deduction 2']                          = $item->deduction2;
            $params[$k]['Remark Deduction2']                    = $item->remark_deduction2;
            $params[$k]['Deduction 3']                          = $item->deduction3;
            $params[$k]['Remark Deduction3']                    = $item->remark_deduction3;

            $params[$k]['BPJS Ketengakerjaan 4.24 %']           = $item->bpjs_ketenagakerjaan;
            $params[$k]['BPJS Kesehatan (4%)']                  = $item->bpjs_kesehatan;
            $params[$k]['BPJS Pensiun 2%']                      = $item->bpjs_pensiun;
            $params[$k]['BPJS Ketenagakerjaan 2% ']             = $item->bpjs_ketenagakerjaan2;
            $params[$k]['BPJS Dana Pensiun (1%)']               = $item->bpjs_pensiun2;
            $params[$k]['BPJS Kesehatan (1%)']                  = $item->bpjs_kesehatan2;
            $params[$k]['Yearly Income Tax']                    = $item->yearly_income_tax;
            $params[$k]['PPh21']                                = $item->monthly_income_tax;
            $params[$k]['Total Deduction']                      = $item->total_deduction;
            $params[$k]['Take Home Pay ( Income - Deduction )'] = $item->thp;

            $params[$k]['Acc No']                               = $item->user->nomor_rekening;
            $params[$k]['Acc Name']                             = $item->user->nama_rekening;
            $params[$k]['Bank Name']                            = isset($item->user->bank->name) ? $item->user->bank->name : '';
            $params[$k]['Amount']                               = $item->user->nomor_rekening;
        }

        return \Excel::create('Report-PayrollNet',  function($excel) use($params){

              $excel->sheet('mysheet',  function($sheet) use($params){

                $sheet->fromArray($params);
                
              });
        })->download('xls');
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import()
    {   
        return view('administrator.payrollnet.import');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('administrator.payrollnet.create');
    }

    /**
     * [store description]
     * @return [type] [description]
     */
    public function store(Request $request)
    {
        $temp = new PayrollNet();

        if((!isset($request->salary) || empty($request->salary)) && (!isset($request->salary) || empty($request->salary))) {
             return redirect()->route('administrator.payrollnet.create')->with('message-error', 'Employee Name & Actual Salary can not empty');

        } else {
        if(!isset($request->basic_salary) || empty($request->basic_salary)) $request->basic_salary = 0;
        if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
        if(!isset($request->call_allowance) || empty($request->call_allowance)) $request->call_allowance = 0;
        if(!isset($request->transport_allowance) || empty($request->transport_allowance)) $request->transport_allowance = 0;
        if(!isset($request->meal_allow) || empty($request->meal_allow)) $request->meal_allow = 0;
        if(!isset($request->homebase_allowance) || empty($request->homebase_allowance)) $request->homebase_allowance = 0;
        if(!isset($request->laptop_allowance) || empty($request->laptop_allowance)) $request->laptop_allowance = 0;
        if(!isset($request->overtime) || empty($request->overtime)) $request->overtime = 0;
        if(!isset($request->bonus) || empty($request->bonus)) $request->bonus = 0;
        if(!isset($request->medical_claim) || empty($request->medical_claim)) $request->medical_claim = 0;
        if(!isset($request->other_income) || empty($request->other_income)) $request->other_income = 0;
        if(!isset($request->other_income2) || empty($request->other_income2)) $request->other_income2 = 0;
        if(!isset($request->total_income) || empty($request->total_income)) $request->total_income = 0;
        if(!isset($request->deduction1) || empty($request->deduction1)) $request->deduction1 = 0;
        if(!isset($request->deduction2) || empty($request->deduction2)) $request->deduction2 = 0;
        if(!isset($request->deduction3) || empty($request->deduction3)) $request->deduction3 = 0;
        if(!isset($request->total_deduction) || empty($request->total_deduction)) $request->total_deduction = 0;
        if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;
        if(!isset($request->ot_normal_hours) || empty($request->ot_normal_hours)) $request->ot_normal_hours = 0;
        if(!isset($request->yearly_income_tax) || empty($request->yearly_income_tax)) $request->yearly_income_tax = 0;
        if(!isset($request->monthly_income_tax) || empty($request->monthly_income_tax)) $request->monthly_income_tax = 0;
        if(!isset($request->bpjs_ketenagakerjaan) || empty($request->bpjs_ketenagakerjaan)) $request->bpjs_ketenagakerjaan = 0;
        if(!isset($request->bpjs_kesehatan) || empty($request->bpjs_kesehatan)) $request->bpjs_kesehatan = 0;
        if(!isset($request->bpjs_pensiun) || empty($request->bpjs_pensiun)) $request->bpjs_pensiun = 0;
        if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
        if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
        if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;
       
        
        $temp->user_id              = $request->user_id;
        $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->call_allowance       = str_replace(',', '', $request->call_allowance);
        $temp->transport_allowance  = str_replace(',', '', $request->transport_allowance);
        $temp->meal_allow           = str_replace(',', '', $request->meal_allow);
        $temp->homebase_allowance   = str_replace(',', '', $request->homebase_allowance);
        $temp->laptop_allowance     = str_replace(',', '', $request->laptop_allowance);
        $temp->overtime             = str_replace(',', '', $request->overtime); 
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->medical_claim        = str_replace(',', '', $request->medical_claim);
        $temp->remark_medical       = str_replace(',', '', $request->remark_medical);
        $temp->other_income         = str_replace(',', '', $request->other_income);
        $temp->remark_other_income  = str_replace(',', '', $request->remark_other_income);
        $temp->other_income2        = str_replace(',', '', $request->other_income2);
        $temp->remark_other_income2 = str_replace(',', '', $request->remark_other_income2); 
        $temp->total_income         = str_replace(',', '', $request->total_income); 
        $temp->deduction1           = str_replace(',', '', $request->deduction1); 
        $temp->remark_deduction1    = str_replace(',', '', $request->remark_deduction1); 
        $temp->deduction2           = str_replace(',', '', $request->deduction2);
        $temp->remark_deduction2    = str_replace(',', '', $request->remark_deduction2);
        $temp->deduction3           = str_replace(',', '', $request->deduction3);
        $temp->remark_deduction3    = str_replace(',', '', $request->remark_deduction3);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->thp                  = str_replace(',', '', $request->thp);
        $temp->ot_normal_hours      = str_replace(',', '', $request->ot_normal_hours);
        $temp->yearly_income_tax    = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax   = str_replace(',', '', $request->monthly_income_tax);
        $temp->bpjs_ketenagakerjaan = str_replace(',', '',$request->bpjs_ketenagakerjaan);
        $temp->bpjs_kesehatan       = str_replace(',', '',$request->bpjs_kesehatan);
        $temp->bpjs_pensiun         = str_replace(',', '',$request->bpjs_pensiun);
        $temp->bpjs_ketenagakerjaan2= str_replace(',', '',$request->bpjs_ketenagakerjaan2);
        $temp->bpjs_kesehatan2      = str_replace(',', '',$request->bpjs_kesehatan2);
        $temp->bpjs_pensiun2        = str_replace(',', '',$request->bpjs_pensiun2);

        $temp->is_calculate         = 1;
        
        $temp->save();
        $payroll_id = $temp->id;

        // Insert History
        $temp = new PayrollNetHistory();
        $temp->payroll_id            = $payroll_id;
        $temp->user_id              = $request->user_id;
        $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->call_allowance       = str_replace(',', '', $request->call_allowance);
        $temp->transport_allowance  = str_replace(',', '', $request->transport_allowance);
        $temp->meal_allow           = str_replace(',', '',$request->meal_allow);
        $temp->homebase_allowance   = str_replace(',', '', $request->homebase_allowance);
        $temp->laptop_allowance     = str_replace(',', '', $request->laptop_allowance);
        $temp->overtime             = str_replace(',', '', $request->overtime); 
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->medical_claim        = str_replace(',', '', $request->medical_claim);
        $temp->remark_medical       = str_replace(',', '', $request->remark_medical);
        $temp->other_income         = str_replace(',', '', $request->other_income);
        $temp->remark_other_income  = str_replace(',', '', $request->remark_other_income);
        $temp->other_income2        = str_replace(',', '', $request->other_income2);
        $temp->remark_other_income2 = str_replace(',', '', $request->remark_other_income2); 
        $temp->total_income         = str_replace(',', '', $request->total_income); 
        $temp->deduction1           = str_replace(',', '', $request->deduction1); 
        $temp->remark_deduction1    = str_replace(',', '', $request->remark_deduction1); 
        $temp->deduction2           = str_replace(',', '', $request->deduction2);
        $temp->remark_deduction2    = str_replace(',', '', $request->remark_deduction2);
        $temp->deduction3           = str_replace(',', '', $request->deduction3);
        $temp->remark_deduction3    = str_replace(',', '', $request->remark_deduction3);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->thp                  = str_replace(',', '', $request->thp);
        $temp->ot_normal_hours      = str_replace(',', '', $request->ot_normal_hours);
        $temp->yearly_income_tax    = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax   = str_replace(',', '', $request->monthly_income_tax);
        $temp->bpjs_ketenagakerjaan = str_replace(',', '',$request->bpjs_ketenagakerjaan);
        $temp->bpjs_kesehatan       = str_replace(',', '',$request->bpjs_kesehatan);
        $temp->bpjs_pensiun         = str_replace(',', '',$request->bpjs_pensiun);
        $temp->bpjs_ketenagakerjaan2= str_replace(',', '',$request->bpjs_ketenagakerjaan2);
        $temp->bpjs_kesehatan2      = str_replace(',', '',$request->bpjs_kesehatan2);
        $temp->bpjs_pensiun2        = str_replace(',', '',$request->bpjs_pensiun2);
        
        $temp->save();

        return redirect()->route('administrator.payrollnet.index')->with('message-success', 'Data successfully saved !');

        }
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        $temp = PayrollNet::where('id', $id)->first();

        if(!isset($request->basic_salary) || empty($request->basic_salary)) $request->basic_salary = 0;
        if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
        if(!isset($request->call_allowance) || empty($request->call_allowance)) $request->call_allowance = 0;
        if(!isset($request->transport_allowance) || empty($request->transport_allowance)) $request->transport_allowance = 0;
        if(!isset($request->meal_allow) || empty($request->meal_allow)) $request->meal_allow = 0;
        if(!isset($request->homebase_allowance) || empty($request->homebase_allowance)) $request->homebase_allowance = 0;
        if(!isset($request->laptop_allowance) || empty($request->laptop_allowance)) $request->laptop_allowance = 0;
        if(!isset($request->overtime) || empty($request->overtime)) $request->overtime = 0;
        if(!isset($request->bonus) || empty($request->bonus)) $request->bonus = 0;
        if(!isset($request->medical_claim) || empty($request->medical_claim)) $request->medical_claim = 0;
        if(!isset($request->other_income) || empty($request->other_income)) $request->other_income = 0;
        if(!isset($request->other_income2) || empty($request->other_income2)) $request->other_income2 = 0;
        if(!isset($request->total_income) || empty($request->total_income)) $request->total_income = 0;
        if(!isset($request->deduction1) || empty($request->deduction1)) $request->deduction1 = 0;
        if(!isset($request->deduction2) || empty($request->deduction2)) $request->deduction2 = 0;
        if(!isset($request->deduction3) || empty($request->deduction3)) $request->deduction3 = 0;
        if(!isset($request->total_deduction) || empty($request->total_deduction)) $request->total_deduction = 0;
        if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;
        if(!isset($request->ot_normal_hours) || empty($request->ot_normal_hours)) $request->ot_normal_hours = 0;
        if(!isset($request->yearly_income_tax) || empty($request->yearly_income_tax)) $request->yearly_income_tax = 0;
        if(!isset($request->monthly_income_tax) || empty($request->monthly_income_tax)) $request->monthly_income_tax = 0;
        if(!isset($request->bpjs_ketenagakerjaan) || empty($request->bpjs_ketenagakerjaan)) $request->bpjs_ketenagakerjaan = 0;
        if(!isset($request->bpjs_kesehatan) || empty($request->bpjs_kesehatan)) $request->bpjs_kesehatan = 0;
        if(!isset($request->bpjs_pensiun) || empty($request->bpjs_pensiun)) $request->bpjs_pensiun = 0;
        if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
        if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
        if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;


        $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->call_allowance       = str_replace(',', '', $request->call_allowance);
        $temp->transport_allowance  = str_replace(',', '', $request->transport_allowance);
        $temp->meal_allow           = str_replace(',', '',$request->meal_allow);
        $temp->homebase_allowance   = str_replace(',', '', $request->homebase_allowance);
        $temp->laptop_allowance     = str_replace(',', '', $request->laptop_allowance);
        $temp->overtime             = str_replace(',', '', $request->overtime); 
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->medical_claim        = str_replace(',', '', $request->medical_claim);
        $temp->remark_medical       = str_replace(',', '', $request->remark_medical);
        $temp->other_income         = str_replace(',', '', $request->other_income);
        $temp->remark_other_income  = str_replace(',', '', $request->remark_other_income);
        $temp->other_income2        = str_replace(',', '', $request->other_income2);
        $temp->remark_other_income2 = str_replace(',', '', $request->remark_other_income2); 
        $temp->total_income         = str_replace(',', '', $request->total_income); 
        $temp->deduction1           = str_replace(',', '', $request->deduction1); 
        $temp->remark_deduction1    = str_replace(',', '', $request->remark_deduction1); 
        $temp->deduction2           = str_replace(',', '', $request->deduction2);
        $temp->remark_deduction2    = str_replace(',', '', $request->remark_deduction2);
        $temp->deduction3           = str_replace(',', '', $request->deduction3);
        $temp->remark_deduction3    = str_replace(',', '', $request->remark_deduction3);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->thp                  = str_replace(',', '', $request->thp);
        $temp->ot_normal_hours      = str_replace(',', '', $request->ot_normal_hours);
        $temp->yearly_income_tax    = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax   = str_replace(',', '', $request->monthly_income_tax);
        $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
        $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
        $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
        $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
        $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
        $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
        $temp->save(); 

        $temp = new PayrollNetHistory();
        $temp->payroll_id            = $id;
        $temp->user_id              = $request->user_id;
        $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->call_allowance       = str_replace(',', '', $request->call_allowance);
        $temp->transport_allowance  = str_replace(',', '', $request->transport_allowance);
        $temp->meal_allow           = str_replace(',', '',$request->meal_allow);
        $temp->homebase_allowance   = str_replace(',', '', $request->homebase_allowance);
        $temp->laptop_allowance     = str_replace(',', '', $request->laptop_allowance);
        $temp->overtime             = str_replace(',', '', $request->overtime); 
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->medical_claim        = str_replace(',', '', $request->medical_claim);
        $temp->remark_medical       = str_replace(',', '', $request->remark_medical);
        $temp->other_income         = str_replace(',', '', $request->other_income);
        $temp->remark_other_income  = str_replace(',', '', $request->remark_other_income);
        $temp->other_income2        = str_replace(',', '', $request->other_income2);
        $temp->remark_other_income2 = str_replace(',', '', $request->remark_other_income2); 
        $temp->total_income         = str_replace(',', '', $request->total_income); 
        $temp->deduction1           = str_replace(',', '', $request->deduction1); 
        $temp->remark_deduction1    = str_replace(',', '', $request->remark_deduction1); 
        $temp->deduction2           = str_replace(',', '', $request->deduction2);
        $temp->remark_deduction2    = str_replace(',', '', $request->remark_deduction2);
        $temp->deduction3           = str_replace(',', '', $request->deduction3);
        $temp->remark_deduction3    = str_replace(',', '', $request->remark_deduction3);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->thp                  = str_replace(',', '', $request->thp);
        $temp->ot_normal_hours      = str_replace(',', '', $request->ot_normal_hours);
        $temp->yearly_income_tax    = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax   = str_replace(',', '', $request->monthly_income_tax);
        $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
        $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
        $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
        $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
        $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
        $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
        $temp->save();

        return redirect()->route('administrator.payrollnet.index')->with('message-success', 'Data successfully saved !');
    }

    /**
     * [download description]
     * @return [type] [description]
     */
    public function download()
    {
        $users = User::where('access_id', 2)->get();

        $params = [];

        foreach($users as $k =>  $i)
        {
            // cek data payroll
            $payroll = PayrollNet::where('user_id', $i->id)->first();

            $params[$k]['NO']           = $k+1;
            $params[$k]['NIK']          = $i->nik;
            $params[$k]['Nama']         = $i->name;

            if($payroll)
            {
                $params[$k]['Basic Salary']                     = $payroll->basic_salary;
                $params[$k]['Actual Salary']                    = $payroll->salary;
                $params[$k]['Call Allowance']                   = $payroll->call_allowance;
                $params[$k]['Transport Allowance']              = $payroll->transport_allowance;
                $params[$k]['Meal Allowance']                   = $payroll->meal_allow;
                $params[$k]['Homebase Allowance']               = $payroll->homebase_allowance;
                $params[$k]['Laptop Allowance']                 = $payroll->laptop_allowance;
                $params[$k]['Overtime']                         = $payroll->overtime;
                $params[$k]['Bonus']                            = $payroll->bonus;
                $params[$k]['Medical']                          = $payroll->medical_claim;
                $params[$k]['Remark Medical']                   = $payroll->remark_medical;
                $params[$k]['Other Income ']                    = $payroll->other_income;
                $params[$k]['Remark Other Income ']             = $payroll->remark_other_income;
                $params[$k]['Other Income 2 ']                  = $payroll->other_income2;
                $params[$k]['Remark Other Income 2']            = $payroll->remark_other_income2;
                $params[$k]['Total Income']                     = $payroll->total_income;
                $params[$k]['Deduction 1']                      = $payroll->deduction1;
                $params[$k]['Remark Deduction 1']               = $payroll->remark_deduction1;
                $params[$k]['Deduction 2']                      = $payroll->deduction2;
                $params[$k]['Remark Deduction 2']               = $payroll->remark_deduction2;
                $params[$k]['Deduction 3']                      = $payroll->deduction3;
                $params[$k]['Remark Deduction 3']               = $payroll->remark_deduction3;
                $params[$k]['Total Deduction']                  = $payroll->total_deduction;
                $params[$k]['Take Home Pay']                    = $payroll->thp;
            }
            else
            {
                $params[$k]['Basic Salary']                     = 0;
                $params[$k]['Actual Salary']                    = 0;
                $params[$k]['Call Allowance']                   = 0;
                $params[$k]['Transport Allowance']              = 0;
                $params[$k]['Meal Allowance']                   = 0;
                $params[$k]['Homebase Allowance']               = 0;
                $params[$k]['Laptop Allowance']                 = 0;
                $params[$k]['Overtime']                         = 0;
                $params[$k]['Bonus']                            = 0;
                $params[$k]['Medical']                          = 0;
                $params[$k]['Remark Medical']                   = "";
                $params[$k]['Other Income ']                    = 0;
                $params[$k]['Remark Other Income ']             = "";
                $params[$k]['Other Income 2 ']                  = 0;
                $params[$k]['Remark Other Income 2']            = "";
                $params[$k]['Total Income']                     = 0;
                $params[$k]['Deduction 1']                      = 0;
                $params[$k]['Remark Deduction 1']               = "";
                $params[$k]['Deduction 2']                      = 0;
                $params[$k]['Remark Deduction 2']               = "";
                $params[$k]['Deduction 3']                      = 0;
                $params[$k]['Remark Deduction 3']               = "";
                $params[$k]['Total Deduction']                  = 0;
                $params[$k]['Take Home Pay']                    = 0;
            }
        }

        return \Excel::create('datapayrollNet',  function($excel) use($params){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
        })->download('xls');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {
        $params['data'] = PayrollNet::where('id', $id)->first();

        return view('administrator.payrollnet.detail')->with($params);
    }

    /**
     * [calculate description]
     * @return [type] [description]
     */
    public function calculate()
    {
        $data = PayrollNet::all();

        $biaya_jabatan  = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum   = PayrollOthers::where('id', 2)->first()->value;

        foreach($data as $item)
        {
           // if($item->is_calculate == 1) continue;

            $temp = PayrollNet::where('id', $item->id)->first();

            $ptkp = PayrollPtkp::where('id', 1)->first();
            $bpjs_pensiunan_batas = PayrollOthers::where('id', 3)->first()->value;
            $bpjs_kesehatan_batas = PayrollOthers::where('id', 4)->first()->value;

            $bpjs_ketenagakerjaan_persen = 4.24;
            $bpjs_ketenagakerjaan = ($item->salary * $bpjs_ketenagakerjaan_persen / 100);
            $bpjs_ketenagakerjaan2_persen = 2;
            $bpjs_ketenagakerjaan2 = ($item->salary * $bpjs_ketenagakerjaan2_persen / 100);

            $bpjs_kesehatan         = 0;
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan_persen  = 4;
            $bpjs_kesehatan2_persen = 1;
            if($item->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan     = ($item->salary * $bpjs_kesehatan_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_persen / 100);
            }

            if($item->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan2     = ($item->salary * $bpjs_kesehatan2_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
            }

            $bpjs_pensiun         = 0;
            $bpjs_pensiun2        = 0;
            $bpjs_pensiun_persen  = 2;
            $bpjs_pensiun2_persen = 1;

            if($item->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun     = ($item->salary * $bpjs_pensiun_persen / 100); 
            }
            else
            {
                $bpjs_pensiun     = ($bpjs_pensiunan_batas * $bpjs_pensiun_persen / 100);
            }

            if($item->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun2     = ($item->salary * $bpjs_pensiun2_persen / 100); 
            }
            else
            {
                $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
            }

            $overtime = $item->ot_multiple_hours / 173 * $item->salary;
            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan + $bpjs_pensiun;
            $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2;

            $total_income= $item->salary +$item->call_allowance+ $item->transport_allowance+$item->meal_allow + $item->homebase_allowance +$item->laptop_allowance +$overtime +$item->bonus + $item->medical_claim + $item->other_income + $item->other_income2 ;

            $total_deduction = ($item->deduction1 + $item->deduction2 + $item->deduction3);

            $thp = $total_income - $total_deduction;

            $gross_income = ($item->salary +$item->call_allowance+ $item->transport_allowance+$item->meal_allow + $item->homebase_allowance +$item->laptop_allowance +$overtime + $bpjspenambahan) * 12 + $item->bonus;

            $gross_income2 = ($item->salary +$item->call_allowance+ $item->transport_allowance+$item->meal_allow + $item->homebase_allowance +$item->laptop_allowance +$overtime + $bpjspenambahan + $item->bonus) - $bpjspengurangan;

// burdern allowance
            $burden_allow = 5 * $gross_income2 / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deductionPer = ($bpjspengurangan * 12) + ($burden_allow*12);

            $net_yearly_income          = $gross_income - $total_deductionPer;

            $untaxable_income = 0;

            
            if(empty($item->user)) continue;
            if(empty($item->salary))continue;


            if($item->user->marital_status == 'Bujangan/Wanita')
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($item->user->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikah;
            }
            if($item->user->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($item->user->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($item->user->marital_status == 'Menikah Anak 3')
            {
                $untaxable_income = $ptkp->menikah_anak_3;
            }

            $taxable_yearly_income = $net_yearly_income - $untaxable_income;

            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * 50000000;
            }

            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= 250000000 )
            {
                $income_tax_calculation_15 = 0.15 * (250000000 - 50000000);
            }
            if($taxable_yearly_income >= 50000000 and $taxable_yearly_income <= 250000000)
            {
                $income_tax_calculation_15 = 0.15 * ($taxable_yearly_income - 50000000);
            }

            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_25 = 0.25 * (500000000 - 250000000);
            }

            if($taxable_yearly_income <= 500000000 and $taxable_yearly_income >= 250000000)
            {
                $income_tax_calculation_25 = 0.25 * ($taxable_yearly_income - 250000000);
            }

            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_30 = 0.35 * ($taxable_yearly_income - 500000000);
            }


            $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax = $yearly_income_tax / 12;

            if(!isset($item->basic_salary) || empty($item->basic_salary)) $item->basic_salary = 0;
            if(!isset($item->salary) || empty($item->salary)) $item->salary = 0;
            if(!isset($item->call_allowance) || empty($item->call_allowance)) $item->call_allowance = 0;
            if(!isset($item->transport_allowance) || empty($item->transport_allowance)) $item->transport_allowance = 0;
            if(!isset($item->meal_allow) || empty($item->meal_allow)) $item->meal_allow = 0;
            if(!isset($item->homebase_allowance) || empty($item->homebase_allowance)) $item->homebase_allowance = 0;
            if(!isset($item->laptop_allowance) || empty($item->laptop_allowance)) $item->laptop_allowance = 0;
            if(!isset($overtime) || empty($overtime)) $overtime = 0;
            if(!isset($item->bonus) || empty($item->bonus)) $item->bonus = 0;
            if(!isset($item->medical_claim) || empty($item->medical_claim)) $item->medical_claim = 0;
            if(!isset($item->other_income) || empty($item->other_income)) $item->other_income = 0;
            if(!isset($item->other_income2) || empty($item->other_income2)) $item->other_income2 = 0;
            if(!isset($total_income) || empty($total_income)) $total_income = 0;
            if(!isset($item->deduction1) || empty($item->deduction1)) $item->deduction1 = 0;
            if(!isset($item->deduction2) || empty($item->deduction2)) $item->deduction2 = 0;
            if(!isset($item->deduction3) || empty($item->deduction3)) $item->deduction3 = 0;
            if(!isset($total_deduction) || empty($total_deduction)) $total_deduction = 0;
            if(!isset($thp) || empty($thp)) $thp = 0;
            if(!isset($item->ot_normal_hours) || empty($item->ot_normal_hours)) $item->ot_normal_hours = 0;
            if(!isset($yearly_income_tax) || empty($yearly_income_tax)) $yearly_income_tax = 0;
            if(!isset($monthly_income_tax) || empty($monthly_income_tax)) $monthly_income_tax = 0;
            if(!isset($bpjs_ketenagakerjaan) || empty($bpjs_ketenagakerjaan)) $bpjs_ketenagakerjaan = 0;
            if(!isset($bpjs_kesehatan) || empty($bpjs_kesehatan)) $bpjs_kesehatan = 0;
            if(!isset($bpjs_pensiun) || empty($bpjs_pensiun)) $bpjs_pensiun = 0;
            if(!isset($bpjs_ketenagakerjaan2) || empty($bpjs_ketenagakerjaan2)) $bpjs_ketenagakerjaan2 = 0;
            if(!isset($bpjs_kesehatan2) || empty($bpjs_kesehatan2)) $bpjs_kesehatan2 = 0;
            if(!isset($bpjs_pensiun2) || empty($bpjs_pensiun2)) $bpjs_pensiun2 = 0;

            $temp->total_income         = $total_income;
            $temp->total_deduction      = $total_deduction;
            $temp->yearly_income_tax    = $yearly_income_tax;
            $temp->monthly_income_tax   = $monthly_income_tax;
            $temp->thp                  = $thp;
            $temp->is_calculate         = 1;
            $temp->overtime             = $overtime;
            $temp->bpjs_ketenagakerjaan         = $bpjs_ketenagakerjaan;
            $temp->bpjs_kesehatan               = $bpjs_kesehatan;
            $temp->bpjs_pensiun                 = $bpjs_pensiun;
            $temp->bpjs_ketenagakerjaan2        = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan2              = $bpjs_kesehatan2;
            $temp->bpjs_pensiun2                = $bpjs_pensiun2;

            $temp->save();

            $user_id        = $temp->user_id;
            $payroll_id     = $temp->id;

            $temp = new PayrollNetHistory();
            $temp->payroll_id            = $payroll_id;
            $temp->user_id              = $user_id;

            $temp->salary               = str_replace(',', '', $item->salary);
            $temp->basic_salary         = str_replace(',', '', $item->basic_salary);
            $temp->call_allowance       = str_replace(',', '', $item->call_allowance);
            $temp->transport_allowance  = str_replace(',', '', $item->transport_allowance);
            $temp->meal_allow           = str_replace(',', '', $item->meal_allow);
            $temp->homebase_allowance   = str_replace(',', '', $item->homebase_allowance); 
            
            $temp->laptop_allowance     = str_replace(',', '', $item->laptop_allowance); 
            $temp->overtime             = $overtime; 
            $temp->bonus                = str_replace(',', '', $item->bonus); 
            $temp->medical_claim        = str_replace(',', '', $item->medical_claim); 
            $temp->remark_medical       = str_replace(',', '', $item->remark_medical); 
            $temp->other_income         = str_replace(',', '', $item->other_income); 
            $temp->remark_other_income  = str_replace(',', '', $item->remark_other_income); 
            $temp->other_income2        = str_replace(',', '', $item->other_income2); 
            $temp->remark_other_income2 = str_replace(',', '', $item->remark_other_income2); 
            $temp->total_income         = str_replace(',', '', $total_income); 
            $temp->deduction1           = str_replace(',', '', $item->deduction1); 
            $temp->remark_deduction1    = str_replace(',', '', $item->remark_deduction1); 
            $temp->deduction2           = str_replace(',', '', $item->deduction2); 
            $temp->remark_deduction2    = str_replace(',', '', $item->remark_deduction2); 
            $temp->deduction3           = str_replace(',', '', $item->deduction3); 
            $temp->remark_deduction3    = str_replace(',', '', $item->remark_deduction3); 
            $temp->total_deduction      = str_replace(',', '', $total_deduction); 
            $temp->thp                  = str_replace(',', '', $thp);
            $temp->ot_normal_hours                   = str_replace(',', '',$item->ot_normal_hours);
            $temp->yearly_income_tax              = str_replace(',', '',$yearly_income_tax);
            $temp->monthly_income_tax              = str_replace(',', '',$monthly_income_tax);
            $temp->bpjs_ketenagakerjaan         = $bpjs_ketenagakerjaan;
            $temp->bpjs_kesehatan               = $bpjs_kesehatan;
            $temp->bpjs_pensiun                 = $bpjs_pensiun;
            $temp->bpjs_ketenagakerjaan2        = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan2              = $bpjs_kesehatan2;
            $temp->bpjs_pensiun2                = $bpjs_pensiun2;

            $temp->save();
        }

        return redirect()->route('administrator.payrollnet.index')->with('message-success', 'Data Payroll successfully calculated !');
    }
    /**
     * [import description]
     * @return [type] [description]
     */
    public function tempImport(Request $request)
    {   
        $this->validate($request, [
            'file' => 'required',
        ]);

        if($request->hasFile('file'))
        {
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            // delete all table temp
            foreach($rows as $key => $row)
            {
                if($key ==0) continue;

                $nik                        = $row[1];
                $basic_salary               = $row[3]; 
                $salary                     = $row[4]; 
                $call_allowance             = $row[5];
                $transport_allowance        = $row[6];
                $meal_allow                 = $row[7];
                $homebase_allowance         = $row[8];
                $laptop_allowance           = $row[9];
                $overtime                   = $row[10];
                $bonus                      = $row[11];
                $medical_claim              = $row[12];
                $remark_medical             = $row[13];
                $other_income               = $row[14];
                $remark_other_income        = $row[15];
                $other_income2              = $row[16];
                $remark_other_income2       = $row[17];
                $total_income               = $row[18];
                $deduction1                 = $row[19];
                $remark_deduction1          = $row[20];
                $deduction2                 = $row[21];
                $remark_deduction2          = $row[22];
                $deduction3                 = $row[23];
                $remark_deduction3          = $row[24];
                $total_deduction            = $row[25];
                $thp                        = $row[26];

                // cek user 
                $user = User::where('nik', $nik)->first();
                if($user)
                {   
                    // cek exit payrol user
                    $payroll = PayrollNet::where('user_id', $user->id)->first();
                    if(!$payroll)
                    {
                        $payroll            = new PayrollNet();
                        $payroll->user_id   = $user->id;
                        $payroll->is_calculate  = 0;
                    }

                    $is_calculate = 1;


                    if($payroll->salary == 0)
                    {
                        $is_calculate   = 0;
                    }

                    if($payroll->salary != $salary) 
                    {
                        $is_calculate   = 0;
                        $payroll->salary= $salary;
                    }

                    if($payroll->basic_salary != $basic_salary) 
                    {
                        $is_calculate   = 0;
                        $payroll->basic_salary= $basic_salary;
                    }
                   
                    if($payroll->call_allowance != $call_allowance) 
                    {
                        $is_calculate       = 0;
                        $payroll->call_allowance= $call_allowance;
                    }

                    if($payroll->bonus != $bonus) 
                    {
                        $is_calculate   = 0;
                        $payroll->bonus = $bonus;
                    }
                    
                    $payroll->is_calculate               = $is_calculate;
                    $payroll->transport_allowance        = $transport_allowance;
                    $payroll->meal_allow                 = $meal_allow;
                    $payroll->homebase_allowance         = $homebase_allowance;
                    $payroll->laptop_allowance           = $laptop_allowance;
                    $payroll->overtime                   = $overtime;
                    $payroll->medical_claim              = $medical_claim;
                    $payroll->remark_medical             = $remark_medical;
                    $payroll->other_income               = $other_income;
                    $payroll->remark_other_income        = $remark_other_income;
                    $payroll->other_income2              = $other_income2;
                    $payroll->remark_other_income2       = $remark_other_income2;
                    $payroll->total_income               = $total_income;
                    $payroll->deduction1                 = $deduction1;
                    $payroll->remark_deduction1          = $remark_deduction1;
                    $payroll->deduction2                 = $deduction2;
                    $payroll->remark_deduction2          = $remark_deduction2;
                    $payroll->deduction3                 = $deduction3;
                    $payroll->remark_deduction3          = $remark_deduction3;
                    $payroll->total_deduction            = $total_deduction;
                    $payroll->thp                        = $thp;

                    $payroll->save();
                }
            }

            return redirect()->route('administrator.payrollnet.index')->with('messages-success', 'Data Payroll successfully import !');
        }
    }
}
