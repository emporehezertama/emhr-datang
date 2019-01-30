<?php

namespace App;

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
    	return $this->hasOne('\App\OrganisasiPosition', 'id', 'organisasi_position_id');
    }
}
