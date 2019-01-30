<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Division;
use App\Directorate;

class DivisionController extends Controller
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
        $params['data'] = \App\OrganisasiDivision::all();

        return view('administrator.division.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['directorate'] = \App\OrganisasiDirectorate::all();

        return view('administrator.division.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['directorate'] = \App\OrganisasiDirectorate::all();
        $params['data'] = \App\OrganisasiDivision::where('id', $id)->first();

        return view('administrator.division.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = \App\OrganisasiDivision::where('id', $id)->first();
        $data->organisasi_directorate_id   = $request->directorate_id;
        $data->name             = $request->name;
        $data->save();

        return redirect()->route('administrator.division.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\OrganisasiDivision::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.division.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\OrganisasiDivision();
        $data->organisasi_directorate_id = $request->directorate_id;
        $data->name         = $request->name;
        $data->save();

        return redirect()->route('administrator.division.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
