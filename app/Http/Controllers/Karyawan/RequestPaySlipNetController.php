<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RequestPaySlipNet;
use App\Models\RequestPaySlipItemNet;

class RequestPaySlipNetController extends Controller
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
        $params['data'] = RequestPaySlipNet::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.request-pay-slipnet.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('karyawan.request-pay-slipnet.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = RequestPaySlipItemNet::where('request_pay_slipNet_id', $id)->first();
        $params['dataArray']    = RequestPaySlipItemNet::where('request_pay_slipNet_id', $id)->get();

        return view('karyawan.request-pay-slipnet.edit')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = RequestPaySlipNet::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.request-pay-slipnet.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        if(is_null($request->bulan)){
             return redirect()->route('karyawan.request-pay-slipnet.create')->with('message-error', 'Your request not complete. Please fill year and month!');
        } else{
            $data                       = new RequestPaySlipNet();
            $data->user_id              = \Auth::user()->id;
            $data->status               = 1;   
            $data->save();

            foreach($request->bulan as $key => $i)
            {   
                $item               = new RequestPaySlipItemNet();
                $item->tahun        = $request->tahun;
                $item->request_pay_slipNet_id = $data->id;
                $item->bulan        = $i;
                $item->status       = 1; 
                $item->user_id      = \Auth::user()->id;
                $item->save();
            }
            return redirect()->route('karyawan.request-pay-slipnet.index')->with('message-success', 'You have Successfully Request Pay Slip !');
        }      
    }
}
