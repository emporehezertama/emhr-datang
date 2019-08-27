<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Payroll;
use App\User;
use App\Models\Bank;
use App\Models\PayrollHistory;
use App\Models\PayrollOthers;
use App\Models\PayrollPtkp;
use App\Models\PayrollEarningsEmployee;
use App\Models\PayrollEarningsEmployeeHistory;
use App\Models\PayrollDeductionsEmployee;
use App\Models\PayrollDeductionsEmployeeHistory;
use App\Models\PayrollEarnings;
use App\Models\PayrollDeductions;
use App\Models\RequestPaySlip;
use App\Models\RequestPaySlipItem;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;
use App\Models\PayrollNpwp;

class PayrollController extends Controller
{   

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
        $user = \Auth::user();
        if($user->project_id != NULL)
        {
            $result = Payroll::select('payroll.*')->join('users', 'users.id','=', 'payroll.user_id')->where('users.project_id', $user->project_id)->orderBy('payroll.id', 'DESC');
            $params['division'] = OrganisasiDivision::join('users','users.id','=','organisasi_division.user_created')->where('users.project_id', $user->project_id)->select('organisasi_division.*')->get();
            $params['position'] = OrganisasiPosition::join('users','users.id','=','organisasi_position.user_created')->where('users.project_id', $user->project_id)->select('organisasi_position.*')->get();
        } else
        {
            $result = Payroll::select('payroll.*')->join('users', 'users.id','=', 'payroll.user_id')->orderBy('payroll.id', 'DESC');
            $params['division'] = OrganisasiDivision::all();
            $params['position'] = OrganisasiPosition::all();
        }

        if(request()->is_calculate || request()->employee_status || request()->position_id || request()->division_id || request()->name || request()->month || request()->year)
        {
            \Session::put('is_calculate', request()->is_calculate);
            \Session::put('employee_status', request()->employee_status);
            \Session::put('position_id', request()->position_id);
            \Session::put('division_id', request()->division_id);
            \Session::put('name', request()->name);
            \Session::put('month', request()->month);
            \Session::put('year', request()->year);
        }

        $is_calculate       = \Session::get('is_calculate');
        $employee_status    = \Session::get('employee_status');
        $position_id        = \Session::get('position_id');
        $division_id        = \Session::get('division_id');
        $name               = \Session::get('name');
        $month              = \Session::get('month');
        $year               = \Session::get('year');

        if(!empty($is_calculate))
        {
            $result = $result->where('is_calculate', request()->is_calculate );
        }

        if($employee_status)
        {
            $result = $result->where('users.organisasi_status', $employee_status);
        }

        if((!empty($division_id)) and (empty($position_id))) 
        {   
            $result = $result->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_division_id',$division_id);
        }
        if((!empty($position_id)) and (empty($division_id)))
        {   
            $result = $result->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',$position_id);
        }
        if((!empty($position_id)) and (!empty($division_id)))
        {
            $result = $result->join('structure_organization_custom','users.structure_organization_custom_id','=','structure_organization_custom.id')->where('structure_organization_custom.organisasi_position_id',$position_id)->where('structure_organization_custom.organisasi_division_id',$division_id);
        }

        // if(!empty($year) || !empty($month))
        // {
        //     if(!empty($year) and empty($year))
        //     {
        //         $result = $result->whereYear('payroll.created_at', $year);
        //     }
        //     elseif(!empty($month) and !empty($year))
        //     {
        //         $result = $result->whereMonth('payroll.created_at', $month)->whereYear('payroll.created_at', $year);
        //     }
        // }

        if(!empty($name))
        {
            $result = $result->where(function($table) use($name){
              $table->where('users.name', 'LIKE', '%'. $name .'%')
                    ->orWhere('users.nik', 'LIKE', '%'. $name .'%');  
            });
        }

        if(request())
        {
            if(request()->action == 'lock')
            {
                if(empty($year) and empty($month))
                {
                    return redirect()->route('administrator.payroll.index')->with('message-error', 'Year / Month required.');
                }else{
                    $this->lock_payroll($year,$month);
                }
            }
            if(request()->action == 'submitpayslip')
            {
                if(!isset(request()->user_id)) return redirect()->route('administrator.payroll.index')->with('message-error', 'Payroll item required.');
                if(empty($year) and empty($month))
                {
                    return redirect()->route('administrator.payroll.index')->with('message-error', 'Year / Month required.');
                }else{
                    return $this->sendsubmitpayslip($year,$month);
                }
            }
            if(request()->action == 'download')
            {
                if(!isset(request()->user_id)) return redirect()->route('administrator.payroll.index')->with('message-error', 'Payroll item required.');

                if(empty($year) and empty($month))
                {
                    return redirect()->route('administrator.payroll.index')->with('message-error', 'Year / Month required.');
                }
                if(!empty($year) and empty($month))
                {
                   return $this->downloadExcelYear($result->get());
                }
                else
                {
                    if($year != date('Y') or $month != (int)date('m'))
                    {
                        $result = cek_payroll_user_id_array($month, $year);
                    }
                    return $this->downloadExcel($result->whereIn('user_id', request()->user_id)->get(),$month,$year);
                }                    
            }
            if(request()->action == 'downloadBank')
            {
                if(empty($year) and empty($month))
                {
                    return redirect()->route('administrator.payroll.index')->with('message-error', 'Year / Month required.');
                }
                if(!empty($year) and !empty($month))
                {
                    if($year != date('Y') or $month != (int)date('m'))
                    {
                        $result = cek_payroll_user_id_array($month, $year);
                    }
                    return $this->downloadExcelBank($result->get());
                }                
            }

            if(request()->action == 'bukti-potong')
            {
                if(!isset(request()->user_id)) return redirect()->route('administrator.payroll.index')->with('message-error', 'Payroll item required.');

                if(empty($year))
                {
                   return redirect()->route('administrator.payroll.index')->with('message-error', 'Year required.');
                }else{
                     return $this->buktiPotong($result->get());
                }
            }

            if(request()->action == 'send-pay-slip')
            {
                return $this->sendPaySlip();
            }
        }

        if(!empty($year) || !empty($month))
        {
            $temp = clone $result;
            if($temp->count() == 0)
            {
                $result = PayrollHistory::select('payroll_history.*')->join('users', 'users.id','=', 'payroll_history.user_id')->orderBy('payroll_history.id', 'DESC');  
            } 
        }

        if(request()->reset == 1)
        { 
            \Session::forget('is_calculate');
            \Session::forget('employee_status');
            \Session::forget('position_id');
            \Session::forget('division_id');
            \Session::forget('name');
            \Session::forget('month');
            \Session::forget('year');

            return redirect()->route('administrator.payroll.index');
        }
        if($user->project_id != NULL)
        {
            $result = $result->where('users.project_id', $user->project_id);
        }

        $params['data'] = $result->get();
        
        return view('administrator.payroll.index')->with($params);
    }

    /**
     * Lock Payroll
     * @return return void
     */
    public function buktiPotong()
    {
        $dataRequest = request();
        $valuePayroll= PayrollHistory::whereIn('user_id', $dataRequest->user_id)->whereYear('created_at',$dataRequest->year)->get();

        if(count($valuePayroll) < 1) {
            return redirect()->route('administrator.payroll.index')->with('message-error', 'Payroll is note define yet!');
        }else
        {
            $params['data']       = PayrollHistory::groupBy('user_id')->whereIn('user_id', $dataRequest->user_id)->get();
            $params['tahun']      = $dataRequest->year;
        /*    if(\Auth::user()->project_id != Null){
                $params['nama_npwp']  = PayrollNpwp::where('id',1)->where('project_id', \Auth::user()->project_id)->first()->value;
                $params['no_npwp']    = PayrollNpwp::where('id',2)->where('project_id', \Auth::user()->project_id)->first()->value;
            }else{
                $params['nama_npwp']  = PayrollNpwp::where('id',1)->whereNull('project_id')->first()->value;
                $params['no_npwp']    = PayrollNpwp::where('id',2)->whereNull('project_id')->first()->value;
            }   */

            $params['nama_npwp']  = get_setting_payroll(1);
            $params['no_npwp']    = get_setting_payroll(2);
            

            $view = view('administrator.payroll.bukti-potong')->with($params);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('Legal');
            return $pdf->download('buktiPotong.pdf');
        }
    }

    public function lock_payroll($year,$month)
    {
        //dd(request()->user_id);
        if(!isset(request()->payroll_id))
        {
            return redirect()->route('administrator.payroll.index')->with('message-error', 'Select Payroll !.');
        }else
        {
            foreach(request()->user_id as $item)
            {
                $dataHistory = get_payroll_history($item,$month,$year);

                if(!isset($dataHistory)) continue;
                if(isset($dataHistory)){
                    $payrollhist = PayrollHistory::where('id', $dataHistory->id)->update(['is_lock' => 1]);
                    $payroll = Payroll::where('id', PayrollHistory::where('id', $dataHistory->id)->first()->payroll_id)->update(['is_lock' => 1]);
                }  
            }
        }
        return redirect()->route('administrator.payroll.index')->with('message-success', 'Payroll Lock.');
    }

    /**
     * Create Payroll History
     * @param  $id
     * @return void
     */
    public function detailHistory($id)
    {
        $params['data'] = PayrollHistory::where('id', $id)->first();
        $params['update_history'] = true;

        return view('administrator.payroll.detail')->with($params);
    }

    /**
     * Create Payroll By ID
     * @param  $id
     * @return void
     */
    public function createByPayrollId($id)
    {
        $params['data'] = Payroll::where('id', $id)->first();
        $params['create_by_payroll_id'] = true;

        return view('administrator.payroll.detail')->with($params);
    }

    /**
     * 
     * @return [type] [description]
     */
    
    /**
     * Download excel year
     * @return object
     */
    public function downloadExcelYear($data)
    {
        $request = request();

        return (new \App\Models\PayrollExportYear($request->year, $request->user_id))->download('EM-HR.Payroll-'. $request->year .'.xlsx');
    }

    
    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data,$month,$year)
    {
        $params = [];
        $request = request();


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

            //  earnings
            $params[$k]['Salary']           = $item->salary;
            $params[$k]['Bonus / THR']      = $item->bonus;

            $params[$k]['BPJS Jaminan Kecelakaan Kerja (JKK) (Company) '. get_setting('bpjs_jkk_company').'%']  = $item->bpjs_jkk_company;
            $params[$k]['BPJS Jaminan Kematian (JKM) (Company) '. get_setting('bpjs_jkm_company').'%']          = $item->bpjs_jkm_company;
            $params[$k]['BPJS Jaminan Hari Tua (JHT) (Company) '. get_setting('bpjs_jht_company').'%']          = $item->bpjs_jht_company;
            $params[$k]['BPJS Pensiun (Company) '. get_setting('bpjs_pensiun_company').'%']                     = $item->bpjs_pensiun_company;
            $params[$k]['BPJS Kesehatan (Company) '. get_setting('bpjs_kesehatan_company').'%']                 = $item->bpjs_kesehatan_company; //$item->salary *  get_setting('bpjs_kesehatan_company') / 100;
            
            
             if(\Auth::user()->project_id != Null){
                 $payrollearning = PayrollEarnings::where('user_created', \Auth::user()->id)->get();
             }else{
                 $payrollearning = PayrollEarnings::all();
             }

            foreach($payrollearning as $i)
            {   
                if($year != date('Y') or $month != (int)date('m'))
                {
                    $earning = PayrollEarningsEmployeeHistory::where('payroll_id', $item->id)->where('payroll_earning_id', $i->id)->first();
                }else
                {
                    $earning = PayrollEarningsEmployee::where('payroll_id', $item->id)->where('payroll_earning_id', $i->id)->first();
                }

                if($earning) 
                {
                    $earning = number_format($earning->nominal);
                }
                else{
                    $earning = 0;
                }

                $params[$k][$i->title] = $earning;
            }
            $params[$k]['Monthly Income Tax (Company)']                                                           = $item->pph21;
            $params[$k]['Total Earnings']                                                                       = $item->total_earnings;


            // deductions
            if(\Auth::user()->project_id != Null){
                $payrolldeduction = PayrollDeductions::where('user_created', \Auth::user()->id)->get();
            }else{
                $payrolldeduction = PayrollDeductions::all();
            }
            foreach($payrolldeduction as $i)
            {   
                if($year != date('Y') or $month != (int)date('m'))
                {
                    $deduction = PayrollDeductionsEmployeeHistory::where('payroll_id', $item->id)->where('payroll_deduction_id', $i->id)->first();
                }else
                {
                   $deduction = PayrollDeductionsEmployee::where('payroll_id', $item->id)->where('payroll_deduction_id', $i->id)->first();
                }
                if($deduction) 
                {
                    $deduction = number_format($deduction->nominal);
                }
                else
                {
                    $deduction = 0;
                }

                $params[$k][$i->title] = $deduction;
            }

            $params[$k]['BPJS Jaminan Hari Tua (JHT) (Employee) '. get_setting('bpjs_jaminan_jht_employee').'%']= $item->bpjs_ketenagakerjaan_employee;
            $params[$k]['BPJS Kesehatan (Employee) '. get_setting('bpjs_kesehatan_employee').'%']               = $item->bpjs_kesehatan_employee; //$item->salary *  get_setting('bpjs_kesehatan_employee') / 100;
            $params[$k]['BPJS Jaminan Pensiun (JP) (Employee) '. get_setting('bpjs_jaminan_jp_employee').'%']   = $item->bpjs_pensiun_employee;
            $params[$k]['Total BPJS (Company) ']   = PayrollHistory::where('payroll_id', $item->id)->latest()->first()->bpjstotalearning;
            
            $params[$k]['Total Deduction (Burden + BPJS)']      = $item->total_deduction;
            $params[$k]['Monthly Income Tax (Employee)']                    = $item->yearly_income_tax;
            $params[$k]['Acc No']                               = isset($item->user->nomor_rekening) ? $item->user->nomor_rekening : '';
            $params[$k]['Acc Name']                             = isset($item->user->nama_rekening) ? $item->user->nama_rekening : '';
            $params[$k]['Bank Name']                            = isset($item->user->bank->name) ? $item->user->bank->name : '';

            
            $params[$k]['Take Home Pay']                        = $item->thp;
        }

        return (new \App\Models\PayrollExportMonth(request()->year, request()->month, $params))->download('EM-HR.Payroll-'. $request->year .'-'. $request->month.'.xlsx');
    }
    public function downloadExcelBank($data)
    {
        $params = [];
        $request = request();

        foreach($data as $k =>  $item)
        {
            $bank = Bank::where('id', $item->bank_id)->first();

            // cek data payroll
            $params[$k]['REKENING']         = isset($item->user->nomor_rekening) ? $item->user->nomor_rekening : '';
            $params[$k]['PLUS']             = '+';
            $params[$k]['NOMINAL']          = $item->thp;
            $params[$k]['CD']               = 'C';
            $params[$k]['NO']               = $k+1;
            $params[$k]['NAMA']             = $item->user->name;
            $params[$k]['KETERANGAN']       = '';
            $params[$k]['NAMA BANK']        = isset($item->user->bank->name) ? $item->user->bank->name : '';
        }
        return (new \App\Models\PayrollExportMonth(request()->year, request()->month, $params))->download('EM-HR.Payroll-'. $request->year .'-'. $request->month.'.xlsx');
    }
    /**
     * [import description]
     * @return [type] [description]
     */
    public function import()
    {	
    	return view('administrator.payroll.import');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('administrator.payroll.create');
    }

    /**
     * [store description]
     * @return [type] [description]
     */
    public function store(Request $request)
    {
        $temp = new Payroll();
        
        if((!isset($request->salary) || empty($request->salary)) && (!isset($request->salary) || empty($request->salary)) || empty($request->user_id)) {
             return redirect()->route('administrator.payroll.create')->with('message-error', __('payroll.message-employee-cannot-empty'));

        }else{
            if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
            
            if(!isset($request->bpjs_jkk_company) || empty($request->bpjs_jkk_company)) $request->bpjs_jkk_company = 0;
            if(!isset($request->bpjs_jkm_company) || empty($request->bpjs_jkm_company)) $request->bpjs_jkm_company = 0;
            if(!isset($request->bpjs_jht_company) || empty($request->bpjs_jht_company)) $request->bpjs_jht_company = 0;
            if(!isset($request->bpjs_pensiun_company) || empty($request->bpjs_pensiun_company)) $request->bpjs_pensiun_company = 0;
            if(!isset($request->bpjs_kesehatan_company) || empty($request->bpjs_kesehatan_company)) $request->bpjs_kesehatan_company = 0;
            if(!isset($request->bpjstotalearning) || empty($request->bpjstotalearning)) $request->bpjstotalearning = 0;
            if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
            if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
            if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;
            if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;
            if(!isset($request->burden_allow) || empty($request->burden_allow)) $request->burden_allow = 0;
            if(!isset($request->yearly_income_tax) || empty($request->yearly_income_tax)) $request->yearly_income_tax = 0;

            $temp->user_id                          = $request->user_id;
            $temp->salary                           = replace_idr($request->salary);
            $temp->thp                              = replace_idr($request->thp);
            $temp->is_calculate                     = 1;
            $temp->bpjs_jkk_company                 = replace_idr($request->bpjs_jkk_company);
            $temp->bpjs_jkm_company                 = replace_idr($request->bpjs_jkm_company);
            $temp->bpjs_jht_company                 = replace_idr($request->bpjs_jht_company);
            $temp->bpjs_pensiun_company             = replace_idr($request->bpjs_pensiun_company);
            $temp->bpjs_kesehatan_company           = replace_idr($request->bpjs_kesehatan_company);
            $temp->bpjstotalearning                 = replace_idr($request->bpjstotalearning);

            $temp->bpjs_ketenagakerjaan2            = replace_idr($request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = replace_idr($request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = replace_idr($request->bpjs_pensiun2);
            $temp->total_deduction                  = $request->total_deductions;
            $temp->total_earnings                   = $request->total_earnings;
            $temp->pph21                            = replace_idr($request->pph21);
            $temp->bpjs_ketenagakerjaan_employee             = replace_idr($request->bpjs_ketenagakerjaan_employee);
            $temp->bpjs_kesehatan_employee                   = replace_idr($request->bpjs_kesehatan_employee);
            $temp->bpjs_pensiun_employee                     = replace_idr($request->bpjs_pensiun_employee);
            $temp->bonus                                     = replace_idr($request->bonus);
            $temp->burden_allow                              = replace_idr($request->burden_allow);
            $temp->yearly_income_tax                         = replace_idr($request->yearly_income_tax); 
            
            $temp->save();
            $payroll_id = $temp->id;

            // save earnings
            if(isset($request->earning))
            {
                foreach($request->earning as $key => $value)
                {
                    $earning                        = new PayrollEarningsEmployee();
                    $earning->payroll_id            = $payroll_id;
                    $earning->payroll_earning_id    = $value;
                    $earning->nominal               = replace_idr($request->earning_nominal[$key]); 
                    $earning->save();
                }
            }
            // save deductions
            if(isset($request->deduction))
            {
                foreach($request->deduction as $key => $value)
                {
                    $deduction                        = new PayrollDeductionsEmployee();
                    $deduction->payroll_id            = $payroll_id;
                    $deduction->payroll_deduction_id  = $value;
                    $deduction->nominal               = replace_idr($request->deduction_nominal[$key]); 
                    $deduction->save();
                }
            }

            // Insert History
            $temp = new PayrollHistory();
            $temp->payroll_id            = $payroll_id;
            $temp->user_id              = $request->user_id;
            $temp->salary               = str_replace('.', '', $request->salary);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->bpjs_jkk_company                 = replace_idr($request->bpjs_jkk_company);
            $temp->bpjs_jkm_company                 = replace_idr($request->bpjs_jkm_company);
            $temp->bpjs_jht_company                 = replace_idr($request->bpjs_jht_company);
            $temp->bpjs_pensiun_company             = replace_idr($request->bpjs_pensiun_company);
            $temp->bpjs_kesehatan_company           = replace_idr($request->bpjs_kesehatan_company);
            $temp->bpjstotalearning                 = replace_idr($request->bpjstotalearning);

            $temp->bpjs_ketenagakerjaan2            = replace_idr($request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = replace_idr($request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = replace_idr($request->bpjs_pensiun2);
            $temp->total_deduction                  = $request->total_deductions;
            $temp->total_earnings                   = $request->total_earnings;
            $temp->pph21                            = replace_idr($request->pph21);
            
            $temp->bpjs_ketenagakerjaan_employee             = replace_idr($request->bpjs_ketenagakerjaan_employee);
            $temp->bpjs_kesehatan_employee                   = replace_idr($request->bpjs_kesehatan_employee);
            $temp->bpjs_pensiun_employee                     = replace_idr($request->bpjs_pensiun_employee);
            $temp->bonus                                     = replace_idr($request->bonus);
            $temp->burden_allow                              = replace_idr($request->burden_allow);
            $temp->yearly_income_tax                         = replace_idr($request->yearly_income_tax);
            
            $temp->save();
            $payroll_id = $temp->id;
            // save earnings
            if(isset($request->earning))
            {
                foreach($request->earning as $key => $value)
                {
                    $earning                        = new PayrollEarningsEmployeeHistory();
                    $earning->payroll_id            = $payroll_id;
                    $earning->payroll_earning_id    = $value;
                    $earning->nominal               = replace_idr($request->earning_nominal[$key]); 
                    $earning->save();
                }
            }
            // save deductions
            if(isset($request->deduction))
            {
                foreach($request->deduction as $key => $value)
                {
                    $deduction                        = new PayrollDeductionsEmployeeHistory();
                    $deduction->payroll_id            = $payroll_id;
                    $deduction->payroll_deduction_id  = $value;
                    $deduction->nominal               = replace_idr($request->deduction_nominal[$key]); 
                    $deduction->save();
                }
            }
            //$this->init_calculate();

            return redirect()->route('administrator.payroll.index')->with('message-success', 'Data successfully saved !');
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
        if(isset($request->create_by_payroll_id)){
            $temp = Payroll::where('id', $id)->first();
       }
       if(isset($request->update_history)) {
           # code...
           $data = PayrollHistory::where('id',$id)->first();
           $temp = Payroll::where('id', $data->payroll_id)->first();
       }

       if(isset($request->create_by_payroll_id) || isset($request->update_history))
       {
           $temp->salary                           = replace_idr($request->salary);
           $temp->thp                              = replace_idr($request->thp);
           //$temp->thp                              = $request->thp;
           $temp->bpjs_jkk_company                 = replace_idr($request->bpjs_jkk_company);
           $temp->bpjs_jkm_company                 = replace_idr($request->bpjs_jkm_company);
           $temp->bpjs_jht_company                 = replace_idr($request->bpjs_jht_company);
           $temp->bpjs_pensiun_company             = replace_idr($request->bpjs_pensiun_company);
           $temp->bpjs_kesehatan_company           = replace_idr($request->bpjs_kesehatan_company);
           $temp->bpjstotalearning                 = replace_idr($request->bpjstotalearning);
   
            $temp->bpjs_ketenagakerjaan2            = replace_idr($request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = replace_idr($request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = replace_idr($request->bpjs_pensiun2);
            $temp->total_deduction                  = $request->total_deductions;
            $temp->total_earnings                   = $request->total_earnings;
            $temp->pph21                            = replace_idr($request->pph21);
            $temp->bpjs_ketenagakerjaan_company     = replace_idr($request->bpjs_ketenagakerjaan_company);
            $temp->bpjs_ketenagakerjaan_employee    = replace_idr($request->bpjs_ketenagakerjaan_employee);
            $temp->bpjs_kesehatan_employee          = replace_idr($request->bpjs_kesehatan_employee);
            $temp->bpjs_pensiun_employee            = replace_idr($request->bpjs_pensiun_employee);
            $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
            $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
            $temp->bonus                        = replace_idr($request->bonus);
            $temp->burden_allow                 = replace_idr($request->burden_allow);
            $temp->yearly_income_tax            = replace_idr($request->yearly_income_tax);
            $temp->is_lock                      = $request->is_lock;
            $temp->save();
        
            // save earnings
            if(isset($request->earning))
            {
                foreach($request->earning as $key => $value)
                {
                    $earning = PayrollEarningsEmployee::where('payroll_id', $id)->where('payroll_earning_id', $value)->first();
                    if(!$earning)
                    {
                        $earning                        = new PayrollEarningsEmployee();
                        $earning->payroll_id            = $id;
                        $earning->payroll_earning_id    = $value;
                    }

                    $earning->nominal               = replace_idr($request->earning_nominal[$key]); 

                    $earning->save();
                }
                foreach($request->earning as $key => $value)
                {
                    $earning = PayrollEarningsEmployeeHistory::where('payroll_id', $id)->where('payroll_earning_id', $value)->first();
                    if(!$earning)
                    {
                        $earning                        = new PayrollEarningsEmployeeHistory();
                        $earning->payroll_id            = $id;
                        $earning->payroll_earning_id    = $value;
                    }

                    $earning->nominal               = replace_idr($request->earning_nominal[$key]); 
                    $earning->save();
                }
            }
            // save deductions
            if(isset($request->deduction))
            {
                foreach($request->deduction as $key => $value)
                {
                    $deduction                        = PayrollDeductionsEmployee::where('payroll_id', $id)->where('payroll_deduction_id', $value)->first();
                    if(!$deduction)
                    {
                        $deduction                        = new PayrollDeductionsEmployee();
                        $deduction->payroll_id            = $id;
                        $deduction->payroll_deduction_id  = $value;
                    }
                    
                    $deduction->nominal               = replace_idr($request->deduction_nominal[$key]); 
                    $deduction->save();
                }
                foreach($request->deduction as $key => $value)
                {
                    $deduction                        = PayrollDeductionsEmployeeHistory::where('payroll_id', $id)->where('payroll_deduction_id', $value)->first();
                    if(!$deduction)
                    {
                        $deduction                        = new PayrollDeductionsEmployeeHistory();
                        $deduction->payroll_id            = $id;
                        $deduction->payroll_deduction_id  = $value;
                    }
                    
                    $deduction->nominal               = replace_idr($request->deduction_nominal[$key]); 
                    $deduction->save();
                }
            }
        }
        if(isset($request->create_by_payroll_id) || isset($request->update_history))
        {
            if(isset($request->create_by_payroll_id)) {
                $history                        = new PayrollHistory();
                $history->payroll_id            = $id;
            }
            if(isset($request->update_history)) {
                $history                        = PayrollHistory::where('id', $id)->first();
            }
                $history->user_id               = $request->user_id;
                $history->salary                = replace_idr($request->salary);
                $history->total_deduction       = replace_idr($request->total_deduction);
                //$history->thp                          = $request->thp;
                $history->thp                              = replace_idr($request->thp);
                $history->bpjs_jkk_company                 = replace_idr($request->bpjs_jkk_company);
                $history->bpjs_jkm_company                 = replace_idr($request->bpjs_jkm_company);
                $history->bpjs_jht_company                 = replace_idr($request->bpjs_jht_company);
                $history->bpjs_pensiun_company             = replace_idr($request->bpjs_pensiun_company);
                $history->bpjs_kesehatan_company           = replace_idr($request->bpjs_kesehatan_company);
                $history->bpjstotalearning                 = replace_idr($request->bpjstotalearning);

                $history->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
                $history->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
                $history->bpjs_kesehatan_employee      = replace_idr($request->bpjs_kesehatan_employee);
    
                $history->pph21                        = replace_idr($request->pph21);
                $history->bpjs_ketenagakerjaan_employee= replace_idr($request->bpjs_ketenagakerjaan_employee);
                $history->bpjs_pensiun_employee        = replace_idr($request->bpjs_pensiun_employee);
                $history->bonus                        = replace_idr($request->bonus);
                $history->total_deduction              = $request->total_deductions;
                $history->total_earnings               = $request->total_earnings;
                $history->is_lock                      = $request->is_lock;
                $history->burden_allow                 = replace_idr($request->burden_allow);
                $history->yearly_income_tax                 = replace_idr($request->yearly_income_tax);


        // if create baru
        if(isset($request->create_by_payroll_id))
        {
            $history->created_at = date('Y-m-d H:i:s', strtotime( $request->date ));
            $history->save(['timestamps' => false]);
        }
        else{
            $history->save();
        }
        
            // save earnings
            if(isset($request->earning))
            {
                foreach($request->earning as $key => $value)
                {
                    $earning = PayrollEarningsEmployeeHistory::where('payroll_id', $history->id)->where('payroll_earning_id', $value)->first();
                    if(!$earning)
                    {
                        $earning                        = new PayrollEarningsEmployeeHistory();
                        $earning->payroll_id            = $history->id;
                        $earning->payroll_earning_id    = $value;
                    }

                    $earning->nominal               = replace_idr($request->earning_nominal[$key]); 
                    if(isset($request->create_by_payroll_id))
                    {
                        $earning->created_at = date('Y-m-d H:i:s', strtotime( $request->date ));
                        $earning->save(['timestamps' => false]);
                    }
                    else  $earning->save();
                }
            }
            // save deductions
            if(isset($request->deduction))
            {
                foreach($request->deduction as $key => $value)
                {
                    $deduction    = PayrollDeductionsEmployeeHistory::where('payroll_id', $history->id)->where('payroll_deduction_id', $value)->first();
                    if(!$deduction)
                    {
                        $deduction                        = new PayrollDeductionsEmployeeHistory();
                        $deduction->payroll_id            = $history->id;
                        $deduction->payroll_deduction_id  = $value;
                    }
                    
                    $deduction->nominal               = replace_idr($request->deduction_nominal[$key]);
                    if(isset($request->create_by_payroll_id))
                    {
                        $deduction->created_at = date('Y-m-d H:i:s', strtotime( $request->date ));
                        $deduction->save(['timestamps' => false]);
                    }
                    else  $deduction->save();
                }
            }
        }

        if(isset($request->create_by_payroll_id) || isset($request->update_history))
        {
            return redirect()->route('administrator.payroll.detail-history', $history->id)->with('message-success', __('general.message-data-saved-success'));
        }
        else
        {
            return redirect()->route('administrator.payroll.detail', $id)->with('message-success', __('general.message-data-saved-success'));
        }
    }

    /**
     * [download description]
     * @return [type] [description]
     */
    public function download()
    {
        if(\Auth::user()->project_id != Null){
            $users = \App\User::where('access_id', 2)->where('project_id', \Auth::user()->project_id)->get();
        }else{
            $users = \App\User::where('access_id', 2)->get();
        }
        

        $params = [];

        foreach($users as $k =>  $i)
        {
            // cek data payroll
            $payroll = Payroll::where('user_id', $i->id)->first();

            $params[$k]['NO']           = $k+1;
            $params[$k]['NIK']          = $i->nik;
            $params[$k]['Nama']         = $i->name;

            if($payroll)
            {
                $params[$k]['Salary']                    = $payroll->salary;
                $params[$k]['Bonus / THR']  = $payroll->bonus;
                

                if(\Auth::user()->project_id != Null){
                    $payrollearning = PayrollEarnings::where('user_created', \Auth::user()->id)->get();
                }else{
                    $payrollearning = PayrollEarnings::all();
                }
                foreach($payrollearning as $item)
                {   
                    $earning = PayrollEarningsEmployee::where('payroll_id', $payroll->id)->where('payroll_earning_id', $item->id)->first();
                    if($earning) 
                    {
                        $earning = number_format($earning->nominal);
                    }
                    else
                        $earning = 0;

                    $params[$k][$item->title] = $earning;
                }

                // earnings
                if(\Auth::user()->project_id != Null){
                    $payrolldeduction = PayrollDeductions::where('user_created', \Auth::user()->id)->get();
                }else{
                    $payrolldeduction = PayrollDeductions::all();
                }
                foreach($payrolldeduction as $item)
                {   
                    $deduction = PayrollDeductionsEmployee::where('payroll_id', $payroll->id)->where('payroll_deduction_id', $item->id)->first();
                    if($deduction) 
                    {
                        $deduction = number_format($deduction->nominal);
                    }
                    else
                        $deduction = 0;

                    $params[$k][$item->title] = $deduction;
                }
            }
            else
            {
                $params[$k]['Salary']                     = 0;
                $params[$k]['Bonus / THR']                = 0;

                if(\Auth::user()->project_id != Null){
                    $payrollearning = PayrollEarnings::where('user_created', \Auth::user()->id)->get();
                }else{
                    $payrollearning = PayrollEarnings::all();
                }
                foreach($payrollearning as $item)
                {   
                    $params[$k][$item->title] = 0;
                }

                // earnings
                if(\Auth::user()->project_id != Null){
                    $payrolldeduction = PayrollDeductions::where('user_created', \Auth::user()->id)->get();
                }else{
                    $payrolldeduction = PayrollDeductions::all();
                }
                foreach($payrolldeduction as $item)
                {   
                    $params[$k][$item->title] = 0;
                }
            }
        }

        return (new \App\Models\PayrollExport($params))->download('EM-HR.Payroll-Template-'. date('Y-m-d') .'.xlsx');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {
         $params['data'] = Payroll::where('id', $id)->first();

        //$params['data'] = PayrollHistory::where('id', $id)->first();
        //$params['create_by_payroll_id'] = false;
        $params['update_history'] = true;

        return view('administrator.payroll.detail')->with($params);
    }

    /**
     * [calculate description]
     * @return [type] [description]
     */
    public function calculate()
    {
        $this->init_calculate();

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Data Payroll successfully calculated !');
    }

    /**
     * Init payroll non bonus
     * @param  item
     * @return object
     */
    public function init_calculate_non_bonus($item)
    {
        $biaya_jabatan = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = PayrollOthers::where('id', 2)->first()->value;

        $temp                   = Payroll::where('id', $item->id)->first();
        $ptkp                   = PayrollPtkp::where('id', 1)->first();
        $bpjs_pensiunan_batas   = PayrollOthers::where('id', 3)->first()->value;
        $bpjs_kesehatan_batas   = PayrollOthers::where('id', 4)->first()->value;

        //JHT EMPLOYEE
        $bpjs_ketenagakerjaan2_persen = get_setting('bpjs_jaminan_jht_employee');
        $bpjs_ketenagakerjaan2 = ($item->salary * $bpjs_ketenagakerjaan2_persen / 100);

        // start custom
        if(replace_idr($item->bpjs_ketenagakerjaan_employee) != $bpjs_ketenagakerjaan2)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_ketenagakerjaan2 = replace_idr($item->bpjs_ketenagakerjaan_employee);                    
            }
        }
        // end custom

        //JHT COMPANY
        $bpjs_jht_company_persen = get_setting('bpjs_jht_company');
        $bpjs_jht_company = ($item->salary * $bpjs_jht_company_persen / 100);

        // start custom
        if(replace_idr($item->bpjs_jht_company) != $bpjs_jht_company)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_jht_company = replace_idr($item->bpjs_jht_company);                    
            }
        }

        //KESEHATAN EMPLOYEE
        $bpjs_kesehatan2        = 0;
        $bpjs_kesehatan2_persen = get_setting('bpjs_kesehatan_employee');
        if($item->salary <= $bpjs_kesehatan_batas)
        {
            $bpjs_kesehatan2     = ($item->salary * $bpjs_kesehatan2_persen / 100); 
        }
        else
        {
            $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
        }

        // start custom
        if(replace_idr($item->bpjs_kesehatan_employee) != $bpjs_kesehatan2)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_kesehatan2 = replace_idr($item->bpjs_kesehatan_employee);                    
            }
        }
        // end custom

        //KESEHATAN COMPANY
        $bpjs_kesehatan_company        = 0;
        $bpjs_kesehatan_company_persen = get_setting('bpjs_kesehatan_company');
        if($item->salary <= $bpjs_kesehatan_batas)
        {
            $bpjs_kesehatan_company     = ($item->salary * $bpjs_kesehatan_company_persen / 100); 
        }
        else
        {
            $bpjs_kesehatan_company     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_company_persen / 100);
        }

        // start custom
        if(replace_idr($item->bpjs_kesehatan_company) != $bpjs_kesehatan_company)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_kesehatan_company = replace_idr($item->bpjs_kesehatan_company);                    
            }
        }
        // end custom

        //PENSIUN EMPLOYEE
        $bpjs_pensiun2        = 0;
        $bpjs_pensiun2_persen = get_setting('bpjs_jaminan_jp_employee');
        if($item->salary <= $bpjs_pensiunan_batas)
        {
            $bpjs_pensiun2     = ($item->salary * $bpjs_pensiun2_persen / 100); 
        }
        else
        {
            $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
        }

        // start custom
        if(replace_idr($item->bpjs_pensiun_employee) != $bpjs_pensiun2)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_pensiun2 = replace_idr($item->bpjs_pensiun_employee);                    
            }
        }
        // end custom

        //PENSIUN COMPANY
        $bpjs_pensiun_company        = 0;
        $bpjs_pensiun_company_persen = get_setting('bpjs_pensiun_company');
        if($item->salary <= $bpjs_pensiunan_batas)
        {
            $bpjs_pensiun_company     = ($item->salary * $bpjs_pensiun_company_persen / 100); 
        }
        else
        {
            $bpjs_pensiun_company     = ($bpjs_pensiunan_batas * $bpjs_pensiun_company_persen / 100);
        }

        // start custom
        if(replace_idr($item->bpjs_pensiun_company) != $bpjs_pensiun_company)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_pensiun_company = replace_idr($item->bpjs_pensiun_company);                    
            }
        }
        // end custom

        //JKK COMPANY
        $bpjs_jkk_company_persen = get_setting('bpjs_jkk_company');
        $bpjs_jkk_company = ($item->salary * $bpjs_jkk_company_persen / 100);

        // start custom
        if(replace_idr($item->bpjs_jkk_company) != $bpjs_jkk_company)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_jkk_company = replace_idr($item->bpjs_jkk_company);                    
            }
        }
        // end custom

        //JKM COMPANY
        $bpjs_jkm_company_persen = get_setting('bpjs_jkm_company');
        $bpjs_jkm_company = ($item->salary * $bpjs_jkm_company_persen / 100);

        // start custom
        if(replace_idr($item->bpjs_jkm_company) != $bpjs_jkm_company)
        {
            if($item->is_calculate ==1)
            {
                $bpjs_jkm_company = replace_idr($item->bpjs_jkm_company);                    
            }
        }
        // end custom
        $bpjstotalearning = $bpjs_jkk_company + $bpjs_jkm_company + $bpjs_jht_company + $bpjs_pensiun_company + $bpjs_kesehatan_company;
        //$bpjspenambahan = $bpjstotalearning;
        //$bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_pensiun2 +$bpjs_kesehatan2 + $bpjstotalearning;
        $bpjspenambahan = $bpjs_jkk_company + $bpjs_jkm_company+$bpjs_kesehatan_company;
        $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_pensiun2;

        $earnings = 0;
        if(isset($item->payrollEarningsEmployee))
        {
            foreach($item->payrollEarningsEmployee as $i)
            {
                if(isset($i->payrollEarnings->title))
                {
                    $earnings += $i->nominal;
                }
            }
        }

        $gross_income = ($item->salary + $earnings + $bpjspenambahan) * 12;

        // burdern allowance
        $burden_allow = 5 * ($item->salary + $earnings + $bpjspenambahan) / 100;
        $biaya_jabatan_bulan = $biaya_jabatan / 12;

        if($burden_allow > $biaya_jabatan_bulan)
        {
            $burden_allow = $biaya_jabatan_bulan;
        }

        $total_deduction = ($bpjspengurangan * 12) + ($burden_allow*12);

        //$net_yearly_income          = $gross_income - $total_deduction;
        $net_yearly_val          = $gross_income - $total_deduction;
        $net_yearly_ratusan      = substr($net_yearly_val, -3);
        $net_yearly_income       = $net_yearly_val - $net_yearly_ratusan;

        $untaxable_income = 0;

        $ptkp = \App\Models\PayrollPtkp::where('id', 1)->first();
        if($item->user->marital_status == 'Bujangan/Wanita' || $item->user->marital_status == "")
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

        $pph_setting_1  = \App\Models\PayrollPPH::where('id', 1)->first();
        // Perhitungan 5 persen
        $income_tax_calculation_5 = 0;
        if($taxable_yearly_income < 0)
        {
            $income_tax_calculation_5 = 0;   
        }
        elseif($taxable_yearly_income <= $pph_setting_1->batas_atas)
        {
            $income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $taxable_yearly_income;
        }
        if($taxable_yearly_income >= $pph_setting_1->batas_atas)
        {
            $income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $pph_setting_1->batas_atas;
        }

        $pph_setting_2  = \App\Models\PayrollPPH::where('id', 2)->first();
        // Perhitungan 15 persen
        $income_tax_calculation_15 = 0;
        if($taxable_yearly_income >= $pph_setting_2->batas_atas)
        {
            $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($pph_setting_2->batas_atas - $pph_setting_2->batas_bawah);
        }
        if($taxable_yearly_income >= $pph_setting_2->batas_bawah and $taxable_yearly_income <= $pph_setting_2->batas_atas)
        {
            $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($taxable_yearly_income - $pph_setting_2->batas_bawah);
        }

        $pph_setting_3  = \App\Models\PayrollPPH::where('id', 3)->first();
        // Perhitungan 25 persen
        $income_tax_calculation_25 = 0;
        if($taxable_yearly_income >= $pph_setting_3->batas_atas)
        {
            $income_tax_calculation_25 = ($pph_setting_3->tarif / 100)  * ($pph_setting_3->batas_atas - $pph_setting_3->batas_bawah);
        }

        if($taxable_yearly_income <= $pph_setting_3->batas_atas and $taxable_yearly_income >= $pph_setting_3->batas_bawah)
        {
            $income_tax_calculation_25 = ($pph_setting_3->tarif / 100) * ($taxable_yearly_income - $pph_setting_3->batas_bawah);
        }

        $pph_setting_4  = \App\Models\PayrollPPH::where('id', 4)->first();
        $income_tax_calculation_30 = 0;
        if($taxable_yearly_income >= $pph_setting_4->batas_atas)
        {
            $income_tax_calculation_30 = ($pph_setting_4->tarif / 100) * ($taxable_yearly_income - $pph_setting_4->batas_bawah);
        }

        $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
        
        $params['yearly_income_tax']    = $yearly_income_tax;

        return $params; 
    }

    /**
     * Init Calculate
     * @return object
     */
    public function init_calculate()
    {
        $data = Payroll::all();

        $biaya_jabatan = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = PayrollOthers::where('id', 2)->first()->value;

        foreach($data as $item)
        {
            if(!isset($item->user->id))
            {
                $p = Payroll::where('user_id', $item->user_id)->first();
                if(!$p)
                {
                    $p->delete();
                }
                continue;
            }

            $temp                   = Payroll::where('id', $item->id)->first();
            $ptkp                   = PayrollPtkp::where('id', 1)->first();
            $bpjs_pensiunan_batas   = PayrollOthers::where('id', 3)->first()->value;
            $bpjs_kesehatan_batas   = PayrollOthers::where('id', 4)->first()->value;

            //$bpjs_ketenagakerjaan_persen = get_setting('bpjs_jkk_company') + get_setting('bpjs_jkm_company');
            //$bpjs_ketenagakerjaan = ($item->salary * $bpjs_ketenagakerjaan_persen / 100);
            
            //JHT EMPLOYEE
            $bpjs_ketenagakerjaan2_persen = get_setting('bpjs_jaminan_jht_employee');
            $bpjs_ketenagakerjaan2 = ($item->salary * $bpjs_ketenagakerjaan2_persen / 100);

            // start custom
            if(replace_idr($item->bpjs_ketenagakerjaan_employee) != $bpjs_ketenagakerjaan2)
            {
                if($item->is_calculate ==1)
                {
                    $bpjs_ketenagakerjaan2 = replace_idr($item->bpjs_ketenagakerjaan_employee);                    
                }
            }
            
            //JHT COMPANY
            $bpjs_jht_company_persen = get_setting('bpjs_jht_company');
            $bpjs_jht_company = ($item->salary * $bpjs_jht_company_persen / 100);
             // start custom
            if(replace_idr($item->bpjs_jht_company) != $bpjs_jht_company)
            {
                if($item->is_calculate ==1)
                {
                    $bpjs_jht_company = replace_idr($item->bpjs_jht_company);                    
                }
            }
            // end custom

            //JP EMPLOYEE
            $bpjs_pensiun2        = 0;
            $bpjs_pensiun2_persen = get_setting('bpjs_jaminan_jp_employee');

            if($item->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun2     = ($item->salary * $bpjs_pensiun2_persen / 100); 
            }
            else
            {
                $bpjs_pensiun2     = ($bpjs_pensiunan_batas * $bpjs_pensiun2_persen / 100);
            }

            // start custom
            if(replace_idr($item->bpjs_pensiun_employee) != $bpjs_pensiun2)
            {
                if($item->is_calculate ==1)
                {
                    $bpjs_pensiun2 = replace_idr($item->bpjs_pensiun_employee);                    
                }
            }
            // end custom

            //JP COMPANY
            $bpjs_pensiun_company        = 0;
            $bpjs_pensiun_company_persen = get_setting('bpjs_pensiun_company');

            if($item->salary <= $bpjs_pensiunan_batas)
            {
                $bpjs_pensiun_company     = ($item->salary * $bpjs_pensiun_company_persen / 100); 
            }
            else
            {
                $bpjs_pensiun_company     = ($bpjs_pensiunan_batas * $bpjs_pensiun_company_persen / 100);
            }

            // start custom
            if(replace_idr($item->bpjs_pensiun_company) != $bpjs_pensiun_company)
            {
                if($item->is_calculate ==1)
                {
                    $bpjs_pensiun_company = replace_idr($item->bpjs_pensiun_company);                    
                }
            }
            // end custom

            //KESEHATAN EMPLOYEE
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan2_persen = get_setting('bpjs_kesehatan_employee');
            if($item->salary <= $bpjs_kesehatan_batas)
            {
                $bpjs_kesehatan2     = ($item->salary * $bpjs_kesehatan2_persen / 100); 
            }
            else
            {
                $bpjs_kesehatan2     = ($bpjs_kesehatan_batas * $bpjs_kesehatan2_persen / 100);
            }

            // start custom
            if(replace_idr($item->bpjs_kesehatan_employee) != $bpjs_kesehatan2)
            {
                if($item->is_calculate ==1)
                {
                    $bpjs_kesehatan2 = replace_idr($item->bpjs_kesehatan_employee);                    
                }
            }
            // end custom

             //KESEHATAN COMPANY
             $bpjs_kesehatan_company        = 0;
             $bpjs_kesehatan_company_persen = get_setting('bpjs_kesehatan_company');
             if($item->salary <= $bpjs_kesehatan_batas)
             {
                 $bpjs_kesehatan_company     = ($item->salary * $bpjs_kesehatan_company_persen / 100); 
             }
             else
             {
                 $bpjs_kesehatan_company     = ($bpjs_kesehatan_batas * $bpjs_kesehatan_company_persen / 100);
             }
 
             // start custom
             if(replace_idr($item->bpjs_kesehatan_company) != $bpjs_kesehatan_company)
             {
                 if($item->is_calculate ==1)
                 {
                     $bpjs_kesehatan_company = replace_idr($item->bpjs_kesehatan_company);                    
                 }
             }
             // end custom
 
             //JKK COMPANY
             $bpjs_jkk_company_persen = get_setting('bpjs_jkk_company');
             $bpjs_jkk_company = ($item->salary * $bpjs_jkk_company_persen / 100);
              // start custom
             if(replace_idr($item->bpjs_jkk_company) != $bpjs_jkk_company)
             {
                 if($item->is_calculate ==1)
                 {
                     $bpjs_jkk_company = replace_idr($item->bpjs_jkk_company);                    
                 }
             }
             // end custom
 
             //JKM COMPANY
             $bpjs_jkm_company_persen = get_setting('bpjs_jkm_company');
             $bpjs_jkm_company = ($item->salary * $bpjs_jkm_company_persen / 100);
              // start custom
             if(replace_idr($item->bpjs_jkm_company) != $bpjs_jkm_company)
             {
                 if($item->is_calculate ==1)
                 {
                     $bpjs_jkm_company = replace_idr($item->bpjs_jkm_company);                    
                 }
             }
             // end custom
             $bpjstotalearning = $bpjs_jkk_company + $bpjs_jkm_company + $bpjs_jht_company + $bpjs_pensiun_company + $bpjs_kesehatan_company;
             //$bpjspenambahan = $bpjstotalearning;
             //$bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_pensiun2 +$bpjs_kesehatan2 + $bpjstotalearning;
             $bpjspenambahan = $bpjs_jkk_company + $bpjs_jkm_company+$bpjs_kesehatan_company;
             $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_pensiun2;

            $earnings = 0;
            if(isset($item->payrollEarningsEmployee))
            {
                foreach($item->payrollEarningsEmployee as $i)
                {
                    if(isset($i->payrollEarnings->title))
                    {
                        $earnings += $i->nominal;
                    }
                }
            }

            $gross_income = (($item->salary + $earnings + $bpjspenambahan) * 12 )+ $item->bonus;

            // burdern allowance
            $burden_allow = 5 * ($item->salary + $earnings + $bpjspenambahan + $item->bonus) / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deduction = ($bpjspengurangan * 12) + ($burden_allow*12);

            //$net_yearly_income          = $gross_income - $total_deduction;
            $net_yearly_val          = $gross_income - $total_deduction;
            $net_yearly_ratusan      = substr($net_yearly_val, -3);
            $net_yearly_income       = $net_yearly_val - $net_yearly_ratusan;


            $untaxable_income = 0;

            $ptkp = \App\Models\PayrollPtkp::where('id', 1)->first();
            if($item->user->marital_status == 'Bujangan/Wanita' || $item->user->marital_status == "")
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

            $pph_setting_1  = \App\Models\PayrollPPH::where('id', 1)->first();
            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= $pph_setting_1->batas_atas)
            {
                $income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= $pph_setting_1->batas_atas)
            {
                $income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $pph_setting_1->batas_atas;
            }

            $pph_setting_2  = \App\Models\PayrollPPH::where('id', 2)->first();
            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= $pph_setting_2->batas_atas)
            {
                $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($pph_setting_2->batas_atas - $pph_setting_2->batas_bawah);
            }
            if($taxable_yearly_income >= $pph_setting_2->batas_bawah and $taxable_yearly_income <= $pph_setting_2->batas_atas)
            {
                $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($taxable_yearly_income - $pph_setting_2->batas_bawah);
            }

            $pph_setting_3  = \App\Models\PayrollPPH::where('id', 3)->first();
            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= $pph_setting_3->batas_atas)
            {
                $income_tax_calculation_25 = ($pph_setting_3->tarif / 100)  * ($pph_setting_3->batas_atas - $pph_setting_3->batas_bawah);
            }
 
            if($taxable_yearly_income <= $pph_setting_3->batas_atas and $taxable_yearly_income >= $pph_setting_3->batas_bawah)
            {
                $income_tax_calculation_25 = ($pph_setting_3->tarif / 100) * ($taxable_yearly_income - $pph_setting_3->batas_bawah);
            }

            $pph_setting_4  = \App\Models\PayrollPPH::where('id', 4)->first();
            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= $pph_setting_4->batas_atas)
            {
                $income_tax_calculation_30 = ($pph_setting_4->tarif / 100) * ($taxable_yearly_income - $pph_setting_4->batas_bawah);
            }

            $yearly_income_tax              = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax             = $yearly_income_tax / 12;
            $gross_income_per_month         = $gross_income / 12;

            $less               = $bpjspengurangan + $monthly_income_tax; 

            $gross_thp = ($item->salary + $earnings + $item->bonus);

            $deductions = 0;
            if(isset($item->payrollDeductionsEmployee))
            {
                foreach($item->payrollDeductionsEmployee as $i)
                {
                    if(isset($i->payrollDeductions->title))
                    {
                        $deductions += $i->nominal;
                    }
                }
            }
            
            #$thp                = $gross_thp - $less - $deductions;
            $thp = ($item->salary + $item->bonus + $earnings + $bpjstotalearning) - ($deductions + $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2 + $monthly_income_tax + $bpjstotalearning);

            if(!isset($item->salary) || empty($item->salary)) $item->salary = 0;
            if(!isset($thp) || empty($thp)) $thp = 0;
            
            // start custom
            $thp                         = $thp + $monthly_income_tax;
 
            $non_bonus = $this->init_calculate_non_bonus($item);
            $monthly_income_tax = $yearly_income_tax - $non_bonus['yearly_income_tax'] + ($non_bonus['yearly_income_tax'] / 12);

            $earnings                     = $earnings + $monthly_income_tax;    
            
            #$temp->total_deduction              = $total_deduction + $deductions; 
            $temp->total_deduction              = $deductions + $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2 + $monthly_income_tax +$bpjstotalearning; 
            $temp->total_earnings               = $item->salary + $item->bonus + $earnings + $bpjstotalearning;
            $temp->thp                          = $thp;
            $temp->pph21                        = $monthly_income_tax;
            $temp->is_calculate                 = 1;
            $temp->bpjs_ketenagakerjaan_employee    = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan_employee          = $bpjs_kesehatan2;
            $temp->bpjs_pensiun_employee            = $bpjs_pensiun2;
            $temp->bpjs_jkk_company             = $bpjs_jkk_company;
            $temp->bpjs_jkm_company             = $bpjs_jkm_company;
            $temp->bpjs_jht_company             = $bpjs_jht_company;
            $temp->bpjs_pensiun_company         = $bpjs_pensiun_company;
            $temp->bpjs_kesehatan_company       = $bpjs_kesehatan_company;
            $temp->bpjstotalearning             = $bpjstotalearning;
            $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
            $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
            //$temp->bpjs_pensiun_company         = $bpjs_pensiun;
            //$temp->bpjs_kesehatan_company       = $bpjs_kesehatan; //get_setting('bpjs_kesehatan_company');
            $temp->yearly_income_tax            = $yearly_income_tax;  
            $temp->burden_allow                 = $burden_allow; 
            $temp->save(); 


            $bonus = $temp->bonus;
            $user_id        = $temp->user_id;
            $payroll_id     = $temp->id;
            

            $history                   = new PayrollHistory();
            $history->payroll_id       = $payroll_id;
            $history->user_id          = $user_id;
            $history->salary           = $temp->salary;
            $history->gross_income     = $temp->gross_income; 
            $history->thp                          = $temp->thp;
            $history->bpjs_jkk_company                 = $temp->bpjs_jkk_company;
            $history->bpjs_jkm_company                 = $temp->bpjs_jkm_company;
            $history->bpjs_jht_company                 = $temp->bpjs_jht_company;
            $history->bpjs_pensiun_company             = $temp->bpjs_pensiun_company;
            $history->bpjs_kesehatan_company           = $temp->bpjs_kesehatan_company;
            $history->bpjstotalearning                 = $temp->bpjstotalearning;

            $history->bpjs_ketenagakerjaan2            = $temp->bpjs_ketenagakerjaan2;
            $history->bpjs_kesehatan2                  = $temp->bpjs_kesehatan2;
            $history->bpjs_pensiun2                    = $temp->bpjs_pensiun2;
            $history->total_deduction                  = $temp->total_deduction;
            $history->total_earnings                   = $temp->total_earnings;
            $history->pph21                            = $temp->pph21;
            
            $history->bpjs_ketenagakerjaan_employee   = $temp->bpjs_ketenagakerjaan_employee;
            $history->bpjs_kesehatan_employee         = $temp->bpjs_kesehatan_employee;
            $history->bpjs_pensiun_employee           = $temp->bpjs_pensiun_employee;
            $history->bonus                           = $temp->bonus;
            $history->burden_allow                    = $temp->burden_allow;
            $history->yearly_income_tax               = $temp->yearly_income_tax;
            
            $history->save();
            $payroll_id = $history->id;
            // save earnings
            if(isset($temp->payrollEarningsEmployee))
            {
                foreach($temp->payrollEarningsEmployee as $key => $value)
                {
                    $earning                        = new PayrollEarningsEmployeeHistory();
                    $earning->payroll_id            = $payroll_id;
                    $earning->payroll_earning_id    = $value->payroll_earning_id;
                    $earning->nominal               = $value->nominal; 
                    $earning->save();
                }
            }
            // save deductions
            if(isset($temp->payrollDeductionsEmployee))
            {
                foreach($temp->payrollDeductionsEmployee as $key => $value)
                {
                    $deduction                        = new PayrollDeductionsEmployeeHistory();
                    $deduction->payroll_id            = $payroll_id;
                    $deduction->payroll_deduction_id  = $value->payroll_deduction_id;
                    $deduction->nominal               = $value->nominal; 
                    $deduction->save();
                }
            }

        }
    }

    /**
     * Send Pay Slip
     * @return email
     */
    public function sendsubmitpayslip($year,$month) {
        $request = request();

        $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];

        $bulan = $bulanArray[$month];

        if(isset($request->user_id))
        {
            foreach($request->user_id as $user_id)
            {
                $user = User::where('id', $user_id)->first();
                $dataArray   = \DB::select(\DB::raw("SELECT payroll_history.*, month(created_at) as bulan FROM payroll_history WHERE MONTH(created_at)=". $month ." and user_id=". $user_id ." and YEAR(created_at) =". $year. ' ORDER BY id DESC'));
                    if(!$dataArray)
                    {
                        continue;
                    }else
                    {
                        if($dataArray)
                        {
                            $skip = 0;
                            foreach ($dataArray as $key => $value) {
                                # code...
                                if($value->is_lock == 0 || empty($value->is_lock) || $value->is_lock == null) {
                                    $skip = 1;
                                }
                            }
                            if($skip == 1){
                                continue;
                            } 
                        }
                    }
                /*
                if($month == (Int)date('m') and $year == date('Y'))
                {
                    $dataArray   = \DB::select(\DB::raw("SELECT payroll.*, month(created_at) as bulan FROM payroll WHERE MONTH(created_at)=". $month ." and user_id=". $user_id ." and YEAR(created_at) =". $year. ' ORDER BY id DESC'));
                    if(!$dataArray)
                    {
                        continue;
                    }else
                    {
                        $skip = 0;
                        if($dataArray){
                            foreach ($dataArray as $key => $value) {
                            # code...
                                if($value->is_lock == 0 || empty($value->is_lock) || $value->is_lock == null) {
                                    $skip = 1;
                                }
                            }
                            if($skip == 1) {
                                continue;
                            }
                        }
                    }
                }
                else {
                    $dataArray   = \DB::select(\DB::raw("SELECT payroll_history.*, month(created_at) as bulan FROM payroll_history WHERE MONTH(created_at)=". $month ." and user_id=". $user_id ." and YEAR(created_at) =". $year. ' ORDER BY id DESC'));
                     if(!$dataArray)
                    {
                        continue;
                    }else
                    {
                        if($dataArray)
                        {
                            $skip = 0;
                            foreach ($dataArray as $key => $value) {
                                # code...
                                if($value->is_lock == 0 || empty($value->is_lock) || $value->is_lock == null) {
                                    $skip = 1;
                                }
                            }
                            if($skip == 1){
                                continue;
                            } 
                        }
                    }
                }
                */
                
                if(!$dataArray){
                    continue;
                }else {
                    $params['dataArray']            = $dataArray;
                    $params['user']                 = $user;
                    $params['bulan']                = $bulan;
                    $params['tahun']                = $year;

                    $view =  view('administrator.payroll.print-pay-slip')->with($params);

                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadHTML($view);

                    $pdf->stream();

                    $output = $pdf->output();
                    $destinationPath = public_path('/storage/temp/');

                    file_put_contents( $destinationPath . $user->nik .'.pdf', $output);

                    $file = $destinationPath . $user->nik .'.pdf';

                    // send email
                    $objDemo = new \stdClass();
                    $objDemo->content = view('administrator.request-pay-slip.email-pay-slip'); 
                    
                    if($user->email != "")
                    { 
                        \Mail::send('administrator.request-pay-slip.email-pay-slip', $params,
                            function($message) use($file, $user, $bulan) {
                                //$message->from('info@system.com');
                                $message->to($user->email);
                                $message->subject('Request Pay-Slip Bulan ('.$bulan.')');
                                $message->attach($file, array(
                                        'as' => 'Payslip-'. $user->nik .'('.$bulan.').pdf', 
                                        'mime' => 'application/pdf')
                                );
                                $message->setBody('');
                            }
                        );
                    }
                }
            }
        }
        return redirect()->route('administrator.payroll.index')->with('message-success', 'Pay Slip Send successfully');
    }
    public function sendPaySlip()
    {
        $request = request();

        if(isset($request->user_id))
        {
            foreach($request->user_id as $user_id)
            {
                $data                       = new RequestPaySlip();
                $data->user_id              = $user_id;
                $data->status               = 1;   
                $data->save();

                if(!isset($data->user->nik)) continue;

                foreach($request->bulan as $key => $i)
                {   
                    $item               = new RequestPaySlipItem();
                    $item->tahun        = $request->tahun;
                    $item->request_pay_slip_id = $data->id;
                    $item->bulan        = $i;
                    $item->status       = 1; 
                    $item->user_id      = $user_id;
                    $item->save();
                }

                $bulanItem = RequestPaySlipItem::where('request_pay_slip_id', $data->id)->get();
                $bulan = [];
                $total = 0;
                $dataArray = [];
                $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                foreach($bulanItem as $k => $i)
                {
                    $bulan[$k] = $bulanArray[$i->bulan]; $total++;


                    if($i->bulan == (Int)date('m') and $request->tahun == date('Y'))
                    {
                        $items   = \DB::select(\DB::raw("SELECT payroll.*, month(created_at) as bulan FROM payroll WHERE MONTH(created_at)=". $i->bulan ." and user_id=". $data->user_id ." and YEAR(created_at) =". $request->tahun. ' ORDER BY id DESC'));
                        
                        if($items)
                        {

                            if(isset($items->is_lock) and $items->is_lock == 0) continue; // jika payroll belum di lock payslip jangan dikirim
                        }
                    }
                    else
                        $items   = \DB::select(\DB::raw("SELECT payroll_history.*, month(created_at) as bulan FROM payroll_history WHERE MONTH(created_at)=". $i->bulan ." and user_id=". $data->user_id ." and YEAR(created_at) =". $request->tahun. ' ORDER BY id DESC'));

                    if(!$items)
                    {
                        $items   = \DB::select(\DB::raw("SELECT * FROM payroll_history WHERE user_id=". $data->user_id ." and YEAR(created_at) =". $request->tahun ." ORDER BY id DESC"));
                        if(!$items)
                        {
                            continue;
                        }
                        $dataArray[$k] = $items[0];
                    }
                    else
                    {
                        $dataArray[$k] = $items[0];
                    }
                }

            //    $payroll = Payroll::where('user_id', $request->user_id)->first();

                $params['total']                = $total;
                $params['dataArray']            = $dataArray;
                $params['data']                 = $data;
                $params['bulan']                = $bulan;
                $params['tahun']                = $request->tahun;

           //     $params['total_earning']        = $payroll->total_earnings;
            //    $params['total_deduction']      = $payroll->total_deduction;

                $view =  view('administrator.request-pay-slip.print-pay-slip')->with($params);

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $pdf->stream();

                $output = $pdf->output();
                $destinationPath = public_path('/storage/temp/');

                file_put_contents( $destinationPath . $data->user->nik .'.pdf', $output);

                $file = $destinationPath . $data->user->nik .'.pdf';

                // send email
                $objDemo = new \stdClass();
                $objDemo->content = view('administrator.request-pay-slip.email-pay-slip'); 
                
                if($data->user->email != "")
                { 
                    \Mail::send('administrator.request-pay-slip.email-pay-slip', $params,
                        function($message) use($file, $data, $bulan) {
                            //$message->from('info@system.com');
                            $message->to($data->user->email);
                            $message->subject('Request Pay-Slip Bulan ('. implode('/', $bulan) .')');
                            $message->attach($file, array(
                                    'as' => 'Payslip-'. $data->user->nik .'('. implode('/', $bulan) .').pdf', 
                                    'mime' => 'application/pdf')
                            );
                            $message->setBody('');
                        }
                    );
                }
                
                $data->note     = $request->note;
                $data->status   = 2;
                $data->save();
            }
        }

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Pay Slip Send successfully');
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
                $count_row = 5;
            	if($key ==0) continue;

                $nik                    = $row[1];
                // cek user 
                $user = User::where('nik', $nik)->first();
                if($user)
                {   
                    // cek exit payrol user
                    $payroll = Payroll::where('user_id', $user->id)->first();
                    $new = 0;
                    if(!$payroll)
                    {
                        $payroll            = new Payroll();
                        $payroll->user_id   = $user->id;
                        $payroll->is_calculate  = 0;
                        $new = 1;
                    }

                    $is_calculate = 1;

                    if($payroll->salary == 0)
                    {
                        $is_calculate   = 0;
                    }
                    
                    if($payroll->salary != replace_idr($row[3])) $is_calculate = 0;
                    
                    $payroll->salary        = replace_idr($row[3]);
                    $payroll->bonus        = replace_idr($row[4]);
                    $payroll->is_calculate  = $is_calculate;
                    $payroll->save();

                    // jika payroll belum ada insert baru
                    if($new==1)
                    {
                        if(\Auth::user()->project_id != Null){
                            $payrollearning = PayrollEarnings::where('user_created', \Auth::user()->id)->get();
                        }else{
                            $payrollearning = PayrollEarnings::all();
                        }
                        foreach($payrollearning as $item)
                        {   
                            if(!empty($row[$count_row]))
                            {
                                $earning                        = new PayrollEarningsEmployee();
                                $earning->payroll_earning_id    = $item->id;
                                $earning->payroll_id            = $payroll->id;
                                $earning->nominal               = replace_idr($row[$count_row]);
                                $earning->save();
                            }
                            $count_row++;
                        }

                        if(\Auth::user()->project_id != Null){
                            $payrolldeduction = PayrollDeductions::where('user_created', \Auth::user()->id)->get();
                        }else{
                            $payrolldeduction = PayrollDeductions::all();
                        }
                        foreach($payrolldeduction as $item)
                        {   
                            if(!empty($row[$count_row]))
                            {
                                $earning                        = new PayrollDeductionsEmployee();
                                $earning->payroll_deduction_id  = $item->id;
                                $earning->payroll_id            = $payroll->id;
                                $earning->nominal               = replace_idr($row[$count_row]);
                                $earning->save();
                            }
                            $count_row++;
                        }
                    }
                    if($new==0)
                    {
                        if(\Auth::user()->project_id != Null){
                            $payrollearning = PayrollEarnings::where('user_created', \Auth::user()->id)->get();
                        }else{
                            $payrollearning = PayrollEarnings::all();
                        }
                        foreach($payrollearning as $i)
                        {   
                            if(!empty($row[$count_row]))
                            {
                                $earning = PayrollEarningsEmployee::where('payroll_id', $payroll->id)->where('payroll_earning_id', $i->id)->first();
                                if(!$earning) 
                                {
                                   $earning = new PayrollEarningsEmployee(); 
                                   $earning->payroll_id = $payroll->id;
                                   $earning->payroll_earning_id = $i->id;
                                }

                                $earning->nominal = replace_idr($row[$count_row]);
                                $earning->save();

                            }
                            $count_row++;
                        }

                        // earnings
                        if(\Auth::user()->project_id != Null){
                            $payrolldeduction = PayrollDeductions::where('user_created', \Auth::user()->id)->get();
                        }else{
                            $payrolldeduction = PayrollDeductions::all();
                        }
                        foreach($payrolldeduction as $i)
                        {   
                            if(!empty($row[$count_row]))
                            {
                                $earning = PayrollDeductionsEmployee::where('payroll_id', $payroll->id)->where('payroll_deduction_id', $i->id)->first();
                                if(!$earning) 
                                {
                                   $earning = new PayrollDeductionsEmployee(); 
                                   $earning->payroll_id = $payroll->id;
                                   $earning->payroll_deduction_id = $i->id;
                                }
                                
                                $earning->nominal = replace_idr($row[$count_row]);
                                $earning->save();

                            }
                            $count_row++;
                        }
                    }
                }
	        }

            return redirect()->route('administrator.payroll.index')->with('messages-success', 'Data Payroll successfully import !');
        }
    }

    /**
     * Delete Payroll Earning
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteEarningPayroll($id)
    {
        $data = PayrollEarningsEmployee::where('id', $id)->first();
        if($data)
        {
            $payroll_id = $data->payroll_id;

            $data->delete();
        }

        //$this->init_calculate();

        return redirect()->route('administrator.payroll.detail', $payroll_id);
    }


    /**
     * Delete Payroll Deduction
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteDeductionPayroll($id)
    {
        $data = PayrollDeductionsEmployee::where('id', $id)->first();
        if($data)
        {
            $payroll_id = $data->payroll_id;

            $data->delete();
        }

        //$this->init_calculate();

        return redirect()->route('administrator.payroll.detail', $payroll_id);
    }
}
