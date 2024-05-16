<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ListController;

// Authentication and Registration Routes (allowing guest users)
Route::group(['middleware' => 'guest', 'prefix' => 'auth'], function () {
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');
});

// All other routes with 'auth' middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', 'Auth\AuthController@getLogout');

    Route::get('/', function () {
        return redirect('/list');
    });

    Route::get('/list', 'ListController@getListOfMatches')->name('list');

    Route::get('/lists', function () {
        return view('lists.list');
    })->name('lists');

    Route::group(['prefix' => 'forms'], function () {
        Route::get('/create', function () {
            return view('lists.form');
        })->name('formCreate');

        Route::get('/{lists}/edit', 'FormController@edit')->name('formEdit');
        Route::post('/{lists}', 'FormController@update')->name('formUpdate');
        Route::delete('/{lists}', 'FormController@delete')->name('formDestroy');
    });

    Route::group(['prefix' => 'channels'], function () {
        return view('channels.channels')->name('channels');
    });

    Route::post('/submit-lists', 'FormController@handleForm')->name('submitForm');
    Route::get('/download-xml', 'ListController@downloadXML')->name('downloadXml');
});