<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetTypeController extends Controller
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
        $params['data'] = \App\AssetType::orderBy('id', 'ASC')->get();

        return view('administrator.asset-type.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.asset-type.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = \App\AssetType::where('id', $id)->first();

        return view('administrator.asset-type.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data           = \App\AssetType::where('id', $id)->first();
        $data->name     = $request->name; 
        $data->save();

        return redirect()->route('administrator.asset-type.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\AssetType::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.asset-type.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data           = new \App\AssetType();
        $data->name     = $request->name; 
        $data->save();

        return redirect()->route('administrator.asset-type.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
