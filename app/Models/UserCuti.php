<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCuti extends Model
{
    protected $table = 'user_cuti';

    /**
     * [cuti description]
     * @return [type] [description]
     */
    public function cuti()
    {
    	return $this->hasOne('\App\Models\Cuti', 'id', 'cuti_id');
    }
}
