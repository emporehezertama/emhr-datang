<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExitInterviewInventaris extends Model
{
    protected $table = 'exit_interview_inventaris';

    /**
     * [inventaris description]
     * @return [type] [description]
     */
    public function inventaris()
    {
    	return $this->hasOne('\App\Models\UserInventaris', 'id', 'user_inventaris_id');
    }
}
