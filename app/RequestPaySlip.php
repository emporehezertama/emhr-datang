<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlip extends Model
{
    protected $table = 'request_pay_slip';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
