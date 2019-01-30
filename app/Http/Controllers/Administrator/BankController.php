<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bank;

class BankController extends Controller
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
        $params['data'] = Bank::orderBy('id', 'DESC')->get();

        return view('administrator.bank.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.bank.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Bank::where('id', $id)->first();

        return view('administrator.bank.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = Bank::where('id', $id)->first();
        $data->name   = $request->name; 
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.bank.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Bank::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.bank.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new Bank();
        $data->name             = $request->name;
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.bank.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
