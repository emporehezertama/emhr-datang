<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\PaymentRequestForm;
use App\User;

class PaymentRequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PaymentRequest::select('payment_request.*')->orderBy('id', 'DESC')->join('users', 'users.id', '=', 'payment_request.user_id');

        if(request())
        {
            if(!empty(request()->employee_status))
            {
                $data = $data->where('users.organisasi_status', request()->employee_status);
            }

            if(!empty(request()->jabatan))
            {   
                if(request()->jabatan == 'Direktur')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->whereNull('users.empore_organisasi_manager_id')->where('users.empore_organisasi_direktur', '<>', '');
                }

                if(request()->jabatan == 'Manager')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->where('users.empore_organisasi_manager_id', '<>', '');
                }

                if(request()->jabatan == 'Staff')
                {
                    $data = $data->where('users.empore_organisasi_staff_id', '<>', '');
                }
            }

            if(request()->action == 'download')
            {
                $this->downloadExcel($data->get());
            }
        }

        $params['data'] = $data->get();

        return view('administrator.payment-request.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('administrator.payment-request.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = PaymentRequest::where('id', $id)->first();
        $params['karyawan']     = User::where('access_id', 2)->get();
        $params['form']         = PaymentRequestForm::where('payment_request_id', $id)->get();

        return view('administrator.payment-request.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = PaymentRequest::where('id', $id)->first();
        $data->save();

        return redirect()->route('administrator.payment-request.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = PaymentRequest::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.payment-request.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [batal description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function batal(Request $request)
    {
        $data = PaymentRequest::where('id', $request->id)->first();
        $data->note_pembatalan = $request->note;
        $data->status = 4;
        $data->save();

        return redirect()->route('administrator.payment-request.index')->with('messages-success', 'Payment Request successfully rejected !');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new PaymentRequest();
        $data->user_id              = $request->from_user_id;
        $data->transaction_type     = $request->transaction_type;
        $data->payment_method       = $request->payment_method;
        $data->tujuan               = $request->tujuan;
        $data->nama_pemilik_rekening = $request->nama_pemilik_rekening;
        $data->no_rekening          = $request->no_rekening;
        $data->nama_bank            = $request->nama_bank;
        $data->nominal_pembayaran   = $request->nominal_pembayaran;
        $data->status               = 1;
        $data->save();

        $form = new PaymentRequestForm();
        foreach($request->description as $key => $item)
        {
            $form->payment_request_id   = $data->id;
            $form->description          = $item;
            $form->quantity             = $request->quantity[$key];
            $form->estimation_cost      = $request->estimation_cost[$key];
            $form->amount               = $request->amount[$key];
            $form->save();
        }

        return redirect()->route('administrator.payment-request.index')->with('message-success', 'Data successfully saved!');
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        $total_loop_header = [];
        foreach($data as $no =>  $item)
        {
            $total = 0;
            foreach($item->payment_request_form as $type => $form)
            {
                $total++;
            }
            $total_loop_header[] = $total;
        }

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']              = $item->user->nik;
            $params[$no]['NAME']    = $item->user->name;
            $params[$no]['POSITION']         = empore_jabatan($item->user_id);
            $params[$no]['DATE REQUEST']    = date('d F Y', strtotime($item->created_at));
            $params[$no]['PURPOSE']           = $item->tujuan;
            $params[$no]['TRANSACTION TYPE']  = $item->transaction_type;
            $params[$no]['PAYMENT METHOD']  = $item->payment_method;

            $total=0;
            foreach($item->payment_request_form as $type => $form)
            {   
                $type = $type+1;
                $params[$no]['TYPE '.$type]             = $form->type_form;
                $params[$no]['DESCRIPTION '.$type]      = $form->description;
                $params[$no]['QUANTITY '.$type]         = $form->quantity;
                $params[$no]['ESTIMATION COST '.$type]  = $form->estimation_cost;
                $params[$no]['AMOUNT '.$type]           = $form->amount;
                $params[$no]['AMOUNT APPROVED '.$type]  = $form->nominal_approved;
                $total++;       
            }
            if($total ==0 ) $total++;
            for($v=$total; $v < max($total_loop_header); $v++)
            {
                $params[$no]['TYPE '. ($v+1)]             = "-";
                $params[$no]['DESCRIPTION '.($v+1)]      = "-";
                $params[$no]['QUANTITY '.($v+1)]         = "-";
                $params[$no]['ESTIMATION COST '.($v+1)]  = "-";
                $params[$no]['AMOUNT '.($v+1)]           = "-";
                $params[$no]['AMOUNT APPROVED '.($v+1)]  = "-";
            }
            $params[$no]['DATE APPROVAL']     = $item->approve_direktur_date !== NULL ? date('d F Y', strtotime($item->approve_direktur_date)) : '';
            $params[$no]['DIRECTOR NAME']       = isset($item->direktur->name) ? $item->direktur->name : "";
        }

        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
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

        return \Excel::create('Report-Payment-Request-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);
        })->download('xls');
    }
}