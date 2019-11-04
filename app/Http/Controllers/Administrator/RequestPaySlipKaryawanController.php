<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RequestPaySlip;
use App\Models\RequestPaySlipItem;

class RequestPaySlipKaryawanController extends Controller
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
        $params['data'] = RequestPaySlip::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('administrator.request-pay-slip-karyawan.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.request-pay-slip-karyawan.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = RequestPaySlipItem::where('request_pay_slip_id', $id)->first();
        $params['dataArray']    = RequestPaySlipItem::where('request_pay_slip_id', $id)->get();

        return view('administrator.request-pay-slip-karyawan.edit')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = RequestPaySlip::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.request-pay-slip-karyawan.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        if(is_null($request->bulan)){
             return redirect()->route('administrator.request-pay-slip-karyawan.create')->with('message-error', 'Your request not completed. Please fill year and month!');
        } else{           
            $data                       = new RequestPaySlip();
            $data->user_id              = \Auth::user()->id;
            $data->status               = 1;   
            $data->save();

            foreach($request->bulan as $key => $i)
            {   
                $item               = new RequestPaySlipItem();
                $item->tahun        = $request->tahun;
                $item->request_pay_slip_id = $data->id;
                $item->bulan        = $i;
                $item->status       = 1; 
                $item->user_id      = \Auth::user()->id;
                $item->save();
            }
        return redirect()->route('administrator.request-pay-slip-karyawan.index')->with('message-success', 'You have Successfully Request Pay Slip !');
     }
    }
}
