<?php

/**
 * Month name
 * @return array
 */
function month_name()
{
	$months = [];
	for ($i = 1; $i <= 12; $i++) {
	    $timestamp = mktime(0, 0, 0, $i, 1);
	    $months[date('n', $timestamp)] = date('F', $timestamp);
	}

	return $months;
}

/**
 * Replace IDR
 * @return string
 */
function replace_idr($nominal)
{
	if($nominal == "") return 0;
	
	$nominal = str_replace('Rp. ','', $nominal);
    $nominal = str_replace('.', '', $nominal);
    $nominal = str_replace(',', '', $nominal);

    return $nominal;
}

/**
 * Times Zone
 * @return array
 */
function generate_timezone_list()
{
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }

    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by offset
    asort($timezone_offsets);

    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

        $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
    }

    return $timezone_list;
}

/**
 * List Language
 * @return array
 */
function list_language()
{
	return ['id' => 'Indonesia', 'en' => 'English'];
}

/**
 * Get Setting
 * @param  $key
 * @return string
 */
function get_setting($key)
{
	$setting = \App\Models\Setting::where('key', $key)->first();

	if($setting)
	{
		return $setting->value;
	}
	
	return '';
}


/**
 * [format_tanggal description]
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function format_tanggal($date, $format='tanggal')
{
	if($format=='tanggal')
	{
		return date('d F Y', strtotime($date));		
	}

	if($format=='tanggal_jam')
	{
		return date('d F Y H:i:s', strtotime($date));		
	}
	
}

/**
 * [jenis_claim_medical description]
 * @param  string $key [description]
 * @return [type]      [description]
 */
function jenis_claim_medical($key="")
{
	$arr = ['RJ' => 'Outpatient', 'RI' => 'Inpatient', 'MA' => 'Maternity','Frame' => 'Frame', 'Glasses' => 'Glasses'];
	if(!empty($key))
	{
		return @$arr[$key];
	}
	else
	{
		return @$arr;
	}
}

/**
 * [total_medical_nominal description]
 * @return [type] [description]
 */
function total_medical_nominal($id)
{
	$data = \App\Models\MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
	$nominal = 0;

	foreach($data as $item)
	{
		$nominal  += $item->jumlah;
	}

	return $nominal;
}

/**
 * [jenis_claim_strint description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function medical_jenis_claim_string($id)
{
	$data = \App\Models\MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
	$string = "";

	foreach($data as $item)
	{
		$string  .= jenis_claim_medical($item->jenis_klaim) .' ,';
	}

	return substr($string, 0, -1);
}

/**
 * @param  [type]
 * @return [type]
 */
function jabatan_level_user($id)
{
	$user = \App\User::where('id', $id)->first();

	if($user)
	{
		if(!empty($user->empore_organisasi_staff_id)):
            return 'Staff';
        endif;

        if(empty($user->empore_organisasi_staff_id) and !empty($user->empore_organisasi_manager_id)):
            return 'Manager';
        endif;

        if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_manager_id) and !empty($user->empore_organisasi_direktur)):
            return 'Direktur';
        endif;
	}

	return;
}

/**
 * @return [type]
 */
function get_level_organisasi()
{
	$organisasi = ['Staff', 'Manager', 'Direktur'];
	
	return $organisasi;
}

/**
 * [pay_slip_tahun description]
 * @return [type] [description]
 */
function pay_slip_tahun($id)
{
	$data = \App\Models\Payroll::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->get();

	return $data;
}

/**
 * [pay_slip_tahun_history description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function pay_slip_tahun_history($id)
{
	$data = \App\Models\PayrollHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

function pay_slip_tahun_historyNet($id)
{
	$data = \App\Models\PayrollNetHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

function pay_slip_tahun_historyGross($id)
{
	$data = \App\Models\PayrollGrossHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

/**
 * [asset_type description]
 * @return [type] [description]
 */
function asset_type($id=null)
{
	if($id != null)
		return \App\Models\AssetType::where('id', $id)->get();
	else
		return \App\Models\AssetType::all();
}

/**
 * @param  [type]
 * @param  [type]
 * @param  [type]
 * @return [type]
 */
function get_cuti_user($cuti_id, $user_id, $field)
{
	$cuti = \App\Models\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	$jenis_cuti = \App\Models\Cuti::where('id', $cuti_id)->first();
	if($cuti){
		if(isset($cuti->$field))
		{
			return $cuti->$field;
		}
	}
	else
		return $jenis_cuti->kuota;

}

/**
 * @return [type]
 */
function cek_cuti_direktur($status='approved')
{
	if($status=='approved')
	{
		$cuti = \App\Models\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur', 1)->count();		
	}
	elseif($status == 'null')
	{
		//$cuti = \App\Models\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();	
		$cuti = \App\Models\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('status' ,'<' ,3)->where('is_approved_atasan',1)->whereNull('approve_direktur')->count();	
	}

	return $cuti;
}


/**
 * @param  string
 * @param  integer 
 * @return [type]
 */
function cek_cuti_atasan($status='approved')
{
	if($status =='null')
	{
		//return \App\Models\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
		return \App\Models\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('is_approved_atasan')->count();
	}
	elseif($status =='approved')
	{
		return \App\Models\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
	}
	elseif($status=='reject')
	{
		return \App\Models\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
	}
	elseif($status=='all')
	{
		return \App\Models\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->count();
	}
}