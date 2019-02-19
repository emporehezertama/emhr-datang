<?php

/**
 * Count
 * @return integer
 */
function countStructureOrganization()
{
	return \App\Models\StructureOrganizationCustom::count();
}

/**
 * get sub menu
 * @return object / objects
 */
function get_sub_structure($id)
{
	if(empty($id) || $id == 0) return 0;

	return \App\Models\StructureOrganizationCustom::where('parent_id',$id)->get();
}

/**
 * Select Navigation Form
 * @return string
 */
function structure_custom()
{
	$object = [];
	$structure = \App\Models\StructureOrganizationCustom::all();

	foreach($structure as $key => $item)
	{
		if($item->parent_id != 0) continue;

		$sub_menu = get_sub_structure($item->id);

		$object[$key]['title'] =  'Directure';
		$object[$key]['name'] =  $item->name;

	  	if(count($sub_menu) > 0)
	  	{
	  		$object[$key]['children']  = structure_ul_form_sub_menu($sub_menu, []);	
	  	}
	}

	return $object;
}

/**
 * Navigation Sub Menu
 * @return html
 */
function structure_ul_form_sub_menu($object, $data)
{	

	foreach($object as $key => $item)
	{
	  	$sub_menu = get_sub_structure($item->id);
	  	
	  	$data[$key]['title'] 	= $item->name .' title';
	  	$data[$key]['name'] 	= $item->name;

	  	// if(count($sub_menu) > 0)
	  	// {
	  	// 	$data['children'][$key] = structure_ul_form_sub_menu($sub_menu, []);	
	  	// }
	}

	return $data;
}