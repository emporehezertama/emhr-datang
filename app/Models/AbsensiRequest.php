<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiRequest extends Model
{
	protected $casts = [
	    'value' => 'array'
	];

    protected $table = 'absensi_request';
}
