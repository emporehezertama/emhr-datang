<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTemp extends Model
{
    protected $table = 'users_temp';

    /**
     * [education description]
     * @return [type] [description]
     */
    public function education()
    {
    	return $this->hasMany('\App\Models\UserEducationTemp', 'user_temp_id', 'id');
    }

    /**
     * [dependent description]
     * @return [type] [description]
     */
    public function family()
    {
    	return $this->hasMany('\App\Models\UserFamilyTemp', 'user_temp_id', 'id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
        return $this->hasOne('\App\Models\EmporeOrganisasiDirektur', 'id', 'empore_organisasi_direktur');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function manager()
    {
        return $this->hasOne('\App\Models\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function staff()
    {
        return $this->hasOne('\App\Models\EmporeOrganisasiStaff', 'id', 'empore_organisasi_staff_id');
    }
}
