<?php

/**
 * Get List Backup
 * @return [type] [description]
 */
function get_schedule_backup()
{
	$auth = \Auth::user();
	if($auth)
	{
		if($auth->project_id != NULL)
        {
        	return \App\Models\ScheduleBackup::orderBy('id', 'DESC')->where('project_id',$auth->project_id)->get();
        } else{
        	return \App\Models\ScheduleBackup::orderBy('id', 'DESC')->get();
        }
	}else{
		return \App\Models\ScheduleBackup::orderBy('id', 'DESC')->get();
	}
	

 	
}