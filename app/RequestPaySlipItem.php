<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlipItem extends Model
{
    protected $table = 'request_pay_slip_item';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
