<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExitInterviewAssets extends Model
{
    protected $table = 'exit_interview_assets';

    /**
     * [asset description]
     * @return [type] [description]
     */
    public function asset()
    {
    	return $this->hasOne('\App\Models\Asset', 'id', 'asset_id');
    }	
}
