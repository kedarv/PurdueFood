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
	@if(Session::has('search_error'))
		<div class="alert alert-danger">
			{{ Session::get('search_error') }}
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
		search by food
	</div>
</div>
@stop