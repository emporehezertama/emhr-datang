r<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalReimbursement;
use App\Models\MedicalReimbursementForm;
use App\User;

class MedicalController extends Controller
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
        $params['data'] = MedicalReimbursement::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.medical.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('karyawan.medical.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = MedicalReimbursement::where('id', $id)->first();;
        $params['form'] = MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
        $params['karyawan'] = User::whereIn('access_id', [1,2])->get();

        return view('karyawan.medical.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = MedicalReimbursement::where('id', $id)->first();
        $data->tanggal_pengajuan = $request->tanggal_pengajuan;
        $data->status       = 1;  
        $data->save();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id           = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];
            $form->save();
        }

        return redirect()->route('karyawan.medical.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = MedicalReimbursement::where('id', $id)->first();
        $data->delete();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        return redirect()->route('karyawan.medical.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new MedicalReimbursement();
        $data->user_id              = \Auth::user()->id;
        $data->tanggal_pengajuan    = $request->tanggal_pengajuan;
        $data->status               = 1;  
        $data->approved_atasan_id   = $request->atasan_user_id; 
        $data->approve_direktur_id      = get_direktur(\Auth::user()->id)->id; 
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }
        $data->save();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id              = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];

            if (request()->hasFile('file_bukti_transaksi'))
            {
                $file = $request->file('file_bukti_transaksi');

                foreach($file as $k => $f)
                {
                    if($k == $key)
                    {
                        $fname = md5($f->getClientOriginalName() . time()) . "." . $f->getClientOriginalExtension();

                        $destinationPath = public_path('/storage/file-medical/');
                        $f->move($destinationPath, $fname);
                        $form->file_bukti_transaksi = $fname;
                    }
                }
            }

            $form->save();
        }

        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Sir/Madam '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Medical Reimbursement and currently waiting your approval.</p>';

        \Mail::send('email.medical-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Medical Reimbursement');
            }
        );

        return redirect()->route('karyawan.medical.index')->with('message-success', 'You have successfully submitted Medical Reimbursement !');
    }
}
