<?php

use App\Model\Property;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
    Route::get('/','AdminController@dashboard')->name('admin.dashboard');
    Route::get('/user','AdminController@user')->name('admin.user');
    Route::get('/property','AdminController@property')->name('admin.property');
    Route::get('/login','AdminController@adminLogin')->name('admin.login');
    Route::post('/logout','AdminController@logout')->name('admin.logout');
    Route::any('/check','AdminController@adminCheck')->name('admin.check')->middleware('cmr');
    Route::get('/profile','AdminController@profile')->name('admin.profile');
    Route::get('/profile/edit','AdminController@profile_edit')->name('admin.profile.edit');
    Route::post('/profile/update/{id}','AdminController@profile_update')->name('admin.profile.update');


    Route::post('/verify','AdminController@verify_user')->name('admin.verify.user');

    // Route::get('/test', function(){

    //      $res = Property::find(11)->active(11);


    // });

});
