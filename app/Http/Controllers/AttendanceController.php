<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiDevice;
use App\Models\AbsensiItem;
use App\Models\AbsensiSetting;
use App\Models\AttendanceExport;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DB;

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

        \Session::forget('filter_start',  request()->filter_start);
        \Session::forget('filter_end',  request()->filter_end);
        \Session::forget('nama_nik',  request()->nama_nik);
        \Session::forget('id',  request()->id);
        \Session::forget('branch',  request()->branch);

        $start       = "";
        $end         = "";
        $nama_nik    = "";
        $id          = "";
        $branch      = "";       

        $data     = AbsensiItem::select('absensi_item.*');

        if(request()->filter_start || request()->filter_end || request()->branch || request()->id)
        {
            \Session::put('filter_start', request()->filter_start);
            \Session::put('filter_end', request()->filter_end);
            \Session::put('nama_nik', request()->nama_nik);
            \Session::put('id', request()->id);
            \Session::put('branch', request()->branch);
        }
        $filter_start       = \Session::get('filter_start');
        $filter_end         = \Session::get('filter_end');
        $nama_nik           = \Session::get('nama_nik');
        $id                 = \Session::get('id');
        $branch             = \Session::get('branch');

        $start = str_replace('/', '-', $filter_start);
        $end = str_replace('/', '-', $filter_end);

        if(request()) {
            if(!empty($filter_start) && !empty($filter_end)){
                $start = str_replace('/', '-', $filter_start);
                $end = str_replace('/', '-', $filter_end);
            }

            if(!empty($id)){
                $id = $id;
            }

            if(!empty($branch)){
                $branch = $branch;
            }

            
        }

        if(request()->import == 1){
        /*    $filter_start       = \Session::get('filter_start');
            $filter_end         = \Session::get('filter_end');
            $nama_nik           = \Session::get('nama_nik');
            $id                 = \Session::get('id');
            $branch             = \Session::get('branch');
    
            $start = str_replace('/', '-', $filter_start);
            $end = str_replace('/', '-', $filter_end);
            
            $this->importAttendance($start, $end, $branch, $id);    */

            $name_excel = 'Attendance'.date('YmdHis');
            return (new AttendanceExport($start, $end, $branch, $id))->download($name_excel.'.xlsx');
        }

        
        if(request()->reset == 1)
        { 
            \Session::forget('filter_start');
            \Session::forget('filter_end');
            \Session::forget('nama_nik');
            \Session::forget('id');
            \Session::forget('branch');

            return redirect()->route('attendance.index');
        }

        $params['data'] = dataAttendance($start, $end, $branch, $id);
    //    $params['datas'] = \App\Models\AbsensiItem::where('date', '2019-08-01')->where('user_id', '15734')->get();

    //dd(json_encode($params['datas']));
   // dd(json_encode($params['datas']), json_encode($params['data']));

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

    public function importAttendance($start, $end, $branch, $id){
        $params['data'] =   dataAttendance($start, $end, $branch, $id);

        $name_excel = 'Attendance'.date('YmdHis');
    //    Excel::store(new AttendanceExport($start, $end, $branch, $id), $name_excel.'.xlsx');
        return (new AttendanceExport($start, $end, $branch, $id))->download($name_excel.'.xlsx');

    //  return redirect()->route('attendance.index');
    }

/*    public function importAttendance(Request $request){
    //    if($request->ajax())
    //    {
            $start = $request->filter_start;
            $end = $request->filter_end;
            $branch = $request->branch;
            $id = $request->id;
            $params['data'] =   dataAttendance($start, $end, $branch, $id);
            $name_excel = 'Attendance'.date('YmdHis');
            return (new AttendanceExport($start, $end, $branch, $id))->download($name_excel.'.xlsx');
        //    (new AttendanceExport($start, $end, $branch, $id))->download($name_excel.'.xlsx');

        //    $hasil = "ok";
        //    return response()->json($hasil);
    //    }
    //    return response()->json($this->respon);
    }   */

}
