<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollHistory extends Model
{
    protected $table = 'payroll_history';

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
    	return $this->hasMany('App\Models\PayrollEarningsEmployeeHistory', 'payroll_id', 'id');
    }

    /**
     * Deductions
     * @return object
     */
    public function payrollDeductionsEmployee()
    {
    	return $this->hasMany('App\Models\PayrollDeductionsEmployeeHistory', 'payroll_id', 'id');
    }
}
