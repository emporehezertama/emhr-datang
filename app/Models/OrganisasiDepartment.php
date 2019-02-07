<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiDepartment extends Model
{
    protected $table = 'organisasi_department';

    /**
     * [directorate description]
     * @return [type] [description]
     */
    public function directorate()
    {
    	return $this->hasOne('App\Models\OrganisasiDirectorate', 'id', 'organisasi_directorate_id');
    }

    /**
     * [division description]
     * @return [type] [description]
     */
    public function division()
    {
    	return $this->hasOne('App\Models\OrganisasiDivision', 'id', 'organisasi_division_id');
    }
}
