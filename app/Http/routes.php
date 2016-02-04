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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@home');

Route::get('records','RecordsController@index');
Route::get('records/create','RecordsController@create');
Route::get('records/my','RecordsController@showmy');

Route::get('records/listpending/{mode}','RecordsController@listpending');


Route::get('about','HomeController@about');
Route::get('support','HomeController@support');

Route::get('records/map/{atlas}','RecordsController@map');
Route::get('records/{id}','RecordsController@show');

Route::post('records/create','RecordsController@store');
Route::post('records/accept/{id}','RecordsController@accept');
Route::post('records/reject/{id}','RecordsController@reject');
Route::post('records/confirm/{id}','RecordsController@confirm');


Route::post('gazeteer/create','GazeteerController@store');
Route::get('gazeteer/create','GazeteerController@create');
Route::get('gazeteer','GazeteerController@index');
Route::get('gazeteer/my','GazeteerController@showmy');
Route::get('gazeteer/{id}','GazeteerController@show');


Route::post('taxonomy/edit/{group}/{id}/{field}','TaxonomyController@edit');
Route::get('taxonomy/{id}','TaxonomyController@show');
Route::get('taxonomylist/{group}','TaxonomyController@index');
Route::get('taxonomylist/{group}/{name}','TaxonomyController@listnames');


Route::get('articles/create','ArticlesController@create');
Route::post('articles/store','ArticlesController@store');

Route::get('users/profile','UsersController@showmy');
Route::get('users/manage','UsersController@manage');
Route::get('users/validate','UsersController@validation ');


Route::get('collector/collector_records/{id}','RecordsController@showCollectorRecords');



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
