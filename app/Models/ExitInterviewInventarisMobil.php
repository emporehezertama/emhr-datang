<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExitInterviewInventarisMobil extends Model
{
    protected $table = "exit_interview_inventaris_mobil";

    /**
     * [inventaris description]
     * @return [type] [description]
     */
    public function inventaris()
    {
    	return $this->hasOne('\App\Models\UserInventarisMobil', 'id', 'user_inventaris_mobil_id');
    }
}
