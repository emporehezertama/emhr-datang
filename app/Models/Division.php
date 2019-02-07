<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'division';

    /**
     * [directorate description]
     * @return [type] [description]
     */
    public function directorate()
    {
    	return $this->hasOne('App\Models\OrganisasiDirectorate', 'id', 'organisasi_directorate_id');
    }
}
