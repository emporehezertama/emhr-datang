<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    /**
     * Earnings
     * @return object
     */
    public function payrollEarningsEmployee()
    {
    	return $this->hasMany('App\Models\PayrollEarningsEmployee', 'payroll_id', 'id');
    }

    /**
     * Deductions
     * @return object
     */
    public function payrollDeductionsEmployee()
    {
    	return $this->hasMany('App\Models\PayrollDeductionsEmployee', 'payroll_id', 'id');
    }
}
