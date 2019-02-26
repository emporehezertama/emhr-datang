<?php 

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
