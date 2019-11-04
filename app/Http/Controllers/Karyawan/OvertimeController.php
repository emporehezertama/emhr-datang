<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OvertimeSheet;
use App\Models\OvertimeSheetForm;
use App\User;

class OvertimeController extends Controller
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
        $params['data'] = OvertimeSheet::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.overtime.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', \Auth::user()->id)->get();

        return view('karyawan.overtime.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = OvertimeSheet::where('id', $id)->first();

        return view('karyawan.overtime.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data               = OvertimeSheet::where('id', $id)->first();
        $form->description  = $request->description[$key];
        $form->awal         = $request->awal[$key];
        $form->akhir        = $request->akhir[$key];
        $form->total_lembur = $request->total_lembur[$key];
        $form->tanggal      = $request->tanggal;
        $form->save();

        return redirect()->route('karyawan.overtime.index')->with('message-success', 'Data successfully saved');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = OvertimeSheet::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.overtima.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new OvertimeSheet();
        $data->user_id              = \Auth::user()->id;
        $data->status               = 1;  
        $data->approved_atasan_id   = $request->atasan_user_id; 
        $data->approve_direktur_id      = get_direktur(\Auth::user()->id)->id; 
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }
        $data->save();

        foreach($request->tanggal as $key => $item)
        {   
            $form               = new OvertimeSheetForm();
            $form->overtime_sheet_id= $data->id;
            $form->description  = $request->description[$key];
            $form->awal         = $request->awal[$key];
            $form->akhir        = $request->akhir[$key];
            $form->total_lembur = $request->total_lembur[$key];
            $form->tanggal      = $request->tanggal[$key];
            $form->save();
        }

        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Sir/Madam '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' applied for Overtime and currently waiting your approval.</p>';

        \Mail::send('email.overtime-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Pengajuan Overtime');
            }
        );

        return redirect()->route('karyawan.overtime.index')->with('message-success', 'Data successfully saved!');
    }
}
