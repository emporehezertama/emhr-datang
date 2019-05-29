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
            'email' => 'email',
            'perusahaan' => 'perusahaan',
            'bidang_usaha' => 'bidang_usaha',
            'handphone' => 'handphone',
            'confirmation'      => 'same:password',
        ]);

        $data               = new LandingPageForm();
        $data->nama         = $request->nama;
        $data->jabatan      = $request->jabatan;
        $data->email        = $request->email;
        $data->password     = $request->password;
        $data->perusahaan   = $request->perusahaan;
        $data->bidang_usaha = $request->bidang_usaha;
        $data->handphone    = $request->handphone; 
        $data->save();

        return redirect()->route('landing-page1')->with('message-success', 'Form Submited.');
    }
}
