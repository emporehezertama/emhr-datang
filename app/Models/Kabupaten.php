<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';

    protected $primaryKey = 'id_kab';

    /**
     * [provinsi description]
     * @return [type] [description]
     */
    public function provinsi()
    {
    	return $this->hasOne('App\Models\Provinsi', 'id_prov', 'id_prov');
    }
}
