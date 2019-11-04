<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryApprovalOvertime extends Model
{
    //
    protected $table = 'history_approval_overtime';
    protected $primaryKey = 'id';

    public function overtimeSheet()
    {
    	return $this->hasOne('App\Models\OvertimeSheet', 'id', 'overtime_sheet_id');
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

    public function userApprovedClaim()
    {
        return $this->hasOne('\App\User', 'id', 'approval_id_claim');
    }
}
