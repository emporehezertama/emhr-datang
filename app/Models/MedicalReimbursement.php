<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalReimbursement extends Model
{
    protected $table = 'medical_reimbursement';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    /**
     * [form description]
     * @return [type] [description]
     */
    public function form()
    {
    	return $this->hasMany('App\Models\MedicalReimbursementForm', 'medical_reimbursement_id', 'id');
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
}
