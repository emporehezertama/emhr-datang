<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\OrganisasiDivision;
use DB;
use App\Models\Directorate;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        #$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $jumlahdata = OrganisasiDivision::count();
        $data = OrganisasiDivision::all();
        $name = [];
        $id = [];
        $karyawan_per_divisi = [];
        $y = 0;
        $x = 0;
        $z = 0;
        for ($i=0; $i < $jumlahdata; $i++) { 	
            $name[$y] = $data[$i]->name;
            $id[$x] = $data[$i]->id;
            
            $karyawan_per_divisi[$z] = DB::table('structure_organization_custom')
                                                ->select('structure_organization_custom.*', 'users.*')
                                                ->join('users', 'structure_organization_custom.id','=', 'users.structure_organization_custom_id')
                                                ->where('structure_organization_custom.organisasi_division_id', $id[$x])
                                                ->whereNull('users.status')
                                                ->count();

            $name[$y++];
            $id[$x++];
            $karyawan_per_divisi[$z++];
        }
        $namedivision = $name;
        $jumlahperdivisi = $karyawan_per_divisi;


        return view('administrator.dashboard', compact('namedivision', 'jumlahperdivisi'));

     //   return view('administrator.setting');
    }

    /**
     * [updateProfile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateProfile(Request $request)
    {
        $user = User::where('id', \Auth::user()->id)->count();
        
        if($user)
        {   
            // cek nik 
            if($user->nik != $request->nik)
            {
                $getOtherUser = User::where('id', \Auth::user()->id)->where('nik', $request->nik)->first();
                if($getOtherUser)
                {
                    return redirect()->route('administrator.profile')->with('message-error', 'NIK sudah dipakai oleh Karyawan lain !');
                }
                else
                {
                    $user->nik = $request->nik;
                }
            }

            if($user->email != $request->email) $user->email = $request->email;

            $user->save();

            return redirect()->route('administrator.profile')->with('message-success', 'Data Profil berhasil di simpan !');
        } 
    }

    /**
     * [setting description]
     * @return [type] [description]
     */
    public function setting()
    {
        return view('administrator.setting');
    }

    /**
     * [structure description]
     * @return [type] [description]
     */
    public function structure()
    {
        $params['directorate'] = Directorate::all();

        return view('administrator.structure')->with($params);
    }

    /**
     * [profile description]
     * @return [type] [description]
     */
    public function profile()
    {
        $params['data'] = \Auth::user();
        
        return view('administrator.profile')->with($params);
    }
}