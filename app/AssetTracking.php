<?php

namespace App;

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
    	return $this->hasOne('App\AssetType', 'id', 'asset_type_id');
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
    	return $this->hasOne('\App\Asset', 'id', 'asset_id');
    }
}
