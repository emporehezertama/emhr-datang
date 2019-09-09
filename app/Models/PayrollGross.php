<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollGross extends Model
{
    //
    protected $table = 'payrollgross';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
