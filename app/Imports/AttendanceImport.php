<?php

namespace App\Imports;

use App\Models\AbsensiItem;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class AttendanceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // foreach($row as $key => $rows){
        //     if($key == 0) continue;
            
        //    $data   = User::where('id', $item[$key])->first();
            return new AbsensiItem([
                'user_id'                  => $key,
                'name'                     => $row[0],
                'timetable'                => getNamaHari('2019-08-31'),
                'date'                     => $row[2],
                'clock_in'                 => $row[3],
                'clock_out'                => $row[4],
            ]);
    //    }
        
        
    }
}
