<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExitClearance;

class ExitClearanceController extends Controller
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
        $params['data'] = ExitClearance::orderBy('id', 'DESC')->get();

        return view('administrator.exit-clearance.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params[] = '';

        return view('administrator.exit-clearance.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params[] = '';

        return view('administrator.exit-clearance.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = ExitClearance::where('id', $id)->first();
        $data->save();

        return redirect()->route('administrator.exit-clearance.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = ExitClearance::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.exit-clearance.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new ExitClearance();
        $data->save();

        return redirect()->route('administrator.exit-clearance.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
