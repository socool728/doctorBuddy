<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@anyIndex');

//Route::get('home', 'HomeController@anyIndex');

//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
Route::any('/admin', 'AdminController@getLogin');
Route::controller('admin', 'AdminController');
Route::controller('home', 'HomeController');
Route::controller('customer', 'CustomerController');
Route::controller('counselor', 'CounselorController');
Route::controller('healthcare_professional', 'HealthcareprofessionalController');
Route::any('question', array('as' => 'questions', 'uses' => 'HomeController@anyQuestion'));
Route::any('video', array('as' => 'video', 'uses' => 'HomeController@anyVideo'));
Route::any('next', array('as' => 'next', 'uses' => 'HomeController@anyNextQuestion'));
Route::any('finish', array('as' => 'finish', 'uses' => 'HomeController@anyFinishQuestion'));
Route::any('download/{pdf}', array('as' => 'download', 'uses' =>'AdminController@anyDownload'));
Route::any('counsellor/assign', array('as' => 'assign', 'uses' => 'AdminController@anyAssign'));
Route::any('admin/dashboard', array('as' => 'dashboard', 'uses' => 'AdminController@anyDashboard'));
Route::any('admin/questions', array('as' => 'questions', 'uses' => 'AdminController@anyQuestions'));
Route::any('admin/add-question', array('as' => 'add-question', 'uses' => 'AdminController@anyAddQuestion'));
Route::any('admin/edit-question/{id}', array('as' => 'edit-question', 'uses' => 'AdminController@anyEditQuestion'));
Route::any('admin/staff', array('as' => 'staff', 'uses' => 'AdminController@anyStaff'));
Route::any('admin/edit-staff/{id}', array('as' => 'edit-staff', 'uses' => 'AdminController@anyEditStaff'));
Route::any('admin/add-staff', array('as' => 'add-staff', 'uses' => 'AdminController@anyAddStaff'));
Route::any('admin/option', array('as' => 'option', 'uses' => 'AdminController@anyOption'));
Route::any('admin/login', array('as' => 'login', 'uses' => 'AdminController@getLogin'));
Route::any('admin/logout', array('as' => 'logout', 'uses' => 'AdminController@getLogout'));
Route::any('admin/del-question/{id}', array('as' => 'del-question', 'uses' => 'AdminController@anyDelQuestion'));
Route::any('admin/del-staff/{id}', array('as' => 'del-staff', 'uses' => 'AdminController@anyDelStaff'));
Route::any('admin/symptom', array('as' => 'symptom', 'uses' => 'AdminController@anySymptom'));
Route::any('admin/edit-symptom/{id}', array('as' => 'edit-symptom', 'uses' => 'AdminController@anyEditSymptom'));
Route::any('admin/add-symptom', array('as' => 'add-symptom', 'uses' => 'AdminController@anyAddSymptom'));
Route::any('admin/del-symptom/{id}', array('as' => 'del-symptom', 'uses' => 'AdminController@anyDelSymptom'));
Route::any('admin/customer', array('as' => 'customer', 'uses' => 'AdminController@anyCustomer'));
Route::any('admin/report/{id}', array('as' => 'report', 'uses' => 'AdminController@anyReport/{id}'));