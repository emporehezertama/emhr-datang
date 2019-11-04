<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryApprovalLeave extends Model
{
    //
    protected $table = 'history_approval_leave';

    
    public function cutiKaryawan()
    {
    	return $this->hasOne('App\Models\CutiKaryawan', 'id', 'cuti_karyawan_id');
    }

    public function level()
    {
    	return $this->hasOne('App\Models\SettingApprovalLevel', 'id', 'setting_approval_level_id');
    }
    
    public function structure()
    {
    	return $this->hasOne('\App\Models\StructureOrganizationCustom', 'id', 'structure_organization_custom_id');
    }

    public function userApproved()
    {
        return $this->hasOne('\App\User', 'id', 'approval_id');
    }

}
