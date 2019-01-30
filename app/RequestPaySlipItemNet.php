<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlipItemNet extends Model
{
    protected $table = 'request_pay_slip_itemnet';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
