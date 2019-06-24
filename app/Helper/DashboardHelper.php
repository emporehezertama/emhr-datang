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
function employee_get_resigness($month)
{
	$user  = \App\User::whereYear('resign_date', date('Y'))->whereMonth('resign_date', $month)->where('access_id', 2)->count();

	return $user;
}

/**
 * get Employee Resigness
 */
function employee_get_joinees($month)
{
	$user  = \App\User::whereYear('join_date', date('Y'))->whereMonth('join_date', $month)->where('access_id', 2)->count();

	return $user;
}

/**
 * Exist this month
 * @return number
 */
function employee_exit_this_month()
{
	return '0';
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
        $employee = \App\User::where('access_id', 2)->where('users.project_id', $user->project_id);
    }else{
        $employee = \App\User::where('access_id', 2);
    }

	if($status== 'all')
	{
		$employee = $employee->count();
	}

	if($status== 'active')
	{
		$employee = $employee->where('status', 1)->count();
	}

	if($status== 'on-leave')
	{
		if($user->project_id != NULL)
	    {
	        $employee = \App\Models\CutiKaryawan::where('cuti_karyawan.status', 2)->whereDate('cuti_karyawan.tanggal_cuti_start','<=', $today)->whereDate('cuti_karyawan.tanggal_cuti_end','>=', $today)->join('users','users.id','=','cuti_karyawan.user_id')->where('users.project_id', $user->project_id)->select('cuti_karyawan.*')->count();
	    }else{
	        $employee = \App\Models\CutiKaryawan::where('status', 2)->whereDate('tanggal_cuti_start','<=', $today)->whereDate('tanggal_cuti_end','>=', $today)->count();
	    }
	}

	if($status== 'on-tour')
	{
		$employee = \App\Models\Training::where('status', 2)->whereDate('tanggal_kegiatan_start','<=', $today)->whereDate('tanggal_kegiatan_end','>=', $today)->count();
	}

	if($status == 'permanent')
	{
		$employee =0;
	}

	if($status == 'contract')
	{
		$employee =0;
	}

	if($status == 'late-comers')
	{
		$employee = \App\Models\AbsensiItem::where('late', 1)->whereDate('date','=', $today)->count();;
	}

	return $employee;
}