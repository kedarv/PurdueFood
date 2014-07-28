<?php
class DiningController extends BaseController {
protected static $restful = true;
	public function getContentDataAttribute($data) {
		return json_decode($data);
	}
    public function pushData($name = NULL, $date = NULL){
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
		/*$getVotes = Reviews::where('reviews.food_id', '=', $id)
					->join('votes', 'votes.comment_id', '=', 'reviews.id')
					->get(array('votes.vote', 'votes.user_id', 'votes.comment_id'))->toArray();
		*/
		$images = Uploads::where('food_id', '=', $id)->where('filename', '!=', '')->get()->toArray();
		
		////////////////////////////////////////////////////////////////////
		// THIS BLOCK SHOULD BE MERGED AS A JOIN
        $query = Reviews::where('user_id', '=', Auth::id())
            ->where('food_id', '=', $id, 'AND');
        if($query->count()>=1){
            $updated=$query->first();
            $data['currentUserRating']=$updated->rating;
            $data['currentUserComment']=$updated->comment;
        }
        else {
            $data['currentUserRating']=0;
            $data['currentUserComment']="";
        }

        $favoriteLookup=Favorites::where('user_id', '=', Auth::id()) ->where('food_id', '=', $id, 'AND');
        $data['isFavorite']=0;
        if($favoriteLookup->count()==1)
        {
            $data['isFavorite']=$favoriteLookup->first()->favorite;
        }
		// THIS BLOCK SHOULD BE MERGED AS A JOIN
		////////////////////////////////////////////////////////////////////

		// Pass data to view
		return View::make('food', compact('data', 'json', 'reviews', 'images'));
	}
    public function setStar() {
		// Verify that request is ajax, and that the user id sent is equal to the actual user id
		if (Request::ajax() && Input::get('user_id') == Auth::id()){
			$data = array(
				'food_id'=> Input::get('food_id'),
				'rating'=>  Input::get('rating'),

			);
			$getReview = Reviews::firstOrNew(array('user_id' => Auth::user()->id, 'food_id' => Input::get('food_id')));
			if(time() > strtotime($getReview['updated_at']) + 30) {
				$getReview->rating = $data['rating'];
				$getReview->food_id = $data['food_id'];
				$getReview->updated_at = date('Y-m-d H:i:s', time());
				$getReview->save();
				$return_data = array('status' => 'success', 'text' => 'Thanks for voting!'); 
			} else {
				$return_data = array('status' => 'info', 'text' => 'Please wait a bit before voting again.'); 
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
			$getReview = Reviews::firstOrNew(array('user_id' => Auth::user()->id, 'food_id' => Input::get('form.id')));
			if(strlen(Input::get('form.comment')) >= 10) {
				$getReview->comment = Input::get('form.comment');
				$getReview->food_id = Input::get('form.id');
				$getReview->updated_at = date('Y-m-d H:i:s', time());
				$getReview->save();
				$return_data = array('status' => 'success', 'text' => 'Thanks for commenting!', 'email' => md5(strtolower(trim(Auth::user()->email))), 'user' => Auth::user()->username, 'comment' => Input::get('form.comment'), 'time' => date('Y-m-d H:i:s', time())); 	
			}
			else {
				$return_data = array('status' => 'danger', 'text' => 'Please enter some content!');
			}
			header('Content-Type: application/json');
			echo json_encode($return_data);
			exit();
		}
	}
	public function insertVote() {
		if (Request::ajax()){
				if(Input::get('action') == "up") {
					$opp = "down"; // Opposite of action
					$vote = 1;
				}
				else {
					$opp = "up"; // Opposite of action
					$vote = 0;
				}
			$getVote = Votes::firstOrNew(array('user_id' => Auth::user()->id, 'comment_id' => Input::get('comment_id')));
			if(time() > strtotime($getVote['updated_at']) + 10) {
				$getVote->user_id = Auth::user()->id;
				$getVote->vote = $vote;
				$getVote->comment_id = Input::get('comment_id');
				$getVote->updated_at = date('Y-m-d H:i:s', time());
				$getVote->save();
				$return_data = array('status' => 'success', 'text' => 'Thanks for voting!', 'id' => Input::get('action'), 'opposite' => $opp); 
			} else {
				$return_data = array('status' => 'info', 'text' => 'Please wait a bit before voting again.', 'id' => Input::get('action'), 'opposite' => $opp);
			}
		} else {
			$return_data = array('status' => 'danger', 'text' => 'Something went wrong!', 'id' => Input::get('action'));
		}
		header('Content-Type: application/json');
		echo json_encode($return_data);
		exit();
	}
	
    public function updateFavorites()
    {
        if (Request::ajax() && Input::get('user_id') == Auth::id()){
            $data = array(
                'food_id'=> Input::get('food_id'),
                'user_id'=>  Input::get('user_id'),
                'value'=> Input::get('value'),
                'foodToggle' => Input::get('foodToggle')
            );

            $int=((int)($data['value']=="true"));
            $getFavorite = Favorites::firstOrNew(array('user_id' => $data['user_id'], 'food_id' => $data['food_id']));
            $getFavorite->favorite = $int;
            $getFavorite->save();
            if($int==0)
            {
                $text="Favorite Removed!";
            }
            else
            {
                $text="Marked as favorite!";
            }

                $return_data = array('status' => 'success', 'text' => $text);
        } else {
            $return_data = array('status' => 'danger', 'text' => 'Something went wrong!');
        }
        // Return JSON Reponse
        header('Content-Type: application/json');
        echo json_encode($return_data);
        exit();
    }
    public function receiveMailImages()
    {
        $username="api";
        $password="key-2b1dxrtom76-hpnspdqqwjfdbnqy84m9";
        $data = $_POST;

        $fromemail = $data['sender'];
        $subject = $data['subject'];
        $body = $data['body-plain'];
        error_log($fromemail);
        error_log($subject);
        error_log($body);
        $attachmentCount=count($data['attachments']);
        error_log($data['attachments']);
        error_log($attachmentCount);



        if(($attachmentCount)>=1)
        {
            $arr=json_decode($data['attachments']);
            foreach($arr as $item)
            {
                $url=$item->{'url'};
                $name=$item->{'name'};
                //File to save the contents to
                $fp = fopen ("uploads/".$fromemail."_".$subject."_".$name, 'w+');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_TIMEOUT, 50);

                //give curl the file pointer so that it can write to it
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                $data = curl_exec($ch);//get curl response
                curl_close($ch);
            }
        }
        $output = print_r($_REQUEST, true);
        file_put_contents('incomingmail.log', $output, FILE_APPEND);
    }
}