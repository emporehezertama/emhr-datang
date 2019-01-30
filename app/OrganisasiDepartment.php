<?php

namespace App;

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
    	return $this->hasOne('App\OrganisasiDirectorate', 'id', 'organisasi_directorate_id');
    }

    /**
     * [division description]
     * @return [type] [description]
     */
    public function division()
    {
    	return $this->hasOne('App\OrganisasiDivision', 'id', 'organisasi_division_id');
    }
}
