<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTracking extends Model
{
    protected $table = 'asset_tracking';

    /**
     * [department description]
     * @return [type] [description]
     */
    public function asset_type()
    {
    	return $this->hasOne('App\Models\AssetType', 'id', 'asset_type_id');
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    /**
     * [asset description]
     * @return [type] [description]
     */
    public function asset()
    {
    	return $this->hasOne('\App\Models\Asset', 'id', 'asset_id');
    }
}
