<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageForm;
use App\Models\ClientExport;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LandingPageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function page1()
    {
        $params = [];

        return view('landing-page/2019-05-28');
    }

    /**
     * Store page 1
     * @return void
     */
    public function storePage1(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'jabatan' => 'required',

            'email' => 'email:required',
            'nama_perusahaan' => 'required',
            'bidang_usaha' => 'required',
            'handphone' => 'required',
            'confirm'      => 'same:password',
        ]);

        return $this->downloadExcel($request);

        }
    public function loginClient(Request $request) 
    {
        $this->validate($request,[
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        return view('landing-page/index');
    }

    public function downloadExcel($request)
    {
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
   
        $nama              = $request['nama'];
        $email             = $request['email'];
        $jabatan           = $request['jabatan'];
        $bidang_usaha      = $request['bidang_usaha'];
        $nama_perusahaan   = $request['nama_perusahaan'];
        $handphone         = $request['handphone'];

        $destination = storage_path('app');
        $name_excel = 'Request_Trial'.date('YmdHis');
        $file = $destination ."\\". $name_excel.'.xlsx';

        Excel::store(new ClientExport($nama, $email, $jabatan, $bidang_usaha, $nama_perusahaan, $handphone), $name_excel.'.xlsx');
    //  return (new ClientExport($nama, $email, $jabatan, $bidang_usaha, $nama_perusahaan, $handphone))->download('Request-trial'.date('d-m-Y') .'.xlsx');
    
        $params['text']     = 'Test Free Trial';
        $emailto = ['farrosashiddiq@gmail.com', 'farros@empore.co.id'];
        \Mail::send('email.trial-account', $params,
            function($message) use($request, $file, $email, $emailto,$name_excel, $destination) {
                $message->from($email);
                $message->to($emailto);
                $message->subject('Request Trial');
                $message->attach($file, array(
                    'as' => $name_excel .'.xlsx',
                    'mime' => 'application/xlsx'
                    )
            );
            }
        );

        return redirect()->route('landing-page1')->with('message-success', 'Thank you for being interested in our products and registering for trial licenses, we have received your data and we will contact you immediately for trial account information');
    
    /*    $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            ''
        ];
        $destination = public_path('storage\temp');
        $name_excel = 'Request_Trial'.date('YmdHis');
        $file = $destination ."\\". $name_excel.'.xls';

        \Excel::create($name_excel,  function($excel) use($params, $styleHeader){
            $excel->sheet('Customer',  function($sheet) use($params){
            
            $sheet->cell('A1:F1', function($cell) {
                     $cell->setFontSize(12);
                     $cell->setBackground('#EEEEEE');
                     $cell->setFontWeight('bold');
                     $cell->setBorder('solid');
                 });

            $borderArray = array(
                 'borders' => array(
                     'outline' => array(
                         'style' => \PHPExcel_Style_Border::BORDER_THICK,
                         'color' => array('argb' => 'FFFF0000'),
                     ),
                 ),
             );

             $sheet->fromArray($params, null, 'A1', true);

            });

             $excel->getActiveSheet()->getStyle('A1:F2')->applyFromArray($styleHeader);

        })->save('xls', $destination, true);

       $params['text']     = 'Test Free Trial';
        
        \Mail::send('email.trial-account', $params,
            function($message) use($request, $file, $name_excel, $destination) {
                $message->from($request->email);
                $message->to('farros.jackson@gmail.com');
                $message->subject('Request Trial');
                $message->attach($file, array(
                    'as' => $name_excel .'.xls',
                    'mime' => 'application/xls'
                    )
            );
            }
        );  */

    }


}
 
