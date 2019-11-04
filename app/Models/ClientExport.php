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
    
    public function __construct($nama, $email, $nama_perusahaan, $handphone)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->nama_perusahaan = $nama_perusahaan;
        $this->handphone = $handphone;
    }

    public function view(): View
    {
        return view('landing-page.export', [
            'nama'  => $this->nama,
            'email'  => $this->email,
            'nama_perusahaan'  => $this->nama_perusahaan,
            'handphone'  => $this->handphone
        ]);
        
    }

}