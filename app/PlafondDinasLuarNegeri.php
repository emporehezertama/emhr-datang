<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlafondDinasLuarNegeri extends Model
{
    protected $table = 'plafond_dinas_luar_negeri';

    /**
     * [position description]
     * @return [type] [description]
     */
    public function position()
    {
    	return $this->hasOne('\App\OrganisasiPosition', 'id', 'organisasi_position_id');
    }
}
