<?php

class SearchController extends Controller {
	//Make Page
	public function searchMain(){
		$data['name'] = "Search";
		$data['current_date'] = date('m-d-Y', time());
		return View::make('search', compact('data'));
	}
	//Validate Form data, redirect to DiningController@pushData if correct
	public function redirectToDate() {
		$validator = Validator::make(
			array('date' => Input::get('date')),
			array('date' => 'required|date_format:"m-d-Y"'),
			array('name' => Input::get('name')),
			array('name' => 'required"')
		);
		if ($validator->fails()) {
			Session::flash('search_date_error', 'Please fill in the form!');
			return Redirect::action('SearchController@searchMain');
		}
		else {
			return Redirect::action('DiningController@pushData', array('name' => Input::get('name'), 'date' => Input::get('date')));
		}
	}
	
	public function searchByFood(){
		if (Request::ajax()) {
			$validator = Validator::make(
				array('food' => Input::get('food')),
				array('food' => 'required|min:3')
			);
			if ($validator->fails()) {
				$json = json_encode(array('status' => 'danger', 'text' => 'Please fill in the form!'));
			}
			else { // Validation Passed
				$url = "http://api.hfs.purdue.edu/Menus/v2/search/". Input::get('food');
				if (Cache::has(Input::get('food') . "_search")) {
					$json = Cache::get(Input::get('food') . "_search");
				}
				else {
					$getfile = file_get_contents($url);
					$get_json = json_decode($getfile, true);
					foreach($get_json['Items'] as $item) {
						$result[$item['Name']] = $item['ID'];	
					}
					if(isset($result)) {
						$encoded_response = json_encode($result);
						Cache::forever(Input::get('food') . "_search", $encoded_response);
						$json = Cache::get(Input::get('food') . "_search");
					}
					else {
						$json = json_encode(array('status' => 'danger', 'text' => 'Could not find item'));
					}
				}
				//echo "http://api.hfs.purdue.edu/Menus/v2/V2Items/78dbc504-255a-4060-839b-fe17ce8e005b?schedule";
			}
			header('Content-Type: application/json');
			echo $json;
			exit();
		}
	}
}
