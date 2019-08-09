<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;


class AttendanceExport implements FromView
{
    use Exportable;

    protected $data;

    protected $title;
    
//    public function __construct($params)
    public function __construct($start, $end, $branch, $id)
    {
    //    $this->params = $params;
        $this->start = $start;
        $this->end = $end;
        $this->branch = $branch;
        $this->id = $id;
    }

    public function view(): View
    {
        $start = $this->start;
        $end = $this->end;
        $branch = $this->branch;
        $id = $this->id;
        return view('attendance.export', [
        //    'params'  => $this->params
            'params'  => dataAttendance($start, $end, $branch, $id)
        ]);
        
    }

}