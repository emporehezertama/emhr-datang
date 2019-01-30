<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingMedicalController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['hr_benefit'] = \App\SettingApproval::where('jenis_form', 'medical')->where('nama_approval', 'HR Benefit')->orderBy('id', 'DESC')->get();
        $params['manager_hr'] = \App\SettingApproval::where('jenis_form', 'medical')->where('nama_approval', 'Manager HR')->orderBy('id', 'DESC')->get();
        $params['gm_hr'] = \App\SettingApproval::where('jenis_form', 'medical')->where('nama_approval', 'GM HR')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-medical.index')->with($params);
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

        return redirect()->route('administrator.setting-medical.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
