<?php

namespace App;

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
    	return $this->hasOne('\App\Cuti', 'id', 'cuti_id');
    }
}
