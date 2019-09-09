<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
	protected $primaryKey = 'id_prov';

    protected $fillable = ['nama', 'id_prov'];

    protected $table = 'provinsi';
}
