@extends('layout')

@section('content')
	<b>endpoint:</b> http://api.hfs.purdue.edu/menus/v2/locations/{{{ $data['shortName'] }}}/{{{ $data['date'] }}}

	@foreach($json['Meals'] as $value)
		<div class="well"><h2 style="margin-top:0px;">{{{$value['Name']}}} <small>From {{{date('g:i A', strtotime($value['Hours']['StartTime']))}}} to {{{date('g:i A', strtotime($value['Hours']['EndTime']))}}}</small></h2><hr/>
		@if($value['Status'] == "Closed" || $value['Status'] == "Unavailable")
			<div class="alert alert-danger">Dining Court Closed</div></div>
			@continue
		@endif
		@foreach($value['Stations'] as $station)
			<h3>{{{$station['Name']}}}</h3>
				<div class="list-group">
			@foreach($station['Items'] as $items)
					<a href="{{action('DiningController@getFood', ['id' => $items['ID']])}}" class="list-group-item" style="padding-top:15px;">
						<h4 class="list-group-item-heading">{{{$items['Name']}}}
						@if($items['IsVegetarian'] == true)
							<span class="glyphicon glyphicon-leaf" style="color: green;"></span>
						@endif
						<span class="glyphicon glyphicon-chevron-right pull-right"></span>
						</h4>
					</a>
			@endforeach
			</div>
		@endforeach
		</div>
	@endforeach
@stop