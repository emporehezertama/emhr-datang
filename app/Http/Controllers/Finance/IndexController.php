<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
Use App\Pinjaman;
use App\Cicilan;
use DB;
use App\Aktiva;
use App\Pasiva;
use App\Pendapatan;
use App\Biaya;

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
        $params['aktiva_harta_lancar']           = Aktiva::where('group', 'A. Harta Lancar')->get();
        $params['aktiva_harta_tetap']               = Aktiva::where('group', 'B. Harta Tetap')->get();
        $params['pasiva_kewajiban_jangka_pendek']   = Pasiva::where('group', 'C. Kewajiban Jangka Pendek')->get();
        $params['pasiva_kewajiban_lainnya']         = Pasiva::where('group', 'D. Kewajiban Lainnya')->get();
        $params['pasiva_modal_sendiri']             = Pasiva::where('group', 'E. Modal Sendiri')->get();
        $params['pendapatan']                   = Pendapatan::all();
        $params['biaya']                        = Biaya::all();        

        return view('finance.index')->with($params);
    }
}
