<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollNet extends Model
{
    //
    protected $table = 'payrollnet';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
