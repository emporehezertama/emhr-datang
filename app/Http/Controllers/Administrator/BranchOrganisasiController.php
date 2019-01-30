<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchOrganisasiController extends Controller
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
        $params['data'] = \App\BranchHead::orderBy('id', 'DESC')->get();

        return view('administrator.branch-organisasi.index')->with($params);
    }

    /**
     * [tree description]
     * @return [type] [description]
     */
    public function tree()
    {
        return view('administrator.branch-organisasi.tree');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.branch-organisasi.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = \App\BranchHead::where('id', $id)->first();

        return view('administrator.branch-organisasi.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data               = \App\BranchHead::where('id', $id)->first();
        $data->name         = $request->name;         
        $data->save();

        return redirect()->route('administrator.branch-organisasi.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\BranchHead::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.branch-organisasi.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\BranchHead();
        $data->name             = $request->name;
        $data->save();

        return redirect()->route('administrator.branch-organisasi.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
