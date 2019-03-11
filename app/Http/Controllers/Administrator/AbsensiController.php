<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AbsensiItemTemp;
use App\Models\AbsensiItem;
use App\User;
use App\Models\Absensi;

class AbsensiController extends Controller
{   

	public function __construct(\Maatwebsite\Excel\Excel $excel)
	{
	    $this->excel = $excel;
	}

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {   
        $data = Absensi::all();
        
        return view('administrator.absensi.index')->with(['data' => $data]);
    }

    /**
     * Detail
     * @param  $id
     * @return view
     */
    public function detail($id)
    {
        $data = AbsensiItem::where('absensi_id', $id)->get();

        return view('administrator.absensi.detail')->with(['data' => $data]);
    }

    /**
     * [importAll description]
     * @return [type] [description]
     */
    public function importAll()
    {
        $data = AbsensiItemTemp::all();

        $absensi                    = new Absensi();
        $absensi->tanggal_upload    = date('Y-m-d');
        $absensi->save();

        foreach ($data as $k => $v) 
        {
            $temp       = new AbsensiItem();

            $user       = User::where('nik', $v->emp_no)->first();
            
            if($user) $temp->user_id = $user->id;

            $temp->absensi_id   = $absensi->id;
            $temp->emp_no       = $v->emp_no;
            $temp->ac_no        = $v->ac_no;
            $temp->no           = $v->no;
            $temp->name         = $v->name;
            $temp->auto_assign  = $v->auto_assign;
            $temp->date         = $v->date;
            $temp->timetable    = $v->timetable;
            $temp->on_dutty     = $v->on_dutty;
            $temp->off_dutty    = $v->off_dutty;
            $temp->clock_in     = $v->clock_in;
            $temp->clock_out    = $v->clock_out;
            $temp->normal       = $v->normal;
            $temp->real_time    = $v->real_time;
            $temp->late         = $v->late;
            $temp->early        = $v->early;
            $temp->absent       = $v->absent;
            $temp->ot_time      = $v->ot_time;
            $temp->work_time    = $v->work_time;
            $temp->exception    = $v->exception;
            $temp->must_c_in    = $v->must_c_in;
            $temp->must_c_out   = $v->must_c_out;
            $temp->department   = $v->department;
            $temp->ndays        = $v->ndays;
            $temp->weekend      = $v->weekend;
            $temp->holiday      = $v->holiday;
            $temp->att_time     = $v->att_time;
            $temp->ndays_ot     = $v->ndays_ot;
            $temp->weekend_ot   = $v->weekend_ot;
            $temp->holiday_ot   = $v->holiday_ot;
            $temp->save();
        }

        AbsensiItemTemp::truncate();

        return redirect()->route('administrator.absensi.index')->with('message-success', 'Data absen berhasil di import');
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import()
    {	
    	return view('administrator.absensi.import');
    }

    /**
     * [deleteNew description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteNew($id)
    {
        AbsensiItem::where('id', $id)->first()->delete();

        return redirect()->route()->with('messages-success', 'Data berhasil dihapus');
    }

    /**
     * [deleteNew description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteOld($id)
    {
        AbsensiItem::where('id', $id)->first()->delete();

        return redirect()->route()->with('messages-success', 'Data berhasil dihapus');
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function tempImport(Request $request)
    {	
        /*
    	$this->validate($request, [
	        'file' => 'required|mimes:xls',
	    ]);
*/
    	if($request->hasFile('file')){

            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
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

            // delete all table temp
            AbsensiItemTemp::truncate();
            foreach($rows as $key => $row)
            {
            	if($key ==0) continue;

            	$temp 				= new AbsensiItemTemp();

            	// cek absensi yang sama dengan no karyawa dan tanggal yang sama
                $date = str_replace("'", '', $row[5]);
                //$date = empty($row[5]) ?  "" : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
                

            	$absensiCek = AbsensiItem::where('emp_no', $row[0])->where('date', $date)->first();
            	
            	if($absensiCek) $temp->absensi_item_id = $absensiCek->id;

            	$temp->emp_no 		= $row[0];
            	$temp->ac_no 		= $row[1];
            	$temp->no 			= $row[2];
            	$temp->name 		= $row[3];
            	$temp->auto_assign 	= $row[4];
            	$temp->date 		= $date;
            	$temp->timetable 	= $row[6];
            	$temp->on_dutty 	= $row[7];
            	$temp->off_dutty 	= $row[8];
            	$temp->clock_in 	= $row[9];
            	$temp->clock_out 	= $row[10];
            	$temp->normal 		= $row[11];
            	$temp->real_time 	= $row[12];
            	$temp->late	 		= $row[13];
            	$temp->early 		= $row[14];
            	$temp->absent 		= $row[15];
            	$temp->ot_time 		= $row[16];
            	$temp->work_time 	= $row[17];
            	$temp->exception 	= $row[18];
            	$temp->must_c_in 	= $row[19];
            	$temp->must_c_out 	= $row[20];
            	$temp->department 	= $row[21];
            	$temp->ndays 		= $row[22];
            	$temp->weekend  	= $row[23];
            	$temp->holiday 		= $row[24];
            	$temp->att_time 	= $row[25];
            	$temp->ndays_ot 	= $row[26];
            	$temp->weekend_ot 	= $row[27];
            	$temp->holiday_ot 	= $row[28];
            	$temp->save();
	        }
        }

        return redirect()->route('administrator.absensi.preview-temp');
    }

    /**
     * [previewTemp description]
     * @return [type] [description]
     */
    public function previewTemp()
    {
    	$params['data'] = AbsensiItemTemp::all();

    	return view('administrator.absensi.preview-temp')->with($params);
    }
}
