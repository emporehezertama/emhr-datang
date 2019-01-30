<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $result = \App\Payroll::select('payroll.*')->join('users', 'users.id','=', 'payroll.user_id')->orderBy('payroll.id', 'DESC');

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
            $bank = \App\Bank::where('id', $item->bank_id)->first();

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
            $params[$k]['Call Allowance']                       = $item->call_allow;
            $params[$k]['Transport Allowance']                  = $item->transport_allowance;
            $params[$k]['Homebase Allowance']                   = $item->homebase_allowance;
            $params[$k]['Laptop Allowance']                     = $item->laptop_allowance;
            $params[$k]['OT Normal Hours']                      = $item->ot_normal_hours;
            $params[$k]['OT Multiple Hours']                    = $item->ot_multiple_hours;
            $params[$k]['Overtime Claim']                       = $item->overtime_claim ;
            $params[$k]['Other Income']                         = $item->other_income;
            $params[$k]['Remark Other Income']                  = $item->remark_other_income;
            $params[$k]['Medical Claim']                        = $item->medical_claim;
            $params[$k]['Remark Medical']                       = $item->remark;
            $params[$k]['Yearly Bonus, THR or others']          = $item->bonus;
            $params[$k]['Other Deduction']                      = $item->other_deduction;
            $params[$k]['RemarkOther Deduction']                = $item->remark_other_deduction;
            $params[$k]['Gross Income Per Year']                = $item->gross_income;
            $params[$k]['Burden Allowance (Monthly)']           = $item->burden_allow;
            $params[$k]['BPJS Ketengakerjaan 4.24 %']           = $item->bpjs_ketenagakerjaan;
            $params[$k]['BPJS Kesehatan (4%)']                  = $item->bpjs_kesehatan;
            $params[$k]['BPJS Pensiun 2%']                      = $item->bpjs_pensiun;
            $params[$k]['BPJS Ketenagakerjaan 2% ']             = $item->bpjs_ketenagakerjaan2;
            $params[$k]['BPJS Dana Pensiun (1%)']               = $item->bpjs_pensiun2;
            $params[$k]['BPJS Kesehatan (1%)']                  = $item->bpjs_kesehatan2;
            $params[$k]['Total Deduction (Burden + BPJS)']      = $item->total_deduction;
            $params[$k]['Yearly Income Tax']                    = $item->yearly_income_tax;
            $params[$k]['Monthly Income Tax / PPh21']           = $item->monthly_income_tax;
            $params[$k]['GROSS INCOME PER MONTH']               = $item->gross_income_per_month;
            $params[$k]['Less : Tax, BPJS (Monthly)']           = $item->less;
            $params[$k]['Take Home Pay'] = $item->thp;
            $params[$k]['Acc No']                               = $item->user->nomor_rekening;
            $params[$k]['Acc Name']                             = $item->user->nama_rekening;
            $params[$k]['Bank Name']                            = isset($item->user->bank->name) ? $item->user->bank->name : '';
            $params[$k]['Amount']                               = $item->user->nomor_rekening;
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

        return \Excel::create('Report-Payroll',  function($excel) use($params, $styleHeader){

              $excel->sheet('mysheet',  function($sheet) use($params){

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
        $temp = new \App\Payroll();
        
         if((!isset($request->salary) || empty($request->salary)) && (!isset($request->salary) || empty($request->salary))) {
             return redirect()->route('administrator.payroll.create')->with('message-error', 'Employee Name & Actual Salary can not empty');

        } else{

            if(!isset($request->basic_salary) || empty($request->basic_salary)) $request->basic_salary = 0;
            if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
            if(!isset($request->call_allow) || empty($request->call_allow)) $request->call_allow = 0;
            if(!isset($request->bonus) || empty($request->bonus)) $request->bonus = 0;
            if(!isset($request->transport_allowance) || empty($request->transport_allowance)) $request->transport_allowance = 0;
            if(!isset($request->homebase_allowance) || empty($request->homebase_allowance)) $request->homebase_allowance = 0;
            if(!isset($request->laptop_allowance) || empty($request->laptop_allowance)) $request->laptop_allowance = 0;
            if(!isset($request->ot_normal_hours) || empty($request->ot_normal_hours)) $request->ot_normal_hours = 0;
            if(!isset($request->ot_multiple_hours) || empty($request->ot_multiple_hours)) $request->ot_multiple_hours = 0;
            if(!isset($request->other_income) || empty($request->other_income)) $request->other_income = 0;
            if(!isset($request->medical_claim) || empty($request->medical_claim)) $request->medical_claim = 0;
            if(!isset($request->overtime_claim) || empty($request->overtime_claim)) $request->overtime_claim = 0;
            if(!isset($request->other_deduction) || empty($request->other_deduction)) $request->other_deduction = 0;
            if(!isset($request->gross_income) || empty($request->gross_income)) $request->gross_income = 0;
            if(!isset($request->burden_allow) || empty($request->burden_allow)) $request->burden_allow = 0;
            if(!isset($request->bpjs_ketenagakerjaan) || empty($request->bpjs_ketenagakerjaan)) $request->bpjs_ketenagakerjaan = 0;
            if(!isset($request->bpjs_kesehatan) || empty($request->bpjs_kesehatan)) $request->bpjs_kesehatan = 0;
            if(!isset($request->bpjs_pensiun) || empty($request->bpjs_pensiun)) $request->bpjs_pensiun = 0;
            if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
            if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
            if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;

            if(!isset($request->total_deduction) || empty($request->total_deduction)) $request->total_deduction = 0;
            if(!isset($request->net_yearly_income) || empty($request->net_yearly_income)) $request->net_yearly_income = 0;
            if(!isset($request->untaxable_income) || empty($request->untaxable_income)) $request->untaxable_income = 0;
            if(!isset($request->taxable_yearly_income) || empty($request->taxable_yearly_income)) $request->taxable_yearly_income = 0;
            if(!isset($request->income_tax_calculation_5) || empty($request->income_tax_calculation_5)) $request->income_tax_calculation_5 = 0;
            if(!isset($request->income_tax_calculation_15) || empty($request->income_tax_calculation_15)) $request->income_tax_calculation_15 = 0;                                                        
            if(!isset($request->income_tax_calculation_25) || empty($request->income_tax_calculation_25)) $request->income_tax_calculation_25 = 0;
            if(!isset($request->income_tax_calculation_30) || empty($request->income_tax_calculation_30)) $request->income_tax_calculation_30 = 0;
            if(!isset($request->yearly_income_tax) || empty($request->yearly_income_tax)) $request->yearly_income_tax = 0;
            if(!isset($request->monthly_income_tax) || empty($request->monthly_income_tax)) $request->monthly_income_tax = 0;
            if(!isset($request->gross_income_per_month) || empty($request->gross_income_per_month)) $request->gross_income_per_month = 0;
            if(!isset($request->less) || empty($request->less)) $request->less = 0;
            if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;
            
           
            $temp->user_id              = $request->user_id;
            $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
            $temp->salary               = str_replace(',', '', $request->salary);
            $temp->call_allow           = str_replace(',', '',$request->call_allow);
            $temp->bonus                = str_replace(',', '', $request->bonus);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
            $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
            $temp->less                         = str_replace(',', '', $request->less);
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->is_calculate                 = 1;
            $temp->transport_allowance              = str_replace(',', '', $request->transport_allowance);
            $temp->homebase_allowance               = str_replace(',', '',$request->homebase_allowance);
            $temp->laptop_allowance                 = str_replace(',', '',$request->laptop_allowance);
            $temp->ot_normal_hours                  = str_replace(',', '',$request->ot_normal_hours);
            $temp->ot_multiple_hours                = str_replace(',', '',$request->ot_multiple_hours);
            $temp->other_income                     = str_replace(',', '',$request->other_income);
            $temp->remark_other_income              = $request->remark_other_income;
            $temp->medical_claim                    = str_replace(',', '',$request->medical_claim);
            $temp->remark                           = $request->remark;
            $temp->other_deduction                  = str_replace(',', '',$request->other_deduction);
            $temp->remark_other_deduction           = $request->remark_other_deduction;
            $temp->gross_income_per_month           = str_replace(',', '',$request->gross_income_per_month);
            $temp->overtime_claim                   = str_replace(',', '',$request->overtime_claim);
            $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
            $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
            $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
            $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
            $temp->save();
            $payroll_id = $temp->id;

            // Insert History
            $temp = new \App\PayrollHistory();
            $temp->payroll_id            = $payroll_id;
            $temp->user_id              = $request->user_id;
            $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
            $temp->salary               = str_replace(',', '', $request->salary);
            $temp->call_allow           = str_replace(',', '',$request->call_allow);
            $temp->bonus                = str_replace(',', '', $request->bonus);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
            $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
            $temp->less                         = str_replace(',', '', $request->less);
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->transport_allowance              = str_replace(',', '', $request->transport_allowance);
            $temp->homebase_allowance               = str_replace(',', '',$request->homebase_allowance);
            $temp->laptop_allowance                 = str_replace(',', '',$request->laptop_allowance);
            $temp->ot_normal_hours                  = str_replace(',', '',$request->ot_normal_hours);
            $temp->ot_multiple_hours                = str_replace(',', '',$request->ot_multiple_hours);
            $temp->other_income                     = str_replace(',', '',$request->other_income);
            $temp->remark_other_income              = $request->remark_other_income;
            $temp->medical_claim                    = str_replace(',', '',$request->medical_claim);
            $temp->remark                           = $request->remark;
            $temp->other_deduction                  = str_replace(',', '',$request->other_deduction);
            $temp->remark_other_deduction           = $request->remark_other_deduction;
            $temp->gross_income_per_month           = str_replace(',', '',$request->gross_income_per_month);
            $temp->overtime_claim                   = str_replace(',', '',$request->overtime_claim);
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
        $temp = \App\Payroll::where('id', $id)->first();

        if(!isset($request->basic_salary) || empty($request->basic_salary)) $request->basic_salary = 0;
            if(!isset($request->salary) || empty($request->salary)) $request->salary = 0;
            if(!isset($request->call_allow) || empty($request->call_allow)) $request->call_allow = 0;
            if(!isset($request->bonus) || empty($request->bonus)) $request->bonus = 0;
            if(!isset($request->transport_allowance) || empty($request->transport_allowance)) $request->transport_allowance = 0;
            if(!isset($request->homebase_allowance) || empty($request->homebase_allowance)) $request->homebase_allowance = 0;
            if(!isset($request->laptop_allowance) || empty($request->laptop_allowance)) $request->laptop_allowance = 0;
            if(!isset($request->ot_normal_hours) || empty($request->ot_normal_hours)) $request->ot_normal_hours = 0;
            if(!isset($request->ot_multiple_hours) || empty($request->ot_multiple_hours)) $request->ot_multiple_hours = 0;
            if(!isset($request->other_income) || empty($request->other_income)) $request->other_income = 0;
            if(!isset($request->medical_claim) || empty($request->medical_claim)) $request->medical_claim = 0;
            if(!isset($request->overtime_claim) || empty($request->overtime_claim)) $request->overtime_claim = 0;
            if(!isset($request->other_deduction) || empty($request->other_deduction)) $request->other_deduction = 0;
            if(!isset($request->gross_income) || empty($request->gross_income)) $request->gross_income = 0;
            if(!isset($request->burden_allow) || empty($request->burden_allow)) $request->burden_allow = 0;
            if(!isset($request->bpjs_ketenagakerjaan) || empty($request->bpjs_ketenagakerjaan)) $request->bpjs_ketenagakerjaan = 0;
            if(!isset($request->bpjs_kesehatan) || empty($request->bpjs_kesehatan)) $request->bpjs_kesehatan = 0;
            if(!isset($request->bpjs_pensiun) || empty($request->bpjs_pensiun)) $request->bpjs_pensiun = 0;
            if(!isset($request->bpjs_ketenagakerjaan2) || empty($request->bpjs_ketenagakerjaan2)) $request->bpjs_ketenagakerjaan2 = 0;
            if(!isset($request->bpjs_kesehatan2) || empty($request->bpjs_kesehatan2)) $request->bpjs_kesehatan2 = 0;
            if(!isset($request->bpjs_pensiun2) || empty($request->bpjs_pensiun2)) $request->bpjs_pensiun2 = 0;

            if(!isset($request->total_deduction) || empty($request->total_deduction)) $request->total_deduction = 0;
            if(!isset($request->net_yearly_income) || empty($request->net_yearly_income)) $request->net_yearly_income = 0;
            if(!isset($request->untaxable_income) || empty($request->untaxable_income)) $request->untaxable_income = 0;
            if(!isset($request->taxable_yearly_income) || empty($request->taxable_yearly_income)) $request->taxable_yearly_income = 0;
            if(!isset($request->income_tax_calculation_5) || empty($request->income_tax_calculation_5)) $request->income_tax_calculation_5 = 0;
            if(!isset($request->income_tax_calculation_15) || empty($request->income_tax_calculation_15)) $request->income_tax_calculation_15 = 0;                                                        
            if(!isset($request->income_tax_calculation_25) || empty($request->income_tax_calculation_25)) $request->income_tax_calculation_25 = 0;
            if(!isset($request->income_tax_calculation_30) || empty($request->income_tax_calculation_30)) $request->income_tax_calculation_30 = 0;
            if(!isset($request->yearly_income_tax) || empty($request->yearly_income_tax)) $request->yearly_income_tax = 0;
            if(!isset($request->monthly_income_tax) || empty($request->monthly_income_tax)) $request->monthly_income_tax = 0;
            if(!isset($request->gross_income_per_month) || empty($request->gross_income_per_month)) $request->gross_income_per_month = 0;
            if(!isset($request->less) || empty($request->less)) $request->less = 0;
            if(!isset($request->thp) || empty($request->thp)) $request->thp = 0;

            $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
            $temp->salary               = str_replace(',', '', $request->salary);
            $temp->call_allow           = str_replace(',', '',$request->call_allow);
            $temp->bonus                = str_replace(',', '', $request->bonus);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
            $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
            $temp->less                         = str_replace(',', '', $request->less);
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->transport_allowance              = str_replace(',', '', $request->transport_allowance);
            $temp->homebase_allowance               = str_replace(',', '',$request->homebase_allowance);
            $temp->laptop_allowance                 = str_replace(',', '',$request->laptop_allowance);
            $temp->ot_normal_hours                  = str_replace(',', '',$request->ot_normal_hours);
            $temp->ot_multiple_hours                = str_replace(',', '',$request->ot_multiple_hours);
            $temp->other_income                     = str_replace(',', '',$request->other_income);
            $temp->remark_other_income              = $request->remark_other_income;
            $temp->medical_claim                    = str_replace(',', '',$request->medical_claim);
            $temp->remark                           = $request->remark;
            $temp->other_deduction                  = str_replace(',', '',$request->other_deduction);
            $temp->remark_other_deduction           = $request->remark_other_deduction;
            $temp->gross_income_per_month           = str_replace(',', '',$request->gross_income_per_month);
            $temp->overtime_claim                   = str_replace(',', '',$request->overtime_claim);
            $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
            $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
            $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
            $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
            $temp->save(); 

            $temp = new \App\PayrollHistory();
            $temp->payroll_id            = $id;
            $temp->user_id              = $request->user_id;
            $temp->basic_salary         = str_replace(',', '', $request->basic_salary);
            $temp->salary               = str_replace(',', '', $request->salary);
            $temp->call_allow           = str_replace(',', '',$request->call_allow);
            $temp->bonus                = str_replace(',', '', $request->bonus);
            $temp->gross_income         = str_replace(',', '', $request->gross_income); 
            $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
            $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
            $temp->less                         = str_replace(',', '', $request->less);
            $temp->thp                          = str_replace(',', '', $request->thp);
            $temp->transport_allowance              = str_replace(',', '', $request->transport_allowance);
            $temp->homebase_allowance               = str_replace(',', '',$request->homebase_allowance);
            $temp->laptop_allowance                 = str_replace(',', '',$request->laptop_allowance);
            $temp->ot_normal_hours                  = str_replace(',', '',$request->ot_normal_hours);
            $temp->ot_multiple_hours                = str_replace(',', '',$request->ot_multiple_hours);
            $temp->other_income                     = str_replace(',', '',$request->other_income);
            $temp->remark_other_income              = $request->remark_other_income;
            $temp->medical_claim                    = str_replace(',', '',$request->medical_claim);
            $temp->remark                           = $request->remark;
            $temp->other_deduction                  = str_replace(',', '',$request->other_deduction);
            $temp->remark_other_deduction           = $request->remark_other_deduction;
            $temp->gross_income_per_month           = str_replace(',', '',$request->gross_income_per_month);
            $temp->overtime_claim                   = str_replace(',', '',$request->overtime_claim);
            $temp->bpjs_ketenagakerjaan             = str_replace(',', '',$request->bpjs_ketenagakerjaan);
            $temp->bpjs_kesehatan                   = str_replace(',', '',$request->bpjs_kesehatan);
            $temp->bpjs_pensiun                     = str_replace(',', '',$request->bpjs_pensiun);
            $temp->bpjs_ketenagakerjaan2            = str_replace(',', '',$request->bpjs_ketenagakerjaan2);
            $temp->bpjs_kesehatan2                  = str_replace(',', '',$request->bpjs_kesehatan2);
            $temp->bpjs_pensiun2                    = str_replace(',', '',$request->bpjs_pensiun2);
            $temp->save();

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Data successfully saved !');
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
            $payroll = \App\Payroll::where('user_id', $i->id)->first();

            $params[$k]['NO']           = $k+1;
            $params[$k]['NIK']          = $i->nik;
            $params[$k]['Nama']         = $i->name;

            if($payroll)
            {
                $params[$k]['Basic Salary']                     = $payroll->basic_salary;
                $params[$k]['Actual Salary']                    = $payroll->salary;
                $params[$k]['Call Allowance']                   = $payroll->call_allow;
                $params[$k]['Yearly Bonus, THR or others']      = $payroll->bonus;
                $params[$k]['Transport Allowance']              = $payroll->transport_allowance;
                $params[$k]['Homebase Allowance']               = $payroll->homebase_allowance;
                $params[$k]['Laptop Allowance']                 = $payroll->laptop_allowance;
                $params[$k]['OT Normal Hours']                  = $payroll->ot_normal_hours;
                $params[$k]['OT Multiple Hours']                = $payroll->ot_multiple_hours;
                $params[$k]['Other Income']                     = $payroll->other_income;
                $params[$k]['Remark Other Income']              = $payroll->remark_other_income;
                $params[$k]['Medical Claim']                    = $payroll->medical_claim;
                $params[$k]['Remark']                           = $payroll->remark;
                $params[$k]['PPh21']                            = $payroll->monthly_income_tax;
                $params[$k]['Other Deduction']                  = $payroll->other_deduction;
                $params[$k]['RemarkOther Deduction']            = $payroll->remark_other_deduction;
            }
            else
            {
                $params[$k]['Basic Salary']                     = 0;
                $params[$k]['Actual Salary']                    = 0;
                $params[$k]['% JKK (Accident) + JK (Death)']    = 0;
                $params[$k]['Call Allowance']                   = 0;
                $params[$k]['Yearly Bonus, THR or others']      = 0;
                $params[$k]['Transport Allowance']              = "";
                $params[$k]['Homebase Allowance']               = "";
                $params[$k]['Laptop Allowance']                 = "";
                $params[$k]['OT Normal Hours']                  = "";
                $params[$k]['OT Multiple Hours']                = "";
                $params[$k]['Other Income']                     = "";
                $params[$k]['Remark Other Income']              = "";
                $params[$k]['Medical Claim']                    = "";
                $params[$k]['Remark']                           = "";
                $params[$k]['PPh21']                            = "";
                $params[$k]['Other Deduction']                  = "";
                $params[$k]['RemarkOther Deduction']            = "";
            }
        }

        return \Excel::create('datapayroll',  function($excel) use($params){
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
        $params['data'] = \App\Payroll::where('id', $id)->first();

        return view('administrator.payroll.detail')->with($params);
    }

    /**
     * [calculate description]
     * @return [type] [description]
     */
    public function calculate()
    {
        $data = \App\Payroll::all();

        $biaya_jabatan = \App\PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = \App\PayrollOthers::where('id', 2)->first()->value;

        foreach($data as $item)
        {
         
            $temp = \App\Payroll::where('id', $item->id)->first();
            $ptkp = \App\PayrollPtkp::where('id', 1)->first();
            $bpjs_pensiunan_batas = \App\PayrollOthers::where('id', 3)->first()->value;
            $bpjs_kesehatan_batas = \App\PayrollOthers::where('id', 4)->first()->value;

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

            $overtime_claim = $item->ot_multiple_hours / 173 * $item->salary;
            $bpjspenambahan = $bpjs_ketenagakerjaan + $bpjs_kesehatan + $bpjs_pensiun;
            $bpjspengurangan = $bpjs_ketenagakerjaan2 + $bpjs_kesehatan2 + $bpjs_pensiun2;

            $gross_income = ($item->salary + $item->call_allow + $item->transport_allowance + $item->homebase_allowance + $item->laptop_allowance + $overtime_claim + $bpjspenambahan) * 12 + $item->bonus;

            $gross_income2 = ($item->salary + $item->call_allow + $item->transport_allowance + $item->homebase_allowance + $item->laptop_allowance + $overtime_claim + $bpjspenambahan + $item->bonus) - $bpjspengurangan;


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
            $gross_income_per_month       = $gross_income / 12;

            $less               = $bpjspengurangan + $monthly_income_tax; 

             $gross_thp = ($item->salary + $item->call_allow + $item->transport_allowance + $item->homebase_allowance + $item->laptop_allowance + $item->other_income + $overtime_claim + $item->other_income+ $item->medical_claim+ $item->bonus);

            $thp                = $gross_thp - $less - $item->other_deduction;

        if(!isset($item->basic_salary) || empty($item->basic_salary)) $item->basic_salary = 0;
        if(!isset($item->salary) || empty($item->salary)) $item->salary = 0;
        if(!isset($item->call_allow) || empty($item->call_allow)) $item->call_allow = 0;
        if(!isset($item->bonus) || empty($item->bonus)) $item->bonus = 0;
        if(!isset($gross_income) || empty($gross_income)) $gross_income = 0;
        if(!isset($burden_allow) || empty($burden_allow)) $burden_allow = 0;
        if(!isset($total_deduction) || empty($total_deduction)) $total_deduction = 0;
        if(!isset($net_yearly_income) || empty($net_yearly_income)) $net_yearly_income = 0;
        if(!isset($untaxable_income) || empty($untaxable_income)) $untaxable_income = 0;
        if(!isset($taxable_yearly_income) || empty($taxable_yearly_income)) $taxable_yearly_income = 0;
        if(!isset($income_tax_calculation_5) || empty($income_tax_calculation_5)) $income_tax_calculation_5 = 0;
        if(!isset($income_tax_calculation_15) || empty($income_tax_calculation_15)) $income_tax_calculation_15 = 0;
        if(!isset($income_tax_calculation_25) || empty($income_tax_calculation_25)) $income_tax_calculation_25 = 0;
        if(!isset($income_tax_calculation_30) || empty($income_tax_calculation_30)) $income_tax_calculation_30 = 0;
        if(!isset($yearly_income_tax) || empty($yearly_income_tax)) $yearly_income_tax = 0;
        if(!isset($monthly_income_tax) || empty($monthly_income_tax)) $monthly_income_tax = 0;
        if(!isset($less) || empty($less)) $less = 0;
        if(!isset($thp) || empty($thp)) $thp = 0;

        if(!isset($item->transport_allowance) || empty($item->transport_allowance)) $item->transport_allowance = 0;
        if(!isset($item->homebase_allowance) || empty($item->homebase_allowance)) $item->homebase_allowance = 0;
        if(!isset($item->laptop_allowance) || empty($item->laptop_allowance)) $item->laptop_allowance = 0;
        if(!isset($item->ot_normal_hours) || empty($item->ot_normal_hours)) $item->ot_normal_hours = 0;
        if(!isset($item->ot_multiple_hours) || empty($item->ot_multiple_hours)) $item->ot_multiple_hours = 0;
        if(!isset($item->other_income) || empty($item->other_income)) $item->other_income = 0;
        if(!isset($item->medical_claim) || empty($item->medical_claim)) $item->medical_claim = 0;
        if(!isset($item->other_deduction) || empty($item->other_deduction)) $item->other_deduction = 0;
        if(!isset($gross_income_per_month) || empty($gross_income_per_month)) $gross_income_per_month = 0;
        if(!isset($overtime_claim) || empty($overtime_claim)) $overtime_claim = 0;
        if(!isset($bpjs_ketenagakerjaan) || empty($bpjs_ketenagakerjaan)) $bpjs_ketenagakerjaan = 0;
        if(!isset($bpjs_kesehatan) || empty($bpjs_kesehatan)) $bpjs_kesehatan = 0;
        if(!isset($bpjs_pensiun) || empty($bpjs_pensiun)) $bpjs_pensiun = 0;
        if(!isset($bpjs_ketenagakerjaan2) || empty($bpjs_ketenagakerjaan2)) $bpjs_ketenagakerjaan2 = 0;
        if(!isset($bpjs_kesehatan2) || empty($bpjs_kesehatan2)) $bpjs_kesehatan2 = 0;
        if(!isset($bpjs_pensiun2) || empty($bpjs_pensiun2)) $bpjs_pensiun2 = 0;
        if(!isset($remark_other_income) || empty($remark_other_income)) $remark_other_income = "";
        

            $temp->gross_income         = $gross_income; 
            $temp->burden_allow         = $burden_allow;
            $temp->total_deduction      = $total_deduction;
            $temp->net_yearly_income    = $net_yearly_income;
            $temp->untaxable_income     = $untaxable_income;
            $temp->taxable_yearly_income        = $taxable_yearly_income;
            $temp->income_tax_calculation_5     = $income_tax_calculation_5; 
            $temp->income_tax_calculation_15    = $income_tax_calculation_15; 
            $temp->income_tax_calculation_25    = $income_tax_calculation_25; 
            $temp->income_tax_calculation_30    = $income_tax_calculation_30; 
            $temp->yearly_income_tax            = $yearly_income_tax;
            $temp->monthly_income_tax           = $monthly_income_tax;
            $temp->gross_income_per_month       = $gross_income_per_month;
            $temp->less                         = $less;
            $temp->thp                          = $thp;
            $temp->is_calculate                 = 1;
            $temp->overtime_claim               = $overtime_claim;
            $temp->bpjs_ketenagakerjaan         = $bpjs_ketenagakerjaan;
            $temp->bpjs_kesehatan               = $bpjs_kesehatan;
            $temp->bpjs_pensiun                 = $bpjs_pensiun;
            $temp->bpjs_ketenagakerjaan2        = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan2              = $bpjs_kesehatan2;
            $temp->bpjs_pensiun2                = $bpjs_pensiun2;
            $temp->save();

            $user_id        = $temp->user_id;
            $payroll_id     = $temp->id;

            $temp = new \App\PayrollHistory();
            $temp->payroll_id            = $payroll_id;
            $temp->user_id              = $user_id;
            $temp->salary               = str_replace(',', '', $item->salary);
            $temp->call_allow           = $item->call_allow;
            $temp->bonus                = str_replace(',', '', $item->bonus);
            $temp->gross_income         = str_replace(',', '', $gross_income); 
            $temp->burden_allow         = str_replace(',', '', $burden_allow);
            $temp->total_deduction      = str_replace(',', '', $total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $monthly_income_tax);
            $temp->basic_salary                 = str_replace(',', '', $item->basic_salary);
            $temp->less                         = str_replace(',', '', $less);
            $temp->thp                          = str_replace(',', '', $thp);
            $temp->overtime_claim               = $overtime_claim;
            $temp->transport_allowance              = str_replace(',', '',$item->transport_allowance);
            $temp->homebase_allowance               = str_replace(',', '',$item->homebase_allowance);
            $temp->laptop_allowance                 = str_replace(',', '',$item->laptop_allowance);
            $temp->ot_normal_hours                  = str_replace(',', '',$item->ot_normal_hours);
            $temp->ot_multiple_hours                = str_replace(',', '',$item->ot_multiple_hours);
            $temp->other_income                     = str_replace(',', '',$item->other_income);
            $temp->remark_other_income              = $item->remark_other_income;
            $temp->medical_claim                    = str_replace(',', '',$item->medical_claim);
            $temp->remark                           = $item->remark;
            $temp->other_deduction                  = str_replace(',', '',$item->other_deduction);
            $temp->remark_other_deduction           = $item->remark_other_deduction;
            $temp->gross_income_per_month           = str_replace(',', '',$item->gross_income_per_month);
            $temp->bpjs_ketenagakerjaan         = $bpjs_ketenagakerjaan;
            $temp->bpjs_kesehatan               = $bpjs_kesehatan;
            $temp->bpjs_pensiun                 = $bpjs_pensiun;
            $temp->bpjs_ketenagakerjaan2        = $bpjs_ketenagakerjaan2;
            $temp->bpjs_kesehatan2              = $bpjs_kesehatan2;
            $temp->bpjs_pensiun2                = $bpjs_pensiun2;
            $temp->save();
        }

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Data Payroll successfully calculated !');
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

                $nik                    = $row[1];
                $basic_salary           = $row[3]; 
                $actual_salary          = $row[4]; 
                $call_allow             = $row[5];
                $bonus                  = $row[6];
                $transport_allowance        = $row[7];
                $homebase_allowance         = $row[8];
                $laptop_allowance           = $row[9];
                $ot_normal_hours            = $row[10];
                $ot_multiple_hours          = $row[11];
                $other_income               = $row[12];
                $remark_other_income        = $row[13];
                $medical_claim              = $row[14];
                $remark                     = $row[15];
                $monthly_income_tax         = $row[16];
                $other_deduction            = $row[17];
                $remark_other_deduction     = $row[18];

                // cek user 
                $user = \App\User::where('nik', $nik)->first();
                if($user)
                {   
                    // cek exit payrol user
                    $payroll = \App\Payroll::where('user_id', $user->id)->first();
                    if(!$payroll)
                    {
                        $payroll            = new \App\Payroll();
                        $payroll->user_id   = $user->id;
                        $payroll->is_calculate  = 0;
                    }

                    $is_calculate = 1;

                    if($payroll->salary == 0)
                    {
                        $is_calculate   = 0;
                    }
                    if($payroll->salary != $actual_salary) 
                    {
                        $is_calculate   = 0;
                        $payroll->salary= $actual_salary;
                    }

                    if($payroll->basic_salary != $basic_salary) 
                    {
                        $is_calculate   = 0;
                        $payroll->basic_salary= $basic_salary;
                    }

                    if($payroll->call_allow != $call_allow) 
                    {
                        $is_calculate       = 0;
                        $payroll->call_allow= $call_allow;
                    }

                    if($payroll->bonus != $bonus) 
                    {
                        $is_calculate   = 0;
                        $payroll->bonus = $bonus;
                    }
                    
                    $payroll->is_calculate               = $is_calculate;
                    $payroll->transport_allowance        = $transport_allowance;
                    $payroll->homebase_allowance         = $homebase_allowance;
                    $payroll->laptop_allowance           = $laptop_allowance;
                    $payroll->ot_normal_hours            = $ot_normal_hours;
                    $payroll->ot_multiple_hours          = $ot_multiple_hours;
                    $payroll->remark_other_income        = $remark_other_income;
                    $payroll->medical_claim              = $medical_claim;
                    $payroll->remark                     = $remark;
                    $payroll->monthly_income_tax         = $monthly_income_tax;
                    $payroll->other_deduction            = $other_deduction;
                    $payroll->remark_other_deduction     = $remark_other_deduction;
                    $payroll->save();
                }
	        }

            return redirect()->route('administrator.payroll.index')->with('messages-success', 'Data Payroll successfully import !');
        }
    }
}
