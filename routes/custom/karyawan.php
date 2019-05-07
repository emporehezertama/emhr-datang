<?php 
// ROUTING KARYAWAN
Route::group(['prefix' => 'karyawan', 'namespace'=>'Karyawan', 'middleware' => ['auth', 'access:2']], function(){
	Route::get('/', 'IndexController@index')->name('karyawan.dashboard');
	Route::resource('medical', 'MedicalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('medical', 'MedicalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('overtime', 'OvertimeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('payment-request', 'PaymentRequestController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('exit-clearance', 'ExitClearanceController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('exit-interview', 'ExitInterviewController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('exit-inteview/detail/{id}',  'ExitInterviewController@detail')->name('karyawan.exit-interview.detail');
	#Route::resource('compassionate-reason', 'CompassionateReasonController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('training', 'TrainingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('training/biaya/{id}', 'TrainingController@biaya')->name('karyawan.training.biaya');
	Route::get('training/detail/{id}', 'TrainingController@detailTraining')->name('karyawan.training.detail');
	Route::post('training/submit-biaya', 'TrainingController@submitBiaya')->name('karyawan.training.submit-biaya');
	Route::resource('cuti', 'CutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	
	Route::resource('leave', 'LeaveController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('approval-leave-custom',  'ApprovalLeaveCustomController@index')->name('karyawan.approval.leave-custom.index');
	Route::get('approval-leave-custom/detail/{id}',  'ApprovalLeaveCustomController@detail')->name('karyawan.approval.leave-custom.detail');
	Route::post('approval-leave-custom/proses',  'ApprovalLeaveCustomController@proses')->name('karyawan.approval.leave-custom.proses');

	Route::resource('payment-request-custom', 'PaymentRequestCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('approval-payment-request-custom',  'ApprovalPaymentRequestCustomController@index')->name('karyawan.approval.payment-request-custom.index');
	Route::get('approval-payment-request-custom/detail/{id}',  'ApprovalPaymentRequestCustomController@detail')->name('karyawan.approval.payment-request-custom.detail');
	Route::post('approval-payment-request-custom/proses',  'ApprovalPaymentRequestCustomController@proses')->name('karyawan.approval.payment-request-custom.proses');

	Route::resource('overtime-custom', 'OvertimeCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('overtime-custom/claim/{id}',  'OvertimeCustomController@claim')->name('karyawan.overtime-custom.claim');
	Route::post('overtime-custom/prosesclaim',  'OvertimeCustomController@prosesclaim')->name('karyawan.overtime-custom.prosesclaim');
	Route::get('approval-overtime-custom',  'ApprovalOvertimeCustomController@index')->name('karyawan.approval.overtime-custom.index');
	Route::get('approval-overtime-custom/detail/{id}',  'ApprovalOvertimeCustomController@detail')->name('karyawan.approval.overtime-custom.detail');
	Route::post('approval-overtime-custom/proses',  'ApprovalOvertimeCustomController@proses')->name('karyawan.approval.overtime-custom.proses');
	Route::get('approval-overtime-custom/claim/{id}',  'ApprovalOvertimeCustomController@claim')->name('karyawan.approval.overtime-custom.claim');
	Route::post('approval-overtime-custom/prosesClaim',  'ApprovalOvertimeCustomController@prosesClaim')->name('karyawan.approval.overtime-custom.prosesClaim');

	Route::resource('training-custom', 'TrainingCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('training-custom/claim/{id}',  'TrainingCustomController@claim')->name('karyawan.training-custom.claim');
	Route::post('training-custom/prosesclaim',  'TrainingCustomController@prosesclaim')->name('karyawan.training-custom.prosesclaim');
	Route::get('approval-training-custom',  'ApprovalTrainingCustomController@index')->name('karyawan.approval.training-custom.index');
	Route::get('approval-training-custom/detail/{id}',  'ApprovalTrainingCustomController@detail')->name('karyawan.approval.training-custom.detail');
	Route::post('approval-training-custom/proses',  'ApprovalTrainingCustomController@proses')->name('karyawan.approval.training-custom.proses');
	Route::get('approval-training-custom/claim/{id}',  'ApprovalTrainingCustomController@claim')->name('karyawan.approval.training-custom.claim');
	Route::post('approval-training-custom/prosesClaim',  'ApprovalTrainingCustomController@prosesClaim')->name('karyawan.approval.training-custom.prosesClaim');

	Route::resource('medical-custom', 'MedicalCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('approval-medical-custom',  'ApprovalMedicalCustomController@index')->name('karyawan.approval.medical-custom.index');
	Route::get('approval-medical-custom/detail/{id}',  'ApprovalMedicalCustomController@detail')->name('karyawan.approval.medical-custom.detail');
	Route::post('approval-medical-custom/proses',  'ApprovalMedicalCustomController@proses')->name('karyawan.approval.medical-custom.proses');

	Route::resource('exit-custom', 'ExitInterviewCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('exit-custom/clearance/{id}',  'ExitInterviewCustomController@clearance')->name('karyawan.exit-custom.clearance');
	Route::post('exit-custom/prosesclearance',  'ExitInterviewCustomController@prosesclearance')->name('karyawan.exit-custom.prosesclearance');
	Route::get('approval-exit-custom',  'ApprovalExitInterviewCustomController@index')->name('karyawan.approval.exit-custom.index');
	Route::get('approval-exit-custom/detail/{id}',  'ApprovalExitInterviewCustomController@detail')->name('karyawan.approval.exit-custom.detail');
	Route::post('approval-exit-custom/proses',  'ApprovalExitInterviewCustomController@proses')->name('karyawan.approval.exit-custom.proses');

	Route::get('approval-clearance-custom', 'ApprovalExitClearanceCustomController@index')->name('karyawan.approval.clearance-custom.index');
	Route::get('approval-clearance-custom/detail/{id}', 'ApprovalExitClearanceCustomController@detail')->name('karyawan.approval.clearance-custom.detail');
	Route::post('approval-clearance-custom/proses', 'ApprovalExitClearanceCustomController@proses')->name('karyawan.approval.clearance-custom.proses');
	

	Route::get('approval-cuti',  'ApprovalCutiController@index')->name('karyawan.approval.cuti.index');
	Route::get('approval-cuti/detail/{id}',  'ApprovalCutiController@detail')->name('karyawan.approval.cuti.detail');
	Route::post('approval-cuti/proses',  'ApprovalCutiController@proses')->name('karyawan.approval.cuti.proses');
	Route::get('approval-cuti-atasan',  'ApprovalCutiAtasanController@index')->name('karyawan.approval.cuti-atasan.index');
	Route::get('approval-cuti-atasan/detail/{id}',  'ApprovalCutiAtasanController@detail')->name('karyawan.approval.cuti-atasan.detail');
	Route::post('approval-cuti-atasan/proses',  'ApprovalCutiAtasanController@proses')->name('karyawan.approval.cuti-atasan.proses');
	Route::get('approval-payment-request',  'ApprovalPaymentRequestController@index')->name('karyawan.approval.payment_request.index');
	Route::get('approval-payment-request/detail/{id}',  'ApprovalPaymentRequestController@detail')->name('karyawan.approval.payment_request.detail');
	Route::post('approval-payment-request/proses',  'ApprovalPaymentRequestController@proses')->name('karyawan.approval.payment_request.proses');
	Route::get('approval-payment-request-atasan',  'ApprovalPaymentRequestAtasanController@index')->name('karyawan.approval.payment-request-atasan.index');
	Route::get('approval-payment-request-atasan/detail/{id}',  'ApprovalPaymentRequestAtasanController@detail')->name('karyawan.approval.payment-request-atasan.detail');
	Route::post('approval-payment-request-atasan/proses',  'ApprovalPaymentRequestAtasanController@proses')->name('karyawan.approval.payment-request-atasan.proses');
	Route::get('approval-medical',  'ApprovalMedicalController@index')->name('karyawan.approval.medical.index');
	Route::get('approval-medical/detail/{id}',  'ApprovalMedicalController@detail')->name('karyawan.approval.medical.detail');
	Route::post('approval-medical/proses',  'ApprovalMedicalController@proses')->name('karyawan.approval.medical.proses');
	Route::get('approval-exit',  'ApprovalExitController@index')->name('karyawan.approval.exit.index');
	Route::get('approval-exit/detail/{id}',  'ApprovalExitController@detail')->name('karyawan.approval.exit.detail');
	Route::post('approval-exit/proses',  'ApprovalExitController@proses')->name('karyawan.approval.exit.proses');
	Route::get('approval-exit-clearance',  'ApprovalExitController@index')->name('karyawan.approval.exit_clearance.index');
	Route::get('approval-exit-clearance/detail/{id}',  'ApprovalExitController@detail')->name('karyawan.approval.exit_clearance.detail');
	Route::post('approval-exit-clearance/proses',  'ApprovalExitController@proses')->name('karyawan.approval.exit_clearance.proses');
	Route::get('approval-training',  'ApprovalTrainingController@index')->name('karyawan.approval.training.index');
	Route::get('approval-training/detail/{id}',  'ApprovalTrainingController@detail')->name('karyawan.approval.training.detail');
	Route::post('approval-training/proses',  'ApprovalTrainingController@proses')->name('karyawan.approval.training.proses');
	Route::get('approval-training/biaya/{id}',  'ApprovalTrainingController@biaya')->name('karyawan.approval.training.biaya');
	Route::post('approval-training/proses-biaya',  'ApprovalTrainingController@prosesBiaya')->name('karyawan.approval.training.proses-biaya');
	Route::get('approval-training-atasan',  'ApprovalTrainingAtasanController@index')->name('karyawan.approval.training-atasan.index');
	Route::get('approval-training-atasan/detail/{id}',  'ApprovalTrainingAtasanController@detail')->name('karyawan.approval.training-atasan.detail');
	Route::post('approval-training-atasan/proses',  'ApprovalTrainingAtasanController@proses')->name('karyawan.approval.training-atasan.proses');
	Route::post('approval-training-atasan/biaya',  'ApprovalTrainingAtasanController@biaya')->name('karyawan.approval.training-atasan.biaya');
	Route::get('approval-training-atasan/biaya/{id}',  'ApprovalTrainingAtasanController@biaya')->name('karyawan.approval.training-atasan.biaya');
	Route::post('approval-training-atasan/proses-biaya',  'ApprovalTrainingAtasanController@prosesBiaya')->name('karyawan.approval.training-atasan.proses-biaya');
	Route::get('approval-overtime',  'ApprovalOvertimeController@index')->name('karyawan.approval.overtime.index');
	Route::get('approval-overtime/detail/{id}',  'ApprovalOvertimeController@detail')->name('karyawan.approval.overtime.detail');
	Route::post('approval-overtime/proses',  'ApprovalOvertimeController@proses')->name('karyawan.approval.overtime.proses');
	Route::get('approval-overtime-atasan',  'ApprovalOvertimeAtasanController@index')->name('karyawan.approval.overtime-atasan.index');
	Route::get('approval-overtime-atasan/detail/{id}',  'ApprovalOvertimeAtasanController@detail')->name('karyawan.approval.overtime-atasan.detail');
	Route::post('approval-overtime-atasan/proses',  'ApprovalOvertimeAtasanController@proses')->name('karyawan.approval.overtime-atasan.proses');
	Route::get('approval-medical-atasan',  'ApprovalMedicalAtasanController@index')->name('karyawan.approval.medical-atasan.index');
	Route::get('approval-medical-atasan/detail/{id}',  'ApprovalMedicalAtasanController@detail')->name('karyawan.approval.medical-atasan.detail');
	Route::post('approval-medical-atasan/proses',  'ApprovalMedicalAtasanController@proses')->name('karyawan.approval.medical-atasan.proses');
	Route::get('approval-exit-atasan',  'ApprovalExitAtasanController@index')->name('karyawan.approval.exit-atasan.index');
	Route::get('approval-exit-atasan/detail/{id}',  'ApprovalExitAtasanController@detail')->name('karyawan.approval.exit-atasan.detail');
	Route::post('approval-exit-atasan/proses',  'ApprovalExitAtasanController@proses')->name('karyawan.approval.exit-atasan.proses');
	Route::get('news/readmore/{id}',  'IndexController@readmore')->name('karyawan.news.readmore');
	Route::get('karyawan/find', 'IndexController@find')->name('karyawan.karyawan.find');
	Route::get('karyawan/profile', 'IndexController@profile')->name('karyawan.profile');
	Route::get('karyawan/traning/detail-all/{id}', 'TrainingController@detailAll')->name('karyawan.training.detail-all');
	Route::get('karyawan/download-internal-memo/{id}', 'IndexController@downloadInternalMemo')->name('karyawan.download-internal-memo');
	Route::get('karyawan/download-peraturan-perusahaan/{id}', 'IndexController@downloadPeraturanPerusahaan')->name('karyawan.download-peraturan-perusahaan');
	Route::get('karyawan/news/more', 'IndexController@newsmore')->name('karyawan.news.more');
	Route::get('karyawan/internal-memo/more', 'IndexController@internalMemoMore')->name('karyawan.internal-memo.more');
	Route::resource('request-pay-slip', 'RequestPaySlipController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('request-pay-slipnet', 'RequestPaySlipNetController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::resource('request-pay-slipgross', 'RequestPaySlipGrossController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('karyawan/backtoadministrator', 'IndexController@backtoadministrator')->name('karyawan.back-to-administrator');
});