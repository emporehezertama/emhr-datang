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

	if($user){
		
        $position = \App\Models\StructureOrganizationCustom::
								select('organisasi_position.name as position')
								->join('organisasi_position', 'organisasi_position.id', '=', 'structure_organization_custom.organisasi_position_id')
								->where('structure_organization_custom.id', $user->structure_organization_custom_id)
								->get();

	/*	$division = \App\Models\StructureOrganizationCustom::
								select('organisasi_division.name as division')
								->join('organisasi_division', 'organisasi_division.id', '=', 'structure_organization_custom.organisasi_division_id')
								->where('structure_organization_custom.id', $user->structure_organization_custom_id)
								->get();
		if(count($position) < 1 && count($division) < 1){
			$pos =  "";
		}else{
			if(count($position) > 0 && count($division) < 1){
				$pos =  $position['0']['position'];
			}elseif(count($position) < 1 && count($division) > 0){
				$pos =  $division['0']['division'];
			}else{
				$pos =  $position['0']['position'].' - '.$division['0']['division'];
			}
		}	*/

	//	$pos =  $position['0']['position'];
		if(count($position) < 1){
			$pos =  "";
		}else{
			$pos = $pos =  $position['0']['position'];
		}
		
	}else{
		$pos = "";
	}

	return $pos;
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


