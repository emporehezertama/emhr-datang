<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingExitClearanceController extends Controller
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
        $params['hrd'] = \App\SettingApproval::where('jenis_form', 'exit_clearance')->where('nama_approval', 'HRD')->orderBy('id', 'DESC')->get();
        $params['ga'] = \App\SettingApproval::where('jenis_form', 'exit_clearance')->where('nama_approval', 'GA')->orderBy('id', 'DESC')->get();
        $params['it'] = \App\SettingApproval::where('jenis_form', 'exit_clearance')->where('nama_approval', 'IT')->orderBy('id', 'DESC')->get();
        $params['accounting_finance'] = \App\SettingApproval::where('jenis_form', 'exit_clearance')->where('nama_approval', 'Accounting')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-exit-clearance.index')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\SettingApproval::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-exit-clearance.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
