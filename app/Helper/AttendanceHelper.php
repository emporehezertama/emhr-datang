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