<?php 

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