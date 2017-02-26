<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::controller('richard', 'RichardController');


Route::get('insert', 'InsertController@getIndex');
Route::post('fileupload', 'InsertController@post_upload');


Route::get('tables', 'TablesController@getIndex');


Route::get('overview', 'OverviewController@getIndex');
Route::get('api/point/{graph}/{due_id?}', 'ApiController@getPointData');
Route::get('api/avg/{graph}/{startDate}/{endDate}', 'ApiController@getAvgData');
Route::get('api2/{graph}/{date}/{endDate?}', 'ApiController@getFleetDueData');


Route::get('/test', function()
{
	return Session::all();
});

