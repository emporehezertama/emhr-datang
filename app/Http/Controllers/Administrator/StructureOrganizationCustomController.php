<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StructureOrganizationCustom;

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
        $data->name         = $request->name;
        $data->save();

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

        $data = StructureOrganizationCustom::where('parent_id', $id);
        if($data)
        {
            $data->delete();            
        }

        return redirect()->route('administrator.organization-structure-custom.index');
    }
}
