<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RequestPaySlipGross;
use App\Models\RequestPaySlipGrossItem;

class RequestPaySlipGrossController extends Controller
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
        $params['data'] = RequestPaySlipGross::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.request-pay-slipgross.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('karyawan.request-pay-slipgross.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = RequestPaySlipGrossItem::where('request_pay_slipgross_id', $id)->first();
        $params['dataArray']    = RequestPaySlipGrossItem::where('request_pay_slipgross_id', $id)->get();

        return view('karyawan.request-pay-slipgross.edit')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = RequestPaySlipGross::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.request-pay-slipgross.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        if(is_null($request->bulan)){
             return redirect()->route('karyawan.request-pay-slipgross.create')->with('message-error', 'Your request not completed. Please fill year and month!');
        } else{           
            $data                       = new RequestPaySlipGross();
            $data->user_id              = \Auth::user()->id;
            $data->status               = 1;   
            $data->save();

            foreach($request->bulan as $key => $i)
            {   
                $item               = new RequestPaySlipGrossItem();
                $item->tahun        = $request->tahun;
                $item->request_pay_slipgross_id = $data->id;
                $item->bulan        = $i;
                $item->status       = 1; 
                $item->user_id      = \Auth::user()->id;
                $item->save();
            }
        return redirect()->route('karyawan.request-pay-slipgross.index')->with('message-success', 'You have Successfully Request Pay Slip !');
     }
    }
}
