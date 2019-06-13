<?php

function checkModule($module)
{
	$user = \Auth::user();
	if($user)
	{
		if($user->project_id != NULL)
		{
			$module = \App\Models\CrmModule::where('project_id', $user->project_id)->where('crm_product_id', $module)->count();
			if($module>0)
			{
				return true;
			}

		}else{
			return true;
		}
	}
	return false;
}

function checkUserLimit()
{
	$user = \Auth::user();
	if($user)
	{
		if($user->project_id != NULL)
		{
			$module = \App\Models\CrmModule::where('project_id', $user->project_id)->where('crm_product_id', 3)->first();

			$User = \App\User::where('project_id', $user->project_id)->where('access_id',2)->count();
			//dd($module->limit_user);

			if($User >= $module->limit_user)
			{
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	return false;
}


?>