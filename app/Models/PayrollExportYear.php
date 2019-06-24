<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollExportYear implements WithMultipleSheets
{
    use Exportable;

    protected $year;
    
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

      	$data = \App\Models\PayrollHistory::groupBy('user_id')->get();

      	foreach($data as $item)
      	{
      		if(!isset($item->user->name)) continue;

      		$sheets[] = new \App\Models\PayrollPerEmployeeSheet($this->year, $item->user->nik, $item->user_id);
      	}
      	
        return $sheets;
    }
}