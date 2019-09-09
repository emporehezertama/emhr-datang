<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeSheetForm extends Model
{
    protected $table = 'overtime_sheet_form';

    public function absensi_item()
    {
    	return $this->hasOne('App\Models\AbsensiItem', 'date', 'tanggal');
    }
}
