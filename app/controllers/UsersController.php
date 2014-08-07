<?php
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
use Facebook\FacebookJavaScriptLoginHelper;
FacebookSession::setDefaultApplication(Config::get('keys.fb_appid'), Config::get('keys.fb_secret'));
/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller {
	/* Custom User Methods */
public function details() {
			$data['name'] = Auth::user()->firstname . "'s Profile";

			$favorites = Favorites::where('user_id', '=', Auth::id())
				->where('favorite', '=', 1, 'AND')->get();
			$favoriteArray=array();
			foreach($favorites as $each)
			{
				$name=$each['food_id'];
				$foodLookup=Foods::find($each['food_id']);
				if($foodLookup!=null)
				{
					$name=$foodLookup->name;
				}
				array_push($favoriteArray,array('name'=>$name,'food_id'=>$each['food_id']));
			}
			$data['favorites'] = $favoriteArray;

			$reviews = Reviews::where('user_id', '=', Auth::id())->get();
			$reviewsArray=array();
			foreach($reviews as $each)
			{
				$name=$each['food_id'];
				$foodLookup=Foods::find($each['food_id']);
				if($foodLookup!=null)
				{
					$name=$foodLookup->name;
				}
				array_push($reviewsArray,array('name'=>$name,'food_id'=>$each['food_id'],'comment'=>$each['comment'],'rating'=>$each['rating'], 'comment_id' => $each['id']));
			}
			$data['numFav'] = $favorites->count();
			$data['numReviews'] = $reviews->count();
			$data['reviews']=$reviewsArray;

			return View::make('user.details',compact('data'));
		}
	// Upload image
	public function post_upload() {
		$file = array('image' => Input::file('file'));
		$rules = array(
			'image' => 'image|max:2500|mimes:jpeg,png,bmp'
		);
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
			return Response::json('error1', 400);
		}
		else {
			$filename = Str::random(20) . '.' . Input::file('file')->guessExtension();
			$destinationPath = 'uploads';
			$upload_success = Input::file('file')->move($destinationPath, $filename);
			if( $upload_success ) {
				$upload = Uploads::create(array('food_id' => Input::get('food_id'), 'filename' => $filename, 'email' => Auth::user()->email));
				return Response::json('success', 200);
			} else {
			   return Response::json('error', 400);
			}
		}
	}
	// Generate code for image upload by email
	public function generateEmailCode(){
		if (Request::ajax()) {
			$checkUpload = Uploads::where('email', '=', Auth::user()->email)
							->where('food_id', '=', Input::get('food_id'))
							->where('filename', '=', '');
			if($checkUpload->count() == 1) {
				$getUpload = $checkUpload->get()->toArray();
				$return_data = array('status' => 'success', 'code' => $getUpload[0]['shortcode']); 
			}
			else {
				$shortcode = substr(md5(rand()), 0, 3);
				Uploads::create(array('email' => Auth::user()->email, 'food_id' => Input::get('food_id'), 'filename' => '', 'shortcode' => $shortcode));
				$return_data = array('status' => 'success', 'code' => $shortcode); 
			}
		}
		header('Content-Type: application/json');
		echo json_encode($return_data);
		exit();
	}
    public function fbGoToLoginUrl()
    {
        $helper = new FacebookRedirectLoginHelper(url('fb/callback'));
        session_start();
        return Redirect::to($helper->getLoginURL(array('scope' => 'publish_stream, email')));
    }
    public function fbCallback()
    {
        session_start();
        $helper = new FacebookRedirectLoginHelper(url('fb/callback'));
        try {
            $session = $helper->getSessionFromRedirect();
        } catch(FacebookRequestException $ex) {
            Clockwork::info($ex);
            // When Facebook returns an error
        } catch(\Exception $ex) {
            Clockwork::info($ex);
            // When validation fails or other local issues
        }
        if ($session)
        {
            Clockwork::info("fb callback success!");
            // Logged in.
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(GraphUser::className());
            $fb_id=$user_profile->getID();
            $email=$user_profile->getProperty('email');
            $user = User::where(array('fb_id'=>$fb_id))->first();
            Clockwork::info($user_profile); // 'Message text.' appears in Clockwork log tab
            if($user==null)
            {
                //fb uid not found in database
                Clockwork::info("fb profile not connected or something");
                $user2 = User::where(array('email'=>$email))->first();
                if($user2!=null)
                {
                    //account with facebook email exists already
                    Clockwork::info($user2);
                    Clockwork::info('need to link!');
                    $user2->fb_id=$fb_id;
                    $user2->save();
                    Clockwork::info($user2);
                    Clockwork::info($user2->errors()->all(':message'));

                    $query="update users set fb_id = ".$fb_id." where id = ".$user2->id."";
                    DB::update($query);

                    Auth::login($user2);

                }
                else
                {
                    //create fresh account
                    Clockwork::info("creating!");
                    $newUser = new User;
                    $newUser->fb_id=$fb_id;
                    $newUser->email=$email;
                    $newUser->firstname=$user_profile->getProperty('first_name');
                    $newUser->lastname=$user_profile->getProperty('last_name');
                    $newUser->username=$fb_id;
                    $newUser->confirmed=1;
                    $hash=Hash::make('asdfjh');
                    $newUser->password=$hash;//temporary
                    $newUser->password_confirmation=$hash;//temporary
                    $newUser->save();
                    Clockwork::info(array('user object'=>$newUser));
                    Clockwork::info(array('user id'=>$newUser->id));
                    Clockwork::info(array('errors'=>$newUser->errors()->all(':message')));
                    Auth::login($newUser);
                }
            }
            else
            {
                Clockwork::info("found matching fbid, logging in");
                Auth::login($user);
            }


            //extend the token
            $extendedToken = (new FacebookRequest(
                $session, 'GET', '/oauth/access_token',array(
                    'grant_type'=>'fb_exchange_token',
                    'client_id'=> Config::get('keys.fb_appid'),
                    'client_secret'=>Config::get('keys.fb_secret'),
                    'fb_exchange_token'=>$session->getToken()
                )
            ))->execute()->getGraphObject(GraphUser::className());
            $token=$extendedToken->getProperty('access_token');
            Clockwork::info(array("token"=>$token));
            //$query="update users set fb_token = ".$token." where id = ".Auth::id();
            $query= "UPDATE users SET fb_token = '".$token."' WHERE id = '".Auth::id()."'";
            DB::update($query);

            $permissionCheck = (new FacebookRequest(
                $session, 'GET', '/me/permissions'
            ))->execute()->getGraphObject()->asArray();
            Clockwork::info($permissionCheck);
            $permissionList = Array();
            foreach($permissionCheck as $eachPerm)
            {
                $permissionList[$eachPerm->permission] = $eachPerm->status;
            }
            if($permissionList['email']=="declined")
            {
                //uh oh
            }
            return Redirect::to('user/details');
        }
    }
    public function updateSettingsToggles() {
		$data = array(
			'settingToggle' =>	Input::get('settingToggle'),
            'user_id'		=>  Input::get('user_id'),
            'value'			=>  Input::get('value'),
        );
		$query= "UPDATE users SET ".$data['settingToggle']." = ".((int)($data['value']=="true"))." where id = ".$data['user_id']."";
		DB::update($query);
		return 'Updated!';
 }
	/* Confide Methods */
    /**
     * Displays the form for account creation
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'))->with('title', 'Registration');
    }

    /**
     * Stores new account
     * @return  Illuminate\Http\Response
     */
    public function store()
    {
        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id)
        {
            Mail::send(Config::get('confide::email_account_confirmation'), compact('user'), function($message) use ($user) {
                $message
                    ->to($user->email, $user->username)
                    ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
            });

            return Redirect::action('UsersController@login')
                ->with( 'notice', Lang::get('confide::confide.alerts.account_created') );
        }
        else
        {
            $error = $user->errors()->all(':message');

            return Redirect::action('UsersController@create')
                ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the login form
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if( Confide::user() )
        {
            return Redirect::to('/');
        }
        else
        {
            return View::make(Config::get('confide::login_form'))->with('title', 'Login');
        }
    }

    /**
     * Attempt to do login
     * @return  Illuminate\Http\Response
     */
    public function do_login()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input))
        {
            return Redirect::intended('/');
        }
        else
        {
            if ($repo->isThrottled($input))
            {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            }
            elseif ($repo->existsButNotConfirmed($input))
            {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            }
            else
            {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     * @param    string  $code
     * @return  Illuminate\Http\Response
     */
    public function confirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Displays the forgot password form
     * @return  Illuminate\Http\Response
     */
    public function forgot_password()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     * @return  Illuminate\Http\Response
     */
    public function do_forgot_password()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@forgot_password')
                ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Shows the change password form with the given token
     * @return  Illuminate\Http\Response
     */
    public function reset_password( $token )
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     * @return  Illuminate\Http\Response
     */
    public function do_reset_password()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get( 'token' ),
            'password'              =>Input::get( 'password' ),
            'password_confirmation' =>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( $repo->resetPassword( $input ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@reset_password', array('token'=>$input['token']))
                ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Log the user out of the application.
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

}
