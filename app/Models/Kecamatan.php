<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    
    /**
     * [kabupaten description]
     * @return [type] [description]
     */
    public function kabupaten()
    {
    	return $this->hasOne('App\Models\Kabupaten', 'id_kab', 'id_kab');
    }
}
