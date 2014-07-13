<?php
class DiningController extends BaseController {
protected static $restful = true;
	public function getContentDataAttribute($data) {
		return json_decode($data);
	}
    public function pushData($name = NULL, $date = NULL)
    {
		$data['name'] = $name;
		if($date == NULL) {
			$date = date('m-d-Y', time());
		}
		if($name == NULL) {
			$name = "Earhart";
		}		
		$data['date'] = $date;
		$url = "http://api.hfs.purdue.edu/menus/v2/locations/". $name . "/".$date."";
		$filename = "cache/" . $name . "_" . $date . ".txt";
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
}