<?php

/**
 * Administrator Routing
 */
Route::group(['prefix' => 'administrator', 'namespace'=>'Administrator', 'middleware' => ['auth', 'access:1']], function(){
	
	Route::get('user-login', 'LoginController@user-login')->name('administrator.payroll.detail-history');

	Route::get('/', 'IndexController@index')->name('administrator.dashboard');
	Route::resource('karyawan', 'KaryawanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('department', 'DepartmentController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('provinsi', 'ProvinsiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kabupaten', 'KabupatenController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kecamatan', 'KecamatanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kelurahan', 'KelurahanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('training', 'TrainingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('training-type', 'TrainingTypeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('cuti', 'CutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('overtime', 'OvertimeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('payment-request', 'PaymentRequestController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('exit-clearance', 'ExitClearanceController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('exit-interview', 'ExitInterviewController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('directorate', 'DirectorateController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('division', 'DivisionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('position', 'PositionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('section', 'SectionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('overtime', 'OvertimeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('cabang', 'CabangController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('medical', 'MedicalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('bank', 'BankController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('universitas', 'UniversitasController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('program-studi', 'ProgramStudiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('jurusan', 'JurusanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('sekolah', 'SekolahController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('alasan-pengunduran-diri', 'AlasanPengunduranDiriSettingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('training/detail/{id}',  'TrainingController@detail')->name('administrator.training.detail');
	Route::post('training/proses',  'TrainingController@proses')->name('administrator.training.proses');
	Route::get('training/biaya/{id}', 'TrainingController@biaya')->name('administrator.training.biaya');
	Route::post('training/proses-biaya', 'TrainingController@prosesBiaya')->name('administrator.training.proses-biaya');
	Route::resource('setting-cuti', 'SettingCutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('setting-payment-request', 'SettingPaymentRequestController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-medical', 'SettingMedicalController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-overtime', 'SettingOvertimeController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-exit', 'SettingExitController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-training', 'SettingTrainingController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-master-cuti', 'SettingMasterCutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('setting-exit-clearance', 'SettingExitClearanceController', ['as' => 'administrator']);
	Route::resource('cuti-bersama', 'CutiBersamaController', ['as' => 'administrator']);
	Route::get('structure', 'IndexController@structure')->name('administrator.structure');
	Route::resource('setting', 'SettingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);

	Route::resource('setting-approvalLeave', 'SettingApprovalLeaveController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalLeave/indexItem/{id}', 'SettingApprovalLeaveController@indexItem')->name('administrator.setting-approvalLeave.indexItem');
	Route::get('setting-approvalLeave/createItem/{id}', 'SettingApprovalLeaveController@createItem')->name('administrator.setting-approvalLeave.createItem');
	Route::post('setting-approvalLeave/storeItem', 'SettingApprovalLeaveController@storeItem')->name('administrator.setting-approvalLeave.storeItem');
	Route::get('setting-approvalLeave/editItem/{id}', 'SettingApprovalLeaveController@editItem')->name('administrator.setting-approvalLeave.editItem');
	Route::post('setting-approvalLeave/updateItem/{id}', 'SettingApprovalLeaveController@updateItem')->name('administrator.setting-approvalLeave.updateItem');
	Route::post('setting-approvalLeave/destroyItem/{id}', 'SettingApprovalLeaveController@destroyItem')->name('administrator.setting-approvalLeave.destroyItem');

	Route::resource('setting-approvalPaymentRequest', 'SettingApprovalPaymentRequestController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalPaymentRequest/indexItem/{id}', 'SettingApprovalPaymentRequestController@indexItem')->name('administrator.setting-approvalPaymentRequest.indexItem');
	Route::get('setting-approvalPaymentRequest/createItem/{id}', 'SettingApprovalPaymentRequestController@createItem')->name('administrator.setting-approvalPaymentRequest.createItem');
	Route::post('setting-approvalPaymentRequest/storeItem', 'SettingApprovalPaymentRequestController@storeItem')->name('administrator.setting-approvalPaymentRequest.storeItem');
	Route::get('setting-approvalPaymentRequest/editItem/{id}', 'SettingApprovalPaymentRequestController@editItem')->name('administrator.setting-approvalPaymentRequest.editItem');
	Route::post('setting-approvalPaymentRequest/updateItem/{id}', 'SettingApprovalPaymentRequestController@updateItem')->name('administrator.setting-approvalPaymentRequest.updateItem');
	Route::post('setting-approvalPaymentRequest/destroyItem/{id}', 'SettingApprovalPaymentRequestController@destroyItem')->name('administrator.setting-approvalPaymentRequest.destroyItem');

	Route::resource('setting-approvalOvertime', 'SettingApprovalOvertimeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalOvertime/indexItem/{id}', 'SettingApprovalOvertimeController@indexItem')->name('administrator.setting-approvalOvertime.indexItem');
	Route::get('setting-approvalOvertime/createItem/{id}', 'SettingApprovalOvertimeController@createItem')->name('administrator.setting-approvalOvertime.createItem');
	Route::post('setting-approvalOvertime/storeItem', 'SettingApprovalOvertimeController@storeItem')->name('administrator.setting-approvalOvertime.storeItem');
	Route::get('setting-approvalOvertime/editItem/{id}', 'SettingApprovalOvertimeController@editItem')->name('administrator.setting-approvalOvertime.editItem');
	Route::post('setting-approvalOvertime/updateItem/{id}', 'SettingApprovalOvertimeController@updateItem')->name('administrator.setting-approvalOvertime.updateItem');
	Route::post('setting-approvalOvertime/destroyItem/{id}', 'SettingApprovalOvertimeController@destroyItem')->name('administrator.setting-approvalOvertime.destroyItem');

	Route::resource('setting-approvalTraining', 'SettingApprovalTrainingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalTraining/indexItem/{id}', 'SettingApprovalTrainingController@indexItem')->name('administrator.setting-approvalTraining.indexItem');
	Route::get('setting-approvalTraining/createItem/{id}', 'SettingApprovalTrainingController@createItem')->name('administrator.setting-approvalTraining.createItem');
	Route::post('setting-approvalTraining/storeItem', 'SettingApprovalTrainingController@storeItem')->name('administrator.setting-approvalTraining.storeItem');
	Route::get('setting-approvalTraining/editItem/{id}', 'SettingApprovalTrainingController@editItem')->name('administrator.setting-approvalTraining.editItem');
	Route::post('setting-approvalTraining/updateItem/{id}', 'SettingApprovalTrainingController@updateItem')->name('administrator.setting-approvalTraining.updateItem');
	Route::post('setting-approvalTraining/destroyItem/{id}', 'SettingApprovalTrainingController@destroyItem')->name('administrator.setting-approvalTraining.destroyItem');

    Route::resource('medical-plafond', 'MedicalPlafondController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
    Route::get('medical-plafond/create-medical-plafond', 'MedicalPlafondController@createMedicalPlafond')->name('administrator.medical-plafond.create-medical-plafond');
	Route::post('medical-plafond/store-medical-plafond', 'MedicalPlafondController@storeMedicalPlafond')->name('administrator.medical-plafond.store-medical-plafond');
	Route::get('medical-plafond/edit-medical-plafond/{id}', 'MedicalPlafondController@editMedicalPlafond')->name('administrator.medical-plafond.edit-medical-plafond');
	Route::post('medical-plafond/update-lmedical-plafond/{id}', 'MedicalPlafondController@updateMedicalPlafond')->name('administrator.medical-plafond.update-medical-plafond');
	Route::get('medical-plafond/destroy-medical-plafond/{id}', 'MedicalPlafondController@deleteMedicalPlafond')->name('administrator.medical-plafond.destroy-medical-plafond');

	Route::resource('setting-approvalMedical', 'SettingApprovalMedicalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalMedical/indexItem/{id}', 'SettingApprovalMedicalController@indexItem')->name('administrator.setting-approvalMedical.indexItem');
	Route::get('setting-approvalMedical/createItem/{id}', 'SettingApprovalMedicalController@createItem')->name('administrator.setting-approvalMedical.createItem');
	Route::post('setting-approvalMedical/storeItem', 'SettingApprovalMedicalController@storeItem')->name('administrator.setting-approvalMedical.storeItem');
	Route::get('setting-approvalMedical/editItem/{id}', 'SettingApprovalMedicalController@editItem')->name('administrator.setting-approvalMedical.editItem');
	Route::post('setting-approvalMedical/updateItem/{id}', 'SettingApprovalMedicalController@updateItem')->name('administrator.setting-approvalMedical.updateItem');
	Route::post('setting-approvalMedical/destroyItem/{id}', 'SettingApprovalMedicalController@destroyItem')->name('administrator.setting-approvalMedical.destroyItem');

	Route::resource('setting-approvalExit', 'SettingApprovalExitController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting-approvalExit/indexItem/{id}', 'SettingApprovalExitController@indexItem')->name('administrator.setting-approvalExit.indexItem');
	Route::get('setting-approvalExit/createItem/{id}', 'SettingApprovalExitController@createItem')->name('administrator.setting-approvalExit.createItem');
	Route::post('setting-approvalExit/storeItem', 'SettingApprovalExitController@storeItem')->name('administrator.setting-approvalExit.storeItem');
	Route::get('setting-approvalExit/editItem/{id}', 'SettingApprovalExitController@editItem')->name('administrator.setting-approvalExit.editItem');
	Route::post('setting-approvalExit/updateItem/{id}', 'SettingApprovalExitController@updateItem')->name('administrator.setting-approvalExit.updateItem');
	Route::post('setting-approvalExit/destroyItem/{id}', 'SettingApprovalExitController@destroyItem')->name('administrator.setting-approvalExit.destroyItem');

	Route::resource('setting-approvalClearance', 'SettingApprovalClearanceController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);

	Route::resource('news', 'NewsController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('internal-memo', 'InternalMemoController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('branch-organisasi', 'BranchOrganisasiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('branch-staff', 'BranchStaffController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('libur-nasional', 'LiburNasionalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('plafond-dinas', 'PlafondDinasController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('position', 'PositionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('job-rule', 'JobRuleController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::post('libur-nasional/import', 'LiburNasionalController@import')->name('administrator.libur-nasional.import');
	Route::post('cabang/import', 'CabangController@import')->name('administrator.cabang.import');
	Route::post('plafond-dinas/import', 'PlafondDinasController@import')->name('administrator.plafond-dinas.import');
	Route::get('plafond-dinas/create-luar-negeri', 'PlafondDinasController@createLuarNegeri')->name('administrator.plafond-dinas.create-luar-negeri');
	Route::post('plafond-dinas/store-luar-negeri', 'PlafondDinasController@storeLuarNegeri')->name('administrator.plafond-dinas.store-luar-negeri');
	Route::get('plafond-dinas/edit-luar-negeri/{id}', 'PlafondDinasController@editLuarNegeri')->name('administrator.plafond-dinas.edit-luar-negeri');
	Route::post('plafond-dinas/update-luar-negeri/{id}', 'PlafondDinasController@updateLuarNegeri')->name('administrator.plafond-dinas.update-luar-negeri');
	Route::get('plafond-dinas/destroy-luar-negeri/{id}', 'PlafondDinasController@deleteLuarNegeri')->name('administrator.plafond-dinas.destroy-luar-negeri');
	
	Route::get('branch-organisasi/tree', 'BranchOrganisasiController@tree')->name('administrator.branch-organisasi.tree');
	Route::get('karyawan/delete-cuti/{id}', 'KaryawanController@DeleteCuti')->name('administrator.karyawan.delete-cuti');
	Route::post('karyawan/import', 'KaryawanController@importData')->name('administrator.karyawan.import');
	Route::get('karyawan/preview-import', 'KaryawanController@previewImport')->name('administrator.karyawan.preview-import');
	Route::get('karyawan/delete-temp/{id}', 'KaryawanController@deleteTemp')->name('administrator.karyawan.delete-temp');
	Route::get('karyawan/detail-temp/{id}', 'KaryawanController@detailTemp')->name('administrator.karyawan.detail-temp');
	Route::get('karyawan/import-all', 'KaryawanController@importAll')->name('administrator.karyawan.import-all');
	Route::get('karyawan/print-profile/{id}', 'KaryawanController@printProfile')->name('administrator.karyawan.print-profile');
	Route::get('karyawan/delete-old-user/{id}', 'KaryawanController@deleteOldUser')->name('administrator.karyawan.delete-old-user');
	Route::get('karyawan/downloadExcel','KaryawanController@downloadExcel')->name('administrator.karyawan.downloadExcel');
	Route::post('karyawan', 'KaryawanController@index')->name('administrator.karyawan.index');
	Route::post('karyawan/store', 'KaryawanController@store')->name('administrator.karyawan.store');
	Route::get('absensi/index', 'AbsensiController@index')->name('administrator.absensi.index');
	Route::get('absensi/import', 'AbsensiController@import')->name('administrator.absensi.import');
	Route::post('absensi/temp-import', 'AbsensiController@tempImport')->name('administrator.absensi.temp-import');
	Route::get('absensi/preview-temp', 'AbsensiController@previewTemp')->name('administrator.absensi.preview-temp');
	Route::get('absensi/import-all', 'AbsensiController@importAll')->name('administrator.absensi.import-all');
	Route::get('absensi/deletenew/{id}', 'AbsensiController@deleteNew')->name('administrator.absensi.deletenew');
	Route::get('absensi/deleteold/{id}', 'AbsensiController@deleteOld')->name('administrator.absensi.deleteold');
	Route::get('absensi/detail/{id}', 'AbsensiController@detail')->name('administrator.absensi.detail');
	Route::post('cuti/batal', 'CutiController@batal')->name('administrator.cuti.batal');
	Route::post('training/batal', 'TrainingController@batal')->name('administrator.training.batal');
	Route::get('cuti/proses/{id}', 'CutiController@proses')->name('administrator.cuti.proses');
	Route::post('cuti/submit-proses', 'CutiController@submitProses')->name('administrator.cuti.submit-proses');
	Route::post('payment-request/batal', 'PaymentRequestController@batal')->name('administrator.payment-request.batal');
	Route::get('exit-inteview/detail/{id}', 'ExitInterviewController@detail')->name('administrator.exit-interview.detail');
	Route::post('exit-interview/proses', 'ExitInterviewController@proses')->name('administrator.exit-interview.proses');
	Route::get('cuti/delete/{id}', 'CutiController@delete')->name('administrator.cuti.delete');
	Route::get('setting-master-cuti/delete/{id}', 'SettingMasterCutiController@delete')->name('administrator.setting-master-cuti.delete');
	Route::resource('peraturan-perusahaan', 'PeraturanPerusahaanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('payroll', 'PayrollController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	#Route::resource('payrollnet', 'PayrollNetController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	#Route::resource('payrollgross', 'PayrollGrossController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('payroll/import', 'PayrollController@import')->name('administrator.payroll.import');
	Route::get('payroll/download', 'PayrollController@download')->name('administrator.payroll.download');
	Route::get('payroll/delete-earning-payroll/{id}', 'PayrollController@deleteEarningPayroll')->name('administrator.payroll.delete-earning-payroll');
	Route::get('payroll/delete-deduction-payroll/{id}', 'PayrollController@deleteDeductionPayroll')->name('administrator.payroll.delete-deduction-payroll');
	Route::post('payroll/temp-import', 'PayrollController@tempImport')->name('administrator.payroll.temp-import');
	#Route::get('payrollnet/import', 'PayrollNetController@import')->name('administrator.payrollnet.import');
	#Route::get('payrollnet/download', 'PayrollNetController@download')->name('administrator.payrollnet.download');
	#Route::post('payrollnet/temp-import', 'PayrollNetController@tempImport')->name('administrator.payrollnet.temp-import');
	#Route::get('payrollgross/import', 'PayrollGrossController@import')->name('administrator.payrollgross.import');
	#Route::get('payrollgross/download', 'PayrollGrossController@download')->name('administrator.payrollgross.download');
	#Route::post('payrollgross/temp-import', 'PayrollGrossController@tempImport')->name('administrator.payrollgross.temp-import');
	Route::get('payroll-setting', 'PayrollSettingController@index')->name('administrator.payroll-setting.index');
	Route::get('payroll-setting/delete-ptkp/{id}', 'PayrollSettingController@deletePtkp')->name('administrator.payroll-setting.delete-ptkp');
	Route::get('payroll-setting/add-pph', 'PayrollSettingController@addPPH')->name('administrator.payroll-setting.add-pph');
	Route::get('payroll-setting/edit-pph/{id}', 'PayrollSettingController@editPPH')->name('administrator.payroll-setting.edit-pph');
	Route::post('payroll-setting/store-pph', 'PayrollSettingController@storePPH')->name('administrator.payroll-setting.store-pph');
	Route::post('payroll-setting/update-pph/{id}', 'PayrollSettingController@updatePPH')->name('administrator.payroll-setting.update-pph');
	Route::post('payroll-setting/store-deductions', 'PayrollSettingController@storeDeductions')->name('administrator.payroll-setting.store-deductions');
	Route::post('payroll-setting/store-earnings', 'PayrollSettingController@storeEarnings')->name('administrator.payroll-setting.store-earnings');
	Route::get('payroll-setting/delete-pph/{id}', 'PayrollSettingController@deletePPH')->name('administrator.payroll-setting.delete-pph');
	Route::get('payroll-setting/delete-others/{id}', 'PayrollSettingController@deleteOthers')->name('administrator.payroll-setting.delete-others');
	Route::get('payroll-setting/add-others', 'PayrollSettingController@addOthers')->name('administrator.payroll-setting.add-others');
	Route::get('payroll-setting/edit-others/{id}', 'PayrollSettingController@editOthers')->name('administrator.payroll-setting.edit-others');
	Route::post('payroll-setting/update-others/{id}', 'PayrollSettingController@updateOthers')->name('administrator.payroll-setting.update-others');
	Route::get('payroll-setting/edit-npwp/{id}', 'PayrollSettingController@editNpwp')->name('administrator.payroll-setting.edit-npwp');
	Route::post('payroll-setting/store-npwp', 'PayrollSettingController@storeNpwp')->name('administrator.payroll-setting.store-npwp');
	Route::post('payroll-setting/update-npwp/{id}', 'PayrollSettingController@updateNpwp')->name('administrator.payroll-setting.update-npwp');

	Route::get('payroll-setting/edit-ptkp/{id}', 'PayrollSettingController@editPtkp')->name('administrator.payroll-setting.edit-ptkp');
	Route::get('payroll-setting/delete-earnings/{id}', 'PayrollSettingController@deleteEarnings')->name('administrator.payroll-setting.delete-earnings');
	Route::get('payroll-setting/delete-deductions/{id}', 'PayrollSettingController@deleteDeductions')->name('administrator.payroll-setting.delete-deductions');
	Route::post('payroll-setting/update-ptkp/{id}', 'PayrollSettingController@updatePtkp')->name('administrator.payroll-setting.update-ptkp');
	Route::post('payroll-setting/store-others', 'PayrollSettingController@storeOthers')->name('administrator.payroll-setting.store-others');
	Route::post('payroll-setting/store-general', 'PayrollSettingController@storeGeneral')->name('administrator.payroll-setting.store-general');
	Route::get('payroll/calculate', 'PayrollController@calculate')->name('administrator.payroll.calculate');
	Route::get('payroll/detail/{id}', 'PayrollController@detail')->name('administrator.payroll.detail');
	#Route::get('payrollnet/calculate', 'PayrollNetController@calculate')->name('administrator.payrollnet.calculate');
	#Route::get('payrollnet/detail/{id}', 'PayrollNetController@detail')->name('administrator.payrollnet.detail');
	#Route::get('payrollgross/calculate', 'PayrollGrossController@calculate')->name('administrator.payrollgross.calculate');
	#Route::get('payrollgross/detail/{id}', 'PayrollGrossController@detail')->name('administrator.payrollgross.detail');
	Route::resource('asset', 'AssetController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('asset-tracking', 'AssetTrackingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('asset-type', 'AssetTypeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('setting', 'IndexController@setting')->name('administrator.setting.index');
	Route::post('karyawan/upload-dokument-file', 'KaryawanController@uploadDokumentFile')->name('administrator.karyawan.upload-dokument-file');
	Route::post('karyawan/generate-dokument-file', 'KaryawanController@generateDocumentFile')->name('administrator.karyawan.generate-dokument-file');
	Route::get('karyawan/print-payslip/{id}', 'KaryawanController@printPayslip')->name('administrator.karyawan.print-payslip');
	Route::get('request-pay-slip', 'RequestPaySlipController@index')->name('administrator.request-pay-slip.index');
	Route::get('request-pay-slip/proses/{id}', 'RequestPaySlipController@proses')->name('administrator.request-pay-slip.proses');
	Route::post('request-pay-slip/submit/{id}', 'RequestPaySlipController@submit')->name('administrator.request-pay-slip.submit');
	Route::get('karyawan/print-payslipnet/{id}', 'KaryawanController@printPayslipNet')->name('administrator.karyawan.print-payslipnet');
	
	#Route::get('request-pay-slipnet', 'RequestPaySlipNetController@index')->name('administrator.request-pay-slipnet.index');
	#Route::get('request-pay-slipnet/proses/{id}', 'RequestPaySlipNetController@proses')->name('administrator.request-pay-slipnet.proses');
	#Route::post('request-pay-slipnet/submit/{id}', 'RequestPaySlipNetController@submit')->name('administrator.request-pay-slipnet.submit');
	#Route::get('karyawan/print-payslipgross/{id}', 'KaryawanController@printPayslipGross')->name('administrator.karyawan.print-payslipgross');
	#Route::get('request-pay-slipgross', 'RequestPaySlipGrossController@index')->name('administrator.request-pay-slipgross.index');
	#Route::get('request-pay-slipgross/proses/{id}', 'RequestPaySlipGrossController@proses')->name('administrator.request-pay-slipgross.proses');
	#Route::post('request-pay-slipgross/submit/{id}', 'RequestPaySlipGrossController@submit')->name('administrator.request-pay-slipgross.submit');
	Route::get('karyawan/delete-dependent/{id}', 'KaryawanController@deleteDependent')->name('administrator.karyawan.delete-dependent');
	Route::get('karyawan/delete-education/{id}', 'KaryawanController@deleteEducation')->name('administrator.karyawan.delete-education');
	Route::get('karyawan/delete-inventaris/{id}', 'KaryawanController@deleteInventaris')->name('administrator.karyawan.delete-inventaris');
	Route::get('karyawan/delete-inventaris-mobil/{id}', 'KaryawanController@deleteInventarisMobil')->name('administrator.karyawan.delete-inventaris-mobil');
	Route::get('karyawan/delete-inventaris-lainnya/{id}', 'KaryawanController@deleteInventarisLainnya')->name('administrator.karyawan.delete-inventaris-lainnya');
	Route::resource('empore-direktur', 'EmporeDirekturController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('empore-manager', 'EmporeManagerController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('empore-staff', 'EmporeStaffController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('payroll/index', 'PayrollController@index')->name('administrator.payroll.index');
	Route::post('payroll/index', 'PayrollController@index')->name('administrator.payroll.index');
	#Route::get('payrollnet/index', 'PayrollNetController@index')->name('administrator.payrollnet.index');
	#Route::post('payrollnet/index', 'PayrollNetController@index')->name('administrator.payrollnet.index');
	#Route::get('payrollgross/index', 'PayrollGrossController@index')->name('administrator.payrollgross.index');
	#Route::post('payrollgross/index', 'PayrollGrossController@index')->name('administrator.payrollgross.index');
	Route::get('karyawan/autologin/{id}', 'KaryawanController@autologin')->name('administrator.karyawan.autologin');
	Route::get('profile', 'IndexController@profile')->name('administrator.profile');
	Route::post('update-profile', 'IndexController@updateProfile')->name('administrator.update-profile');
	//custom
	Route::post('leaveCustom/index', 'LeaveCustomController@index')->name('administrator.leaveCustom.index');
	Route::get('leaveCustom/index', 'LeaveCustomController@index')->name('administrator.leaveCustom.index');
	Route::get('leaveCustom/proses/{id}', 'LeaveCustomController@proses')->name('administrator.leaveCustom.proses');
	
	Route::post('paymentRequestCustom/index', 'PaymentRequestCustomController@index')->name('administrator.paymentRequestCustom.index');
	Route::get('paymentRequestCustom/index', 'PaymentRequestCustomController@index')->name('administrator.paymentRequestCustom.index');
	Route::get('paymentRequestCustom/proses/{id}', 'PaymentRequestCustomController@proses')->name('administrator.paymentRequestCustom.proses');

	Route::post('overtimeCustom/index', 'OvertimeCustomController@index')->name('administrator.overtimeCustom.index');
	Route::get('overtimeCustom/index', 'OvertimeCustomController@index')->name('administrator.overtimeCustom.index');
	Route::get('overtimeCustom/proses/{id}', 'OvertimeCustomController@proses')->name('administrator.overtimeCustom.proses');
	Route::get('overtimeCustom/claim/{id}', 'OvertimeCustomController@claim')->name('administrator.overtimeCustom.claim');

	Route::post('trainingCustom/index', 'TrainingCustomController@index')->name('administrator.trainingCustom.index');
	Route::get('trainingCustom/index', 'TrainingCustomController@index')->name('administrator.trainingCustom.index');
	Route::get('trainingCustom/proses/{id}', 'TrainingCustomController@proses')->name('administrator.trainingCustom.proses');
	Route::get('trainingCustom/claim/{id}', 'TrainingCustomController@claim')->name('administrator.trainingCustom.claim');

	Route::post('medicalCustom/index', 'MedicalCustomController@index')->name('administrator.medicalCustom.index');
	Route::get('medicalCustom/index', 'MedicalCustomController@index')->name('administrator.medicalCustom.index');
	Route::get('medicalCustom/proses/{id}', 'MedicalCustomController@proses')->name('administrator.medicalCustom.proses');

	Route::post('exitCustom/index', 'ExitInterviewClearanceCustomController@index')->name('administrator.exitCustom.index');
	Route::get('exitCustom/index', 'ExitInterviewClearanceCustomController@index')->name('administrator.exitCustom.index');
	Route::get('exitCustom/detail/{id}', 'ExitInterviewClearanceCustomController@detail')->name('administrator.exitCustom.detail');
	Route::get('exitCustom/clearance/{id}', 'ExitInterviewClearanceCustomController@clearance')->name('administrator.exitCustom.clearance');
	

	Route::post('cuti/index', 'CutiController@index')->name('administrator.cuti.index');
	Route::get('cuti/index', 'CutiController@index')->name('administrator.cuti.index');
	Route::post('payment-request/index', 'PaymentRequestController@index')->name('administrator.payment-request.index');
	Route::get('payment-request/index', 'PaymentRequestController@index')->name('administrator.payment-request.index');
	Route::post('medical-reimbursement/index', 'MedicalController@index')->name('administrator.medical-reimbursement.index');
	Route::get('medical-reimbursement/index', 'MedicalController@index')->name('administrator.medical-reimbursement.index');
	Route::post('overtime/index', 'OvertimeController@index')->name('administrator.overtime.index');
	Route::get('overtime/index', 'OvertimeController@index')->name('administrator.overtime.index');
	Route::post('training/index', 'TrainingController@index')->name('administrator.training.index');
	Route::get('training/index', 'TrainingController@index')->name('administrator.training.index');
	Route::post('exit-interview/index', 'ExitInterviewController@index')->name('administrator.exit-interview.index');
	Route::get('exit-interview/index', 'ExitInterviewController@index')->name('administrator.exit-interview.index');
	Route::get('setting/general', 'SettingController@index')->name('administrator.setting.general');
	Route::get('setting/email', 'SettingController@email')->name('administrator.setting.email');
	Route::get('organization-structure-custom', 'StructureOrganizationCustomController@index')->name('administrator.organization-structure-custom.index');
	Route::get('organization-structure-custom/delete/{id}', 'StructureOrganizationCustomController@delete')->name('administrator.organization-structure-custom.delete');
	Route::get('setting/backup', 'SettingController@backup')->name('administrator.setting.backup');
	Route::post('setting/backup-save', 'SettingController@backupSave')->name('administrator.setting.backup-save');
	Route::post('setting/backup-delete',  'SettingController@backupDelete')->name('administrator.setting.backup-delete');
	Route::post('setting/backup-get',  'SettingController@backupGet')->name('administrator.setting.backup-get');
	Route::post('setting/save','SettingController@save')->name('administrator.setting.save');
	Route::post('setting/email-save', 'SettingController@emailSave')->name('administrator.setting.email-save');
	Route::post('setting/email-test-send', 'SettingController@emailTestSend')->name('administrator.setting.email-test-send');
	Route::post('organization-structure-custom/store', 'StructureOrganizationCustomController@store')->name('administrator.organization-structure-custom.store');
	Route::post('karyawan/send-pay-slip', 'KaryawanController@sendPaySlip')->name('administrator.karyawan.send-pay-slip');
	Route::post('setting/store-backup-schedule', 'SettingController@storeBackupSchedule')->name('administrator.setting.store-backup-schedule');
	Route::get('setting/delete-backup-schedule/{id}', 'SettingController@deleteBackupSchedule')->name('administrator.setting.delete-backup-schedule');
	Route::get('payroll/create-by-payroll-id/{id}', 'PayrollController@createByPayrollId')->name('administrator.payroll.create-by-payroll-id');
	Route::get('payroll/detail-history/{id}', 'PayrollController@detailHistory')->name('administrator.payroll.detail-history');


	Route::resource('leave', 'LeaveController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('approval-leave-custom',  'ApprovalLeaveCustomController@index')->name('administrator.approval.leave-custom.index');
	Route::get('approval-leave-custom/detail/{id}',  'ApprovalLeaveCustomController@detail')->name('administrator.approval.leave-custom.detail');
	Route::post('approval-leave-custom/proses',  'ApprovalLeaveCustomController@proses')->name('administrator.approval.leave-custom.proses');

	Route::resource('payment-request-custom', 'PaymentRequestKaryawanCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('approval-payment-request-custom',  'ApprovalPaymentRequestCustomController@index')->name('administrator.approval.payment-request-custom.index');
	Route::get('approval-payment-request-custom/detail/{id}',  'ApprovalPaymentRequestCustomController@detail')->name('administrator.approval.payment-request-custom.detail');
	Route::post('approval-payment-request-custom/proses',  'ApprovalPaymentRequestCustomController@proses')->name('administrator.approval.payment-request-custom.proses');

	Route::resource('overtime-custom', 'OvertimeKaryawanCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('overtime-custom/claim/{id}',  'OvertimeCustomController@claim')->name('administrator.overtime-custom.claim');
	Route::post('overtime-custom/prosesclaim',  'OvertimeCustomController@prosesclaim')->name('administrator.overtime-custom.prosesclaim');
	Route::get('approval-overtime-custom',  'ApprovalOvertimeCustomController@index')->name('administrator.approval.overtime-custom.index');
	Route::get('approval-overtime-custom/detail/{id}',  'ApprovalOvertimeCustomController@detail')->name('administrator.approval.overtime-custom.detail');
	Route::post('approval-overtime-custom/proses',  'ApprovalOvertimeCustomController@proses')->name('administrator.approval.overtime-custom.proses');
	Route::get('approval-overtime-custom/claim/{id}',  'ApprovalOvertimeCustomController@claim')->name('administrator.approval.overtime-custom.claim');
	Route::post('approval-overtime-custom/prosesClaim',  'ApprovalOvertimeCustomController@prosesClaim')->name('administrator.approval.overtime-custom.prosesClaim');

	Route::resource('training-custom', 'TrainingKaryawanCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('training-custom/claim/{id}',  'TrainingCustomController@claim')->name('administrator.training-custom.claim');
	Route::post('training-custom/prosesclaim',  'TrainingCustomController@prosesclaim')->name('administrator.training-custom.prosesclaim');
	Route::get('approval-training-custom',  'ApprovalTrainingCustomController@index')->name('administrator.approval.training-custom.index');
	Route::get('approval-training-custom/detail/{id}',  'ApprovalTrainingCustomController@detail')->name('administrator.approval.training-custom.detail');
	Route::post('approval-training-custom/proses',  'ApprovalTrainingCustomController@proses')->name('administrator.approval.training-custom.proses');
	Route::get('approval-training-custom/claim/{id}',  'ApprovalTrainingCustomController@claim')->name('administrator.approval.training-custom.claim');
	Route::post('approval-training-custom/prosesClaim',  'ApprovalTrainingCustomController@prosesClaim')->name('administrator.approval.training-custom.prosesClaim');

	Route::resource('medical-custom', 'MedicalKaryawanCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('approval-medical-custom',  'ApprovalMedicalCustomController@index')->name('administrator.approval.medical-custom.index');
	Route::get('approval-medical-custom/detail/{id}',  'ApprovalMedicalCustomController@detail')->name('administrator.approval.medical-custom.detail');
	Route::post('approval-medical-custom/proses',  'ApprovalMedicalCustomController@proses')->name('administrator.approval.medical-custom.proses');

	Route::resource('exit-custom', 'ExitInterviewKaryawanCustomController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('exit-custom/clearance/{id}',  'ExitInterviewCustomController@clearance')->name('administrator.exit-custom.clearance');
	Route::post('exit-custom/prosesclearance',  'ExitInterviewCustomController@prosesclearance')->name('administrator.exit-custom.prosesclearance');
	Route::get('approval-exit-custom',  'ApprovalExitInterviewCustomController@index')->name('administrator.approval.exit-custom.index');
	Route::get('approval-exit-custom/detail/{id}',  'ApprovalExitInterviewCustomController@detail')->name('administrator.approval.exit-custom.detail');
	Route::post('approval-exit-custom/proses',  'ApprovalExitInterviewCustomController@proses')->name('administrator.approval.exit-custom.proses');

	Route::get('approval-clearance-custom', 'ApprovalExitKaryawanClearanceCustomController@index')->name('administrator.approval.clearance-custom.index');
	Route::get('approval-clearance-custom/detail/{id}', 'ApprovalExitClearanceCustomController@detail')->name('administrator.approval.clearance-custom.detail');
	Route::post('approval-clearance-custom/proses', 'ApprovalExitClearanceCustomController@proses')->name('administrator.approval.clearance-custom.proses');

	Route::resource('request-pay-slip-karyawan', 'RequestPaySlipKaryawanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);	
});