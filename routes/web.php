<?php

// Route::get('/', function(){
//   return view('welcome');
// });

Auth::routes();

Route::get('/register', 'UserController@index');
Route::get('/reset-password', 'Auth\ResetPasswordController@password')->name('password.request');
Route::POST('/reset-password', 'Auth\ResetPasswordController@resetpassword')->name('password.email');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');
//=========================================================================
Route::group(['middleware'=>'auth'], function(){	
	Route::get('/employee/{id_karyawan}/show', 'EmployeeController@show');
	//=========================================================================
	Route::resource('product', 'ProductController');
	Route::get('/product/{id_produk}/show', 'ProductController@show');
	Route::post('/product/get/image/url', 'ProductController@getimageurl');
	Route::post('/product/get/by/category', 'ProductController@getcategory');
	Route::post('/product/get/newnumber', 'ProductController@getnewnumber');
	Route::post('/product/get/batch', 'BatchController@getbatch');
	//=========================================================================
	Route::resource('purchase', 'PurchaseController');
	Route::get('/purchase/{id_produk}/show', 'PurchaseController@show');	
	//=========================================================================
	Route::get('/sell', 'SellController@index')->name('sell.index');
	Route::post('/sell', 'SellController@store')->name('sell.store');
	Route::get('/sell/update', 'SellController@update')->name('sell.update');
	Route::get('/sell/update/by/{id_sell}', 'SellController@updatebyid')->name('sell.updatebyid');	
	Route::get('/sell/laporan', 'SellController@report')->name('sell.report');
	//=========================================================================
	Route::resource('/report', 'ReportController');
	//=========================================================================
	//=========================================================================
	Route::resource('/report-barang-masuk', 'ReportMasukController');
	//=========================================================================
	// Route::resource('schedule', 'ScheduleController');
	// Route::get('/schedule/{id_jadwal}/show', 'ScheduleController@show');
	// Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');
	// Route::get('/schedule/create', 'ScheduleController@create')->name('schedule.create');
	// Route::post('/schedule', 'ScheduleController@store');
	// Route::get('/schedule/{id_jadwal}/edit', 'ScheduleController@edit');
	// Route::put('/schedule/{id_jadwal}', 'ScheduleController@update');
	// Route::delete('/schedule/{id_jadwal}', 'ScheduleController@destroy');
	//=========================================================================
	Route::get('/setting', 'UserSettingController@form')->name('user.setting');
	Route::post('/setting', 'UserSettingController@update');
	Route::resource('employee', 'EmployeeController');
	//=========================================================================
	Route::group(['middleware'=>'akses.admin'], function(){
		
		Route::resource('category', 'CategoryController');
		Route::resource('unit', 'UnitController');
		Route::resource('product_conversion', 'ProductConversionController');
		Route::resource('user', 'UserController');
		Route::resource('batch', 'BatchController');
		Route::resource('audit', 'AuditController');
		Route::resource('gender', 'GenderController');
		Route::delete('/sell/{id_sell}', 'SellController@destroy');

	});
	// Route::get('/user', 'UserController@index')->name('user.index')->middleware('akses.admin');
	//=========================================================================

	Route::get('/about', function(){
		return view('gudang.about');
	});
});
