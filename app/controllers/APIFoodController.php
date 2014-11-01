<?php

class APIFoodController extends \BaseController {

	public $restful = true;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function get_index() {
        return "Hello World [API]";
	}
	
	public function get_food($id) {
		if (empty($id) || $id == null) {
			return null;
			http_response_code(400);
		}
		else {
			return Foods::find($id)->toJson();
		}
	}
}