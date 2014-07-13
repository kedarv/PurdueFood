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

Route::get('/', array('as' => 'home', function()
{
	return View::make('home');
}));
Route::get('dining/{name?}/{date?}', 'DiningController@pushData')
->where(array('name' => 'Earhart|Ford|Hillenbrand|Wiley|Windsor', 'date' => '[0-9]{2}-[0-9]{2}-[0-9]{4}+'));