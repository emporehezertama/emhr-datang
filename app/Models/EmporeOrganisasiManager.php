<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmporeOrganisasiManager extends Model
{
    protected $table = 'empore_organisasi_manager';

    /**
     * [direktur description]
     * @return [type] [description]
     */
    public function direktur()
    {
    	return $this->hasOne('\App\Models\EmporeOrganisasiDirektur', 'id', 'empore_organisasi_direktur_id');
    }
}
