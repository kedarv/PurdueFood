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
Blade::extend(function($value)
{
  return preg_replace('/(\s*)@(break|continue)(\s*)/', '$1<?php $2; ?>$3', $value);
});

// Main Content Routes
Route::get('/', array('as' => 'home', function() {
	return View::make('home');
}));

Route::get('dining/{name?}/{date?}', 'DiningController@pushData')
->where(array('name' => 'Earhart|Ford|Hillenbrand|Wiley|Windsor', 'date' => '[0-9]{2}-[0-9]{2}-[0-9]{4}+'));

Route::get('dining/food/{id}', 'DiningController@getFood');

Route::get('search', 'SearchController@searchMain');

// Confide Routes
Route::get('user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get('user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get('user/confirm/{code}',         'UserController@confirm');
Route::get('user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get('user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get('user/logout',                 'UserController@logout');

// Additional Confide Routes
Route::get('user/details',                 array('before' => 'auth', 'uses' => 'UserController@details'));

//Upload Route
Route::post('user/upload',                 'UserController@post_upload');

//Rating, Comment, Favorite Routes
Route::post('ratings/setStar',               'DiningController@setStar');
Route::post('ratings/insertComment',         array('before' => 'csrf|auth', 'uses' => 'DiningController@insertComment'));
Route::post('user/updateSettingsToggles',   'UserController@updateSettingsToggles');
Route::post('favorites/update',               'DiningController@updateFavorites');
Route::post('ratings/insertVote',         array('before' => 'auth', 'uses' => 'DiningController@insertVote'));

//Search Routes
Route::post('search/by/date',              array('before' => 'csrf', 'uses' => 'SearchController@redirectToDate'));
Route::post('search/by/food',              array('before' => 'csrf', 'uses' => 'SearchController@searchByFood'));
Route::post('search/schedule',             'SearchController@getSchedule');