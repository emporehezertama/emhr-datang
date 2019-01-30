<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sekolah;

class SekolahController extends Controller
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
        $params['data'] = Sekolah::orderBy('id', 'DESC')->get();

        return view('administrator.sekolah.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.sekolah.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Sekolah::where('id', $id)->first();

        return view('administrator.sekolah.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = Sekolah::where('id', $id)->first();
        $data->name             = $request->name; 
        $data->alamat           = $request->alamat;
        $data->telepon           = $request->telepon;
        $data->save();

        return redirect()->route('administrator.sekolah.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Sekolah::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.sekolah.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new Sekolah();
        $data->name             = $request->name;
        $data->alamat           = $request->alamat;
        $data->telepon           = $request->telepon;
        $data->save();

        return redirect()->route('administrator.sekolah.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
