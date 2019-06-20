<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiDevice;
use App\Models\AbsensiItem;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        getAttendanceDevice();
        
        $params['data']     = Absensi::all();
        
        $params['device']   = AbsensiDevice::all();

        return view('attendance.index')->with($params);
    }

    /**
     * Detail Attandance
     * @param  $SN
     * @return objects
     */
    public function AttendanceList($SN)
    {   
        $absensi_device_id = getAttendanceList($SN);

        $params['data'] = AbsensiItem::where('absensi_device_id', $absensi_device_id)->get();

        return view('attendance.attendance-detail')->with($params);
    }
}
