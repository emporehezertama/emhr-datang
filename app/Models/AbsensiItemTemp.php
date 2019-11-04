<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiItemTemp extends Model
{
    protected $table = 'absensi_item_temp';

    /**
     * Relation to table users
     * @return object
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
