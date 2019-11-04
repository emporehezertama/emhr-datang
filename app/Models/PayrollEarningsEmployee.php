<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollEarningsEmployee extends Model
{
    protected $table = 'payroll_earnings_employee';

    /**
     * Payroll Earnings
     * @return object row
     */
    public function payrollEarnings()
    {
    	return $this->hasOne('App\Models\PayrollEarnings', 'id', 'payroll_earning_id');
    }
}
