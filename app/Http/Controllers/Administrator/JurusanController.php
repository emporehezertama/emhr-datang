<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jurusan;

class JurusanController extends Controller
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
        $params['data'] = Jurusan::orderBy('id', 'DESC')->get();

        return view('administrator.jurusan.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.jurusan.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Jurusan::where('id', $id)->first();

        return view('administrator.jurusan.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = Jurusan::where('id', $id)->first();
        $data->name             = $request->name; 
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.jurusan.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Jurusan::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.jurusan.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new Jurusan();
        $data->name             = $request->name;
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.jurusan.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
