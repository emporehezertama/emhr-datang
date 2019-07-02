<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KaryawanExport implements FromView
{
    use Exportable;

    protected $data;

    protected $title;
    
    public function __construct(array $data, string $title)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function view(): View
    {
        return view('administrator.karyawan.export', [
            'data'  => $this->data,
            'title' => $this->title
        ]);
    }
}