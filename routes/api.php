<?php

Route::post('user/login', 'AuthController@userLogin');
Route::post('admin/login', 'AuthController@adminLogin');
Route::post('register', 'AuthController@register');
Route::get('seminar', 'AdminController@getSeminar');
Route::group(['middleware' => 'auth:api'], function () {
	
	Route::group(['prefix' => 'user'], function () {
		Route::post('donate/{type}', 'UserController@donate');
		Route::get('notifications', 'UserController@notifications');
		Route::get('no-notifications', 'UserController@noNotifications');
	});

	Route::group(['prefix' => 'admin'], function () {
		Route::post('add-seminar', 'AdminController@addSeminar');
		Route::get('donation-requests/{type}', 'AdminController@donationRequests');
		Route::get('donation/{donate}', 'AdminController@donation');
		Route::post('change-donation/{donate}', 'AdminController@changeDonation');
		Route::post('donate-money/{donate}', 'AdminController@donateMoney');
	});
	Route::post('logout', 'AuthController@logout');
});