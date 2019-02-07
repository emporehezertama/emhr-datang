<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiDivision extends Model
{
    protected $table = 'organisasi_division';

    /**
     * [directorate description]
     * @return [type] [description]
     */
    public function directorate()
    {
    	return $this->hasOne('App\Models\OrganisasiDirectorate', 'id', 'organisasi_directorate_id');
    }
}
