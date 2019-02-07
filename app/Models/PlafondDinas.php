<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlafondDinas extends Model
{
    protected $table = 'plafond_dinas';

    /**
     * [position description]
     * @return [type] [description]
     */
    public function position()
    {
    	return $this->hasOne('\App\Models\OrganisasiPosition', 'id', 'organisasi_position_id');
    }
}
