<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
	protected $table = 'kelurahan';

	/**
	 * [kecamatan description]
	 * @return [type] [description]
	 */
	protected function kecamatan()
	{
		return $this->hasOne('App\Kecamatan', 'id_kec', 'id_kec');
	}
}
