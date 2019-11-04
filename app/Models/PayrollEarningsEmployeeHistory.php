<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollEarningsEmployeeHistory extends Model
{
    protected $table = 'payroll_earnings_employee_history';

    /**
     * Payroll Earnings
     * @return object row
     */
    public function payrollEarnings()
    {
    	return $this->hasOne('App\Models\PayrollEarnings', 'id', 'payroll_earning_id');
    }
}
