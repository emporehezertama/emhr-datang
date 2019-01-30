<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingMasterCutiController extends Controller
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
        $params['data'] = \App\Cuti::orderBy('id', 'DESC')->get();

        return view('administrator.setting-master-cuti.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.setting-master-cuti.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = \App\Cuti::where('id', $id)->first();

        return view('administrator.setting-master-cuti.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = \App\Cuti::where('id', $id)->first();
        $data->jenis_cuti       = $request->jenis_cuti; 
        $data->kuota            = $request->kuota;
        $data->save();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $data = \App\Cuti::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\Cuti::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new \App\Cuti();
        $data->jenis_cuti   = $request->jenis_cuti;
        $data->kuota        = $request->kuota;
        $data->save();

        return redirect()->route('administrator.setting-master-cuti.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
