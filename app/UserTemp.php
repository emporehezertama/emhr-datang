<?php

namespace App;

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
    	return $this->hasMany('\App\UserEducationTemp', 'user_temp_id', 'id');
    }

    /**
     * [dependent description]
     * @return [type] [description]
     */
    public function family()
    {
    	return $this->hasMany('\App\UserFamilyTemp', 'user_temp_id', 'id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
        return $this->hasOne('\App\EmporeOrganisasiDirektur', 'id', 'empore_organisasi_direktur');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function manager()
    {
        return $this->hasOne('\App\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function staff()
    {
        return $this->hasOne('\App\EmporeOrganisasiStaff', 'id', 'empore_organisasi_staff_id');
    }
}
