<?php
/**
 * Format IDR
 * @param  snumber
 * @return string
 */
function format_idr($number)
{
	return number_format($number,0,0,'.');
}


function get_plafond_type()
{
	$type = ['Standard', 'Middle', 'High'];
	
	return $type;
}

function overtime_absensi($date,$user_id)
{
	//tanggal dan user_id
	$data = \App\Models\AbsensiItem::where('date',$date)->where('user_id',$user_id)->first();
	return $data;
	
}

function get_level_header()
{
	$data = \App\Models\HistoryApprovalLeave::orderBy('setting_approval_level_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}

function get_payment_header()
{
	$data = \App\Models\HistoryApprovalPaymentRequest::orderBy('setting_approval_level_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}

function get_overtime_header()
{
	$data = \App\Models\HistoryApprovalOvertime::orderBy('setting_approval_level_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}
function get_training_header()
{
	$data = \App\Models\HistoryApprovalTraining::orderBy('setting_approval_level_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}
function get_medical_header()
{
	$data = \App\Models\HistoryApprovalMedical::orderBy('setting_approval_level_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}
function get_exit_header()
{
	$data = \App\Models\HistoryApprovalExit::orderBy('exit_interview_id', 'DESC')->first();

	if($data)
		return $data->setting_approval_level_id;
	else
		return 0;
}

/**
 * cek level up
 */
function getStructureName()
{
	$all = \App\Models\StructureOrganizationCustom::orderBy('organisasi_division_id','ASC')->get();
        $data = [];
        foreach ($all as $key => $item) 
        {
            $data[$key]['id']       = $item->id;
            $data[$key]['name']     = isset($item->position) ? $item->position->name:'';
            $data[$key]['name']     = isset($item->division) ? $data[$key]['name'] .' - '. $item->division->name: $data[$key]['name'];
        }
        return $data;
}
function cek_level_leave_up($id)
{
	$cuti = \App\Models\HistoryApprovalLeave::join('cuti_karyawan','cuti_karyawan.id','=','history_approval_leave.cuti_karyawan_id')->where('cuti_karyawan.id', $id);

	$cek1 = clone $cuti;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return false;

	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $cuti;
		$cek2 = $cek2->where('history_approval_leave.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			return false;
		} 
	}

	return true;
}

/**
 * Delete Item Asset
 * @return void
 */
function delete_asset_item($id)
{
	$asset = \App\Models\Asset::where('id', $id)->first();
	if($asset)
	{
		$asset->delete();
	}

	$history = \App\Models\AssetTracking::where('asset_id', $id)->first();
	if($history)
	{
		$history->delete();
	}

	return;
}


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

function cek_leave_approval()
{
	$cuti = \App\Models\HistoryApprovalLeave::join('cuti_karyawan','cuti_karyawan.id','=','history_approval_leave.cuti_karyawan_id')->orderBy('cuti_karyawan_id', 'DESC');

	$cek1 = clone $cuti;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return [];

	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $cuti;
		$cek2 = $cek2->where('history_approval_leave.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			//return [];
		} 
	}
	return $cuti->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();
}

function count_leave_approval()
{
	$data = cek_leave_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;	
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL)
		{
			if($item->status == 3) continue;
			
            if(cek_level_leave_up($item->cutiKaryawan->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0)
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;
}

//payment request
function cek_payment_request_approval()
{
	$paymentRequest = \App\Models\HistoryApprovalPaymentRequest::join('payment_request','payment_request.id','=','history_approval_payment_request.payment_request_id')->orderBy('payment_request_id', 'DESC');
	$cek1 = clone $paymentRequest;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return [];
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $paymentRequest;
		$cek2 = $cek2->where('history_approval_payment_request.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			//return [];
		} 
	}
	return $paymentRequest->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();
}

function count_payment_request_approval()
{
	$data = cek_payment_request_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;
		
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL)
		{
			if($item->status == 3) continue;
			
            if(cek_level_payment_request_up($item->paymentRequest->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0)
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;
}

function cek_level_payment_request_up($id)
{
	$paymentRequest = \App\Models\HistoryApprovalPaymentRequest::join('payment_request','payment_request.id','=','history_approval_payment_request.payment_request_id')->where('payment_request.id', $id);

	$cek1 = clone $paymentRequest;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	if(!$cek1) return false;
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $paymentRequest;
		$cek2 = $cek2->where('history_approval_payment_request.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			return false;
		} 
	}

	return true;
}

//overtime
function cek_overtime_approval()
{
	//jika statusnya 1
	//jika status claimnya 1
	$all = \App\Models\HistoryApprovalOvertime::join('overtime_sheet','overtime_sheet.id','=','history_approval_overtime.overtime_sheet_id')->orderBy('overtime_sheet_id', 'DESC')->get();
	
	$overtime = \App\Models\HistoryApprovalOvertime::join('overtime_sheet','overtime_sheet.id','=','history_approval_overtime.overtime_sheet_id')->orderBy('overtime_sheet_id', 'DESC');

	foreach ($all as $key => $data) {
		# code...
		if($data->status == 1)
		{
			$cek1 = clone $overtime;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();	
			if(!$cek1) return [];
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $overtime;
				$cek2 = $cek2->where('history_approval_overtime.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
				if($cek2)
				{
					//return [];
				} 
			}
		}elseif($data->status_claim == 1)
		{
			$cek1 = clone $overtime;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();	
			if(!$cek1) return [];
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $overtime;
				$cek2 = $cek2->where('history_approval_overtime.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved_claim')->first();
				if($cek2)
				{
					//return [];
				} 
			}
		}
	}
	
	return $overtime->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();
}

function count_overtime_approval()
{
	$data = cek_overtime_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;
		
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL || $item->is_approved_claim == NULL)
		{
			if($item->status == 3 || $item->status_claim == 3) continue;
			
            if(cek_level_overtime_up($item->overtimeSheet->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0 || $item->is_approved_claim == 0) 
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1 || $item->is_approved_claim == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;
}

function cek_level_overtime_up($id)
{
	$all = \App\Models\HistoryApprovalOvertime::join('overtime_sheet','overtime_sheet.id','=','history_approval_overtime.overtime_sheet_id')->where('overtime_sheet.id', $id)->get();
	
	$overtime = \App\Models\HistoryApprovalOvertime::join('overtime_sheet','overtime_sheet.id','=','history_approval_overtime.overtime_sheet_id')->where('overtime_sheet.id', $id);

	foreach ($all as $key => $data) {
		# code...
		if($data->status == 1)
		{
			$cek1 = clone $overtime;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
			if(!$cek1) return false;
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $overtime;
				$cek2 = $cek2->where('history_approval_overtime.setting_approval_level_id', ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
				if($cek2)
				{
					return false;
				} 
			}
			return true;
		}elseif ($data->status_claim == 1) {
			# code...
			$cek1 = clone $overtime;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
			if(!$cek1) return false;
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $overtime;
				$cek2 = $cek2->where('history_approval_overtime.setting_approval_level_id', ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved_claim')->first();
				if($cek2)
				{
					return false;
				} 
			}
			return true;
		}
	}
}

function cek_training_approval()
{
	/*
	$training = \App\Models\HistoryApprovalTraining::join('training','training.id','=','history_approval_training.training_id')->orderBy('training_id', 'DESC');
	$cek1 = clone $training;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return [];
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $training;
		$cek2 = $cek2->where('history_approval_training.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			//return [];
		} 
	}
	return $training->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();

	*/

	//jika statusnya 1
	//jika status claimnya 1
	$all = \App\Models\HistoryApprovalTraining::join('training','training.id','=','history_approval_training.training_id')->orderBy('training.id', 'DESC')->get();
	
	$training = \App\Models\HistoryApprovalTraining::join('training','training.id','=','history_approval_training.training_id')->orderBy('training.id', 'DESC');

	foreach ($all as $key => $data) {
		# code...
		if($data->status == 1)
		{
			$cek1 = clone $training;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();	
			if(!$cek1) return [];
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $training;
				$cek2 = $cek2->where('history_approval_training.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
				if($cek2)
				{
					//return [];
				} 
			}
		}elseif($data->status_actual_bill == 1)
		{
			$cek1 = clone $training;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();	
			if(!$cek1) return [];
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $training;
				$cek2 = $cek2->where('history_approval_training.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved_claim')->first();
				if($cek2)
				{
					//return [];
				} 
			}
		}
	}
	
	return $training->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();

}

function count_training_approval()
{
	$data = cek_training_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;
		
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL || $item->is_approved_claim == NULL)
		{
			if($item->status == 3 || $item->status_actual_bill == 3) continue;
			
            if(cek_level_training_up($item->training->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0 || $item->is_approved_claim == 0)
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1 || $item->is_approved_claim == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;

}

function cek_level_training_up($id)
{
	$all = \App\Models\HistoryApprovalTraining::join('training','training.id','=','history_approval_training.training_id')->where('training.id', $id)->get();
	
	$training = \App\Models\HistoryApprovalTraining::join('training','training.id','=','history_approval_training.training_id')->where('training.id', $id);

	foreach ($all as $key => $data) {
		# code...
		if($data->status == 1)
		{
			$cek1 = clone $training;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
			if(!$cek1) return false;
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $training;
				$cek2 = $cek2->where('history_approval_training.setting_approval_level_id', ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
				if($cek2)
				{
					return false;
				} 
			}
			return true;
		}elseif ($data->status_actual_bill == 1) {
			# code...
			$cek1 = clone $training;
			$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
			if(!$cek1) return false;
			if($cek1->setting_approval_level_id >=2)
			{
				$cek2 = clone $training;
				$cek2 = $cek2->where('history_approval_training.setting_approval_level_id', ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved_claim')->first();
				if($cek2)
				{
					return false;
				} 
			}
			return true;
		}
	}

}

//medical
function cek_medical_approval()
{
	$medical = \App\Models\HistoryApprovalMedical::join('medical_reimbursement','medical_reimbursement.id','=','history_approval_medical.medical_reimbursement_id')->orderBy('medical_reimbursement_id', 'DESC');

	$cek1 = clone $medical;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return [];
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $medical;
		$cek2 = $cek2->where('history_approval_medical.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			//return [];
		} 
	}
	return $medical->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();
}

function count_medical_approval()
{
	$data = cek_medical_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;
		
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL)
		{
			if($item->status == 3) continue;
			
            if(cek_level_medical_up($item->medicalReimbursement->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0)
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;
}

function cek_level_medical_up($id)
{
	$medical = \App\Models\HistoryApprovalMedical::join('medical_reimbursement','medical_reimbursement.id','=','history_approval_medical.medical_reimbursement_id')->where('medical_reimbursement.id', $id);

	$cek1 = clone $medical;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	if(!$cek1) return false;
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $medical;
		$cek2 = $cek2->where('history_approval_medical.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			return false;
		} 
	}

	return true;
}

//exit interview
function cek_exit_approval()
{
	$exit = \App\Models\HistoryApprovalExit::join('exit_interview','exit_interview.id','=','history_approval_exit.exit_interview_id')->orderBy('exit_interview_id', 'DESC');

	$cek1 = clone $exit;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	
	if(!$cek1) return [];
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $exit;
		$cek2 = $cek2->where('history_approval_exit.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			//return [];
		} 
	}
	return $exit->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->get();
}

function count_exit_approval()
{
	$data = cek_exit_approval();
	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;
		
	if(!$data) return $params;
	foreach($data as $item)	
	{
		if($item->is_approved == NULL)
		{
			if($item->status == 3) continue;
			
            if(cek_level_exit_up($item->exitInterview->id))
            {
                $params['waiting'] = $params['waiting'] + 1; 
            }
        }
        if($item->is_approved == 0)
        {
			$params['reject'] = $params['reject'] + 1;
        }
        if($item->is_approved == 1)
        {
			$params['approved'] = $params['approved'] + 1;
        }
	}
	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
	return $params;
}

function cek_level_exit_up($id)
{
	$exit = \App\Models\HistoryApprovalExit::join('exit_interview','exit_interview.id','=','history_approval_exit.exit_interview_id')->where('exit_interview.id', $id);

	$cek1 = clone $exit;
	$cek1 = $cek1->where('structure_organization_custom_id', \Auth::user()->structure_organization_custom_id)->first();
	if(!$cek1) return false;
	if($cek1->setting_approval_level_id >=2)
	{
		$cek2 = clone $exit;
		$cek2 = $cek2->where('history_approval_exit.setting_approval_level_id',  ( $cek1->setting_approval_level_id - 1) )->whereNull('is_approved')->first();
		if($cek2)
		{
			return false;
		} 
	}

	return true;
}


//exit clearance
function count_clearance_approval()
{
	// cek jenis user
    $approval = \App\Models\SettingApprovalClearance::where('user_id', \Auth::user()->id)->first();
   	$data = \App\Models\ExitInterviewAssets::join('exit_interview','exit_interview.id','=','exit_interview_assets.exit_interview_id')->where('exit_interview.status','<',3)->get();
   	
   	$params['approved'] 	= 0;
	$params['waiting'] 		= 0;
	$params['reject'] 		= 0;
	$params['all']			= 0;

	if(!$data) return $params;
    if($approval)
    {
    	foreach($data as $item)	
		{
			if($item->approval_check == NULL)
			{
				 $params['waiting'] = $params['waiting'] + 1; 
			}
			if($item->approval_check == 0)
	        {
				$params['reject'] = $params['reject'] + 1;
	        }
	        if($item->approval_check == 1)
	        {
				$params['approved'] = $params['approved'] + 1;
	        }
		}
    	$params['all'] = $params['approved'] + $params['waiting'] + $params['reject'];
		return $params;
    }
}


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
 * Update Setting
 */
function update_setting($key, $value)
{
	$setting = \App\Models\Setting::where('key', $key)->first();

	if($setting)
	{
		$setting->value = $value;
		$setting->save();
	}
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

function medical_type_string($id)
{
	$data = \App\Models\MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
	$string = "";

	foreach($data as $item)
	{
		$string  .= $item->medicalType->name.' ,';
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