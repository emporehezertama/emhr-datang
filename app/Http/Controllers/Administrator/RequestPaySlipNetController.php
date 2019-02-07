<?php

namespace App\Http\Controllers\Administrator;

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
        $params['data'] = RequestPaySlipNet::orderBy('id', 'DESC')->get();

        return view('administrator.request-pay-slipnet.index')->with($params);
    }

    /**
     * [proses description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function proses($id)
    {
        $params['datamaster']   = RequestPaySlipNet::where('id', $id)->first();
        $params['data']         = RequestPaySlipItemNet::where('request_pay_slipNet_id', $id)->first();
        $params['dataArray']    = RequestPaySlipItemNet::where('request_pay_slipNet_id', $id)->get();

        return view('administrator.request-pay-slipnet.proses')->with($params);
    }

    /**
     * [submit description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function submit(Request $request, $id)
    {
        $data = RequestPaySlipNet::where('id', $id)->first();

        $bulanItem = RequestPaySlipItemNet::where('request_pay_slipNet_id', $id)->get();
        $bulan = [];
        $total = 0;
        $dataArray = [];
        $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        foreach($bulanItem as $k => $i)
        {
            $bulan[$k] = $bulanArray[$i->bulan]; $total++;

            $items   = \DB::select(\DB::raw("SELECT payrollnet_history.*, month(created_at) as bulan FROM payrollnet_history WHERE MONTH(created_at)=". $i->bulan ." and user_id=". $data->user_id ." and YEAR(created_at) =". $request->tahun. ' ORDER BY id DESC'));
            
            if(!$items)
            {
                $items   = \DB::select(\DB::raw("SELECT * FROM  payrollnet_history WHERE user_id=". $data->user_id ." and YEAR(created_at) =". $request->tahun ." ORDER BY id DESC"));
                $dataArray[$k] = $items[0];
            }
            else
            {
                $dataArray[$k] = $items[0];
            }
        }

        $params['total']        = $total;
        $params['dataArray']    = $dataArray;//\App\PayrollHistory::whereIn('id', $whereIn)->get();
        $params['data']         = $data;
        $params['bulan']        = $bulan;
        $params['tahun']        = $request->tahun;

        $view =  view('administrator.request-pay-slipnet.print-pay-slip')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        $pdf->stream();

        $output = $pdf->output();
        $destinationPath = public_path('/storage/temp/');

        file_put_contents( $destinationPath . $data->user->nik .'.pdf', $output);

        $file = $destinationPath . $data->user->nik .'.pdf';

        // send email
        $objDemo = new \stdClass();
        $objDemo->content = view('administrator.request-pay-slipnet.email-pay-slip'); 
        
        if($data->user->email != "")
        { 
            \Mail::send('administrator.request-pay-slipnet.print-pay-slip', $params,
                function($message) use($file, $data) {
                    $message->from('info@system.com');
                   
                    //$message->to('doni.enginer@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Request Pay-Slip');
                    $message->attach($file, array(
                            'as' => 'Payslip-'. $data->user->nik .'.pdf', 
                            'mime' => 'application/pdf')
                    );
                    $message->setBody('');
                }
            );
        }
        
        $data->note     = $request->note;
        $data->status   = 2;
        $data->save();

        return redirect()->route('administrator.request-pay-slipnet.index')->with('message-success', 'Request Pay Slip berhasil diproses');
    }
}
