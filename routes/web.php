<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

Route::get('/rq/{svcequip_type?}', 'RequestController@index')->name('rq.index');
Route::get('/rq/{svcequip_type}/{request_id}', 'RequestController@show')->name('rq.show');
Route::get('/rq/{svcequip_type}/{request_id}/create', 'RequestController@create')->name('rq.create');
Route::post('/rq/{svcequip_type}/{request_id}', 'RequestController@store')->name('rq.store');
Route::patch('/rq/{svcequip_type}/{request_id}', 'RequestController@update')->name('rq.update');
Route::get('/rq/{svcequip_type}/{request_id}/edit', 'RequestController@edit')->name('rq.edit');
Route::delete('/rq/{svcequip_type}/{request_id}', 'RequestController@destroy')->name('rq.destroy');
Route::get('/rq/{svcequip_type}/{request_id}/apply', 'RequestController@apply')->name('rq.apply');
Route::get('/rq_status', 'RequestController@status')->name('rq.status');
Route::get('/recently_msgs', 'UserMsgController@recently_msgs')->name('usermsg.recently');
Route::get('/rq_approve/{request_id}', 'RequestController@approve_request')->name('rq.approve');
Route::get('/rq_reject/{request_id}', 'RequestController@reject_request')->name('rq.reject');
Route::get('/set_2fa', 'UserController@setEnhancedAuth')->name('user.2fa');
Route::post('/set_2fa', 'UserController@setEnhancedAuth')->name('user.2fa');
Route::get('/tg', 'RequestController@tg')->name('rq.tg');


Route::resource('user', 'UserController');
Route::resource('zone', 'ZoneController');
Route::resource('branchdept', 'BranchDeptController');
Route::resource('setting', 'SettingController');
Route::resource('usermsg', 'UserMsgController');
Route::resource('subsystem', 'SvcEquipTypeController');
Route::resource('subcategory', 'SvcEquipCategoryController');
Route::resource('requestitem', 'SvcEquipItemsController');
Route::resource('svcequip', 'SvcEquipController');
Route::resource('usertype', 'UserTypeController');
Route::resource('permission', 'PermissionController');
Route::resource('useraccess', 'AccessStatusController');
// Route::resource('rq', 'RequestController');
//Route::resource('com_req', 'SvcEquipItemsController');


Route::view('/it_service', 'request_items.service');
Route::view('/acc_manage', 'management.accountmgm');
Route::view('/acc_manage/req_newacc', 'management.reqnewacc');
Route::view('/req_tray', 'request_items.tray');