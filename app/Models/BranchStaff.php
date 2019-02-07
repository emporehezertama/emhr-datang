<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStaff extends Model
{
    protected $table = 'branch_staff';

    /**
     * [head description]
     * @return [type] [description]
     */
    public function head()
    {
    	return $this->hasOne('\App\Models\BranchHead', 'id', 'branch_head_id');
    }
}
