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
            'email' => 'email:required',
            'company' => 'required',
            'phone' => 'required',
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
        $nama_perusahaan   = $request['company'];
        $handphone         = $request['phone'];

        $destination = storage_path('app');
        $name_excel = 'Request_Trial'.date('YmdHis');
        $file = $destination ."//". $name_excel.'.xlsx';

        Excel::store(new ClientExport($nama, $email, $nama_perusahaan, $handphone), $name_excel.'.xlsx');
    
        $params['text']     = 'Request Free Trial Absensi Digital';
        $emailto = ['marketing@empore.co.id'];
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
    
    }


}
 
