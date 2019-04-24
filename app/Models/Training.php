<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    /**
     * [atasan description]
     * @return [type] [description]
     */
    public function atasan()
    {
    	return $this->hasOne('\App\User', 'id', 'approved_atasan_id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
    	return $this->hasOne('\App\User', 'id', 'approve_direktur_id');
    }

    public function training_type()
    {
        return $this->hasOne('\App\Models\TrainingType', 'id', 'training_type_id');
    }

    public function historyApproval()
    {
        return $this->hasMany('\App\Models\HistoryApprovalTraining', 'training_id', 'id')->orderBy('setting_approval_level_id', 'ASC');
    }

    public function training_acomodation()
    {
        return $this->hasMany('App\Models\TrainingTransportation', 'training_id', 'id');
    }

    public function training_allowance()
    {
        return $this->hasMany('App\Models\TrainingAllowance', 'training_id', 'id');
    }

    public function training_daily()
    {
        return $this->hasMany('App\Models\TrainingDaily', 'training_id', 'id');
    }

    public function training_other()
    {
        return $this->hasMany('App\Models\TrainingOther', 'training_id', 'id');
    }

    
}