<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiSection extends Model
{
    protected $table = 'section';

    /**
     * [department description]
     * @return [type] [description]
     */
    public function department()
    {
    	return $this->hasOne('App\Models\Department', 'id', 'department_id');
    }

    /**
     * [directorate description]
     * @return [type] [description]
     */
    public function directorate()
    {
    	return $this->hasOne('App\Models\Directorate', 'id', 'directorate_id');
    }

    /**
     * [division description]
     * @return [type] [description]
     */
    public function division()
    {
    	return $this->hasOne('App\Models\Division', 'id', 'division_id');
    }
}
