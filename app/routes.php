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

// Confide routes
Route::get( 'users/create',                 'UsersController@create');
Route::post('users',                        'UsersController@store');
Route::get( 'users/login',                  'UsersController@login');
Route::post('users/login',                  'UsersController@do_login');
Route::get( 'users/confirm/{code}',         'UsersController@confirm');
Route::get( 'users/forgot_password',        'UsersController@forgot_password');
Route::post('users/forgot_password',        'UsersController@do_forgot_password');
Route::get( 'users/reset_password/{token}', 'UsersController@reset_password');
Route::post('users/reset_password',         'UsersController@do_reset_password');
Route::get( 'users/logout',                 'UsersController@logout');

// Additional Confide Routes
Route::get('user/details',                 array('before' => 'auth', 'uses' => 'UsersController@details'));

//Upload Route
Route::post('users/upload',                 'UsersController@post_upload');
Route::post('users/generateCode',            'UsersController@generateEmailCode');

//Rating, Comment, Favorite Routes
Route::post('ratings/setStar',               'DiningController@setStar');
Route::post('ratings/insertComment',         array('before' => 'csrf|auth', 'uses' => 'DiningController@insertComment'));
Route::post('user/updateSettingsToggles',    'UsersController@updateSettingsToggles');
Route::post('favorites/update',              'DiningController@updateFavorites');
Route::post('ratings/insertVote',            array('before' => 'auth', 'uses' => 'DiningController@insertVote'));

//Search Routes
Route::post('search/by/date',               array('before' => 'csrf', 'uses' => 'SearchController@redirectToDate'));
Route::post('search/by/food',               array('before' => 'csrf', 'uses' => 'SearchController@searchByFood'));
Route::post('search/schedule',              'SearchController@getSchedule');
Route::post('mail/receiveimages', 			'DiningController@receiveMailImages');
Route::get('fb/callback', 					'UsersController@fbCallback');
Route::get('fb/auth', array('uses' => 'UsersController@fbGoToLoginUrl'));


Route::post('followers/update',              'UsersController@updateFollowers');


//Confide Custom Validator
App::bind('confide.user_validator', 'CustomValidator');

//temp
//Route::get( 'dining/temp',                 'DiningController@tempProc');
