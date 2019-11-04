<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApproval;

class SettingExitController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['hr_manager']   = SettingApproval::where('jenis_form', 'exit')->where('nama_approval', 'HR Manager')->orderBy('id', 'DESC')->get();
        $params['hr_gm']        = SettingApproval::where('jenis_form', 'exit')->where('nama_approval', 'HR GM')->orderBy('id', 'DESC')->get();
        $params['hr_director']  = SettingApproval::where('jenis_form', 'exit')->where('nama_approval', 'HR Director')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-exit.index')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = SettingApproval::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-exit.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}