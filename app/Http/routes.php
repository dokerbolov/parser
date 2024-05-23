<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ListController;

// Authentication and Registration Routes (allowing guest users)
Route::get('/get-xml-matches', 'ListController@getXmlServer');

Route::group(['middleware' => 'guest', 'prefix' => 'auth'], function () {
    Route::get('/login', 'Auth\AuthController@getLogin');
    Route::post('/login', 'Auth\AuthController@postLogin');
    Route::get('/register', 'Auth\AuthController@getRegister');
    Route::post('/register', 'Auth\AuthController@postRegister');
});

// All other routes with 'auth' middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', 'Auth\AuthController@getLogout');

    Route::get('/', function () {
        return redirect('/list');
    });

    Route::get('/download-xml', 'ListController@downloadXML')->name('downloadXml');
    Route::get('/download-server-xml', 'ListController@downloadServerXml')->name('downloadServerXml');
    Route::get('/update-xml', 'ListController@updateXML')->name('updateXml');

    Route::get('/list', 'ListController@getListOfMatches')->name('list');
    Route::group(['prefix' => 'forms'], function () {
        Route::get('/create', 'FormController@create')->name('formCreate');

        Route::get('/{lists}/edit', 'FormController@edit')->name('formEdit');
        Route::post('/{lists}', 'FormController@update')->name('formUpdate');
        Route::delete('/{lists}', 'FormController@delete')->name('formDestroy');
    });
    Route::post('/submit-lists', 'FormController@handleForm')->name('submitForm');


    Route::get('/channel', 'ChannelController@getListOfChannels')->name('channel');
    Route::group(['prefix' => 'channels'], function () {
        Route::get('/create', function () {
            return view('channels.form');
        })->name('ChannelCreate');

        Route::get('/{channel}/edit', 'ChannelController@edit')->name('channelEdit');
        Route::post('/{channel}', 'ChannelController@update')->name('channelUpdate');
        Route::delete('/{channel}', 'ChannelController@delete')->name('channelDestroy');
    });
    Route::post('/submit-channel', 'ChannelController@handleForm')->name('channelSubmitForm');

    Route::get('/genre', 'GenreController@getListOfGenres')->name('genre');
    Route::group(['prefix' => 'genre'], function () {
        Route::get('/create', function () {
            return view('genres.form');
        })->name('GenreCreate');

        Route::get('/{genre}/edit', 'GenreController@edit')->name('genreEdit');
        Route::post('/{genre}', 'GenreController@update')->name('genreUpdate');
        Route::delete('/{genre}', 'GenreController@delete')->name('genreDestroy');
    });
    Route::post('/submit-genre', 'GenreController@handleForm')->name('genreSubmitForm');
});