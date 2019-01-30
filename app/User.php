<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * [assets description]
     * @return [type] [description]
     */
    public function assets()
    {
        return $this->hasMany('\App\Asset', 'user_id', 'id');
    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_staff()
    {
        return $this->hasOne('App\EmporeOrganisasiStaff', 'id', 'empore_organisasi_staff_id');
    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_manager()
    {
        return $this->hasOne('App\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_direktur()
    {
        return $this->hasOne('App\EmporeOrganisasiDirektur', 'id', 'empore_organisasi_direktur');
    }

    /**
     * [inventaris_mobil description]
     * @return [type] [description]
     */
    public function inventaris_mobil()
    {
        return $this->hasMany('App\UserInventarisMobil', 'user_id', 'id');
    }

    /**
     * [inventaris description]
     * @return [type] [description]
     */
    public function inventaris()
    {
        return $this->hasMany('App\UserInventaris', 'user_id', 'id');
    }

    /**
     * [department description]
     * @return [type] [description]
     */
    public function department()
    {
        return $this->hasOne('App\OrganisasiDepartment', 'id', 'department_id');
    }

    /**
     * [section description]
     * @return [type] [description]
     */
    public function section()
    {
        return $this->hasOne('App\OrganisasiSection', 'id', 'section_id');
    }

    /**
     * [position description]
     * @return [type] [description]
     */
    public function position()
    {
        return $this->hasOne('App\OrganisasiPosition', 'id', 'organisasi_position');
    }

    /**
     * [position description]
     * @return [type] [description]
     */
    public function organisasiposition()
    {
        return $this->hasOne('App\OrganisasiPosition', 'id', 'organisasi_position');
    }

    /**
     * [division description]
     * @return [type] [description]
     */
    public function division()
    {
        return $this->hasOne('App\OrganisasiDivision', 'id', 'division_id');
    }

    /**
     * [cabang description]
     * @return [type] [description]
     */
    public function cabang()
    {
        return $this->hasOne('App\Cabang', 'id', 'cabang_id');
    }

    /**
     * [bank description]
     * @return [type] [description]
     */
    public function bank()
    {
        return $this->hasOne('App\Bank', 'id', 'bank_id');
    }  

    /**
     * [userFamily description]
     * @return [type] [description]
     */
    public function userFamily()
    {
        return $this->hasMany('App\UserFamily', 'user_id', 'id');
    }

    /**
     * [userEducation description]
     * @return [type] [description]
     */
    public function userEducation()
    {
        return $this->hasMany('App\UserEducation', 'user_id', 'id');
    }

    /**
     * [cuti description]
     * @return [type] [description]
     */
    public function cuti()
    {
        return $this->hasMany('App\UserCuti', 'user_id', 'id');
    }

    /**
     * [provinsi description]
     * @return [type] [description]
     */
    public function provinsi()
    {
        return $this->hasOne('App\Provinsi', 'id_prov', 'provinsi_id');
    }

    /**
     * [kabupaten description]
     * @return [type] [description]
     */
    public function kabupaten()
    {
        return $this->hasOne('App\Kabupaten', 'id_kab', 'kabupaten_id');
    }

    /**
     * [kecamatan description]
     * @return [type] [description]
     */
    public function kecamatan()
    {
        return $this->hasOne('App\Kecamatan', 'id_kec', 'kecamatan_id');
    }

    /**
     * [kelurahan description]
     * @return [type] [description]
     */
    public function kelurahan()
    {
        return $this->hasOne('App\Kelurahan', 'id_kel', 'kelurahan_id');
    }
}
