<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelUser; 
Use App\Pinjaman;
use App\Cicilan;
use App\PinjamanEndowment;
use App\CicilanEndowment;
use App\Deposit;
use App\SimpananPokok;
use App\SimpananWajib;
use App\Transaksi;
use App\AhliWaris;
use Auth;

class UserController extends Controller
{	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
    public function index()
    {
    	$data = ModelUser::where('access_id', 1)->get();

    	return view('user.index', compact('data'));
    }

    /**
     * [active description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function active($id)
    {
        $data = ModelUser::where('id', $id)->first();
        
        if($data)
        {
            $data->tanggal_aktivasi = date('Y-m-d');
            $data->status = 1;
            $data->save();
            
            return redirect()->route('user.index')->with('message-success', 'Data Anggota berhasil di aktifkan !');
        }else{
            return redirect()->route('user.index')->with('message-error', 'Data Anggota tidak ditemukan !');
        }
    }

    /**
     * [active description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function inactive($id)
    {
        $data = ModelUser::where('id', $id)->first();
        
        if($data)
        {
            $data->status = 0;
            $data->save();
            
            return redirect()->route('user.index')->with('message-success', 'Data Anggota berhasil di inaktif !');
        }else{
            return redirect()->route('user.index')->with('message-error', 'Data Anggota tidak ditemukan !');
        }
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $user = ModelUser::where('id', $id)->first();
        $data['data'] 	= $user;
        $data['id'] 	= $id;
        
        return view('user.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  ModelUser::where('id', $id)->first();
        
        $data->name        = $request->nama; 
        $data->jenis_kelamin= $request->jenis_kelamin; 
        $data->email        = $request->email;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->is_endowment = 0;
        
        if(!empty($request->password))
        {
            $data->password             = bcrypt($request->password); 
        }
        
        $data->status   = $request->status;
        $data->alamat       = $request->alamat;

        $data->save();

        return redirect()->route('user.index')->with('message-success', 'Data berhasil disimpan'); 
    }


    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = ModelUser::where('id', $id)->first();
        $data->delete();

        return redirect()->route('user.index')->with('message-sucess', 'Data berhasi di hapus');
    }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $no_anggota = date('y').date('m').date('d'). (ModelUser::all()->count() + 1);

        $this->validate($request,[
            'telepon'           => 'required',
            'nama'              => 'required',
            'email'             => 'required|email|unique:users',
            'password'          => 'required',
            'confirmation'      => 'required|same:password',
        ]);
        
        $data               =  new ModelUser();
        $data->name         = $request->nama; 
        $data->jenis_kelamin= $request->jenis_kelamin; 
        $data->email        = $request->email;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir= $request->tanggal_lahir; 
        $data->password             = bcrypt($request->password); 
        $data->access_id    = 1;
        $data->status       = 1;
        $data->is_endowment  = 0;
        $data->status       = $request->status;
        $data->save();

        return redirect()->route('user.index')->with('message-success', 'Data berhasil disimpan'); 
   }
}
