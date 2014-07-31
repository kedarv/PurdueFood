@extends('user/layout')
@section('css')
@parent

{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'); }}
<style>
.btn-facebook {
	color: #fff;
	background-color: #3b5998;
	border-color: rgba(0,0,0,0.2);
	padding: 10px 0px !important;
}
.btn-facebook:hover{
	color: #fff;
	background-color: #30487b;
}
.btn-facebook-i {
	width: 20px;
	padding-right: 5px;
	border-right: 1px solid rgba(0,0,0,0.2);
}
</style>
@stop

@section('content')
<div class="text-center">
<a href="{{ action('UsersController@fbGoToLoginUrl')}}" class="btn btn-lg btn-facebook" style="width:215px;">
	<i class="fa fa-facebook btn-facebook-i"></i> Login with Facebook
</a>
</div>
<hr/>
<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input class="form-control" placeholder="First Name" type="text" name="firstname" id="firstname" value="{{{ Input::old('firstname') }}}">
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input class="form-control" placeholder="Last Name" type="text" name="lastname" id="lastname" value="{{{ Input::old('lastname') }}}">
        </div>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>({{ Lang::get('confide::confide.signup.confirmation_required') }})</small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if ( Session::get('error') )
            <div class="alert alert-error alert-danger">
                @if ( is_array(Session::get('error')) )
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
@stop