<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitInterview extends Model
{
    protected $table = 'exit_interview';

    /**
     * [exit_interview_form description]
     * @return [type] [description]
     */
    public function exitInterviewReason()
    {
    	return $this->hasOne('App\ExitInterviewReason', 'id', 'exit_interview_reason');
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
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

    /**
     * [inventaris description]
     * @return [type] [description]
     */
    public function inventaris()
    {
        return $this->hasMany('\App\ExitInterviewInventaris', 'exit_interview_id', 'id');
    }

    /**
     * [inventaris_mobil description]
     * @return [type] [description]
     */
    public function inventaris_mobil()
    {
        return $this->hasMany('\App\ExitInterviewInventarisMobil', 'exit_interview_id', 'id');
    }

    /**
     * [assets description]
     * @return [type] [description]
     */
    public function assets()
    {
        return $this->hasMany('\App\ExitInterviewAssets', 'exit_interview_id', 'id');
    }
}
