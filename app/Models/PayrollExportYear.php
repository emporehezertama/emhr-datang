<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollExportYear implements WithMultipleSheets
{
    use Exportable;

    protected $year;

    protected $user;
    
    public function __construct(int $year, array $user)
    {
        $this->year = $year;

        $this->user = $user;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

      	$data = \App\Models\PayrollHistory::groupBy('user_id')->whereIn('user_id', $this->user)->get();

      	foreach($data as $item)
      	{
      		if(!isset($item->user->name)) continue;

      		$sheets[] = new \App\Models\PayrollPerEmployeeSheet($this->year, $item->user->nik, $item->user_id);
      	}
      	
        return $sheets;
    }
}