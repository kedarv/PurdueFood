@extends('layout')

@section('js')
@parent
{{ HTML::script('js/star-rating.min.js'); }}
@stop

@section('bottom_js')
@parent
{{ HTML::script('js/rating.js') }}
{{ HTML::script('libs/ckeditor/ckeditor.js') }}
{{ HTML::script('js/dropzone.js') }}
{{ HTML::script('js/jquery.fancybox.pack.js') }}
<script>
	$("#input-1").rating({
		starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
		starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
	});
	$(".fancybox").fancybox({
		openEffect  : 'elastic',
		closeEffect : 'elastic',
		nextEffect  : 'none',
		prevEffect : 'none',
	});
	CKEDITOR.replace('comment');
</script>
@stop

@section('css')
@parent
{{ HTML::style('css/dropzone.css'); }}
{{ HTML::style('css/jquery.fancybox.css'); }}
<style>
    input[type=checkbox] { display:none; } /* to hide the checkbox itself */
    input[type=checkbox] + label:before {
        font-family: FontAwesome;
        display: inline-block;
		position: absolute;
		margin-top: -22px;
        font-size: 2.8em;
		font-weight: 500;
        content: "\f004";
    }
    input[type=checkbox] + label:before { color: #BFBFBF; } /* allow space for check mark */
    input[type=checkbox]:checked + label:before { color: #F01D7C; } /* allow space for check mark */
	.code {
		padding: 2px 4px;
		font-size: 90%;
		color: #fff;
		background-color: #333;
		border-radius: 3px;
		box-shadow: inset 0 -1px 0 rgba(0,0,0,.25);
	}
	body.modal-open {
		overflow: visible;
	}
	.spinner {
	  width: 30px;
	  height: 30px;
	  background-color: #333;

	  margin: 100px auto;
	  -webkit-animation: rotateplane 1.2s infinite ease-in-out;
	  animation: rotateplane 1.2s infinite ease-in-out;
	}

	@-webkit-keyframes rotateplane {
	  0% { -webkit-transform: perspective(120px) }
	  50% { -webkit-transform: perspective(120px) rotateY(180deg) }
	  100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
	}

	@keyframes rotateplane {
	  0% { 
		transform: perspective(120px) rotateX(0deg) rotateY(0deg);
		-webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg) 
	  } 50% { 
		transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
		-webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg) 
	  } 100% { 
		transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
		-webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
	  }
	}
</style>
@stop

@section('append_header')
@parent
	<div style="display:inline-block;font-size:12px;">
		<input id="input-avgRating" value="{{$data['averageRating']}}" class="rating" data-disabled="true" data-show-clear="false" data-show-caption="false">
	</div>
@if (Auth::check())
    <div style="display:inline-block;font-size:12px;">
        {{Form::checkbox('Favorite', 'foodToggle_favorite', $data['isFavorite'], array('id' => 'favoriteCheckbox'))}}
        <label for="favoriteCheckbox"></label>
    </div>
@endif
</h1>
<a href="#" data-toggle="modal" data-target="#scheduleModal" data-id="{{$data['id']}}" data-name="{{$data['name']}}" id="info">View Item Schedule &raquo;</a>
<hr/>
@stop

@section('content')
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
		<table class='table'>
		<thead>
			<tr>
				<th>Date</th>
				<th>Location</th>
				<th>Meal</th>
			</tr>
			</thead>
			<tbody id='details_id'>
			</tbody>
		</table>
		<div class="spinner hidden" id="schedule_loader"></div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="uploadModalLabel">Upload image by email</h4>
      </div>
      <div class="modal-body">
        Please send an email with your image attached to {{ HTML::mailto('uploads@purduefood.com') }} with the subject: <span class="code" id="genCode">generating..</span>
		<hr/>
		If you are not using the same email address as your Purdue Food account, it may take up to 48 hours for your image to be processed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="row">
	@if (Auth::check())
	<div class="col-xs-6 col-md-4">
		<div class="thumbnail">
			<form id="my-awesome-dropzone" action="{{ url('users/upload')}}" class="dropzone">
				<input type="hidden" name="food_id" value="{{$data['id']}}" />
			</form>
		</div>
	</div>
	@endif
	@foreach($images as $image)
	<div class="col-xs-6 col-md-2">
		<a rel="gallery" class="fancybox thumbnail" href="{{URL::to('/')}}/uploads/{{($image['filename'])}}">
			<img src="{{URL::to('/')}}/uploads/{{($image['filename'])}}" style="height: 110px;" class="img-responsive">
		</a>
	</div>
	@endforeach
	@if (Auth::check())
	<div class="col-md-12">
		<a href="#" id="generate_code" data-toggle="modal" data-target="#myModal" data-user="{{Auth::id()}}" data-food="{{$data['id']}}">Upload an image by sending an email &raquo;</a>
	</div>
	@endif
</div>

<div class="alert hidden" role="alert" id="postFavoriteAlert"></div>
<input type="hidden" id="id_data" data-user="{{Auth::id()}}" data-food="{{$data['id']}}">
	@if (Auth::check())
	<hr/>
	<input id="input-1" class="rating"  value="{{$data['currentUserRating']}}">
	<div class="alert hidden" role="alert" id="postRatingAlert"></div>
    {{Form::button('Update Review &raquo;', array('class' => 'btn btn-primary hidden', 'id' => 'updateCommentButton'))}}
	<div class="alert hidden" id="commentAlert"></div>
    <div id="commentArea" >
        {{Form::open(array('action' => 'DiningController@insertComment', 'id' => 'submit-comment', 'data-id' => $data['id']))}}
        {{Form::textarea('comment', $data['currentUserComment'], array('class' => 'form-control', 'rows' => '3', 'id' => 'comment', 'required'))}}
        <br>
        {{Form::button('Submit Review &raquo;', array('class' => 'btn btn-primary', 'type' => 'submit', 'data-user' => Auth::user()->id))}}
        {{ Form::close() }}
    </div>
	@else
	Hey, you need an account to comment! {{ HTML::linkAction('UsersController@create', 'Register', 'Register') }} or {{ HTML::linkAction('UsersController@login', 'Login', 'Login') }}
	@endif
	<hr/>
	<div class="comments"></div>
		@foreach(array_chunk($reviews, 2) as $twoReviews)
			<div class="row">
			@foreach($twoReviews as $review)
			<div class="col-md-6">
				<div class="well" id="{{$review['id']}}">
					<img src="https://www.gravatar.com/avatar/{{md5(strtolower(trim($review['email'])))}}?&r=x&d=identicon" alt="{{{ $review['firstname'] or $review['username'] }}}" class="img-responsive" style="float:left;padding-right:10px;"/>
					<h4 style="margin:0px 0px 0px 95px;">{{{ $review['firstname'] }}} {{{substr($review['lastname'], 0, 1)}}}.</h4>
					<input id="input-avgRating" value="{{$review['rating']}}" class="rating" data-size="xs" data-disabled="true" data-show-clear="false" data-show-caption="false">	
					<small>Posted {{$review['created_at']}}</small>
					<hr/>
					 {{Purifier::clean($review['comment'])}}
				</div>
			</div>
			@endforeach
			</div>
		@endforeach	
@stop