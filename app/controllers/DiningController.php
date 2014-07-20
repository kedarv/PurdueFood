<?php
class DiningController extends BaseController {
protected static $restful = true;
	public function getContentDataAttribute($data) {
		return json_decode($data);
	}
    public function pushData($name = NULL, $date = NULL)
    {

		if($date == NULL) {
			$date = date('m-d-Y', time());
		}
		if($name == NULL) {
			$name = "Earhart";
		}
        $data['shortName'] = $name;
        $data['name'] = $name . " Dining Hall";
		$data['date'] = $date;
		$url = "http://api.hfs.purdue.edu/menus/v2/locations/". $name . "/".$date."";
		if (Cache::has($name . "_" . $date)) {
			$json = Cache::get($name . "_" . $date);
		} else {
			$getfile = file_get_contents($url);
			$cacheforever = Cache::forever($name . "_" . $date, $getfile);
			$json = Cache::get($name . "_" . $date);
		}
		$json = json_decode($json, true);
		return View::make('dining', compact('data', 'json'));
    }
	public function getFood($id){
		$url = "http://api.hfs.purdue.edu/Menus/v2/V2Items/".$id."";
		if (Cache::has($id)) {
			$json = Cache::get($id);
		} else {
			$getfile = file_get_contents($url);
			$cacheforever = Cache::forever($id, $getfile);
			$json = Cache::get($id);
		}
		$json = json_decode($json, true);
		$data['id'] = $id;
		$data['name'] = $json['Name'];
		
		// Get Relevant Reviews
		$reviews = Reviews::where('food_id', '=', $id)->get();
		
		if($reviews->count() > 0) { 
			// Sum ratings and divide by number of ratings to get an average
			$sum = ($reviews->sum('rating'))/($reviews->count());
			$rounded = round($sum * 2) / 2; // rounds to nearest .5
			$data['full_stars'] = floor( $rounded ); // number of full stars
			$data['half_stars'] = $rounded - $data['full_stars']; // .5 if half star
		}
		else {
			$data['full_stars'] = 0;
			$data['half_stars'] = 0;
		}
		
		// Push reviews to array
		$reviews = $reviews->toArray();
		
		// Pass data to view
		return View::make('food', compact('data', 'json', 'reviews'));
	}
	
}