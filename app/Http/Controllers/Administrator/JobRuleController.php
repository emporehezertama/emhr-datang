<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisasiJobRole;
use App\Models\OrganisasiDirectorate;
use App\Models\OrganisasiDivision;
use App\Models\OrganisasiDepartment;
use App\Models\OrganisasiSection;
use App\Models\OrganisasiUnit;
use App\Models\OrganisasiPosition;

class JobRuleController extends Controller
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
        $params['data'] = OrganisasiJobRole::orderBy('id', 'DESC')->get();

        return view('administrator.job-rule.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['directorate']  = OrganisasiDirectorate::all();
        $params['division']     = OrganisasiDivision::all();
        $params['department']   = OrganisasiDepartment::all();
        $params['department']   = OrganisasiSection::all();

        return view('administrator.job-rule.create')->with($params);
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
        $params['department']   = OrganisasiDepartment::all();
        $params['unit']         = OrganisasiUnit::all();
        $params['data']         = OrganisasiPosition::where('id', $id)->first();

        return view('administrator.job-rule.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                           = OrganisasiPosition::where('id', $id)->first();
        $data->directorate_id           = $request->directorate_id; 
        $data->division_id              = $request->division_id;
        $data->department_id            = $request->department_id;
        $data->organisasi_unit_id       = $request->unit_id;
        $data->name                     = $request->name;
        $data->save();

        return redirect()->route('administrator.job-rule.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OrganisasiPosition::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.job-rule.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new OrganisasiPosition();
        $data->organisasi_directorate_id    = $request->directorate_id; 
        $data->organisasi_division_id       = $request->division_id;
        $data->organisasi_department_id     = $request->department_id;
        $data->organisasi_unit_id           = $request->unit_id;
        $data->name                         = $request->name;
        $data->save();

        return redirect()->route('administrator.job-rule.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
