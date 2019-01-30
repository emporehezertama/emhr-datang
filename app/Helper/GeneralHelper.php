<?php


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
	$data = \App\MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
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
	$data = \App\MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
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
	$data = \App\Payroll::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->get();

	return $data;
}

/**
 * [pay_slip_tahun_history description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function pay_slip_tahun_history($id)
{
	$data = \App\PayrollHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

function pay_slip_tahun_historyNet($id)
{
	$data = \App\PayrollNetHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

function pay_slip_tahun_historyGross($id)
{
	$data = \App\PayrollGrossHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

/**
 * [asset_type description]
 * @return [type] [description]
 */
function asset_type($id=null)
{
	if($id != null)
		return \App\AssetType::where('id', $id)->get();
	else
		return \App\AssetType::all();
}

/**
 * @param  [type]
 * @param  [type]
 * @param  [type]
 * @return [type]
 */
function get_cuti_user($cuti_id, $user_id, $field)
{
	$cuti = \App\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti){
		if(isset($cuti->$field))
		{
			return $cuti->$field;
		}
	}
	else
		return 0;
}

/**
 * @return [type]
 */
function cek_cuti_direktur($status='approved')
{
	if($status=='approved')
	{
		$cuti = \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur', 1)->count();		
	}
	elseif($status == 'null')
	{
		$cuti = \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();		
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
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
	}
	elseif($status =='approved')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
	}
	elseif($status=='reject')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
	}
	elseif($status=='all')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->count();
	}
}