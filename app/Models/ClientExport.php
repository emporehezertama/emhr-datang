<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;


class ClientExport implements FromView
{
    use Exportable;

    protected $data;

    protected $title;
    
    public function __construct($nama, $email, $jabatan, $bidang_usaha, $nama_perusahaan, $handphone)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->jabatan = $jabatan;
        $this->bidang_usaha = $bidang_usaha;
        $this->nama_perusahaan = $nama_perusahaan;
        $this->handphone = $handphone;
    }

    public function view(): View
    {
        return view('landing-page.export', [
            'nama'  => $this->nama,
            'email'  => $this->email,
            'jabatan'  => $this->jabatan,
            'bidang_usaha'  => $this->bidang_usaha,
            'nama_perusahaan'  => $this->nama_perusahaan,
            'handphone'  => $this->handphone
        ]);
        
    }

}