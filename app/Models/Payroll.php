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
}
