<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiDevice;
use App\Models\AbsensiItem;
use App\Models\AbsensiSetting;

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

        $user = \Auth::user();

        if($user->project_id != NULL)
        {
            $params['data']     = AbsensiItem::join('users','users.id','=','absensi_item.user_id')->where('users.project_id', $user->project_id)->select('absensi_item.*')->orderBy('absensi_item.id', 'DESC')->paginate(100);
        }else{
           $params['data']     = AbsensiItem::orderBy('id', 'DESC')->paginate(100);
        }
        
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
    /**
     * Absensi Setting
     * @return view
     */
    public function setting()
    {
        $params['data'] = AbsensiSetting::where('project_id', \Auth::user()->project_id)->get();

        return view('attendance.setting')->with($params);
    }

    /**
     * Absensi Setting Store
     * @return view
     */
    public function settingStore(Request $r)
    {
        $data                   = new AbsensiSetting();
        $data->project_id       = \Auth::user()->project_id;
        $data->shift            = $r->shift;
        $data->clock_in         = $r->clock_in;
        $data->clock_out        = $r->clock_out;
        $data->save();

        return redirect()->route('attendance-setting.index')->with('message-success', 'Setting saved');
    }

    /**
     * Delete Setting
     */
    public function settingDelete($id)
    {
        AbsensiSetting::where('id', $id)->delete();

        return redirect()->route('attendance-setting.index')->with('message-success', 'Setting Deleted.');
    }
}
