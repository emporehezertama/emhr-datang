<?php /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


#Set Language
$language = empty(get_setting('language')) ? 'en' : get_setting('language') ;

App::setLocale($language);
#End

#Set Language
$timezone = empty(get_setting('timezone')) ? "Asia/Bangkok" : get_setting('timezone') ;

date_default_timezone_set($timezone);
#End

Route::get('/', function () 
{
	return redirect()->route('landing-page1');
});

Auth::routes();

Route::get('asset-accept/{id}', 'IndexController@acceptAsset')->name('accept-asset');
Route::get('em-hris-application-system', 'LandingPageController@page1')->name('landing-page1');
Route::post('post-em-hris-application-system', 'LandingPageController@storePage1')->name('post-landing-page1');

Route::post('get-price-list', 'LandingPageController@getPriceList')->name('get-price-list');


Route::group(['middleware' => ['auth']], function(){
//	Route::post('logout', 'LoginController@Logout')->name('logout');
	Route::post('ajax/get-division-by-directorate', 'AjaxController@getDivisionByDirectorate')->name('ajax.get-division-by-directorate');
	Route::post('ajax/get-department-by-division', 'AjaxController@getDepartmentByDivision')->name('ajax.get-department-by-division');
	Route::post('ajax/get-section-by-department', 'AjaxController@getSectionByDepartment')->name('ajax.get-section-by-department');
	Route::get('ajax/get-structure', 'AjaxController@getStructure')->name('ajax.get-stucture');
	Route::get('ajax/get-structure-custome', 'AjaxController@getStructureCustome')->name('ajax.get-stucture-custome');
	Route::get('ajax/get-structure-branch', 'AjaxController@getStructureBranch')->name('ajax.get-stucture-branch');
	Route::post('ajax/get-kabupaten-by-provinsi', 'AjaxController@getKabupatenByProvinsi')->name('ajax.get-kabupaten-by-provinsi');
	Route::post('ajax/get-kecamatan-by-kabupaten', 'AjaxController@getKecamatanByKabupaten')->name('ajax.get-kecamatan-by-kabupaten');
	Route::post('ajax/get-kelurahan-by-kecamatan', 'AjaxController@getKelurahanByKecamatan')->name('ajax.get-kelurahan-by-kecamatan');
	Route::post('ajax/get-karyawan-by-id', 'AjaxController@getKaryawanById')->name('ajax.get-karyawan-by-id');
	Route::post('ajax/add-setting-cuti-personalia', 'AjaxController@addtSettingCutiPersonalia')->name('ajax.add-setting-cuti-personalia');
	Route::post('ajax/add-setting-cuti-atasan', 'AjaxController@addtSettingCutiAtasan')->name('ajax.add-setting-cuti-atasan');
	Route::post('ajax/add-setting-payment-request-approval', 'AjaxController@addtSettingPaymentRequestApproval')->name('ajax.add-setting-payment-request-approval');
	Route::post('ajax/add-setting-payment-request-verification', 'AjaxController@addtSettingPaymentRequestVerification')->name('ajax.add-setting-payment-request-verification');
	Route::post('ajax/add-setting-payment-request-payment', 'AjaxController@addtSettingPaymentRequestPayment')->name('ajax.add-setting-payment-request-payment');
	Route::post('ajax/add-inventaris-mobil', 'AjaxController@addInvetarisMobil')->name('ajax.add-inventaris-mobil');
	Route::post('ajax/add-setting-medical-hr-benefit', 'AjaxController@addSettingMedicalHRBenefit')->name('ajax.add-setting-medical-hr-benefit');
	Route::post('ajax/add-setting-medical-manager-hr', 'AjaxController@addSettingMedicalManagerHR')->name('ajax.add-setting-medical-manager-hr');
	Route::post('ajax/add-setting-medical-gm-hr', 'AjaxController@addSettingMedicalGMHR')->name('ajax.add-setting-medical-gm-hr');
	Route::post('ajax/add-setting-overtime-hr-operation', 'AjaxController@addSettingOvertimeHrOperation')->name('ajax.add-setting-overtime-hr-operation');
	Route::post('ajax/add-setting-overtime-manager-hr', 'AjaxController@addSettingOvertimeManagerHR')->name('ajax.add-setting-overtime-manager-hr');
	Route::post('ajax/add-setting-overtime-manager-department', 'AjaxController@addSettingOvertimeManagerDepartment')->name('ajax.add-setting-overtime-manager-department');
	Route::post('ajax/add-setting-exit-hr-manager', 'AjaxController@addSettingExitHRManager')->name('ajax.add-setting-exit-hr-manager');
	Route::post('ajax/add-setting-exit-hr-gm', 'AjaxController@addSettingExitHRGM')->name('ajax.add-setting-exit-hr-gm');
	Route::post('ajax/add-setting-exit-hr-director', 'AjaxController@addSettingExitHRDirector')->name('ajax.add-setting-exit-hr-director');
	Route::post('ajax/add-setting-training-ga-department-mengetahui', 'AjaxController@addSettingTrainingGaDepartment')->name('ajax.add-setting-training-ga-department-mengetahui');
	Route::post('ajax/add-setting-training-hrd', 'AjaxController@addSettingTrainingHRD')->name('ajax.add-setting-training-hrd');
	Route::post('ajax/add-setting-training-finance', 'AjaxController@addSettingTrainingFinance')->name('ajax.add-setting-training-finance');
	Route::post('ajax/add-setting-exit-hrd', 'AjaxController@addSettingExitHRD')->name('ajax.add-setting-exit-hrd');
	Route::post('ajax/add-setting-exit-ga', 'AjaxController@addSettingExitGA')->name('ajax.add-setting-exit-ga');
	Route::post('ajax/add-setting-exit-it', 'AjaxController@addSettingExitIT')->name('ajax.add-setting-exit-it');
	Route::post('ajax/add-setting-exit-accounting', 'AjaxController@addSettingExitAccounting')->name('ajax.add-setting-exit-accounting');
	
	Route::post('ajax/get-detail-setting-approval-leave-item', 'AjaxController@getDetailSettingApprovalLeaveItem')->name('ajax.get-detail-setting-approval-leave-item');
	Route::post('ajax/get-detail-setting-approval-paymentRequest-item', 'AjaxController@getDetailSettingApprovalPaymentRequestItem')->name('ajax.get-detail-setting-approval-paymentRequest-item');
	Route::post('ajax/get-detail-setting-approval-overtime-item', 'AjaxController@getDetailSettingApprovalOvertimeItem')->name('ajax.get-detail-setting-approval-overtime-item');
	Route::post('ajax/get-detail-setting-approval-training-item', 'AjaxController@getDetailSettingApprovalTrainingItem')->name('ajax.get-detail-setting-approval-training-item');
	Route::post('ajax/get-detail-setting-approval-medical-item', 'AjaxController@getDetailSettingApprovalMedicalItem')->name('ajax.get-detail-setting-approval-medical-item');
	Route::post('ajax/get-detail-setting-approval-exit-item', 'AjaxController@getDetailSettingApprovalExitItem')->name('ajax.get-detail-setting-approval-exit-item');

	Route::post('ajax/get-history-approval-leave-custom', 'AjaxController@getHistoryApprovalLeaveCustom')->name('ajax.get-history-approval-leave-custom');
	Route::post('ajax/get-history-approval-payment-request-custom', 'AjaxController@getHistoryApprovalPaymentRequestCustom')->name('ajax.get-history-approval-payment-request-custom');
	Route::post('ajax/get-history-approval-overtime-custom', 'AjaxController@getHistoryApprovalOvertimeCustom')->name('ajax.get-history-approval-overtime-custom');
	Route::post('ajax/get-history-approval-overtime-claim-custom', 'AjaxController@getHistoryApprovalOvertimeClaimCustom')->name('ajax.get-history-approval-overtime-claim-custom');
	Route::post('ajax/get-date-overtime-custom', 'AjaxController@chekDateOVertime')->name('ajax.get-date-overtime-custom');
	Route::post('ajax/get-in-out-overtime-custom', 'AjaxController@chekInOutOVertime')->name('ajax.get-in-out-overtime-custom');
	Route::post('ajax/get-history-approval-training-custom', 'AjaxController@getHistoryApprovalTrainingCustom')->name('ajax.get-history-approval-training-custom');
	Route::post('ajax/get-history-approval-training-claim-custom', 'AjaxController@getHistoryApprovalTrainingClaimCustom')->name('ajax.get-history-approval-training-claim-custom');
	Route::post('ajax/get-history-approval-medical-custom', 'AjaxController@getHistoryApprovalMedicalCustom')->name('ajax.get-history-approval-medical-custom');
	Route::post('ajax/get-history-approval-exit-custom', 'AjaxController@getHistoryApprovalExitCustom')->name('ajax.get-history-approval-exit-custom');
	Route::post('ajax/get-history-approval-clearance-custom', 'AjaxController@getHistoryApprovalClearanceCustom')->name('ajax.get-history-approval-clearance-custom');

	Route::post('ajax/get-karyawan-approval', 'AjaxController@getKaryawanApproval')->name('ajax.get-karyawan-approval');
	Route::post('ajax/add-setting-clearance-hrd', 'AjaxController@addSettingClearanceHrd')->name('ajax.add-setting-clearance-hrd');
	Route::post('ajax/add-setting-clearance-ga', 'AjaxController@addSettingClearanceGA')->name('ajax.add-setting-clearance-ga');
	Route::post('ajax/add-setting-clearance-it', 'AjaxController@addSettingClearanceIT')->name('ajax.add-setting-clearance-it');
	Route::post('ajax/add-setting-clearance-accounting', 'AjaxController@addSettingClearanceAccounting')->name('ajax.add-setting-clearance-accounting');


	Route::post('ajax/get-city', 'AjaxController@getCity')->name('ajax.get-city');
	Route::post('ajax/get-university', 'AjaxController@getUniversity')->name('ajax.get-university');
	Route::post('ajax/get-history-approval', 'AjaxController@getHistoryApproval')->name('ajax.get-history-approval');
	Route::post('ajax/get-airports', 'AjaxController@getAirports')->name('ajax.get-airports');
	Route::post('ajax/get-history-approval-cuti', 'AjaxController@getHistoryApprovalCuti')->name('ajax.get-history-approval-cuti');	
	Route::post('ajax/get-history-approval-exit', 'AjaxController@getHistoryApprovalExit')->name('ajax.get-history-approval-exit');	
	Route::post('ajax/get-history-approval-training', 'AjaxController@getHistoryApprovalTraining')->name('ajax.get-history-approval-training');	
	Route::post('ajax/get-history-training-bill', 'AjaxController@getHistoryApprovalTrainingBill')->name('ajax.get-history-training-bill');	
	Route::post('ajax/get-history-approval-payment-request', 'AjaxController@getHistoryApprovalPaymentRequest')->name('ajax.get-history-approval-payment-request');		
	Route::post('ajax/get-history-approval-overtime', 'AjaxController@getHistoryApprovalOvertime')->name('ajax.get-history-approval-overtime');		
	Route::post('ajax/get-history-approval-medical', 'AjaxController@getHistoryApprovalMedical')->name('ajax.get-history-approval-medical');		
	Route::post('ajax/get-karyawan', 'AjaxController@getKaryawan')->name('ajax.get-karyawan');
	Route::post('ajax/get-karyawan-payroll', 'AjaxController@getKaryawanPayroll')->name('ajax.get-karyawan-payroll');	
	Route::post('ajax/get-calculate-payroll', 'AjaxController@getCalculatePayroll')->name('ajax.get-calculate-payroll');
	
	#Route::post('ajax/get-karyawan-payrollnet', 'AjaxController@getKaryawanPayrollNet')->name('ajax.get-karyawan-payrollnet');
	#Route::post('ajax/get-calculate-payrollnet', 'AjaxController@getCalculatePayrollNet')->name('ajax.get-calculate-payrollnet');

	Route::post('ajax/get-karyawan-payrollgross', 'AjaxController@getKaryawanPayrollGross')->name('ajax.get-karyawan-payrollgross');
	Route::post('ajax/get-calculate-payrollgross', 'AjaxController@getCalculatePayrollGross')->name('ajax.get-calculate-payrollgross');
	Route::post('ajax/get-bulan-pay-slip', 'AjaxController@getBulanPaySlip')->name('ajax.get-bulan-pay-slip');		
	Route::post('ajax/update-dependent', 'AjaxController@updateDependent')->name('ajax.update-dependent');		
	Route::post('ajax/update-education', 'AjaxController@updateEducation')->name('ajax.update-education');		
	Route::post('ajax/update-cuti', 'AjaxController@updateCuti')->name('ajax.update-cuti');		
	Route::post('ajax/update-inventaris-mobil', 'AjaxController@updateInventarisMobil')->name('ajax.update-inventaris-mobil');	
	Route::post('ajax/update-inventaris-lainnya', 'AjaxController@updateInventarisLainnya')->name('ajax.update-inventaris-lainnya');
	Route::post('ajax/get-manager-by-direktur', 'AjaxEmporeController@getManagerByDirektur')->name('ajax.get-manager-by-direktur');
	Route::post('ajax/get-staff-by-manager', 'AjaxEmporeController@getStaffByManager')->name('ajax.get-staff-by-manager');
	Route::post('ajax/update-first-password', 'AjaxController@updatePassword')->name('ajax.update-first-password');		
	Route::post('ajax/update-password-administrator', 'AjaxController@updatePasswordAdministrator')->name('ajax.update-password-administrator');		
	Route::post('ajax/structure-custome-add', 'AjaxController@structureCustomeAdd')->name('ajax.structure-custome-add');		
	Route::post('ajax/structure-custome-delete', 'AjaxController@structureCustomeDelete')->name('ajax.structure-custome-delete');		
	Route::post('ajax/structure-custome-edit', 'AjaxController@structureCustomeEdit')->name('ajax.structure-custome-edit');		
	Route::get('attendance/index', 'AttendanceController@index')->name('attendance.index');
	Route::get('attendance/detail-attendance/{SN}', 'AttendanceController@AttendanceList')->name('attendance.detail-attendance');
	Route::post('ajax/get-year-pay-slip', 'AjaxController@getYearPaySlip')->name('ajax.get-year-pay-slip');		
	Route::post('ajax/get-year-pay-slip-all', 'AjaxController@getYearPaySlipAll')->name('ajax.get-year-pay-slip-all');	
	Route::post('ajax/get-bulan-pay-slip-all', 'AjaxController@getBulanPaySlipAll')->name('ajax.get-bulan-pay-slip-all');	
	
	Route::post('ajax/delete-karyawan', 'AjaxController@deleteKaryawan')->name('ajax.delete-karyawan');
	Route::get('ajax/get-libur-nasional', 'AjaxController@getLiburNasional')->name('ajax.get-libur-nasional');
	Route::post('ajax/get-filter-join-resign', 'AjaxController@getFilterJoinResign')->name('ajax.get-filter-join-resign');
	Route::post('ajax/get-filter-attrition', 'AjaxController@getFilterAttrition')->name('ajax.get-filter-attrition');
	Route::get('ajax/get-user-active', 'AjaxController@getUserActive')->name('ajax.get-user-active');
	Route::post('ajax/get-data-dashboard', 'AjaxController@getDataDashboard')->name('ajax.get-data-dashboard');

});

/**
 * Include Custom Routing
 */
foreach (File::allFiles(__DIR__ . '/custom') as $route_file) {
  require $route_file->getPathname();
}