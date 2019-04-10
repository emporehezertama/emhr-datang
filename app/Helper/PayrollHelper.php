<?php 

/**
 * Get Deduction Employee
 * @param  $id
 * @return object
 */
function getDeductionEmployee($id, $payroll_id)
{
	$item = \App\Models\PayrollDeductionsEmployee::where('payroll_deduction_id', $id)->where('payroll_id', $payroll_id)->first();

	return $item;
}

/**
 * Get Earning Employee
 * @param  $id
 * @return object
 */
function getEarningEmployee($id, $payroll_id)
{
	$item = \App\Models\PayrollEarningsEmployee::where('payroll_earning_id', $id)->where('payroll_id', $payroll_id)->first();

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
	return \App\Models\PayrollEarnings::all();
}

/**
 * Deductions
 * @return objects
 */
function get_deductions()
{
	return \App\Models\PayrollDeductions::all();
}