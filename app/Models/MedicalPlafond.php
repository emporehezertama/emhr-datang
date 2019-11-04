<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalPlafond extends Model
{
    //
    protected $table = 'medical_plafond';

    public function medicalType()
    {
    	return $this->hasOne('\App\Models\MedicalType', 'id', 'medical_type_id');
    }

    public function position()
    {
    	return $this->hasOne('\App\Models\OrganisasiPosition', 'id', 'position_id');
    }

    
}
