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
        'name', 
        'email', 
        'password', 
        'last_logged_in_at',
    //    'npwp_number',
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
     * Absensi Setting
     * @return void
     */
    public function absensiSetting()
    {
        return $this->hasOne('App\Models\AbsensiSetting', 'id', 'absensi_setting_id');
    }

    /**
     * [assets description]
     * @return [type] [description]
     */
    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'user_id', 'id');
    }

    /**
     * Attendence
     * @return objects
     */
    public function absensiItem()
    {
        return $this->hasMany('App\Models\AbsensiItem', 'user_id', 'id')->orderBy('absensi_item.id', 'DESC');

    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_staff()
    {
        return $this->hasOne('App\Models\EmporeOrganisasiStaff', 'id', 'empore_organisasi_staff_id');
    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_manager()
    {
        return $this->hasOne('App\Models\EmporeOrganisasiManager', 'id', 'empore_organisasi_manager_id');
    }

    /**
     * [empore_staff description]
     * @return [type] [description]
     */
    public function empore_direktur()
    {
        return $this->hasOne('App\Models\EmporeOrganisasiDirektur', 'id', 'empore_organisasi_direktur');
    }

    /**
     * [inventaris_mobil description]
     * @return [type] [description]
     */
    public function inventaris_mobil()
    {
        return $this->hasMany('App\Models\UserInventarisMobil', 'user_id', 'id');
    }

    /**
     * [inventaris description]
     * @return [type] [description]
     */
    public function inventaris()
    {
        return $this->hasMany('App\Models\UserInventaris', 'user_id', 'id');
    }

    /**
     * [department description]
     * @return [type] [description]
     */
    public function department()
    {
        return $this->hasOne('App\Models\OrganisasiDepartment', 'id', 'department_id');
    }

    /**
     * [section description]
     * @return [type] [description]
     */
    public function section()
    {
        return $this->hasOne('App\Models\OrganisasiSection', 'id', 'section_id');
    }

    /**
     * [position description]
     * @return [type] [description]
     */
    public function position()
    {
        return $this->hasOne('App\Models\OrganisasiPosition', 'id', 'organisasi_position');
    }

    /**
     * [position description]
     * @return [type] [description]
     */
    public function organisasiposition()
    {
        return $this->hasOne('App\Models\OrganisasiPosition', 'id', 'organisasi_position');
    }

    /**
     * [division description]
     * @return [type] [description]
     */
    public function division()
    {
        return $this->hasOne('App\Models\OrganisasiDivision', 'id', 'division_id');
    }

    /**
     * [cabang description]
     * @return [type] [description]
     */
    public function cabang()
    {
        return $this->hasOne('App\Models\Cabang', 'id', 'cabang_id');
    }

    /**
     * [bank description]
     * @return [type] [description]
     */
    public function bank()
    {
        return $this->hasOne('App\Models\Bank', 'id', 'bank_id');
    }  

    /**
     * [userFamily description]
     * @return [type] [description]
     */
    public function userFamily()
    {
        return $this->hasMany('App\Models\UserFamily', 'user_id', 'id');
    }

    /**
     * [userEducation description]
     * @return [type] [description]
     */
    public function userEducation()
    {
        return $this->hasMany('App\Models\UserEducation', 'user_id', 'id');
    }

    /**
     * [cuti description]
     * @return [type] [description]
     */
    public function cuti()
    {
        return $this->hasMany('App\Models\UserCuti', 'user_id', 'id');
    }

    /**
     * [provinsi description]
     * @return [type] [description]
     */
    public function provinsi()
    {
        return $this->hasOne('App\Models\Provinsi', 'id_prov', 'provinsi_id');
    }

    /**
     * [kabupaten description]
     * @return [type] [description]
     */
    public function kabupaten()
    {
        return $this->hasOne('App\Models\Kabupaten', 'id_kab', 'kabupaten_id');
    }

    /**
     * [kecamatan description]
     * @return [type] [description]
     */
    public function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id_kec', 'kecamatan_id');
    }

    /**
     * [kelurahan description]
     * @return [type] [description]
     */
    public function kelurahan()
    {
        return $this->hasOne('App\Models\Kelurahan', 'id_kel', 'kelurahan_id');
    }

    public function structure()
    {
        return $this->hasOne('\App\Models\StructureOrganizationCustom', 'id', 'structure_organization_custom_id');
    }

    public function approvalLeave()
    {
        return $this->hasOne('\App\Models\SettingApprovalLeave', 'structure_organization_custom_id', 'structure_organization_custom_id');
    }
    
}
