<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusApproval extends Model
{
    protected $table = 'status_approval';

    /**
     * [user_approval description]
     * @return [type] [description]
     */
    public function user_approval()
    {
    	return $this->hasOne('App\User', 'id', 'approval_user_id');
    }
}
