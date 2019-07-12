<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollExport implements FromView
{
    use Exportable;

    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('administrator.payroll.export', [
            'data' => $this->data
        ]);
    }
}