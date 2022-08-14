<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::group(['namespace'=>'Api','middleware' =>['check.api.pass','change.api.lang']]
    ,function (){
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('me', 'AuthController@me');
        // register
        Route::post('register','Auth\RegisterController@create');

        // send email to set password
        Route::post('forgot_password', 'AuthController@forgot_password');
        Route::post('change_password', 'AuthController@change_password');
        // verify email
        Route::post('email/verify/{id}', 'AuthController@verify')->name('verify.verify'); // Make sure to keep this as your route name
        Route::post('email/resend', 'AuthController@resend')->name('verify.resend');

        // users api routes
        Route::group([
            'prefix' => 'user',
            'middleware' =>'auth:api'
        ], function (){
            // update user
            Route::post('update','UserController@update');
        });


        // Properties api routes
        Route::group([
            'prefix' => 'property',
        ], function (){
            // update user
            Route::post('create','PropertyController@create');
            Route::post('store','PropertyController@store');
            Route::post('edit','PropertyController@edit');
            Route::post('update','PropertyController@update');
            Route::post('delete','PropertyController@delete');
            Route::post('index','PropertyController@index');
            Route::post('showAll','PropertyController@showAllProperties');
            Route::post('special','PropertyController@allSpecial');
            Route::post('search','SearchController@mainSearch');


            Route::post('get_cities','PropertyController@getCities');
        });



});
