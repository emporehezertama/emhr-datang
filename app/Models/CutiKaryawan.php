<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiKaryawan extends Model
{
    protected $table = 'cuti_karyawan';

    /**
     * [karyawan description]
     * @return [type] [description]
     */
    public function karyawan()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }   

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * [atasan description]
     * @return [type] [description]
     */
    public function atasan()
    {
        return $this->hasOne('App\User', 'id', 'approved_atasan_id');
    }

    /**
     * [backup_karyawan description]
     * @return [type] [description]
     */
    public function backup_karyawan()
    {
    	return $this->hasOne('App\User', 'id', 'backup_user_id');
    }

    /**
     * [cuti description]
     * @return [type] [description]
     */
    public function cuti()
    {
        return $this->hasOne('App\Models\Cuti', 'id', 'jenis_cuti');
    }

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
        return $this->hasOne('\App\User', 'id', 'approve_direktur_id');
    }
    public function manager()
    {
        return $this->hasOne('\App\User', 'id', 'approved_atasan_id');
    }
}
