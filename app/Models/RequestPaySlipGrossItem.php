<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlipGrossItem extends Model
{
    protected $table = 'request_pay_slipgross_item';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
