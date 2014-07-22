@extends('layout')

@section('bottom_js')
@parent
{{ HTML::script('js/rating.js') }}
{{ HTML::script('libs/ckeditor/ckeditor.js') }}
<script>
	CKEDITOR.replace('comment');
</script>
@stop

@section('append_header')
@parent
	<div style="display:inline-block;font-size:12px;">
		<input id="input-avgRating" value="{{$data['averageRating']}}" class="rating" data-disabled="true" data-show-clear="false" data-show-caption="false">
	</div>
@stop

@section('content')
	{{var_dump($json)}}
	<hr/>
	@if (Auth::check())
	<b>Reviewing as {{Auth::user()->username}}</b> [User ID: {{Auth::user()->id}} on {{$data['id']}}]
	<br>
	<input id="input-1" class="rating"  value="{{$data['currentUserRating']}}" data-user="{{Auth::user()->id}}" data-food="{{$data['id']}}">
	<div class="alert hidden" role="alert" id="postRatingAlert">
	</div>
    {{Form::button('Update Review &raquo;', array('class' => 'btn btn-primary hidden', 'id' => 'updateCommentButton'))}}
    <div id="commentArea" >
        {{Form::open(array('action' => 'DiningController@insertComment', 'id' => 'submit-comment', 'data-id' => $data['id']))}}
        {{Form::textarea('comment', $data['currentUserComment'], array('class' => 'form-control', 'rows' => '3', 'id' => 'comment', 'required'))}}
        <br>
        {{Form::button('Submit Review &raquo;', array('class' => 'btn btn-primary', 'type' => 'submit', 'data-user' => Auth::user()->id))}}
        {{ Form::close() }}
    </div>
	<div class="alert hidden" id="commentAlert"></div>
	@else
	Hey, you need an account to comment! {{ HTML::linkAction('UserController@create', 'Register', 'Register') }} or {{ HTML::linkAction('UserController@login', 'Login', 'Login') }}
	@endif
	<hr/>
	<div class="row">
	<div class="comments"></div>
		@foreach(array_chunk($reviews, 2) as $twoReviews)
			<div class="row">
			@foreach($twoReviews as $review)
			<div class="col-md-6">
				<div class="well">
					<img src="http://www.gravatar.com/avatar/{{md5(strtolower(trim($review['email'])))}}?&r=x&d=identicon" alt="{{$review['username']}}" class="img-responsive" style="float:left;padding-right:10px;"/>
					<h4 style="margin:0px 0px 0px 95px;">{{$review['username']}}</h4>
					<input id="input-avgRating" value="{{$review['rating']}}" class="rating" data-size="xs" data-disabled="true" data-show-clear="false" data-show-caption="false">	
					<small>Posted {{$review['created_at']}}</small>
					<hr/>
					{{$review['comment']}}
				</div>
			</div>
			@endforeach
			</div>
		@endforeach	
		</div>
@stop