<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingCutiController extends Controller
{   
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['personalia'] = \App\SettingApproval::where('jenis_form', 'cuti')->where('nama_approval', 'Personalia')->orderBy('id', 'DESC')->get();
        $params['atasan'] = \App\SettingApproval::where('jenis_form', 'cuti')->where('nama_approval', 'Atasan')->orderBy('id', 'DESC')->get();

        return view('administrator.setting-cuti.index')->with($params);
    }

     /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('administrator.setting-cuti.create');
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

        return redirect()->route('administrator.setting-cuti.index')->with('message-success', 'Data Approval berhasi di hapus');
    }
}
