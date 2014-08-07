@foreach($data as $item)
	{{$item['food_name']}} at {{$item['hall']}} during {{$item['meal']}}<br/>
@endforeach