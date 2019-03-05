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
use App\Models\PayrollDeductionsEmployee;
use App\Models\PayrollEarnings;
use App\Models\PayrollDeductions;

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
        $result = Payroll::select('payroll.*')->join('users', 'users.id','=', 'payroll.user_id')->orderBy('payroll.id', 'DESC');

        if(request())
        {
            if(!empty(request()->is_calculate))
            {
                $result = $result->where('is_calculate', request()->is_calculate );
            }

            if(!empty(request()->employee_status))
            {
                $result = $result->where('users.organisasi_status', request()->employee_status);
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

        return view('administrator.payroll.index')->with($params);
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
            $params[$k]['Salary']           = $item->salary;
            
            // earnings
            foreach(PayrollEarnings::all() as $i)
            {   
                $earning = PayrollEarningsEmployee::where('payroll_id', $item->id)->where('payroll_earning_id', $i->id)->first();
                if($earning) 
                {
                    $earning = number_format($earning->nominal);
                }
                else
                    $earning = 0;

                $params[$k][$i->title] = $earning;
            }

            // earnings
            foreach(PayrollDeductions::all() as $i)
            {   
                $deduction = PayrollDeductionsEmployee::where('payroll_id', $item->id)->where('payroll_deduction_id', $i->id)->first();
                if($deduction) 
                {
                    $deduction = number_format($deduction->nominal);
                }
                else
                    $deduction = 0;

                $params[$k][$i->title] = $deduction;
            }

            $params[$k]['BPJS Jaminan Kecelakaan Kerja (JKK) (Company) '. get_setting('bpjs_jkk_company').'%']  = $item->salary *  get_setting('bpjs_jkk_company') / 100;
            $params[$k]['BPJS Jaminan Kematian (JKM) (Company) '. get_setting('bpjs_jkm_company').'%']          = $item->salary *  get_setting('bpjs_jkm_company') / 100;
            $params[$k]['BPJS Jaminan Hari Tua (JHT) (Company) '. get_setting('bpjs_jht_company').'%']          = $item->salary *  get_setting('bpjs_jht_company') / 100;
            $params[$k]['BPJS Pensiun (Company) '. get_setting('bpjs_pensiun_company').'%']                     = $item->salary *  get_setting('bpjs_pensiun_company') / 100;
            $params[$k]['BPJS Kesehatan (Company) '. get_setting('bpjs_kesehatan_company').'%']                 = $item->salary *  get_setting('bpjs_kesehatan_company') / 100;
            $params[$k]['BPJS Jaminan Hari Tua (JHT) (Employee) '. get_setting('bpjs_jaminan_jht_employee').'%']= $item->salary *  get_setting('bpjs_jaminan_jht_employee') / 100;
            $params[$k]['BPJS Jaminan Pensiun (JP) (Employee) '. get_setting('bpjs_jaminan_jp_employee').'%']   = $item->salary *  get_setting('bpjs_jaminan_jp_employee') / 100;
            $params[$k]['BPJS Kesehatan (Employee) '. get_setting('bpjs_kesehatan_employee').'%']               = $item->salary *  get_setting('bpjs_kesehatan_employee') / 100;
            
            $params[$k]['Total Deduction (Burden + BPJS)']      = $item->total_deduction;
            $params[$k]['Total Earnings']                       = $item->total_earnings;
            #$params[$k]['Yearly Income Tax']                    = $item->yearly_income_tax;
            #$params[$k]['Monthly Income Tax / PPh21']           = $item->pph21;
            #$params[$k]['GROSS INCOME PER MONTH']               = $item->gross_income_per_month;
            #$params[$k]['Less : Tax, BPJS (Monthly)']           = $item->less;
            $params[$k]['Take Home Pay']                        = $item->thp;
            $params[$k]['Acc No']                               = isset($item->user->nomor_rekening) ? $item->user->nomor_rekening : '';
            $params[$k]['Acc Name']                             = isset($item->user->nama_rekening) ? $item->user->nama_rekening : '';
            $params[$k]['Bank Name']                            = isset($item->user->bank->name) ? $item->user->bank->name : '';
            $params[$k]['Amount']                               = isset($item->user->nomor_rekening) ? $item->user->nomor_rekening : '';
        }

        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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

        return \Excel::create('Report-Payroll-'.date('Y-m-d'),  function($excel) use($params, $styleHeader){

              $excel->sheet('Payroll',  function($sheet) use($params){

                $sheet->fromArray($params);
                
              });

            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);

        })->download('xls');
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
            if(!isset($request->bpjs_ketenagakerjaan) || empty($request->bpjs_ketenagakerjaan)) $request->bpjs_ketenagakerjaan = 0;
            if(!isset($request->bpjs_kesehatan) || empty($request->bpjs_kesehatan)) $request->bpjs_kesehatan = 0;
            if(!isset($request->bpjs_pensiun) || empty($request->bpjs_pensiun)) $request->bpjs_pensiun = 0;
            if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
            if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
            if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;
            if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;
            
            $temp->user_id                          = $request->user_id;
            $temp->salary                           = replace_idr($request->salary);
            $temp->thp                              = replace_idr($request->thp);
            $temp->is_calculate                     = 1;
            $temp->bpjs_ketenagakerjaan             = replace_idr($request->bpjs_ketenagakerjaan);
            $temp->bpjs_kesehatan                   = replace_idr($request->bpjs_kesehatan);
            $temp->bpjs_pensiun                     = replace_idr($request->bpjs_pensiun);
            $temp->bpjs_ketenagakerjaan2            = replace_idr($request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = replace_idr($request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = replace_idr($request->bpjs_pensiun2);
            $temp->total_deduction                  = $request->total_deductions;
            $temp->total_earnings                   = $request->total_earnings;
            $temp->pph21                            = replace_idr($request->pph21);
            $temp->bpjs_ketenagakerjaan_company             = replace_idr($request->bpjs_ketenagakerjaan_company);
            $temp->bpjs_kesehatan_company                   = replace_idr($request->bpjs_kesehatan_company);
            $temp->bpjs_pensiun_company                     = replace_idr($request->bpjs_pensiun_company);
            $temp->bpjs_ketenagakerjaan_employee             = replace_idr($request->bpjs_ketenagakerjaan_employee);
            $temp->bpjs_kesehatan_employee                   = replace_idr($request->bpjs_kesehatan_employee);
            $temp->bpjs_pensiun_employee                     = replace_idr($request->bpjs_pensiun_employee);
            $temp->bonus                                     = replace_idr($request->bonus);
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
            $temp->salary               = str_replace(',', '', $request->salary);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
            $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
            $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
            $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
            $temp->save();

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
        $temp = Payroll::where('id', $id)->first();

        if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
        if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;

        $temp->salary                           = replace_idr($request->salary);
        $temp->thp                              = replace_idr($request->thp);
        
        $temp->bpjs_ketenagakerjaan             = replace_idr($request->bpjs_ketenagakerjaan);
        $temp->bpjs_kesehatan                   = replace_idr($request->bpjs_kesehatan);
        $temp->bpjs_pensiun                     = replace_idr($request->bpjs_pensiun);
        $temp->bpjs_ketenagakerjaan2            = replace_idr($request->bpjs_ketenagakerjaan2);
        $temp->bpjs_kesehatan2                  = replace_idr($request->bpjs_kesehatan2);
        $temp->bpjs_pensiun2                    = replace_idr($request->bpjs_pensiun2);

        $temp->total_deduction                  = $request->total_deductions;
        $temp->total_earnings                   = $request->total_earnings;
        $temp->pph21                            = replace_idr($request->pph21);

        $temp->bpjs_ketenagakerjaan_company     = replace_idr($request->bpjs_ketenagakerjaan_company);
        $temp->bpjs_kesehatan_company           = replace_idr($request->bpjs_kesehatan_company);
        $temp->bpjs_pensiun_company             = replace_idr($request->bpjs_pensiun_company);
        $temp->bpjs_ketenagakerjaan_employee    = replace_idr($request->bpjs_ketenagakerjaan_employee);
        $temp->bpjs_kesehatan_employee          = replace_idr($request->bpjs_kesehatan_employee);
        $temp->bpjs_pensiun_employee            = replace_idr($request->bpjs_pensiun_employee);

        $temp->bpjs_jkk_company             = get_setting('bpjs_jkk_company');
        $temp->bpjs_jkm_company             = get_setting('bpjs_jkm_company');
        $temp->bpjs_jht_company             = get_setting('bpjs_jht_company');
        $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
        $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
        $temp->bpjs_pensiun_company         = get_setting('bpjs_pensiun_company');
        $temp->bpjs_kesehatan_company       = get_setting('bpjs_kesehatan_company');

        $temp->bonus                                     = replace_idr($request->bonus);
        $temp->save(); 

        // save earnings
        if(isset($request->earning))
        {
            foreach($request->earning as $key => $value)
            {
                $earning = PayrollEarningsEmployee::where('payroll_id', $temp->id)->where('payroll_earning_id', $value)->first();
                if(!$earning)
                {
                    $earning                        = new PayrollEarningsEmployee();
                    $earning->payroll_id            = $temp->id;
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
                $deduction                        = PayrollDeductionsEmployee::where('payroll_id', $temp->id)->where('payroll_deduction_id', $value)->first();
                if(!$deduction)
                {
                    $deduction                        = new PayrollDeductionsEmployee();
                    $deduction->payroll_id            = $temp->id;
                    $deduction->payroll_deduction_id  = $value;
                }
                
                $deduction->nominal               = replace_idr($request->deduction_nominal[$key]); 
                $deduction->save();
            }
        }
        
        $temp = new PayrollHistory();
        $temp->payroll_id            = $id;
        $temp->user_id              = $request->user_id;
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->thp                          = str_replace(',', '', $request->thp);
        $temp->bpjs_jkk_company             = get_setting('bpjs_jkk_company');
        $temp->bpjs_jkm_company             = get_setting('bpjs_jkm_company');
        $temp->bpjs_jht_company             = get_setting('bpjs_jht_company');
        $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
        $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
        $temp->bpjs_kesehatan_employee      = get_setting('bpjs_kesehatan_employee');
        $temp->bpjs_pensiun_company         = get_setting('bpjs_pensiun_company');
        $temp->bpjs_kesehatan_company       = get_setting('bpjs_kesehatan_company');
        $temp->save();

        return redirect()->route('administrator.payroll.detail', $id)->with('message-success', __('general.message-data-saved-success'));
    }

    /**
     * [download description]
     * @return [type] [description]
     */
    public function download()
    {
        $users = \App\User::where('access_id', 2)->get();

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
                
                foreach(PayrollEarnings::all() as $item)
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
                foreach(PayrollDeductions::all() as $item)
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
                foreach(PayrollEarnings::all() as $item)
                {   
                    $params[$k][$item->title] = 0;
                }

                // earnings
                foreach(PayrollDeductions::all() as $item)
                {   
                    $params[$k][$item->title] = 0;
                }
            }
        }

        return \Excel::create('Payroll-Template-'. date('Y-m-d'),  function($excel) use($params){
              $excel->sheet('Payroll',  function($sheet) use($params){
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
        $params['data'] = Payroll::where('id', $id)->first();

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

    public function init_calculate()
    {
        $data = Payroll::all();

        $biaya_jabatan = PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = PayrollOthers::where('id', 2)->first()->value;

        foreach($data as $item)
        {
            $temp                   = Payroll::where('id', $item->id)->first();
            $ptkp                   = PayrollPtkp::where('id', 1)->first();
            $bpjs_pensiunan_batas   = PayrollOthers::where('id', 3)->first()->value;
            $bpjs_kesehatan_batas   = PayrollOthers::where('id', 4)->first()->value;

            $bpjs_ketenagakerjaan_persen = get_setting('bpjs_jkk_company') + get_setting('bpjs_jkm_company');
            $bpjs_ketenagakerjaan = ($item->salary * $bpjs_ketenagakerjaan_persen / 100);
            $bpjs_ketenagakerjaan2_persen = get_setting('bpjs_jaminan_jht_employee');
            $bpjs_ketenagakerjaan2 = ($item->salary * $bpjs_ketenagakerjaan2_persen / 100);

            $params['$bpjs_ketenagakerjaan'] = $bpjs_ketenagakerjaan;

            $bpjs_kesehatan         = 0;
            $bpjs_kesehatan2        = 0;
            $bpjs_kesehatan_persen  = get_setting('bpjs_kesehatan_company');
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
            $bpjs_pensiun2_persen = get_setting('bpjs_jaminan_jp_employee');

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

            $params['$bpjs_kesehatan'] = $bpjs_kesehatan;

            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan;
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

            $gross_income = ($item->salary + $earnings + $bpjspenambahan) * 12 + $item->bonus;

            $gross_income2 = ($item->salary + $earnings + $bpjspenambahan + $item->bonus) - $bpjspengurangan;

            // burdern allowance
            $burden_allow = 5 * $gross_income2 / 100;
            $biaya_jabatan_bulan = $biaya_jabatan / 12;
            if($burden_allow > $biaya_jabatan_bulan)
            {
                $burden_allow = $biaya_jabatan_bulan;
            }
 
            $total_deduction = ($bpjspengurangan * 12) + ($burden_allow*12);

            $net_yearly_income          = $gross_income - $total_deduction;

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
            $gross_income_per_month       = $gross_income / 12;

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
            $thp = ($item->salary + $item->bonus + $earnings) - ($deductions + $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2 + $monthly_income_tax);

            if(!isset($item->salary) || empty($item->salary)) $item->salary = 0;
            if(!isset($thp) || empty($thp)) $thp = 0;
            
            #$temp->total_deduction              = $total_deduction + $deductions; 
            $temp->total_deduction              = $deductions + $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2; 
            $temp->total_earnings               = $item->salary + $item->bonus + $earnings;
            $temp->thp                          = $thp;
            $temp->pph21                        = $monthly_income_tax;
            $temp->is_calculate                 = 1;

            $temp->bpjs_ketenagakerjaan_employee    = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan_employee          = $bpjs_kesehatan2;
            $temp->bpjs_pensiun_employee            = $bpjs_pensiun2;
            
            $temp->bpjs_jkk_company             = get_setting('bpjs_jkk_company');
            $temp->bpjs_jkm_company             = get_setting('bpjs_jkm_company');
            $temp->bpjs_jht_company             = get_setting('bpjs_jht_company');
            $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
            $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
            #$temp->bpjs_kesehatan_employee      = get_setting('bpjs_kesehatan_employee');
            $temp->bpjs_pensiun_company         = get_setting('bpjs_pensiun_company');
            $temp->bpjs_kesehatan_company       = get_setting('bpjs_kesehatan_company');
            $temp->save(); 

            $user_id        = $temp->user_id;
            $payroll_id     = $temp->id;

            $temp                               = new PayrollHistory();
            $temp->payroll_id                   = $payroll_id;
            $temp->user_id                      = $user_id;
            $temp->salary                       = replace_idr($item->salary);
            $temp->thp                          = replace_idr($thp);
            $temp->bpjs_jkk_company             = get_setting('bpjs_jkk_company');
            $temp->bpjs_jkm_company             = get_setting('bpjs_jkm_company');
            $temp->bpjs_jht_company             = get_setting('bpjs_jht_company');
            $temp->bpjs_jaminan_jht_employee    = get_setting('bpjs_jaminan_jht_employee');
            $temp->bpjs_jaminan_jp_employee     = get_setting('bpjs_jaminan_jp_employee');
            $temp->bpjs_kesehatan_employee      = get_setting('bpjs_kesehatan_employee');
            $temp->bpjs_pensiun_company         = get_setting('bpjs_pensiun_company');
            $temp->bpjs_kesehatan_company       = get_setting('bpjs_kesehatan_company');
            $temp->save();
        }
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
                $count_row = 4;
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
                    $payroll->salary        = replace_idr($row[3]);
                    $payroll->is_calculate  = $is_calculate;
                    $payroll->save();

                    // jika payroll belum ada insert baru
                    if($new==1)
                    {
                        foreach(PayrollEarnings::all() as $item)
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

                        foreach(PayrollDeductions::all() as $item)
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
                        foreach(PayrollEarnings::all() as $i)
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
                        foreach(PayrollDeductions::all() as $i)
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

        $this->init_calculate();

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

        $this->init_calculate();

        return redirect()->route('administrator.payroll.detail', $payroll_id);
    }
}
