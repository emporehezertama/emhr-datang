<?php
function getPlafondTraining($lokasi_kegiatan,$tempat_tujuan)
{
	//lokasi_kegiatan //Dalam Negeri atau Luar Negeri
	//tempat_tujuan kemudia dia di cek kabupaten dan dapatkan ke provinsi
	$position = \Auth::user()->structure->position->id;
	$plafond = \App\Models\Kabupaten::select('provinsi.type')->where('kabupaten.nama',$tempat_tujuan)->join('provinsi','provinsi.id_prov','=','kabupaten.id_prov')->first();

	//dd($plafond);

	if($lokasi_kegiatan == 'Dalam Negeri'){
		if($plafond == null)
		{
			$data = new \App\Models\PlafondDinas();
			$data->tunjangan_makanan = 0;
			$data->tunjangan_harian = 0;
		}else{
			if($plafond->type == null)
			{
				$data = new \App\Models\PlafondDinas();
				$data->tunjangan_makanan = 0;
				$data->tunjangan_harian = 0;
			} else{
				$data = \App\Models\PlafondDinas::where('organisasi_position_id',$position)->where('plafond_type',$plafond->type)->first();
			}
		}
	}elseif ($lokasi_kegiatan == 'Luar Negeri') {
		# code...
		$data = \App\Models\PlafondDinasLuarNegeri::where('organisasi_position_id',$position)->first();
	}
	//dd($lokasi_kegiatan,$tempat_tujuan,$plafond,$data);
	//return 'aaa';
	return $data;

}
function cek_create_exit_interview($user_id)
{
	$cek = \App\Models\ExitInterview::where('user_id', $user_id)->where('status','<',3)->count();

	if($cek == 0)
	{
		return true;
	}	
	else
	{
		return false;
	}
}

/**
 * [cek_count_exit_admin description]
 * @return [type] [description]
 */
function cek_count_training_admin()
{
	$total = \App\Models\Training::where('status', 1)->orWhere('status_actual_bill', 2)->count();

	return $total;
}

/**
 * [cek_count_exit_admin description]
 * @return [type] [description]
 */
function cek_count_exit_admin()
{
	$total = \App\Models\ExitInterview::where('status', 1)->count();

	return $total;
}

/**
 * [hari_libur description]
 * @return [type] [description]
 */
function hari_libur()
{
	return \App\Models\LiburNasional::get();
}

/**
 * [cek_count_cuti_admin description]
 * @return [type] [description]
 */
function cek_count_cuti_admin()
{
	$total = \App\Models\CutiKaryawan::where('status', 1)->count();

	return $total;
}

/**
 * [total_payment_request description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function sum_payment_request_price($id)
{
	$payment = \App\Models\PaymentRequestForm::where('payment_request_id', $id)->get();
	$total  = 0 ;

	foreach($payment as $i)
	{
		$total += !empty($i->amount) ? $i->amount : $i->estimation_cost;
	}	

	return $total;
}

/**
 * [get_kuota_cuti description]
 * @param  [type] $cuti_id [description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function get_cuti_terpakai($cuti_id, $user_id)
{
	$cuti = \App\Models\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti)
		return $cuti->cuti_terpakai;
	else
		return 0;
} 

/**
 * [get_cuti_terpakai description]
 * @param  [type] $cuti_id [description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function get_kuota_cuti($cuti_id, $user_id)
{ 
	$cuti = \App\Models\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti)
		return $cuti->kuota;
	else
	{
		$cuti = \App\Models\Cuti::where('id', $cuti_id)->first();

		return $cuti->kuota;
	}
}

/**
 * [plafond_perjalanan_dinas description]
 * @return [type] [description]
 */
function plafond_perjalanan_dinas($name, $jenis = 'domestik')
{
	if($jenis=='domestik')
	{
		return \App\Models\PlafondDinas::where('organisasi_position_text', 'LIKE', '%'. strtoupper($name) .'%')->first();
	}
	else
	{
		return \App\Models\PlafondDinasLuarNegeri::where('organisasi_position_text', 'LIKE', '%'. strtoupper($name) .'%')->first();
	}
}

/**
 * [get_backup_cuti description]
 * @return [type] [description]
 */
function get_backup_cuti()
{
	$user = \Auth::user();
	if($user->project_id != NULL)
    {
    	if($user->branch_type == 'BRANCH')
		{
			$karyawan = \App\User::where('cabang_id', $user->cabang_id)->where('id', '<>', $user->id)->where('project_id',$user->project_id)->whereNull('resign_date');
		}
		else
		{
			$karyawan = \App\User::where('division_id', $user->division_id)->where('id', '<>', $user->id)->where('project_id',$user->project_id)->whereNull('resign_date');
		}
    }else{
    	if($user->branch_type == 'BRANCH')
		{
			$karyawan = \App\User::where('cabang_id', $user->cabang_id)->where('id', '<>', $user->id)->whereNull('resign_date');
		}
		else
		{
			$karyawan = \App\User::where('division_id', $user->division_id)->where('id', '<>', $user->id)->whereNull('resign_date');
		}
    }
		$karyawan = $karyawan->where('id', '<>', $user->id)->whereIn('access_id', [1,2])->whereNull('resign_date')->get();

	return $karyawan;
}

/**
 * [list_user_cuti description]
 * @return [type] [description]
 */
function list_user_cuti()
{
	$user = \Auth::user();
    if($user->project_id != NULL)
    {
    	return \App\Models\Cuti::orderBy('cuti.jenis_cuti','ASC')->join('users', 'users.id','=', 'cuti.user_created')->where('users.project_id', $user->project_id)->select('cuti.*')->get();
    }else{
    	return \App\Models\Cuti::orderBy('jenis_cuti','ASC')->get();
    }
	
}

/**
 * [jenis_perjalanan_dinas description]
 * @return [type] [description]
 */
function jenis_perjalanan_dinas()
{
	return ['Training', 'Management Meeting','Hearing Meeting','Regional/Division Meeting','Assessment','Branch Visit', 'Others'];
}

/**
 * [cek_training_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_training_approval_user($user_id)
{
	$count =  \App\Models\Training::where('approved_atasan_id', $user_id)->count();

	return $count;
}

/**
 * [cek_training_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function count_training_approval_atasan($user_id)
{
	$count =  \App\Models\Training::where('approved_atasan_id', $user_id)->where('is_approved_atasan', 0)->count();
	$count +=  \App\Models\Training::where('approved_atasan_id', $user_id)->where('status_actual_bill', 2)->where('is_approve_atasan_actual_bill', 0)->count();

	return $count;
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_exit_approval_user($user_id)
{
	return \App\Models\ExitInterview::where('approved_atasan_id', $user_id)->count();
}


/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function count_exit_approval_user($user_id)
{
	return \App\Models\ExitInterview::where('approved_atasan_id', $user_id)->where('is_approved_atasan', '<>', 1)->count();
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_medical_approval_user($user_id)
{
	return \App\Models\MedicalReimbursement::where('approved_atasan_id', $user_id)->count();
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_cuti_approval_user($user_id)
{
	return \App\Models\CutiKaryawan::where('approved_atasan_id', $user_id)->count();
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_overtime_approval_user_count($user_id)
{
	$data =  \App\Models\OvertimeSheet::where('approved_atasan_id', $user_id)->get();
	$count = 0;
	foreach($data as $i)
	{	
		if($i->is_approved_atasan == "") 
		{
			$count++;
		}
	}
	
	return $count;
}

/**
 * [cek_overtime_approval_user_count description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_overtime_approval_user_2()
{
    $approval = \App\Models\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();
    $data = \App\Models\OvertimeSheet::orderBy('id', 'DESC')->get();

    $count = 0;
    foreach($data as $item)
    {
    	if($approval)
    	{
	    	if($approval->nama_approval == 'Manager HR')
	    	{
			    if($item->is_hr_manager == null)
			    {
					$count++;
			    }
			}

			if($approval->nama_approval == 'HR Operation')
			{
			    if($item->is_hr_benefit_approved == "")
		    	{
		    		$count++;
		    	}
		    }
		}
    }

    return $count;
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_overtime_approval_user($user_id)
{
	return \App\Models\OvertimeSheet::where('approved_atasan_id', $user_id)->count();
}

/**
 * [get_atasan description]
 * @return [type] [description]
 */
function get_atasan_langsung()
{
	// cek sebagai branch / tidak
	$user = \Auth::user();
	$karyawan = [];

	if($user->branch_type == 'BRANCH')
	{
		if(isset($user->organisasiposition->name))
		{
			if($user->organisasiposition->name == 'Staff')
			{
				$res = \App\User::where('department_id', $user->department_id)
								->join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Head')
										->orWhere('organisasi_position.name', 'Branch Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}

				if($no==0)
				{
					$res = \App\User::join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Head')
										->orWhere('organisasi_position.name', 'Branch Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
					$karyawan = new stdClass;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item;
					}
				}
			}
			// jika sabagai Head
			if($user->organisasiposition->name  == 'Head')
			{
				$karyawan = \App\User::join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where('organisasi_position.name', 'Branch Manager')
								->select('users.nik', 'users.id', 'users.name','organisasi_position.name as job_rule')
								->get();
			}
			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'Branch Manager')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Area Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
			}

			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'Head' and $user->organisasi_job_role == 'Manager Outlet')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Area Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
			}

			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'General Manager')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get()
								;
			}
		}
	}
	else
	{
		if(isset($user->organisasiposition->name))
		{
			if($user->organisasiposition->name == 'Staff')
			{
				// mencari di department
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Supervisor')
											->orWhere('organisasi_position.name', 'Manager')
											->orWhere('organisasi_position.name', 'Senior Manager');
								})
								->where('users.department_id', $user->department_id)
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}

				if($no == 0)
				{
					// mencari di division
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Supervisor')
											->orWhere('organisasi_position.name', 'Manager')
											->orWhere('organisasi_position.name', 'Senior Manager');
								})
								->where('users.division_id', $user->division_id)
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

					$karyawan = new stdClass; $no=0;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item; $no++;
					}
				}

				// mencari bukan berdasarkan divisi atau department
				if($no == 0)
				{
					// mencari di division
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where('organisasi_position.name', '<>', 'Staff')
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

					$karyawan = new stdClass; $no=0;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item; $no++;
					}

				}
			}

			// Supervisor / Head
			if($user->organisasiposition->name == 'Supervisor' || $user->organisasiposition->name == 'Head')
			{
				// mencari di division
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
							->where('users.id', '<>', $user->id)
							->where(function($query){
								$query->orWhere('organisasi_position.name', 'Manager')
										->orWhere('organisasi_position.name', 'Senior Manager');
							})
							->where('users.division_id', $user->division_id)
							->select('users.*', 'organisasi_position.name as job_rule')
							->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}
			}

			// Jika manager
			if($user->organisasiposition->name == 'Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
							->where('users.id', '<>', $user->id)
							->where(function($query){
								$query->orWhere('organisasi_position.name', 'Director')
										->orWhere('organisasi_position.name', 'Expatriat')
										->orWhere('organisasi_position.name', 'General Manager')
										->orWhere('organisasi_position.name', 'Senior Manager')
										;
							})
							->select('users.*', 'organisasi_position.name as job_rule')
							->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}
			}

			// Manager, Sales Manager, Area Manager
			if($user->organisasiposition->name == 'Area Manager' || $user->organisasiposition->name == 'Sales Manager' )
			{
				
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where('users.department_id', $user->department_id)
								->where('organisasi_position.name', 'Senior Manager')
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
								
				$karyawan = new stdClass;$no=0;
				foreach($res as $k => $item)
				{
					$no++;
					$karyawan->$k = $item;
				}

				if($no ==0)
				{
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
									->where('users.id', '<>', $user->id)
									->where('users.division_id', $user->division_id)
									->where(function($query){
											$query->orWhere('organisasi_position.name', 'General Manager')
													->orWhere('organisasi_position.name', 'Senior Manager');
										})
									->select('users.*', 'organisasi_position.name as job_rule')
									->get();
									
					$karyawan = new stdClass;$no=0;
					foreach($res as $k => $item)
					{
						$no++;
						$karyawan->$k = $item;
					}
				}
			}

			// General Manager / Senior Manager
			if($user->organisasiposition->name =='Senior Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where(function($query){
									$query->orWhere('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;

				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}
			}

			// General Manager / Senior Manager
			if($user->organisasiposition->name == 'General Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where(function($query){
									$query->orWhere('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;

				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}
			}
		}
	}

	return $karyawan;
}

/**
 * [tree_organisasi description]
 * @return [type] [description]
 */
function tree_atasan_organisasi()
{
	return ['Head', 'Supervisor','Manager', 'Branch Manager', 'Senior Advisor', 'Senior Manager', 'General Manager', 'Director'];
}


/**
 * [get_organisasi_position_group description]
 * @return [type] [description]
 */
function get_organisasi_position_group()
{
	return \App\Models\OrganisasiPosition::groupBy('name')->get();
}

/**
 * [get_organisasi_position description]
 * @param  string $unit_id [description]
 * @return [type]          [description]
 */
function get_organisasi_position($unit_id = "")
{
	if($unit_id != "")
		return \App\Models\OrganisasiPosition::where('organisasi_unit_id', $unit_id)->get();
	else
		return \App\Models\OrganisasiPosition::all();

}
/**
 * [get_organisasi_unit description]
 * @param  string $department_id [description]
 * @return [type]                [description]
 */
function get_organisasi_unit($department_id = "")
{
	if(!empty($department_id))
		return \App\Models\OrganisasiUnit::where('organisasi_department_id', $department_id)->get();
	else
		return \App\Models\OrganisasiUnit::all();
}

/**
 * [get_organisasi_division description]
 * @return [type] [description]
 */
function get_organisasi_department($division_id = 0)
{
	if(!empty($division_id))
		return \App\Models\OrganisasiDepartment::orderBy('name', 'ASC')->get();
	else
		return \App\Models\OrganisasiDepartment::where('organisasi_division_id', $division_id)->orderBy('name', 'ASC')->get();
}

/**
 * [get_organisasi_division description]
 * @return [type] [description]
 */
function get_organisasi_division()
{
	return \App\Models\OrganisasiDivision::orderBy('name', 'ASC')->get();
}

/**
 * [list_hari_libur description]
 * @return [type] [description]
 */
function list_hari_libur()
{
	return \App\Models\LiburNasional::all();
}

/**
 * [get_head_branch description]
 * @return [type] [description]
 */
function get_head_branch()
{
	return \App\Models\BranchHead::all();
}

/**
 * [get_head_branch description]
 * @return [type] [description]
 */
function get_staff_branch()
{
	return \App\Models\BranchStaff::all();
}

/**
 * [cek_approval description]
 * @param  [type] $table [description]
 * @return [type]        [description]
 */
function cek_approval($table)
{
	$cek = DB::table($table)->where('status', 1)->where('user_id', \Auth::user()->id)->count();

	if($cek >= 1)
		return false;
	else
		return true;
}

/**
 * [get_master_cuti description]
 * @return [type] [description]
 */
function get_master_cuti()
{
	return \App\Models\Cuti::all();
}

/**
 * [position_karyawan description]
 * @return [type] [description]
 */
function position_structure()
{
	return ['Staff', 'SPV', 'Head', 'General Manager', 'Manager'];
}

if (! function_exists('d')) {
    /**
     * Dump the passed variables.
     *
     * @param  mixed
     * @return void
     */
    function d($var)
    {
		return yii\helpers\VarDumper::dump($var);
    }
}

/**
 * [total_training description]
 * @return [type] [description]
 */
function total_training()
{
	return \App\Models\Training::join('users', 'users.id', '=', 'training.user_id')->count();
}

/**
 * [total_exit_interview description]
 * @return [type] [description]
 */
function total_exit_interview()
{
	return \App\Models\ExitInterview::join('users', 'users.id', '=', 'exit_interview.user_id')->count();
}

/**
 * [total_overtime description]
 * @return [type] [description]
 */
function total_overtime()
{
	return \App\Models\OvertimeSheet::join('users', 'users.id', '=', 'overtime_sheet.user_id')->count();
}

/**
 * [total_medical description]
 * @return [type] [description]
 */
function total_medical()
{
	return \App\Models\MedicalReimbursement::join('users', 'users.id', '=', 'medical_reimbursement.user_id')->count();
}

/**
 * [total_payment_request description]
 * @return [type] [description]
 */
function total_payment_request()
{
	return \App\Models\PaymentRequest::join('users', 'users.id', '=', 'payment_request.user_id')->count();
}

/**
 * [total_karyawan description]
 * @return [type] [description]
 */
function total_karyawan()
{
	$user = \Auth::user();
	if($user->project_id != Null){
		return \App\User::whereIn('access_id', ['1', '2'])
						->whereNull('status')
						->where('project_id', \Auth::user()->project_id)
						->count();
	}else{
		return \App\User::whereIn('access_id', ['1', '2'])
						->whereNull('status')
						->count();
	}
	
}

/**
 * [total_cuti_karyawan description]
 * @return [type] [description]
 */
function total_cuti_karyawan()
{
	return \App\Models\CutiKaryawan::join('users', 'users.id', '=', 'cuti_karyawan.user_id')->count();
}

/**
 * [list_cuti_user description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function list_cuti_user($id)
{
	return \App\Models\CutiKaryawan::where('user_id', $id)->get();
}

/**
 * [data_overtime_user description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function data_overtime_user($id)
{
	$total = \App\Models\OvertimeSheet::where('user_id', $id)->where('status', 2)->count();
	
	if($total == 0)
		return false;
	else
		return \App\Models\OvertimeSheet::where('user_id', $id)->where('status', 2)->get();
}

/**
 * [get_airports description]
 * @return [type] [description]
 */
function get_airports()
{
	return \App\Models\Airports::orderBy('code', 'ASC')->get();
}

/**
 * [cek_status_approval_user description]
 * @param  [type] $id         [description]
 * @param  [type] $jenis_form [description]
 * @param  [type] $foreign_id [description]
 * @return [type]             [description]
 */
function cek_status_approval_user($user_id, $jenis_form, $foreign_id)
{
	// cek approval
	$approval = \App\Models\StatusApproval::where('approval_user_id', $user_id)->where('jenis_form', $jenis_form)->where('foreign_id', $foreign_id)->first();

	if($approval)
		return true;
	else
		return false;
}

/**
 * [cek_approval_user description]
 * @return [type] [description]
 */
function cek_approval_user()
{
	$user = \Auth::user();

	// cek approval
	$approval = \App\Models\SettingApproval::where('user_id', $user->id)->first();

	if($approval)
		return true;
	else
		return false;
}

/**
 * [cek_approval_user description]
 * @return [type] [description]
 */
function list_approval_user()
{
	$user = \Auth::user();

	// cek approval
	$approval = \App\Models\SettingApproval::where('user_id', $user->id)->groupBy('jenis_form')->get();

	$list = [];
	foreach($approval as $k => $item)
	{
		$list[$k]['name'] = $item->nama_approval;
		$list[$k]['link'] = $item->jenis_form;

		switch($item->jenis_form)
		{
			case 'cuti':
				$list[$k]['nama_menu'] = 'Leave / Permit Employee (Assign HRD)';
			break;
			case 'payment_request':
				$list[$k]['nama_menu'] = 'Payment Request';
			break;
			case 'medical':
				$list[$k]['nama_menu'] = 'Medical Reimbursement';
			break;
			case 'exit_clearance':
				$list[$k]['nama_menu'] = 'Exit Interview & Clearance';
			break;
			case 'exit':
				$list[$k]['nama_menu'] = 'Exit Interview & Clearance';
			break;
			case 'training':
				$list[$k]['nama_menu'] = 'Training & Perjalanan Dinas';
			break;
			case 'overtime':
				$list[$k]['nama_menu'] = 'Overtime Sheet';
			break;
			default:
				$list[$k]['nama_menu'] = '';
			break;
		}
	}	

	return $list;
}

/**
 * [get_karyawan description]
 * @return [type] [description]
 */
function get_karyawan()
{
	return \App\User::whereIn('access_id', [1,2])->get();
}

/**
 * [list_exit_clearance_accounting_finance_note description]
 * @return [type] [description]
 */
function list_exit_clearance_accounting_finance_note()
{	
	$list[0]['item'] = 'Employee Loan';
	$list[1]['item'] = 'Advance Payment';
	$list[2]['item'] = 'Early Term COP';

	return $list;
}

/**
 * [list_exit_clearance_inventory_to_it description]
 * @return [type] [description]
 */
function list_exit_clearance_inventory_to_it()
{
	$list[0]['item'] = 'Laptop/PC & Other IT Device';
	$list[1]['item'] = 'Password PC/Laptop';
	$list[2]['item'] = 'Email Address';
	$list[3]['item'] = 'Arium';

	return $list;
}
/**
 * [list_exit_clearance_inventory_to_ga description]
 * @return [type] [description]
 */
function list_exit_clearance_inventory_to_ga()
{
	$list[0]['item'] = 'Parking Card';
	$list[1]['item'] = 'Vehicle Operasional';
	$list[2]['item'] = 'Vehicle Registration Number Letter / STNK';
	$list[3]['item'] = 'Drawer Lock';
	$list[4]['item'] = 'Camera';
	$list[5]['item'] = 'Handphone';

	return $list;
}

/**
 * [list_exit_clearance_inventory_to_hrd description]
 * @return [type] [description]
 */
function list_exit_clearance_inventory_to_hrd()
{
	$list[0]['item'] = 'ID Card';
	$list[1]['item'] = 'Business  Card';
	$list[2]['item'] = 'Stamp';
	$list[3]['item'] = 'Company Regulation Book';
	$list[4]['item'] = 'Uniform';
	
	return $list;
}

/**
 * [list_exit_clearance_document description]
 * @return [type] [description]
 */
function list_exit_clearance_document()
{
	$list[0]['item'] 	= 'Exit Interview';
	$list[0]['form_no'] 	= 'HR/P 14';

	$list[1]['item'] 	= 'Resignation Form';
	$list[1]['form_no'] 	= '';

	return $list;
}

/**
 * [status_exit_interview description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_exit_interview($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		default:
			break;
	}

	return $html;
}

/**
 * [get_reason_interview description]
 * @return [type] [description]
 */
function get_reason_interview()
{
	return \App\Models\ExitInterviewReason::all();
}

/**
 * [get_bank description]
 * @return [type] [description]
 */
function get_bank()
{
	return \App\Models\Bank::all();
}

/**
 * [get_lembur_detail description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function get_lembur_detail($id)
{
	$data = \App\Models\OvertimeSheetForm::where('overtime_sheet_id', $id)->get();

	return $data;
}

/**
 * [status_overtime description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_overtime($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		
		default:
			break;
	}

	return $html;
}

/**
 * [get_department_name description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function get_department_name($id)
{
	$data = \App\Models\Department::where('id', $id)->first();

	if($data)
		return $data->name;
	else
		return '';
}

/**
 * [get_kabupten description]
 * @param  integer $id_prov [description]
 * @return [type]           [description]
 */
function get_kabupaten($id_prov = 0)
{
	if($id_prov == 0)
	{
		$data = \App\Models\Kabupaten::all();
	}
	else
	{
		$data = \App\Models\Kabupaten::where('id_prov', $id_prov)->get();
	}

	return $data;
}

/**
 * [get_provinsi description]
 * @return [type] [description]
 */
function get_provinsi()
{
	return \App\Models\Provinsi::orderBy('nama', 'ASC')->get();;
}

/**
 * [get_sekolah description]
 * @return [type] [description]
 */
function get_sekolah()
{
	return \App\Models\Sekolah::orderBy('name', 'ASC')->get();
}

/**
 * [get_cabang description]
 * @return [type] [description]
 */
function get_cabang()
{
	return \App\Models\Cabang::orderBy('name', 'ASC')->get();
}

/**
 * [get_program_studi description]
 * @return [type] [description]
 */
function get_program_studi()
{
	return \App\Models\ProgramStudi::orderBy('name', 'ASC')->get();
}

/**
 * [get_universitas description]
 * @return [type] [description]
 */
function get_jurusan()
{
	return \App\Models\Jurusan::orderBy('name', 'ASC')->get();
}

/**
 * [get_universitas description]
 * @return [type] [description]
 */
function get_universitas()
{
	return \App\Models\Universitas::orderBy('name', 'ASC')->get();
}

/**
 * [status_medical description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_medical($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		default:
			break;
	}

	return $html;
}

/**
 * [status_payment_request description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_payment_request($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		default:
			break;
	}

	return $html;
}

/**
 * [lama_hari description]
 * @param  [type] $start [description]
 * @param  [type] $end   [description]
 * @return [type]        [description]
 */
function lama_hari($start, $end)
{

	$start_date = new DateTime($start);
	$end_date = new DateTime($end);
	$interval = $start_date->diff($end_date);
		
	// jika hari sama maka dihitung 1 hari
	if($start_date == $end_date)  return "1";

	$hari = $interval->days + 1;

	return "$hari "; // hasil : 217 hari

}

/**
 * [status_cuti description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_cuti($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		default:
			break;
	}

	return $html;
}


/**
 * [get_department_by_section_id description]
 * @param  [type] $department_id [description]
 * @param  string $type          [description]
 * @return [type]                [description]
 */
function get_section_by_department_id($department_id, $type='array')
{
	if($type == 'array')
		$data = \App\Models\Section::where('department_id', $department_id)->get();
	else
		$data = \App\Models\Section::where('department_id', $department_id)->first();
	
	return $data;	
}

/**
 * [get_department_by_division_id description]
 * @param  [type] $division_id [description]
 * @return [type]              [description]
 */
function get_department_by_division_id($division_id, $type='array')
{
	if($type == 'array')
		$data = \App\Models\Department::where('division_id', $division_id)->get();
	else
		$data = \App\Models\Department::where('division_id', $division_id)->first();
	
	return $data;	
}
/**
 * [get_division_by_directorate_id description]
 * @param  [type] $directorate_id [description]
 * @return [type]                 [description]
 */
function get_division_by_directorate_id($directorate_id, $type = 'array')
{
	if($type == 'array')
		$data = \App\Models\Division::where('directorate_id', $directorate_id)->get();
	else
		$data = \App\Models\Division::where('directorate_id', $directorate_id)->first();
	
	return $data;		
}

/**
 * [agama description]
 * @return [type] [description]
 */
function agama()
{
	return ['Muslim', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
}
?>