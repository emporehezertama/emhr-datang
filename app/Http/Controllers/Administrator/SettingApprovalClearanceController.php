<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApprovalClearance;

class SettingApprovalClearanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['hrd'] = SettingApprovalClearance::where('nama_approval', 'HRD')->orderBy('id', 'DESC')->get();
        $params['ga'] = SettingApprovalClearance::where('nama_approval', 'GA')->orderBy('id', 'DESC')->get();
        $params['it'] = SettingApprovalClearance::where('nama_approval', 'IT')->orderBy('id', 'DESC')->get();
        $params['accounting_finance'] = SettingApprovalClearance::where('nama_approval', 'Accounting')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-approvalClearance.index')->with($params);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = SettingApprovalClearance::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-approvalClearance.index')->with('message-success', 'Data Approval successfully delete');
    }
}
