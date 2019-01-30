<?php

namespace App;

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
    	return $this->hasOne('App\OrganisasiDirectorate', 'id', 'organisasi_directorate_id');
    }
}
