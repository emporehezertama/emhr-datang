<?php 
namespace App\Models;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

#class PayrollPerEmployeeSheet implements FromQuery, WithTitle
class PayrollPerEmployeeSheet implements FromView, WithTitle 
{
    private $year;
    private $employee;
    private $user_id;

    public function __construct(int $year, string $employee, int $user_id)
    {
        $this->year     = $year;
        $this->employee = $employee;
        $this->user_id  = $user_id;
    }
    
    /**
     * @return view
     */
    public function view(): View
    {
        $params['title']    = $this->employee;
        $params['year']     = $this->year;
        $params['user_id']  = $this->user_id;

        $data = [];
        for ($month = 1; $month <= 12; $month++) 
        {
            $data[$month] = get_payroll_history_param($this->user_id, $this->year, $month);
        }
        $params['data'] = $data;
        
        return view('administrator.payroll.export-year', $params);
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return  'Employee '. $this->employee;
    }
}