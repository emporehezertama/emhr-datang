<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingApproval extends Model
{
    protected $table = 'setting_approval';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
