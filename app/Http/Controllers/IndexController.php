<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
Use App\Pinjaman;
use App\Cicilan;
use DB;

class IndexController extends Controller
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
        $params = [];
        $params['total_anggota'] = User::where('access_id', '<>', 1)->count();
        $params['total_simpanan_pokok']         = DB::table('users')->select(DB::raw('SUM(simpanan_pokok) as total'))->first();
        $params['total_simpanan_sukarela']      = DB::table('users')->select(DB::raw('SUM(simpanan_sukarela) as total'))->first();;
        $params['total_simpanan_wajib']         = DB::table('users')->select(DB::raw('SUM(simpanan_wajib) as total'))->first();;
        $params['cicilan']                      = Cicilan::orderBy('id', 'DESC')->get();
        
        return view('home')->with($params);
    }

    /**
     * [acceptAsset description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function acceptAsset($id)
    {
        $data                   = \App\Asset::where('id', $id)->first();
        $data->handover_date    = date('Y-m-d H:i:s');
        $data->status           = 1;
        $data->save();
        
        // Update Asset Tracking
        $tracking = \App\AssetTracking::whereNull('handover_date')->where('asset_id', $id)->first();
        if($tracking)
        {
            $tracking->handover_date = $data->handover_date;
            $tracking->save();
        }

        return view('accept-asset');
    }

    /**
     * [kwitansi description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function kwitansi($id)
    {
        //return view('kwitansi')->with($params)->render();

        $params['data'] = Cicilan::where('id', $id)->first();

        ob_start();

        echo view('kwitansi')->with($params)->render();
        
        $content = ob_get_contents();

        ob_end_clean();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($content);
        
        return $mpdf->Output();

        /*
        $params['data'] = Cicilan::where('id', $id)->first();

        ob_start();

        echo view('kwitansi')->with($params)->render();
        
        $content = ob_get_contents();

        ob_end_clean();

    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($content);
        
        return $pdf->stream('kwitansi.pdf');
        */
       
    }
}
