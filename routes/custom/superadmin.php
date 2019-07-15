<?php

/**
 * SuperAdmin Routing
 */
Route::group(['prefix' => 'superadmin', 'namespace'=>'SuperAdmin', 'middleware' => ['auth', 'access:3']], function(){
	Route::get('/', 'IndexController@index')->name('superadmin.dashboard');
	Route::get('profile', 'IndexController@profile')->name('superadmin.profile');
	Route::post('update-profile', 'IndexController@updateProfile')->name('superadmin.update-profile');
	Route::resource('admin', 'AdminController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'superadmin']);
	Route::get('admin/changeStatus/{id}', 'AdminController@changeStatus')->name('superadmin.admin.changeStatus');

	Route::get('setting/general', 'SettingController@index')->name('superadmin.setting.general');
	Route::post('setting/save','SettingController@save')->name('superadmin.setting.save');
	Route::get('setting/email', 'SettingController@email')->name('superadmin.setting.email');
	Route::post('setting/email-save', 'SettingController@emailSave')->name('superadmin.setting.email-save');
	Route::post('setting/email-test-send', 'SettingController@emailTestSend')->name('superadmin.setting.email-test-send');
	Route::get('setting/backup', 'SettingController@backup')->name('superadmin.setting.backup');
	Route::post('setting/backup-save', 'SettingController@backupSave')->name('superadmin.setting.backup-save');
	Route::post('setting/backup-delete',  'SettingController@backupDelete')->name('superadmin.setting.backup-delete');
	Route::post('setting/backup-get',  'SettingController@backupGet')->name('superadmin.setting.backup-get');
	Route::get('setting/delete-backup-schedule/{id}', 'SettingController@deleteBackupSchedule')->name('superadmin.setting.delete-backup-schedule');
	Route::post('setting/store-backup-schedule', 'SettingController@storeBackupSchedule')->name('superadmin.setting.store-backup-schedule');
});
