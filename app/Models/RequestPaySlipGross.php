<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlipGross extends Model
{
    protected $table = 'request_pay_slipgross';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
