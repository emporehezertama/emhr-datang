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
use App\Imports\AttendanceImport;

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
        $user = \Auth::user();

        if(request()->filter_start || request()->filter_end || request()->branch || request()->name)
        {
            \Session::put('filter_start', request()->filter_start);
            \Session::put('filter_end', request()->filter_end);
            \Session::put('name', request()->name);
        }

        $filter_start       = \Session::get('filter_start');
        $filter_end         = \Session::get('filter_end');
        $name               = \Session::get('name');
        $branch             = \Session::get('branch');

        $start = str_replace('/', '-', $filter_start);
        $end = str_replace('/', '-', $filter_end);

        if(request()) {
            if(!empty($filter_start) && !empty($filter_end)){
                $start = str_replace('/', '-', $filter_start);
                $end = str_replace('/', '-', $filter_end);
            }
        }

        if(request()->reset == 1)
        { 
            \Session::forget('filter_start');
            \Session::forget('filter_end');
            \Session::forget('name');
            \Session::forget('branch');
            return redirect()->route('attendance.index');
        }

        if($user->project_id != Null){
            $params['data'] = AbsensiItem::join('users',  'users.id', '=','absensi_item.user_id')
                                    ->whereIn('users.access_id', ['1', '2'])
                                    ->whereNotIn('absensi_item.date', ['1970-01-01'])
                                    ->where('users.project_id', $user->project_id)
                                    ->orderBy('absensi_item.id', 'DESC');
        }else{
            $params['data'] = AbsensiItem::join('users',  'users.id', '=','absensi_item.user_id')
                                    ->whereIn('users.access_id', ['1', '2'])
                                    ->whereNotIn('absensi_item.date', ['1970-01-01'])
                                    ->orderBy('absensi_item.id', 'DESC');
        }    

        if(!empty($name))
        {
            $name = explode('-', $name);
            $params['data'] = $params['data']->where(function($table) use($name){
                                $table->where('users.name', 'LIKE', '%'. ltrim(@$name[1]) .'%')
                                        ->orWhere('users.nik', 'LIKE', '%'. rtrim(@$name[0]) .'%');
                              });
        }
        if(!empty($filter_start) and !empty($filter_end))
        {
            $params['data'] = $params['data']->whereBetween('absensi_item.date', [$start, $end]);
        }
        if(!empty($branch))
        {
            $params['data'] = $params['data']->where('users.branch_id', $branch);
        }

        if(request()->import == 1)
        {
            return (new AttendanceExport($params['data']))->download('EM-HR.Attendance-'.date('Y-m-d').'.xlsx');
        }

        if(request()->eksport == 1)
        {
            return (new AttendanceExport($params['data']))->download('EM-HR.Attendance-'.date('Y-m-d').'.xlsx');
        }

        $params['data'] = $params['data']->paginate(100);

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

/*    public function exportAttendance($start, $end, $branch, $id){
        $params['data'] =   dataAttendance($start, $end, $branch, $id);

        $name_excel = 'Attendance'.date('YmdHis');
    //    Excel::store(new AttendanceExport($start, $end, $branch, $id), $name_excel.'.xlsx');
        return (new AttendanceExport($start, $end, $branch, $id))->download($name_excel.'.xlsx');

    //  return redirect()->route('attendance.index');
    }   */

    public function importAttendance(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        
        if($request->hasFile('file'))
        {
            // menangkap file excel
            $file = $request->file('file');
     
            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();
     
            // upload ke folder file_siswa di dalam folder public
            $file->move('storage',$nama_file);
     
            // import data
            Excel::import(new AttendanceImport, public_path('/storage/'.$nama_file));

            return redirect()->route('attendance.index')->with('message-success', 'Attendance saved.');
        }
    }
}
