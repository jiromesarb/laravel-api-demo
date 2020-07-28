<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [
    'as' => 'login.login',
    'uses' => 'Api\Auth\LoginController@login'
]);

Route::post('/forgot-password', 'Api\Auth\LoginController@forgotPassword');
Route::post('/reset-password/{token}', 'Api\Auth\LoginController@resetPassword');
Route::get('/forgot-password/check/{token}', 'Api\Auth\LoginController@checkForgotPassword');

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::post('/new-password', 'Api\Auth\LoginController@newPassword');
    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::group(['middleware' => ['access_control:admin']], function (){
        Route::resource('user', 'Api\UserController');
        Route::get('get-roles', 'Api\UserController@getRoles');
    });
});

Route::get('/person', function(){
    $person = [
        'first_name' => 'John',
        'last_name' => 'Doe',
    ];

    // return response()->json(['upload_file_not_found'], 400);
    return $person;
});
