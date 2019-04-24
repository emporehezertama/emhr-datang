<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingApprovalLeave extends Model
{
    //
    protected $table = 'setting_approval_leave';

     public function structure()
    {
    	return $this->hasOne('\App\Models\StructureOrganizationCustom', 'id', 'structure_organization_custom_id');
    }

    public function item()
    {
    	return $this->hasOne('\App\Models\SettingApprovalLeaveItem', 'setting_approval_leave_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('\App\Models\SettingApprovalLeaveItem', 'setting_approval_leave_id', 'id');
    }

    public function level1()
    {
        return $this->hasOne('\App\Models\SettingApprovalLeaveItem', 'setting_approval_leave_id', 'id')->where('setting_approval_level_id',1);
    } 


    public function itemPaymentRequest()
    {
        return $this->hasOne('\App\Models\SettingApprovalPaymentRequestItem', 'setting_approval_leave_id', 'id');
    }

    public function itemsPaymentRequest()
    {
        return $this->hasMany('\App\Models\SettingApprovalPaymentRequestItem', 'setting_approval_leave_id', 'id');
    }

    public function level1PaymentRequest()
    {
        return $this->hasOne('\App\Models\SettingApprovalPaymentRequestItem', 'setting_approval_leave_id', 'id')->where('setting_approval_level_id',1);
    } 

    public function itemOvertime()
    {
        return $this->hasOne('\App\Models\SettingApprovalOvertimeItem', 'setting_approval_leave_id', 'id');
    }

    public function itemsOvertime()
    {
        return $this->hasMany('\App\Models\SettingApprovalOvertimeItem', 'setting_approval_leave_id', 'id');
    }

    public function level1Overtime()
    {
        return $this->hasOne('\App\Models\SettingApprovalOvertimeItem', 'setting_approval_leave_id', 'id')->where('setting_approval_level_id',1);
    }

    public function itemTraining()
    {
        return $this->hasOne('\App\Models\SettingApprovalTrainingItem', 'setting_approval_leave_id', 'id');
    }

    public function itemsTraining()
    {
        return $this->hasMany('\App\Models\SettingApprovalTrainingItem', 'setting_approval_leave_id', 'id');
    }

    public function level1Training()
    {
        return $this->hasOne('\App\Models\SettingApprovalTrainingItem', 'setting_approval_leave_id', 'id')->where('setting_approval_level_id',1);
    } 
    public function itemMedical()
    {
        return $this->hasOne('\App\Models\SettingApprovalMedicalItem', 'setting_approval_leave_id', 'id');
    }

    public function itemsMedical()
    {
        return $this->hasMany('\App\Models\SettingApprovalMedicalItem', 'setting_approval_leave_id', 'id');
    }

    public function level1Medical()
    {
        return $this->hasOne('\App\Models\SettingApprovalMedicalItem', 'setting_approval_leave_id', 'id')->where('setting_approval_level_id',1);
    } 


}
