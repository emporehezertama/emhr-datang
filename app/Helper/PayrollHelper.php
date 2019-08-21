<?php 

/**
 * Cek Payroll User ID array
 */
function cek_payroll_user_id_array($month, $year)
{
	// Payroll History
	$result = \App\Models\PayrollHistory::whereMonth('created_at', $month)->whereYear('created_at', $year);

	return $result;
}


/**
 * Cek Payroll User ID
 */
function get_payroll_history($user_id, $month, $year)
{
	// Payroll History
	$row = \App\Models\PayrollHistory::where('user_id', $user_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->orderBy('id', 'DESC')->first();

	return $row;
}

/**
 * Cek Payroll User ID
 */
function cek_payroll_user_id($user_id, $month, $year)
{
	// Payroll History
	// $count = \App\Models\PayrollHistory::where('user_id', $user_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->first();

	// if($count) return $count;

	// $count = \App\Models\Payroll::where('user_id', $user_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->first();

	// if($count) return $count;

	$count = \App\Models\PayrollHistory::where('user_id', $user_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

	if($count) return true;

	$count = \App\Models\Payroll::where('user_id', $user_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

	if($count) return true;

	return false;
}

/**
 * Round Down
 */
function roundDown($decimal, $precision)
{
    $sign = $decimal > 0 ? 1 : -1;
    $base = pow(10, $precision);
    return floor(abs($decimal) * $base) / $base * $sign;
}

/**
 * Get PTKP
 */
function get_ptkp($user_id)
{
	$user = \App\User::where('id', $user_id)->first();

	$ptkp = \App\Models\PayrollPtkp::where('id', 1)->first();
    
    if($user->marital_status == 'Bujangan/Wanita' || $user->marital_status == "")
    {
        $data = $ptkp->bujangan_wanita;
    }
    if($user->marital_status == 'Menikah')
    {
        $data = $ptkp->menikah;
    }
    if($user->marital_status == 'Menikah Anak 1')
    {
        $data = $ptkp->menikah_anak_1;
    }
    if($user->marital_status == 'Menikah Anak 2')
    {
        $data = $ptkp->menikah_anak_2;
    }
    if($user->marital_status == 'Menikah Anak 3')
    {
        $data = $ptkp->menikah_anak_3;
    }

    return $data;
}
function getpphYear($nominal)
{
	$pph_setting_1  = \App\Models\PayrollPPH::where('id', 1)->first();
    // Perhitungan 5 persen
    $income_tax_calculation_5 = 0;
    if($nominal < 0)
    {
        $income_tax_calculation_5 = 0;   
	}
	elseif($nominal <= $pph_setting_1->batas_atas)
    {
    	$income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $nominal;
    }
    if($nominal >= $pph_setting_1->batas_atas)
    {
    	$income_tax_calculation_5 = ($pph_setting_1->tarif / 100) * $pph_setting_1->batas_atas;
    }
    $pph_setting_2  = \App\Models\PayrollPPH::where('id', 2)->first();
    // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($nominal >= $pph_setting_2->batas_atas)
            {
                $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($pph_setting_2->batas_atas - $pph_setting_2->batas_bawah);
            }
            if($nominal >= $pph_setting_2->batas_bawah and $nominal <= $pph_setting_2->batas_atas)
            {
                $income_tax_calculation_15 = ($pph_setting_2->tarif / 100) * ($nominal - $pph_setting_2->batas_bawah);
            }

            $pph_setting_3  = \App\Models\PayrollPPH::where('id', 3)->first();
            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($nominal >= $pph_setting_3->batas_atas)
            {
                $income_tax_calculation_25 = ($pph_setting_3->tarif / 100)  * ($pph_setting_3->batas_atas - $pph_setting_3->batas_bawah);
            }
 
            if($nominal <= $pph_setting_3->batas_atas and $nominal >= $pph_setting_3->batas_bawah)
            {
                $income_tax_calculation_25 = ($pph_setting_3->tarif / 100) * ($nominal - $pph_setting_3->batas_bawah);
            }

            $pph_setting_4  = \App\Models\PayrollPPH::where('id', 4)->first();
            $income_tax_calculation_30 = 0;
            if($nominal >= $pph_setting_4->batas_atas)
            {
                $income_tax_calculation_30 = ($pph_setting_4->tarif / 100) * ($nominal - $pph_setting_4->batas_bawah);
            }

            $yearly_income_tax              = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
    return $yearly_income_tax;
}

/**
 * Get History Earning
 */
function get_payroll_earning_history_param($payroll_id, $year, $month, $id)
{
	if(!isset($payroll_id)) return 0;

	// $data = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id->payroll_id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'DESC')->first();
	$data = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'DESC')->first();

	if($data)
	{
		return $data->nominal;
	}
	else
	{
		return 0;
	}
}

/**
 * Get Payroll pph21
 */
function get_payroll_history_param($user_id, $year, $month, $field="")
{
	$data = \App\Models\PayrollHistory::where('user_id', $user_id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'DESC')->first();

	if(empty($field)) return $data;

	if($data)
	{
		return $data->$field;
	}
	else
	{
		return 0;
	}
}

/**
 * Bukti Potong
 * Integer / String
 */
function bukti_potong($id, $type)
{
	$data_arr = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->where('payroll_id', $id)->groupBy('month')->orderBy('id', 'DESC')->get();
	
	$data = [];
	foreach($data_arr as $item)
	{
		$row = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->whereMonth("created_at", $item->month)->where('payroll_id', $id)->orderBy('id', 'DESC')->first();
		$data[] = $row;
 	}

 	$nominal = 0;

	if($type == 'gaji' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->salary;
		}	
	}

	if($type == 'pph21' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->pph21;
		}	
	}

	if($type == 'tunjangan' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$earning = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_id', $item->payroll_id)->groupBy('payroll_earning_id')->orderBy('created_at', 'DESC')->get();
	
			if($earning)
			{
				foreach($earning as $i)
				{
					$nominal 	+= $i->nominal;					
				}
			}
		}	
	}

	if($type == 'premi' || $type== 'bruto')
	{	
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->bpjs_ketenagakerjaan_employee + $item->bpjs_kesehatan_employee + $item->bpjs_pensiun_employee;
		}	
	}

	if($type == 'bonus' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->bonus;
		}	
	}

	return $nominal;		
}

function send_bukti_potong($id, $tahun,$type)
{
	$data_arr = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->where('user_id', $id)->whereYear('created_at',$tahun)->groupBy('month')->orderBy('id', 'DESC')->get();
	
	$data_start = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->where('user_id', $id)->whereYear('created_at',$tahun)->groupBy('month')->orderBy('month', 'ASC')->first();
	
	$data_end = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->where('user_id', $id)->whereYear('created_at',$tahun)->groupBy('month')->orderBy('month', 'DESC')->first();

	$data = [];
	foreach($data_arr as $item)
	{
		$row = \App\Models\PayrollHistory::select('*',DB::raw('MONTH(created_at) month'))->whereMonth("created_at", $item->month)->where('user_id', $id)->orderBy('id', 'DESC')->first();

		$data[] = $row;
 	}

 	$nominal = 0;

 	if($type == 'start')
 	{
 		$nominal = $data_start->month;
 	}
 	if($type =='end')
 	{
 		$nominal = $data_end->month;
 	}

	if($type == 'gaji' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->salary;
		}	
	}

	if($type == 'pph21')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->pph21;
		}	
	}

	if($type == 'tunjangan' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$earning = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_id', $item->id)->groupBy('payroll_earning_id')->orderBy('created_at', 'DESC')->get();
	
			if($earning)
			{
				foreach($earning as $i)
				{
					$nominal 	+= $i->nominal;					
				}
			}
		}	
	}

	if($type == 'premi' || $type== 'bruto')
	{	
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->bpjs_jkk_company + $item->bpjs_jkm_company + $item->bpjs_kesehatan_company;
		}	
	}

	if($type == 'bonus' || $type== 'bruto')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->bonus;
		}	
	}
	if($type == 'burden' || $type=='pengurang')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->burden_allow;
		}	
	}
	if($type == 'jht' || $type=='pengurang')
	{
		foreach($data as $k => $item)
		{
			$nominal 	+= $item->bpjs_pensiun_employee + $item->bpjs_ketenagakerjaan_employee;
		}	
	}

	return $nominal;		
}

/**
 * Get All Year Payroll
 * @return array
 */
function get_year_payroll()
{	
	$data = \App\Models\PayrollHistory::select(DB::raw('YEAR(created_at) year'))->groupBy('year')->get();
	$year = [];

	foreach($data as $item)
	{
		$year[] = $item->year;
	}
	
	return $year;
}

/**
 * Get Deduction Employee
 * @param  $id
 * @return object
 */
function getDeductionEmployee($id, $payroll_id, $type = 'current')
{
	if($type == 'history')
	{
		$item = \App\Models\PayrollDeductionsEmployeeHistory::where('payroll_deduction_id', $id)->where('payroll_id', $payroll_id)->first();
	}
	else $item = \App\Models\PayrollDeductionsEmployee::where('payroll_deduction_id', $id)->where('payroll_id', $payroll_id)->first();

	return $item;
}

/**
 * Get Earning Employee
 * @param  $id
 * @return object
 */
function getEarningEmployee($id, $payroll_id, $type='current')
{
	if($type == 'history')
	{
		$item = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id)->first();
	}
	else $item = \App\Models\PayrollEarningsEmployee::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id)->first();

	return $item;
}
function getDeductionEmployeeDataHistory($id, $payroll_id)
{
	$item = \App\Models\PayrollDeductionsEmployeeHistory::where('payroll_deduction_id', $id)->where('payroll_id', $payroll_id)->first();
	return $item;
}

function getEarningEmployeeDataHistory($id, $payroll_id)
{
	$item = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id)->first();
	return $item;
}

/**
 * Deduction Employee History
 */
function payrollDeductionsEmployeeHistory($id)
{
	return App\Models\PayrollDeductionsEmployeeHistory::where('payroll_id', $id)->get();
}


/**
 * Earning Employee History
 */
function payrollEarningsEmployeeHistory($id)
{
	return App\Models\PayrollEarningsEmployeeHistory::where('payroll_id', $id)->get();
}


function payrollEarningsEmployeeData($id,$bulan,$tahun)
{
	$bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
	
	$intBulan = array_search($bulan, $bulanArray);

	if($intBulan == (Int)date('m') and $tahun == date('Y'))
    {
    	return App\Models\PayrollEarningsEmployee::where('payroll_id', $id)->get();
    }else{
    	return \App\Models\PayrollEarningsEmployeeHistory::where('payroll_id', $id)->get();
    }
}

function payrollDeductionsEmployeeData($id,$bulan,$tahun)
{
	$bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
	$intBulan = array_search($bulan, $bulanArray);

	if($intBulan == (Int)date('m') and $tahun == date('Y'))
    {
    	return App\Models\PayrollDeductionsEmployee::where('payroll_id', $id)->get();
    }else{
    	return \App\Models\PayrollDeductionsEmployeeHistory::where('payroll_id', $id)->get();
    }
}


/**
 * Earning
 * @return objects
 */
function get_earnings()
{
	$user = \Auth::user();
    if($user->project_id != NULL)
    {
    	return \App\Models\PayrollEarnings::join('users', 'users.id','=', 'payroll_earnings.user_created')->where('users.project_id', $user->project_id)->select('payroll_earnings.*')->get();
    }else{
    	return \App\Models\PayrollEarnings::all();
    }
}

/**
 * Deductions
 * @return objects
 */
function get_deductions()
{
	$user = \Auth::user();
    if($user->project_id != NULL)
    {
    	return \App\Models\PayrollDeductions::join('users', 'users.id','=', 'payroll_deductions.user_created')->where('users.project_id', $user->project_id)->select('payroll_deductions.*')->get();
    }else{
    	return \App\Models\PayrollDeductions::all();
    }
}

function get_setting_payroll($id){
	if(\Auth::user()->project_id != NULL){
		$value = \App\Models\PayrollNpwp::where('id_payroll_npwp',$id)->where('project_id', \Auth::user()->project_id)->get();
		if(count($value) < 1){
			return "";
		}else{
			return \App\Models\PayrollNpwp::where('id_payroll_npwp',$id)->where('project_id', \Auth::user()->project_id)->first()->value;
		}
	}else{
		$value = \App\Models\PayrollNpwp::where('id_payroll_npwp',$id)->whereNull('project_id')->get();
		if(count($value) < 1){
			return "kakaka";
		}else{
			return \App\Models\PayrollNpwp::where('id_payroll_npwp',$id)->whereNull('project_id')->first()->value;
		}
	}
}