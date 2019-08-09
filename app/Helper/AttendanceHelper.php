<?php 

/**
 * Get Attendance Device
 * @return object
 */
function getAttendanceDevice()
{
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, env('ATTENDANCE_URL').'/device-list?key='. env('ATTENDANCE_KEY'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 

    curl_close($ch);      

    $data = json_decode($output);

    if(!isset($data->data)) return false;

    foreach($data->data as $key => $item)
    {   
        $new = App\Models\AbsensiDevice::where('sn', $item->SN)->first();
        if(!$new)
        {
            $new                    = new App\Models\AbsensiDevice();    
            $new->sn                = $item->SN;        
        }

        $new->state             = $item->State;
        $new->last_activity     = $item->LastActivity;
        $new->trans_times       = $item->TransTimes;
        $new->trans_interval    = $item->TransInterval;
        $new->alias             = $item->Alias;
        $new->style             = $item->Style;
        $new->version           = $item->FWVersion;
        $new->fp_count          = $item->FPCount;
        $new->transaction_count = $item->TransactionCount;
        $new->user_count        = $item->UserCount;
        $new->main_time         = $item->MainTime;
        $new->max_finger_count  = $item->MaxFingerCount;
        $new->max_att_log_count = $item->MaxAttLogCount;
        $new->device_name       = $item->DeviceName;
        $new->save();
    }
}


/**
 * Get Attendance List
 * @return object
 */
function getAttendanceList($SN)
{
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, env('ATTENDANCE_URL').'/attendance-list?key='. env('ATTENDANCE_KEY') .'&SN='.$SN );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 

    curl_close($ch);      
    
    $data =  json_decode($output);

    $absensi_device_id     = App\Models\AbsensiDevice::where('sn', $SN)->first();
    if($absensi_device_id)
    {
        $absensi_device_id     = $absensi_device_id->id;        
    }

    if(!isset($data->data)) 
    {
        return $absensi_device_id;
    }

    foreach($data->data as $item)
    {
        $date           = date('Y-m-d', strtotime($item->checktime));

        $new            = App\Models\AbsensiItem::where('date', $date)->where('absensi_device_id', $absensi_device_id)->first();            
           
        if(!$new)
        {
            $new                    = new App\Models\AbsensiItem();            
            $new->date              = $date;
            $user_id                = \App\User::where('absensi_number', $item->badgenumber)->first();
            $new->user_id           = $user_id;
        }

        if($item->checktype == 0)
        {
            $new->clock_in = date('H:i:s', strtotime($item->checktime));
        }

        if($item->checktype == 1)
        {
            $new->clock_out = date('H:i:s', strtotime($item->checktime));
        }

        if(!empty($new->clock_in) and !empty($new->clock_out))
        {
            $in     = new DateTime($new->clock_in);
            $out    = new DateTime($new->clock_out);

            $clock = $in->diff($out);

            $new->work_time = $clock->format('%H:%i:%s');;            
        }

        $new->late      = 0;
        $new->early     = 0;
        $new->timetable = date('l', strtotime($date));
        $new->absensi_device_id = $absensi_device_id;
        $new->save();    
    }

    return $absensi_device_id;
}

function attendanceKaryawan($name){
    $absensi = App\Models\AbsensiItem::join('users', 'users.id', '=', 'absensi_item.user_id')
                                        ->where('users.project_id', \Auth::user()->project_id)
                                        ->groupBy('absensi_item.date')
                                        ->select('absensi_item.*')
                                        ->orderBy('absensi_item.date', 'DESC')
                                        ->get();
    $a = 0;
    $b = 0;
    $c = 0;
    $v = 0;
    $tanggal = [];
    $data = [];
    $dd = [];
    for($i = 0; $i<count($absensi); $i++){
        $tanggal[$b] = $absensi[$i]->date;
        $arrayhari = array("Minggu"=>"Sun", "Senin"=>"Mon", "Selasa"=>"Tue", "Rabu"=>"Wed", "Kamis"=>"Thu", "Jumat"=>"Fri", "Sabtu"=>"Sat");
        $day[$v] = array_search(date_format(date_create($tanggal[$b]), "D"), $arrayhari);
        $data[$c] = App\Models\AbsensiItem::where('name', $name)
                                        ->where('date', $tanggal[$b])
                                        ->get();
        if(count($data[$c]) < 1){
            $array = array(
                'id'  => "",
                'absensi_id'  => "",
                'user_id'  => "",
                'emp_no' => "", 
                'ac_no' => "", 
                'name' => "", 
                'auto_assign' => "", 
                'date' => $tanggal[$b],
                'timetable' => $day[$v],
                'on_dutty' => "",
                'off_dutty' => "",
                'clock_in' => "00:00",
                'clock_out' => "00:00",
                'normal' => "",
                'real_time' => "",
                'late' => "",
                'early' => "",
                'absent' => "",
                'ot_time' => "",
                'work_time' => "00:00",
                'exception' => "00:00",
                'must_c_in' => "00:00",
                'must_c_out' => "00:00",
                'department' => "00:00",
                'ndays' => "00:00",
                'weekend' => "00:00",
                'holiday' => "00:00",
                'att_time' => "00:00",
                'ndays_ot' => "00:00",
                'weekend_ot' => "00:00",
                'holiday_ot' => "00:00",
                'absensi_device_id' => "00:00",
                'pic_out' => "",
                'long_out' => "00:00",
                'lat_out' => "00:00",
                'absensi_setting_id' => "00:00"
            );
            $array2 = [];
            array_push($array2, $array);
            $data[$c] = $array2;
        }
        $dd[$c] = $data[$c][0];
        $tanggal[$b++];
        $data[$c++];
    }
//    dd(json_encode($dd));
    return $data;
}

function dataAttendance($start, $end, $branch, $id){
    $user = \Auth::user();

    
        if($user->project_id != NULL){
            $dataabsen      = App\Models\AbsensiItem::select('absensi_item.date')
                                            ->join('users', 'users.id', 'absensi_item.user_id')
                                            ->where('users.project_id', $user->project_id)
                                            ->groupBy('absensi_item.date')
                                            ->orderBy('absensi_item.date', 'DESC');

            if(!empty($start) && !empty($end)){
                $dataabsen = $dataabsen->whereBetween('absensi_item.date', [$start, $end]);
            }
        }else{
            $dataabsen      = App\Models\AbsensiItem::groupBy('date')
                                                    ->orderBy('date', 'DESC');

            if(!empty($start) && !empty($end)){
                $dataabsen = $dataabsen->whereBetween('date', [$start, $end]);
            }
        }

        $dataabsen = $dataabsen->get();

        $tanggal = $tgl = $data = $dd = $name = [];
        $x = $j = $y = $z = $w = $v = 0;
        for($i = 0; $i < count($dataabsen); $i++){
            $tanggal[$j] = $dataabsen[$i]->date;
            $arrayhari = array("Minggu"=>"Sun", "Senin"=>"Mon", "Selasa"=>"Tue", "Rabu"=>"Wed", "Kamis"=>"Thu", "Jumat"=>"Fri", "Sabtu"=>"Sat");
            $day[$v] = array_search(date_format(date_create($tanggal[$j]), "D"), $arrayhari);

            if($user->project_id != NULL){
                $karyawan   = \App\User::where('project_id', \Auth::user()->project_id)
                                        ->where('access_id', 2)
                                        ->where(function($query) use($tanggal, $j){
                                            $query->whereNull('resign_date')
                                                    ->orWhere('resign_date', '>=', $tanggal[$j]);
                                        });

                if(!empty($branch)){
                    $karyawan = $karyawan->where('cabang_id', $branch);
                }
                if(!empty($id)){
                    $karyawan = $karyawan->where('id', $id);
                }
            }else{
                $karyawan   = \App\User::where('access_id', 2)
                                        ->where(function($query) use($tanggal, $j){
                                            $query->whereNull('resign_date')
                                                    ->orWhere('resign_date', '>=', $tanggal[$j]);
                                        });
                                        
                if(!empty($branch)){
                    $karyawan = $karyawan->where('cabang_id', $branch);
                }
                if(!empty($id)){
                    $karyawan = $karyawan->where('id', $id);
                }
            }
            
            $karyawan = $karyawan->orderBy('name', 'ASC')->get();
            

            for($no = 0; $no < count($karyawan); $no++){
                $nik[$w] = $karyawan[$no]->nik;
                $name[$z] = $karyawan[$no]->name;
                if($user->project_id != NULL){
                    $data[$x]     = App\Models\AbsensiItem::join('users','users.id','=','absensi_item.user_id')
                                                            ->where('users.project_id', $user->project_id)
                                                            ->where('absensi_item.date', $tanggal[$j])
                                                            ->where('users.name', $name[$z])
                                                            ->select('absensi_item.*', 'users.nik')
                                                            ->orderBy('absensi_item.date', 'DESC')
                                                            ->paginate(100);
                }else{
                    $data[$x]     = App\Models\AbsensiItem::where('date', $tanggal[$j])
                                                            ->where('name', $name[$z])
                                                            ->orderBy('date', 'DESC')
                                                            ->paginate(100);
                }

                if(count($data[$x]) < 1){
                    $array = array(
                                    'nik'  => $nik[$w],
                                    'name' => $name[$z], 
                                    'date' => $tanggal[$j],
                                    'timetable' => $day[$v],
                                    'late' => "",
                                    'early' => "",
                                    'work_time' => "00:00",
                                    'pic' => "",
                                    'lat' => "00:00",
                                    'long' => "00:00",
                                    'clock_in' => "00:00",
                                    'clock_out' => "00:00"
                                );
                    if(date('Y-m-d H:i:s') > $tanggal[$j]." 17:00:00"){
                        $array2 = [];
                        array_push($array2, $array);
                        $data[$x] = $array2;
                    }
                }

                $dd[$x] = $data[$x][0];
                $name[$z++];
                $nik[$w++];
                $data[$x++];
            }
            $tanggal[$j++];
            $day[$v++];
        }
        $dataabsensi = $dd;
    

    return $dataabsensi;
}


function cabang(){
    if(\Auth::user()->project_id != Null){
        $cabang = App\Models\Cabang::join('users', 'users.id', '=', 'cabang.user_created')
                                ->where('users.project_id', \Auth::user()->project_id)
                                ->select('cabang.*')
                                ->get();
    }else{
        $cabang = App\Models\Cabang::all();
    }
    
    return $cabang;
}

function getNamaCabang($id){
    $cabang = App\Models\Cabang::where('id', $id)->first();
    return $cabang;
}