<?php

namespace App;

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

    /**
     * [department description]
     * @return [type] [description]
     */
    public function department()
    {
    	return $this->hasOne('App\OrganisasiDepartment', 'id', 'organisasi_department_id');
    }

    /**
     * [unit description]
     * @return [type] [description]
     */
    public function unit()
    {
    	return $this->hasOne('App\OrganisasiUnit', 'id', 'organisasi_unit_id');
    }
}
