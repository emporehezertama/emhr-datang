<?php

/**
 * get sub menu
 * @return object / objects
 */
function get_sub_structure($id)
{
	if(empty($id) || $id == 0) return 0;

	return \App\Models\StructureOrganizationCustom::where('parent_id',$id)->get();
}

/*
function structure_custom()
{
	$data = [];
	
	$structure = \App\Models\StructureOrganizationCustom::all();

	foreach($structure as $item)
	{
		if($item->parent_id != 0) continue;

		$sub_menu = get_sub_structure($item->id);

		$data['name']  = $item->name; //'<li><a href="#">'. $item->name .'</a> <i class="fa fa-plus text-info" title="Add Structure" style="cursor: pointer;" onclick="add_structure('. $item->id .',\''. $item->name .'\')"></i>'. "\n";
		$data['title'] = $item->name; //'<i class="fa fa-trash text-danger" onclick="confirm_delete_structure(\''. route('administrator.organization-structure-custom.delete', $item->id) .'\')" title="Delete Structure" style="cursor: pointer;"></i>';

	  	if(count($sub_menu) > 0)
	  	{
	  		#$html 	.= '<ul>';
	  		$html  	.= structure_ul_form_sub_menu($sub_menu, "");	
	  		$html 	.= '</ul>'. "\n";
	  	}
	  	$html .'</li>'. "\n";
	}

	$html .= '</ul>'. "\n";

	return $data;
}

function structure_ul_form_sub_menu($object, $html)
{
	foreach($object as $item)
	{
	  	$sub_menu = get_sub_structure($item->id);
	  	
	  	$html  .= '<li><a href="#">'. $item->name .'</a> <i class="fa fa-plus text-info" title="Add Structure" style="cursor: pointer;" onclick="add_structure('. $item->id .',\''. $item->name .'\')"></i>'. "\n";
		$html  .= '<i class="fa fa-trash text-danger"  onclick="confirm_delete_structure(\''. route('administrator.organization-structure-custom.delete', $item->id) .'\')" title="Delete Structure" style="cursor: pointer;"></i>';

	  	if(count($sub_menu) > 0)
	  	{
	  		$html .= '<ul>'. "\n";
	  		$html .= structure_ul_form_sub_menu($sub_menu, '');	
	  		$html .= "</ul>". "\n";
	  	}

	  	$html .= '</li>'. "\n";
	}

	return $html;
}
*/

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