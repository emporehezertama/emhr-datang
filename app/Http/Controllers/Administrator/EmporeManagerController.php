<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmporeOrganisasiManager;
use App\Models\EmporeOrganisasiDirektur;

class EmporeManagerController extends Controller
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
        $params['data'] = EmporeOrganisasiManager::orderBy('id', 'DESC')->get();

        return view('administrator.empore-manager.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['direktur'] = EmporeOrganisasiDirektur::all();

        return view('administrator.empore-manager.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = EmporeOrganisasiManager::where('id', $id)->first();
        $params['direktur']     = EmporeOrganisasiDirektur::all();

        return view('administrator.empore-manager.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                       = EmporeOrganisasiManager::where('id', $id)->first();
        $data->empore_organisasi_direktur_id = $request->organisasi_direktur_id;
        $data->name     = $request->name;
        $data->save();

        return redirect()->route('administrator.empore-manager.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = EmporeOrganisasiManager::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.empore-manager.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new EmporeOrganisasiManager();
        $data->name                         = $request->name;
        $data->empore_organisasi_direktur_id = $request->empore_organisasi_direktur_id;
        $data->save();

        return redirect()->route('administrator.empore-manager.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
