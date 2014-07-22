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
		$reviews = Reviews::where('food_id', '=', $id)
					->join('users', 'reviews.user_id', '=', 'users.id')
					->get(array('reviews.*', 'users.username', 'users.email'));
		$data['numVotes'] = $reviews->count();
		if($data['numVotes'] > 0) {
			// Round votes to nearest .5
			$notrounded_average = $reviews->sum('rating')/$reviews->count();
			$data['averageRating'] = round($notrounded_average * 2, 0)/2;
		}
		else {
            $data['averageRating'] = 0;
		}

		// Push reviews to array
		$reviews = $reviews->toArray();

        $query = Reviews::where('user_id', '=', Auth::id())
            ->where('food_id', '=', $id, 'AND');
        if($query->count()>=1)
        {
            $updated=$query->first();
            $data['currentUserRating']=$updated->rating;
        }
        else
        {
            $data['currentUserRating']=0;
        }


		// Pass data to view
		return View::make('food', compact('data', 'json', 'reviews'));
	}
    public function setStar() {
		// Verify that request is ajax, and that the user id sent is equal to the actual user id
		if (Request::ajax() && Input::get('user_id') == Auth::id()){
			$data = array(
				'food_id'=> Input::get('food_id'),
				'user_id'=> Input::get('user_id'),
				'rating'=>  Input::get('rating'),

			);
			$query = Reviews::where('user_id', '=', $data['user_id'])
				->where('food_id', '=', $data['food_id'], 'AND');
			if($query->count() == 1) {
				$updated = $query->first();
				if(time() > strtotime($updated['updated_at']) + 30) {
					$updated->rating = $data['rating'];
					$updated->updated_at = date('Y-m-d H:i:s', time());
					$updated->save();
					$return_data = array('status' => 'success', 'text' => 'Thanks for voting!'); 
				} else {
					$return_data = array('status' => 'info', 'text' => 'Please wait a bit before voting again.'); 
				}
			}
			else {
				$rating = Reviews::firstOrNew($data);
				$rating->save();
				$return_data = array('status' => 'success', 'text' => 'Thanks for voting!'); 
			}
		} else {
			$return_data = array('status' => 'danger', 'text' => 'Something went wrong!'); 
		}
		// Return JSON Reponse
		header('Content-Type: application/json');
		echo json_encode($return_data);
		exit();
    }
	public function insertComment() {
		if (Request::ajax()) {
		
			$getReview = Reviews::firstOrNew(array('user_id' => Auth::user()->id));
			$getReview->comment = Input::get('form.comment');
			$getReview->food_id = Input::get('form.id');
			$getReview->save();
			
			$return_data = array('status' => 'success', 'text' => 'Thanks for commenting!', 'email' => md5(strtolower(trim(Auth::user()->email))), 'user' => Auth::user()->username, 'comment' => Input::get('form.comment'), 'time' => date('Y-m-d H:i:s', time())); 
			header('Content-Type: application/json');
			echo json_encode($return_data);
			exit();
		}
	}
}