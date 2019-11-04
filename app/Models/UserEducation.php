<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    protected $table = 'user_education';

    /**
     * [provinsi description]
     * @return [type] [description]
     */
    public function kota()
    {
    	return $this->hasOne('App\Models\Kabupaten', 'id_kab', 'kota');
    }
}