<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollExportMonth implements FromView
{
    use Exportable;

    protected $year;
    
    protected $month;

    protected $data;
    
    public function __construct(int $year, int $month, array $data)
    {
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
    }

    public function view(): View
    {
        return view('administrator.payroll.export-month', [
            'data' => $this->data,
            'year' => $this->year,
            'month' => $this->month
        ]);
    }
}