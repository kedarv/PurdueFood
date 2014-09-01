@extends('layout')
@section('js')
@parent
<script>
console.log("endpoint: http://api.hfs.purdue.edu/menus/v2/locations/{{{ $data['shortName'] }}}/{{{ $data['date'] }}}");
</script>
@stop

@section('content')
<a href="https://www.google.com/maps/dir/Current+Location/{{{urlencode($data['nav_link'])}}}+Lafayette+IN">Navigate to {{{$data['shortName']}}} Dining Court &raquo;</a>
<hr/>
	@foreach($json['Meals'] as $value)
		<div class="well"><h2 style="margin-top:0px;">{{{$value['Name']}}} <small>From {{{date('g:i A', strtotime($value['Hours']['StartTime']))}}} to {{{date('g:i A', strtotime($value['Hours']['EndTime']))}}}</small></h2><hr/>
		@if(count($value['Stations']) == 0)
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
							<span class="fa fa-leaf" style="color: green;"></span>
						@endif
						<span class="fa fa-chevron-right pull-right" style="padding-top:2px;"></span>
						</h4>
					</a>
			@endforeach
			</div>
		@endforeach
		</div>
	@endforeach
@stop