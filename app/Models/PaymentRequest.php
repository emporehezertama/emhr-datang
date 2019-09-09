<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $table = 'payment_request';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * [payment_request_form description]
     * @return [type] [description]
     */
    public function payment_request_form()
    {
    	return $this->hasMany('App\Models\PaymentRequestForm', 'payment_request_id', 'id');
    }

    /**
     * @return [type]
     */
    public function atasan()
    {
        return $this->hasOne('App\User', 'id', 'approved_atasan_id');
    }

    /**
     * @return [type]
     */
    public function direktur()
    {
        return $this->hasOne('App\User', 'id', 'approve_direktur_id');
    }

    public function historyApproval()
    {
        return $this->hasMany('\App\Models\HistoryApprovalPaymentRequest', 'payment_request_id', 'id')->orderBy('setting_approval_level_id', 'ASC');
    }
}
