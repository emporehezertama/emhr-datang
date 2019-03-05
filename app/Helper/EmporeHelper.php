<?php

/**
 * [status_asset description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function status_asset($key=NULL)
{
	$arr = [1 => 'Accepted', 2 => 'Office Inventory'];
	if($key === NULL)
	{
		return "Waiting Acceptance";
	}
	else
	{
		return @$arr[$key];
	}
}

/**
 * [empore_select_direktur description]
 * @return [type] [description]
 */
function empore_list_direktur()
{
	return \App\Models\EmporeOrganisasiDirektur::all();
}
	
/**
 * [get_atasan description]
 * @return [type] [description]
 */
function empore_get_atasan_langsung()
{
	$user = \Auth::user();	

	$karyawan = [];

	if(!empty($user->empore_organisasi_staff_id))
	{
		$data = \App\User::where('empore_organisasi_manager_id', $user->empore_organisasi_manager_id)->get();

		$karyawan = new stdClass;
		foreach($data as $k => $i)
		{	
			if(empty($i->empore_organisasi_staff_id))
			{
				$karyawan->$k = $i;
			}
		}
	}

	if(empty($user->empore_organisasi_staff_id) and !empty($user->empore_organisasi_manager_id))
	{
		$data = \App\User::where('empore_organisasi_direktur', $user->empore_organisasi_direktur)->get();

		$karyawan = new stdClass;
		foreach($data as $k => $i)
		{	
			if(empty($i->empore_organisasi_manager_id))
			{
				$karyawan->$k = $i;
			}
		}
	}

	return $karyawan;
}

/**
 * [get_direktur description]
 * @return [type] [description]
 */
function get_direktur($id)
{ 
	$user = \App\User::where('id', $id)->first();

	$data = \App\User::where('empore_organisasi_direktur', $user->empore_organisasi_direktur)->whereNull('empore_organisasi_manager_id')->whereNull('empore_organisasi_staff_id')->first();

	return $data;
}

/**
 * [empore_jabatan description]
 * @param  [type] $id [description]
 * @return [type]     [descrip=ion]
 */
function empore_jabatan($id)
{
	$user = \App\User::where('id', $id)->first();

	if($user)
	{
		if(!empty($user->empore_organisasi_staff_id)):
            return 'Staff - '.$user->empore_staff->name;
        endif;

        if(empty($user->empore_organisasi_staff_id) and !empty($user->empore_organisasi_manager_id)):
            return 'Manager - '.$user->empore_manager->name;
        endif;

        if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_manager_id) and !empty($user->empore_organisasi_direktur)):
            return 'Direktur ';
        endif;
	}

	return;
}

/**
 * [empore_is_direktur description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function empore_is_direktur($id)
{
	$user = \App\User::where('id', $id)->first();

	if($user)
	{	
		if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_manager_id) and !empty($user->empore_organisasi_direktur))
		{
			return true;
		} 
	}

	return;
}


