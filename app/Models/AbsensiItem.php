<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiItem extends Model
{
    protected $table = 'absensi_item';

    /**
     * Relation to table users
     * @return object
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
