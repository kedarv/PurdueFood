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
<a href="{{ action('UserController@fbGoToLoginUrl')}}" class="btn btn-lg btn-facebook" style="width:215px;">
	<i class="fa fa-facebook btn-facebook-i"></i> Login with Facebook
</a>
</div>
<hr/>
<form method="POST" action="{{{ Confide::checkAction('UserController@do_login') ?: URL::to('/user/login') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.username_e_mail') }}}</label>
            <input class="form-control" tabindex="1" placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
        <label for="password">
            {{{ Lang::get('confide::confide.password') }}}
            <small>
                <a href="{{{ (Confide::checkAction('UserController@forgot_password')) ?: 'forgot' }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a>
            </small>
        </label>
        <input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="remember" class="checkbox">{{{ Lang::get('confide::confide.login.remember') }}}
                <input type="hidden" name="remember" value="0">
                <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
            </label>
        </div>
        @if ( Session::get('error') )
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif
        <div class="form-group">
            <button tabindex="3" type="submit" class="btn btn-default">{{{ Lang::get('confide::confide.login.submit') }}}</button>
        </div>
    </fieldset>
</form>
@stop