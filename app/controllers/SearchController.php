<?php

class SearchController extends Controller {
	public function searchByDate(){
		$data['name'] = "Search";
		$data['current_date'] = date('m-d-Y', time());
		return View::make('search', compact('data'));
	}
	public function redirectToDate() {
		$validator = Validator::make(
			array('date' => Input::get('date')),
			array('date' => 'required|date_format:"m-d-Y"'),
			array('name' => Input::get('name')),
			array('date' => 'required"')
		);
		if ($validator->fails()) {
			Session::flash('search_error', 'Please fill in the form!');
			return Redirect::action('SearchController@searchByDate');
		}
		else {
			return Redirect::action('DiningController@pushData', array('name' => Input::get('name'), 'date' => Input::get('date')));
		}
	}
	
	public function searchByFood($date = NULL){
		
	}
}
