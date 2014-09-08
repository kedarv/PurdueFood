@extends('layout')

@section('css')
@parent
{{ HTML::style('css/datepicker3.css'); }}
<style>
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

@section('bottom_js')
@parent
{{ HTML::script('js/rating.js') }}
{{ HTML::script('js/bootstrap-datepicker.js') }}
<script>
$('.input-group.date').datepicker({
    startDate: "02/28/2012",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true,
	format: 'mm-dd-yyyy',
	endDate: '+7d',
});
</script>
@stop

@section('content')
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		<div class="alert alert-danger hidden" id="search_by_food_error"></div>
		{{Form::open(array('action' => 'SearchController@searchByFood', 'id' => 'search_by_food'))}}
		<div class="form-group">
			{{Form::label('insertFood', 'Name of Food')}}
			{{Form::text('food', null, array('class' => 'form-control', 'placeholder' => 'Name of Food', 'id' => 'insertFood' ))}}
		</div>
		{{Form::submit('Search &raquo;', array('class' => 'btn btn-primary'))}}
		{{ Form::close() }}
		<div class="spinner hidden" id="search_loader"></div>
		<div class="results hidden" id="results_container"><hr/><div class="list-group" id="results"></div></div>
	</div>
</div>
@stop