<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiItem extends Model
{
    protected $table = 'absensi_item';

    protected $fillable = ['absensi_id', 'user_id', 'emp_no', 'ac_no', 'name', 'auto_assign', 'date', 'timetable', 'on_dutty', 'off_dutty',
                            'clock_in', 'clock_out', 'normal', 'real_time', 'late', 'early', 'absent', 'ot_time', 'work_time', 'exception',
                            'must_c_in', 'must_c_out', 'department', 'created_at', 'updated_at', 'ndays', 'weekend', 'holiday', 'att_time', 'ndays_ot',
                            'weekend_ot', 'holiday_ot', 'no', 'absensi_device_id', 'long', 'lat', 'pic', 'long_out', 'lat_out', 'pic_out',
                            'absensi_setting_id'];

    /**
     * Relation to table users
     * @return object
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
