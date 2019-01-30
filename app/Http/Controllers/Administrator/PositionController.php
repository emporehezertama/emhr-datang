<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
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
        $params['data'] = \App\OrganisasiPosition::orderBy('id', 'DESC')->get();

        return view('administrator.position.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['directorate']  = \App\OrganisasiDirectorate::all();
        $params['division']     = \App\OrganisasiDivision::all();
        $params['department']   = \App\OrganisasiDepartment::all();
        $params['unit']   = \App\OrganisasiUnit::all();

        return view('administrator.position.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['directorate']  = \App\OrganisasiDirectorate::all();
        $params['division']     = \App\OrganisasiDivision::all();
        $params['department']   = \App\OrganisasiDepartment::all();
        $params['unit']         = \App\OrganisasiUnit::all();
        $params['data']         = \App\OrganisasiPosition::where('id', $id)->first();

        return view('administrator.position.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = \App\OrganisasiPosition::where('id', $id)->first();
        $data->directorate_id           = $request->directorate_id; 
        $data->division_id              = $request->division_id;
        $data->department_id            = $request->department_id;
        $data->organisasi_unit_id       = $request->unit_id;
        $data->name                     = $request->name;
        $data->save();

        return redirect()->route('administrator.position.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\OrganisasiPosition::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.position.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\OrganisasiPosition();
        $data->organisasi_division_id       = $request->division_id;
        $data->organisasi_department_id     = $request->department_id;
        $data->organisasi_unit_id           = $request->unit_id;
        $data->name                         = $request->name;
        $data->save();

        return redirect()->route('administrator.position.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
