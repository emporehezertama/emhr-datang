<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiPosition extends Model
{
    protected $table = 'organisasi_position';

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

    /**
     * [department description]
     * @return [type] [description]
     */
    public function department()
    {
    	return $this->hasOne('App\Models\OrganisasiDepartment', 'id', 'organisasi_department_id');
    }

    /**
     * [unit description]
     * @return [type] [description]
     */
    public function unit()
    {
    	return $this->hasOne('App\Models\OrganisasiUnit', 'id', 'organisasi_unit_id');
    }
}
