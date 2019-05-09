<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingApprovalClearance extends Model
{
    //
    protected $table = 'setting_approval_clearance';

    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
