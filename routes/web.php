<?php
const PAGINATION_COUNT = 20;

use App\Model\Property;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Auth::routes(['verify'=>true]);

    Route::get('/','Front\WelcomeController@index');

    Route::get('/special-properties','Front\WelcomeController@allSpecial')->name('all.special.properties');
    Route::get('/s','Front\SearchController@mainSearch')->name('main.search');

    Route::get('/about','Front\AboutController@index')->name('about');

    Route::group(['namespace'=>'Front','prefix'=>'property'],function(){
        Route::get('/show/{id}','PropertyController@index')->name('show.property');
        Route::get('/add','PropertyController@create')->name('add.property');

        Route::any('get_cities','PropertyController@getCities')->name('get.cities')->middleware('cmr');
        Route::any('store','PropertyController@store')->name('store.property')->middleware('cmr');

        Route::get('edit/{id}','PropertyController@edit')->name('edit.property');

        Route::any('update','PropertyController@update')->name('update.property')->middleware('cmr');
        Route::any('comments','CommentPropertyController@store')->name('comments.store')->middleware('cmr');

        Route::get('search','SearchController@index')->name('index.search');

        Route::any('process','SearchController@process')->name('process.search')->middleware('cmr');

        Route::get('activation/{id}','PaymentController@activation')->name('property.activation');
        Route::get('get-check-id','PaymentController@getCheckId')->name('get.check.id');


        Route::get('/','PropertyController@showAllProperties')->name('show.all.properties');
        Route::get('/delete/{id}','PropertyController@delete')->name('delete.property');


        Route::post('favorite','PropertyController@favorite')->name('add.favorite');

    });

    Route::group(['namespace'=>'Front','prefix'=>'user','middleware'=>'auth'],function(){
        Route::get('/','UserController@index')->name('user.index')->middleware('verified');
        Route::get('/edit','UserController@edit')->name('user.edit');
        Route::get('/change_password','UserController@change_password')->name('user.change_password');
        Route::any('/store_change_password/{id}','UserController@store_change_password')->name('user.store_change_password')->middleware('cmr');
        Route::get('/favorite','UserController@favorite')->name('user.favorite');

        Route::any('/update/{id}','UserController@update')->name('user.update')->middleware('cmr');
    });
/*
    last eit eidt kovbko koviko
*/

});
