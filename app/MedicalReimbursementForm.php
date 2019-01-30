<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalReimbursementForm extends Model
{
    protected $table = 'medical_reimbursement_form';

    /**
     * [userFamily description]
     * @return [type] [description]
     */
    public function UserFamily()
    {
    	return $this->hasOne('App\UserFamily', 'id', 'user_family_id');
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user_family()
    {
    	return $this->hasOne('App\User', 'id', 'user_family_id');
    }
}
