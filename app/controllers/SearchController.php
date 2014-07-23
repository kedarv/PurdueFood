<?php

class SearchController extends Controller {
	public function searchByDate(){
		$data['name'] = "Search";
		return View::make('search', compact('data'));
	}
	public function searchByFood($date = NULL){
		
	}
}
