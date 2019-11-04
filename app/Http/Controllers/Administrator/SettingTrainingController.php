<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingApproval;

class SettingTrainingController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['ga_department']    = SettingApproval::where('jenis_form', 'training_mengetahui')->where('nama_approval', 'GA Department')->orderBy('id', 'DESC')->get();
        $params['hrd']              = SettingApproval::where('jenis_form', 'training')->where('nama_approval', 'HRD')->orderBy('id', 'DESC')->get();
        $params['finance']          = SettingApproval::where('jenis_form', 'training')->where('nama_approval', 'Finance')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-training.index')->with($params);
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

        return redirect()->route('administrator.setting-training.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
