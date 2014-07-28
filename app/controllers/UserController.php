<?php
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
use Facebook\FacebookJavaScriptLoginHelper;
FacebookSession::setDefaultApplication('309640359218030', 'e80105d3f5ccdb973d2773f7c9204f6c');
class UserController extends BaseController {
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
			$shortcode = substr(md5(rand()), 0, 3);
			$getUpload = Uploads::firstOrNew(array('email' => Auth::user()->email, 'food_id' => Input::get('food_id'), 'filename' => ''));
			$getUpload->email = Auth::user()->email;
			$getUpload->food_id = Input::get('food_id');
			$getUpload->shortcode = $shortcode;
			$getUpload->save();
			$return_data = array('status' => 'success', 'code' => $shortcode); 
		}
		header('Content-Type: application/json');
		echo json_encode($return_data);
		exit();
	}

    /**
     * Displays the form for account creation
     *
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'))->with('title', 'Registration');
    }
	
    public function details()
    {
        $data['name'] = "";
        return View::make('user.details',compact('data'));
    }	
    /**
     * Stores new account
     *
     */
    public function store()
    {
        $user = new User;
		$user->firstname = Input::get( 'firstname' );
		$user->lastname = Input::get( 'lastname' );
        $user->username = Input::get( 'username' );
        $user->email = Input::get( 'email' );
        $user->password = Input::get( 'password' );

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = Input::get( 'password_confirmation' );

        // Save if valid. Password field will be hashed before save
        $user->save();

        if ( $user->id )
        {
                        $notice = Lang::get('confide::confide.alerts.account_created') . ' ' . Lang::get('confide::confide.alerts.instructions_sent'); 
                    
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
                        return Redirect::action('UserController@login')
                            ->with( 'notice', $notice );
        }
        else
        {
            // Get validation errors (see Ardent package)
            $error = $user->errors()->all(':message');

                        return Redirect::action('UserController@create')
                            ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the login form
     *
     */
    public function login()
    {
        if( Confide::user() )
        {
            // If user is logged, redirect to internal 
            // page, change it to '/admin', '/dashboard' or something
            return Redirect::to('/');
        }
        else
        {
            session_start();
            $helper = new FacebookRedirectLoginHelper(url('fb/callback'));
            $data['fb_loginUrl']=$helper->getLoginURL(array('scope' => 'publish_stream, email'));
            return View::make(Config::get('confide::login_form'), compact('data'))->with('title', 'Login');;
        }
    }

    /**
     * Attempt to do login
     *
     */
    public function do_login()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // so we have to pass both
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );

        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Get the value from the config file instead of changing the controller
        if ( Confide::logAttempt( $input, Config::get('confide::signup_confirm') ) ) 
        {
            // Redirect the user to the URL they were trying to access before
            // caught by the authentication filter IE Redirect::guest('user/login').
            // Otherwise fallback to '/'
            // Fix pull #145
            return Redirect::intended('/'); // change it to '/admin', '/dashboard' or something
        }
        else
        {
            $user = new User;

            // Check if there was too many login attempts
            if( Confide::isThrottled( $input ) )
            {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            }
            elseif( $user->checkUserExists( $input ) and ! $user->isConfirmed( $input ) )
            {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            }
            else
            {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

                        return Redirect::action('UserController@login')
                            ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param    string  $code
     */
    public function confirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
                        return Redirect::action('UserController@login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
                        return Redirect::action('UserController@login')
                            ->with( 'error', $error_msg );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function forgot_password()
    {
        return View::make(Config::get('confide::forgot_password_form'))->with('title', 'Forgot Password');;
    }

    /**
     * Attempt to send change password link to the given email
     *
     */
    public function do_forgot_password()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
                        return Redirect::action('UserController@login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
                        return Redirect::action('UserController@forgot_password')
                            ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function reset_password( $token )
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     */
    public function do_reset_password()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
                        return Redirect::action('UserController@login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
                        return Redirect::action('UserController@reset_password', array('token'=>$input['token']))
                            ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function logout()
    {
        Confide::logout();
        
        return Redirect::to('/');
    }
    public function updateSettingsToggles() {
        $data = array(
            'settingToggle'=> Input::get('settingToggle'),
            'user_id'=>     Input::get('user_id'),
            'value'=>  Input::get('value'),
        );
        $query="update users set ".$data['settingToggle']." = ".((int)($data['value']=="true"))." where id = ".$data['user_id']."";
        DB::update($query);
        return 'Updated!';

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
        if ($session) {
            Clockwork::info("logged in via fb!");
            // Logged in.
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(GraphUser::className());
            $id=$user_profile->getID();
            $email=$user_profile->getProperty('email');
            //var_dump($user_profile);
            $user = User::where(array('fb_id'=>$id))->first();
            Clockwork::info($user_profile); // 'Message text.' appears in Clockwork log tab
            if($user==null)
            {

                Clockwork::info("fb profile not connected or something");
                $user = User::where(array('email'=>$email))->first();
                if($user!=null)
                {
//                    var_dump($id);
//                    var_dump($user);
                    Clockwork::info('need to link!');
                    //account exists already, needs to be linked
                    $user->fb_id=$id;
                    $user->save();
                    Auth::login($user);
                    return Redirect::to('user/details');

                }
                else
                {
                    Clockwork::info("creating!");
                    $user = new User;
                    $user->fb_id=$id;
                    $user->firstname=$user_profile->getProperty('first_name');
                    $user->lastname=$user_profile->getProperty('last_name');
                    $user->fb_id=$id;
                    $user->username=$id;
                    $user->confirmed=1;
                    $user->save();
                    Auth::login($user);
                    Clockwork::info($user);
                    return Redirect::to('user/details');

                    //$user-
                    //no account at all
                }
            }
            else
            {
                Auth::login($user);
                return Redirect::to('user/details');
            }

        }
    }

}
