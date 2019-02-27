<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollDeductionsEmployee extends Model
{
    protected $table = 'payroll_deductions_employee';

    /**
     * Payroll Deductions
     * @return object row
     */
    public function payrollDeductions()
    {
    	return $this->hasOne('App\Models\PayrollDeductions', 'id', 'payroll_deduction_id');
    }
}
