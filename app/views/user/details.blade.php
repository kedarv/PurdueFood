@extends('user/layout')
@section('content')
<b>Username:</b> {{Auth::user()->username}}
<br/>
<b>Email:</b> {{Auth::user()->email}}
<hr/>
Account created on {{date("F j Y", strtotime(Auth::user()->created_at))}}
@stop