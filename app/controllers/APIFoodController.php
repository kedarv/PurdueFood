<?php

class APIFoodController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
        return "Hello World [API]";
	}
	public function show($id){
		$check = Foods::where('food_id', '=', $id)->count();
		if($check == 1) {
			$content = Foods::find($id)->toJson();
			$response = Response::make($content);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		else {
			$content = ["Bad Request"];
			$response = Response::make($content, 200);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
	}
}