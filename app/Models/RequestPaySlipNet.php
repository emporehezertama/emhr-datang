<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPaySlipNet extends Model
{
    protected $table = 'request_pay_slipnet';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
