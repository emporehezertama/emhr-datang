<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageForm;

class LandingPageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function page1()
    {
        $params = [];

        return view('landing-page/2019-05-28');
    }

    /**
     * Store page 1
     * @return void
     */
    public function storePage1(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email|unique:landing_page_form',
            'nama_perusahaan' => 'required',
            'bidang_usaha' => 'required',
            'handphone' => 'required',
            'confirm'      => 'same:password',
        ]);

        $data               = new LandingPageForm();
        $data->nama         = $request->nama;
        $data->jabatan      = $request->jabatan;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->perusahaan   = $request->nama_perusahaan;
        $data->bidang_usaha = $request->bidang_usaha;
        $data->handphone    = $request->handphone; 
        $data->save();

        return redirect()->route('landing-page1')->with('message-success', 'Thank you for being interested in our products and registering for trial licenses, we have received your data and we will contact you immediately for trial account information');
    }
    public function loginClient(Request $request) 
    {
        $this->validate($request,[
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        return view('landing-page/index');
    }
}
