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
    
    public function userApproved()
    {
        return $this->hasOne('\App\User', 'id', 'approval_id');
    }

    public function userApproval()
    {
        return $this->hasOne('\App\Models\SettingApprovalClearance', 'user_id', 'approval_id');
    }
    
}
