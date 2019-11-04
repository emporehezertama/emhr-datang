<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisasiDepartment;
use App\Models\OrganisasiDirectorate;
use App\Models\OrganisasiDivision;

class DepartmentController extends Controller
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
        $params['data'] = OrganisasiDepartment::all();

        return view('administrator.department.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['directorate']  = OrganisasiDirectorate::all();
        $params['division']     = OrganisasiDivision::all();

        return view('administrator.department.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['directorate']  = OrganisasiDirectorate::all();
        $params['division']     = OrganisasiDivision::all();
        $params['data']         = OrganisasiDepartment::where('id', $id)->first();

        return view('administrator.department.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = Department::where('id', $id)->first();
        $data->organisasi_directorate_id   = $request->directorate_id; 
        $data->organisasi_division_id      = $request->division_id;
        $data->name             = $request->name;
        $data->save();

        return redirect()->route('administrator.department.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OrganisasiDivision::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.department.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new Department();
        $data->organisasi_directorate_id   = $request->directorate_id; 
        $data->organisasi_division_id      = $request->division_id;
        $data->name             = $request->name;
        $data->save();

        return redirect()->route('administrator.department.index')->with('message-success', 'Data berhasil disimpan !');
    }
}