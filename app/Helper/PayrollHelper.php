<?php 

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

/**
 * Get History Earning
 */
function get_payroll_earning_history_param($payroll_id, $year, $month, $id)
{
	if(!isset($payroll_id)) return 0;

	$data = \App\Models\PayrollEarningsEmployeeHistory::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id->payroll_id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'DESC')->first();

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