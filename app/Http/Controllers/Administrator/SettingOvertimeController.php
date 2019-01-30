<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingOvertimeController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['hr_operation'] = \App\SettingApproval::where('jenis_form', 'overtime')->where('nama_approval', 'HR Operation')->orderBy('id', 'DESC')->get();
        $params['manager_hr'] = \App\SettingApproval::where('jenis_form', 'overtime')->where('nama_approval', 'Manager HR')->orderBy('id', 'DESC')->get();
        $params['manager_department'] = \App\SettingApproval::where('jenis_form', 'overtime')->where('nama_approval', 'Manager Department')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-overtime.index')->with($params);
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

        return redirect()->route('administrator.setting-overtime.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
