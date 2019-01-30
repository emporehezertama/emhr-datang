<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProgramStudi;

class ProgramStudiController extends Controller
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
        $params['data'] = ProgramStudi::orderBy('id', 'DESC')->get();

        return view('administrator.program-studi.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.program-studi.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = ProgramStudi::where('id', $id)->first();

        return view('administrator.program-studi.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = ProgramStudi::where('id', $id)->first();
        $data->name             = $request->name; 
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.program-studi.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = ProgramStudi::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.program-studi.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new ProgramStudi();
        $data->name             = $request->name;
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.program-studi.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
