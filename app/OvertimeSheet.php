<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OvertimeSheet extends Model
{
    protected $table = 'overtime_sheet';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * [overtime_form description]
     * @return [type] [description]
     */
    public function overtime_form()
    {
    	return $this->hasMany('App\OvertimeSheetForm', 'overtime_sheet_id', 'id');
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
