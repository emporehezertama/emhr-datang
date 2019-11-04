<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmporeOrganisasiDirektur;

class EmporeDirekturController extends Controller
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
        $params['data'] = EmporeOrganisasiDirektur::orderBy('id', 'DESC')->get();

        return view('administrator.empore-direktur.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.empore-direktur.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = EmporeOrganisasiDirektur::where('id', $id)->first();

        return view('administrator.empore-direktur.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data           = EmporeOrganisasiDirektur::where('id', $id)->first();
        $data->name     = $request->name;
        $data->save();

        return redirect()->route('administrator.empore-direktur.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = EmporeOrganisasiDirektur::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.empore-direktur.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new EmporeOrganisasiDirektur();
        $data->name                         = $request->name;
        $data->save();

        return redirect()->route('administrator.empore-direktur.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
