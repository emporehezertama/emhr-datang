<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StructureOrganizationCustom;
use App\Models\SettingApprovalLeave;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiPosition;


class StructureOrganizationCustomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['data']   = StructureOrganizationCustom::orderBy('id', 'DESC');
        $params['division'] = OrganisasiDivision::all();
        $params['position'] = OrganisasiPosition::all();

        return view('administrator.structure-organization-custom.index')->with($params);
    }

    /**
     * Store
     * @param  Request $request
     */
    public function store(Request $request)
    {
        $data               = new StructureOrganizationCustom();
        $data->parent_id    = $request->parent_id;
        $data->organisasi_division_id   = $request->organisasi_division_id;
        $data->organisasi_position_id   = $request->organisasi_position_id;
        $data->save();

        $settingApproval = new SettingApprovalLeave();
        $settingApproval->structure_organization_custom_id = $data->id;
        $settingApproval->save();

        return redirect()->route('administrator.organization-structure-custom.index');
    }

    /**
     * Delete
     * @param  $id
     */
    public function delete($id)
    {

        $data = StructureOrganizationCustom::where('id', $id)->first();
        $data->delete();

        $settingApproval = SettingApprovalLeave::where('structure_organization_custom_id', $id)->first();
        $settingApproval->delete();

        $data = StructureOrganizationCustom::where('parent_id', $id);
        if($data)
        {
            $settingApproval = SettingApprovalLeave::where('structure_organization_custom_id', $data->id);
            if($settingApproval)
            {
               $settingApproval->delete();   
            }
            $data->delete();    
        }
        return redirect()->route('administrator.organization-structure-custom.index');
    }
}
