@extends('layout')

@section('css')
@parent
{{ HTML::style('css/datepicker3.css'); }}
@stop

@section('bottom_js')
@parent
{{ HTML::script('js/bootstrap-datepicker.js') }}
<script>
$('.input-group.date').datepicker({
    startDate: "02/28/2012",
    todayBtn: "linked",
    daysOfWeekDisabled: "0",
    autoclose: true,
    todayHighlight: true,
	format: 'mm-dd-yyyy',
	endDate: '+7d',
});
</script>
@stop

@section('content')
<hr/>
<div class="col-md-6">
	<div class="well">
	Look up what food courts have served in the past, or view what they will serve in the future (up to one week).<hr/>
	@if(Session::has('search_date_error'))
		<div class="alert alert-danger">
			{{ Session::get('search_date_error') }}
		</div>
	@endif
	
	{{Form::open(array('action' => 'SearchController@redirectToDate'))}}
	<div class="form-group">
		{{Form::label('insertDate', 'Date')}}
		<div class="input-group date">
			{{Form::text('date', null, array('class' => 'form-control', 'placeholder' => $data['current_date'], 'id' => 'insertDate' ))}}<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
	</div>
	<div class="form-group">
		{{Form::label('selectHall', 'Select Hall')}}
		{{Form::select('name', array('Earhart' => 'Earhart', 'Ford' => 'Ford', 'Hillenbrand' => 'Hillenbrand', 'Wiley' => 'Wiley', 'Windsor' => 'Windsor'), "Earhart", array('class' => 'form-control'))}}
	</div>
	{{Form::submit('Search &raquo;', array('class' => 'btn btn-primary'))}}
	{{ Form::close() }}
	</div>
</div>

<div class="col-md-6">
	<div class="well">
	Want to know when a dish will reappear in the dining courts? Search the name of the food below!<br/><hr/>
		@if(Session::has('search_food_error'))
		<div class="alert alert-danger">
			{{ Session::get('search_food_error') }}
		</div>
	@endif
	{{Form::open(array('action' => 'SearchController@searchByFood'))}}
	<div class="form-group">
		{{Form::label('insertFood', 'Name of Food')}}
		{{Form::text('food', null, array('class' => 'form-control', 'placeholder' => 'Name of Food', 'id' => 'insertFood' ))}}
	</div>
	{{Form::submit('Search &raquo;', array('class' => 'btn btn-primary'))}}
	{{ Form::close() }}
	</div>
</div>
@stop