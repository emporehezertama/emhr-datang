<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';

    /**
     * [provinsi description]
     * @return [type] [description]
     */
    public function provinsi()
    {
    	return $this->hasOne('App\Models\Provinsi', 'id_prov', 'id_prov');
    }
}
