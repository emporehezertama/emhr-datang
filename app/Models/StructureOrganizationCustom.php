<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructureOrganizationCustom extends Model
{
    protected $table = 'structure_organization_custom';

    public function division()
    {
    	return $this->hasOne('\App\Models\OrganisasiDivision', 'id', 'organisasi_division_id');
    }
    public function position()
    {
    	return $this->hasOne('\App\Models\OrganisasiPosition', 'id', 'organisasi_position_id');
    }
    
}
