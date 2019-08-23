<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiDevice;
use App\Models\AbsensiItem;
use App\Models\AbsensiItemTemp;
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
     * Set Position
     * @param Request $request
     */
    public function setPosition(Request $request)
    {
        User::where('structure_organization_custom_id', $request->structure_organization_custom_id)
                ->update(['absensi_setting_id' => $request->shift_id]);
        
        return redirect()->route('attendance-setting.index')->with('message-success', 'Setting saved');
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

        User::where('absensi_setting_id', $id)->update(['absensi_setting_id' => null]);;

        return redirect()->route('attendance-setting.index')->with('message-success', 'Setting Deleted.');
    }

    /**
     * Import Attendance
     * @param  Request $request
     * @return void
     */
    public function attendanceImport(Request $request)
    {
        if($request->hasFile('file'))
        {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }

            AbsensiItemTemp::truncate();
            // delete all table temp
            foreach($rows as $key => $item)
            {
                if(empty($item[1])) continue;
                
                if($key ==0) continue;
                
                // check nik 
                $user =  User::where('nik', $item[1])->first();
                if($user)
                {
                    $date           = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[2]);
                    $clock_in       = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[3]);
                    $clock_out      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[4]);
                    
                    $data               = new AbsensiItemTemp();
                    $data->user_id      = $user->id;
                    $data->date         = $date->format('Y-m-d');
                    $data->timetable    = date('l', strtotime($data->date));   
                    $data->clock_in     = $clock_in->format('H:i');
                    $data->clock_out    = $clock_out->format('H:i');

                    // Clock In
                    if(isset($data->user->absensiSetting->clock_in))
                    {
                        $awal  = strtotime($data->date .' '. $data->user->absensiSetting->clock_in .':00');
                        $akhir = strtotime($data->date .' '. $data->clock_in.":00");
                        $diff  = $akhir - $awal;
                        $jam   = floor($diff / (60 * 60));
                        $menit = ($diff - $jam * (60 * 60)) / 60;
                        
                        if($diff > 0)
                        {
                            $jam = abs($jam);
                            $menit = abs($menit);
                            $jam = $jam <= 9 ? "0".$jam : $jam;
                            $menit = $menit <= 9 ? "0".$menit : $menit;

                            $data->late = $jam .':'. $menit;
                        }
                    }

                    if(isset($data->user->absensiSetting->clock_out))
                    {
                        $akhir  = strtotime($data->date .' '. $data->user->absensiSetting->clock_out .':00');
                        $awal = strtotime($data->date .' '. $data->clock_out.":00");
                        $diff  = $akhir - $awal;
                        $jam   = floor($diff / (60 * 60));
                        $menit = ($diff - $jam * (60 * 60)) / 60;
                        if($diff > 0)
                        {
                            $awal  = date_create($data->date .' '. $data->user->absensiSetting->clock_out .':00');
                            $akhir = date_create($data->date .' '. $data->clock_out.":00"); // waktu sekarang, pukul 06:13
                            $diff  = @date_diff( $akhir, $awal );
                            $data->early = @$diff->h .':'. @$diff->i;
                        }
                    }

                    if(!empty($data->clock_out) and !empty($data->clock_in))
                    {
                        $awal  = strtotime($data->date .' '. $data->clock_in.":00");
                        $akhir = strtotime($data->date .' '. $data->clock_out.":00");
                        $diff  = $akhir - $awal;
                        $jam   = floor($diff / (60 * 60));
                        $menit = ($diff - $jam * (60 * 60) ) / 60;

                        $jam = $jam <= 9 ? "0".$jam : $jam;

                        $data->work_time        = $jam .':'. $menit;  
                    }

                    $data->save();
                }
            }   
        }

        return redirect()->route('attendance.preview')->with('message-success', 'Import success');
    }

    /**
     * Import Attendance
     * @param  Request $request
     * @return void
     */
    public function attendancePreview()
    {
        $params['data'] = AbsensiItemTemp::all();

        return view('attendance.preview')->with($params);
    }

    /**
     * Import All
     * @return void
     */
    public function importAll()
    {
        $data = AbsensiItemTemp::all();
        foreach($data as $i)
        {
            $item               = new AbsensiItem();
            $item->user_id      = $i->user_id;
            $item->date         = $i->date;
            $item->timetable    = $i->timetable;
            $item->clock_in     = $i->clock_in; 
            $item->clock_out    = $i->clock_out; 
            $item->early        = $i->early; 
            $item->late         = $i->late; 
            $item->work_time    = $i->work_time; 
            $item->save();
        }

        AbsensiItemTemp::truncate();

        return redirect()->route('attendance.index')->with('message-success', 'Import success');
    }  
}