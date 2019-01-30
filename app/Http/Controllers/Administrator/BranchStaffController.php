<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchStaffController extends Controller
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
        $params['data'] = \App\BranchStaff::orderBy('id', 'DESC')->get();

        return view('administrator.branch-staff.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['head'] = \App\BranchHead::all();

        return view('administrator.branch-staff.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = \App\BranchStaff::where('id', $id)->first();
        $params['head'] = \App\BranchHead::all();

        return view('administrator.branch-staff.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = \App\BranchStaff::where('id', $id)->first();
        $data->branch_head_id   = $request->branch_head_id;         
        $data->name             = $request->name;         
        $data->save();

        return redirect()->route('administrator.branch-staff.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\BranchStaff::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.branch-staff.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\BranchStaff();
        $data->branch_head_id   = $request->branch_head_id;         
        $data->name             = $request->name;   
        $data->save();

        return redirect()->route('administrator.branch-staff.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
