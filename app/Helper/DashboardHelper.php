<?php
/**
 * get Employee Rate
 */
function employee_rate($month)
{
	$period = 0;
	if($month == 1)
	{
		#$period  = \App\User::whereYear('date', date('Y'))->whereMonth('resign_date', $month)->where('access_id', 2)->count();
	}
	else
	{

	}

	return $period;
}

/**
 * get Employee Resigness
 */
function employee_get_resigness($StartDate, $StopDate, $currentMonth)
{
	$year = substr($currentMonth, 0, 4);
	$month = substr($currentMonth, 5, 7);
	$user  = \App\User::whereBetween('resign_date', array($StartDate, $StopDate))
						->whereMonth('resign_date', $month)
						->whereYear('resign_date', $year)
						->whereIn('access_id', [1,2])
						->where('project_id', \Auth::user()->project_id)
						->count();
	return $user;
}

/**
 * get Employee Resigness
 */
function employee_get_joinees($StartDate, $StopDate, $currentMonth)
{
	$year = substr($currentMonth, 0, 4);
	$month = substr($currentMonth, 5, 7);

	if(\Auth::user()->project_id != Null){
		$user  = \App\User::whereBetween('join_date', array($StartDate, $StopDate))
						->whereMonth('join_date', $month)
						->whereYear('join_date', $year)
						->whereIn('access_id', ['1', '2'])

						->where('project_id', \Auth::user()->project_id)
						->count();
	}else{
		$user  = \App\User::whereBetween('join_date', array($StartDate, $StopDate))
						->whereMonth('join_date', $month)
						->whereYear('join_date', $year)
						->whereIn('access_id', ['1', '2'])
						->count();
	}
	
	return $user;
}

/**
 * Exist this month
 * @return number
 */
function employee_exit_this_month()
{
	if(\Auth::user()->project_id != Null){
		$user  = \App\User::whereYear('resign_date', date('Y'))
						->whereMonth('resign_date', date('m'))
						->whereIn('access_id', ['1', '2'])
						->where('project_id', \Auth::user()->project_id)
						->count();
	}else{
		$user  = \App\User::whereYear('resign_date', date('Y'))
						->whereMonth('resign_date', date('m'))
						->whereIn('access_id', ['1', '2'])
						->count();
	}
	
	
	return $user;
}

/**
 * Status Employee
 * @return integer
 */
function employee($status='all')
{
	$today = date('Y-m-d');

	$user = \Auth::user(); 
    if($user->project_id != NULL)
    {
        $employee = \App\User::whereIn('access_id', [1,2])->where('users.project_id', $user->project_id);
    }else{
        $employee = \App\User::whereIn('access_id', [1,2]);
    }

	if($status== 'all')
	{
		$employee = $employee->count();
	}

	if($status== 'active')
	{
	//	$employee = \App\Models\AbsensiItem::whereDate('date','=', $today)->count();
		$employee = DB::table('absensi_item')
						->join('users', 'absensi_item.user_id','=', 'users.id')
						->where('users.project_id', \Auth::user()->project_id)
						->whereDate('absensi_item.date','=', $today)
						->count();

	}

	if($status== 'on-leave')
	{
		if($user->project_id != NULL)
	    {
			$employee = \App\Models\CutiKaryawan::where('cuti_karyawan.status', 2)
												->whereDate('cuti_karyawan.tanggal_cuti_start','<=', $today)
												->whereDate('cuti_karyawan.tanggal_cuti_end','>=', $today)
												->join('users','users.id','=','cuti_karyawan.user_id')
												->where('users.project_id', $user->project_id)
												->select('cuti_karyawan.*')->count();
	    }else{
			$employee = \App\Models\CutiKaryawan::where('status', 2)
												->whereDate('tanggal_cuti_start','<=', $today)
												->whereDate('tanggal_cuti_end','>=', $today)->count();
	    }
	}

	if($status== 'on-tour')
	{
	/*	$employee = \App\Models\Training::where('status', 2)
										->whereDate('tanggal_kegiatan_start','<=', $today)
										->whereDate('tanggal_kegiatan_end','>=', $today)->count();	*/

		$employee = DB::table('training')
						->join('users', 'users.id', '=', 'training.user_id')
						->where('users.project_id', \Auth::user()->project_id)
						->where('training.status', 2)
						->whereDate('training.tanggal_kegiatan_start','<=', $today)
						->whereDate('training.tanggal_kegiatan_end','>=', $today)
						->count();
	}

	if($status == 'permanent')
	{
		$employee = $employee->where('organisasi_status', 'Permanent')->count();
	}

	if($status == 'contract')
	{
		$employee = $employee->where('organisasi_status', 'Contract')->count();
	}

	if($status == 'late-comers')
	{
		$employee = \App\Models\AbsensiItem::where('late', 1)->whereDate('date','=', $today)->count();
		$employee = DB::table('absensi_item')
						->join('users', 'absensi_item.user_id','=', 'users.id')
						->where('users.project_id', \Auth::user()->project_id)
						->where('absensi_item.late', 1)
						->whereDate('absensi_item.date','=', $today)
						->count();
	}

	return $employee;
}


function employee_attrition($StartDate, $StopDate, $currentMonth, $nextmonth){
	$year = substr($currentMonth, 0, 4);
	$month = substr($currentMonth, 5, 7);

	$next_month = substr($nextmonth, 5, 7);
	$next_month_year = substr($nextmonth, 0, 4);
	$jumlah_karyawan_resign_perbulan = \App\User::whereBetween('resign_date', array($StartDate, $StopDate))
													->whereMonth('resign_date', $month)
													->whereYear('resign_date', $year)
													->whereIn('access_id', [1,2])
													->where('project_id', \Auth::user()->project_id)
													->count();

	$jumlah_karyawan_sebelum_resign_perbulan = \App\User::whereIn('access_id', [1,2])
														//	->whereBetween('join_date', array($StartDate, $StopDate))
															->whereMonth('join_date', '<',$next_month)
															->whereYear('join_date', $next_month_year)
															->where('project_id', \Auth::user()->project_id)
															->count();

	if($jumlah_karyawan_resign_perbulan == 0){
		$attrition = 0;
	}else{
		$attrition = round(($jumlah_karyawan_resign_perbulan / $jumlah_karyawan_sebelum_resign_perbulan) * 100);
	}

	return $attrition;
}
