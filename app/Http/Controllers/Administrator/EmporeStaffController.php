<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmporeStaffController extends Controller
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
        $params['data'] = \App\EmporeOrganisasiStaff::orderBy('id', 'DESC')->get();

        return view('administrator.empore-staff.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['manager'] = \App\EmporeOrganisasiManager::all();

        return view('administrator.empore-staff.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['manager']      = \App\EmporeOrganisasiManager::all();
        $params['data']         = \App\EmporeOrganisasiStaff::where('id', $id)->first();

        return view('administrator.empore-staff.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data           = \App\EmporeOrganisasiStaff::where('id', $id)->first();
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->name     = $request->name;
        $data->save();

        return redirect()->route('administrator.empore-staff.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\EmporeOrganisasiStaff::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.empore-staff.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\EmporeOrganisasiStaff();
        $data->name                         = $request->name;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->save();

        return redirect()->route('administrator.empore-staff.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
