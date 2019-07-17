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
function checkModuleAdmin($module){
	$user = \Auth::user();
	if($user)
	{
		if($user->project_id != NULL)
		{
			$admin = \App\Models\CrmModuleAdmin::where('user_id',$user->id)->where('product_id',$module)->count();
			if($admin>0)
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

			$User = \App\User::where('project_id', $user->project_id)->whereIn('access_id',[1,2])->count();
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