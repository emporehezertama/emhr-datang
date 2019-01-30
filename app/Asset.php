<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'asset';

    /**
     * [department description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * [department description]
     * @return [type] [description]
     */
    public function asset_type()
    {
    	return $this->hasOne('App\AssetType', 'id', 'asset_type_id');
    }
}
