<script type="application/ld+json">
{
  "@context": "http://purduefood.com",
  "@type": "EmailMessage",
  "action": {
    "@type": "ViewAction",
    "url": "http://purduefood.com",
    "name": "View Full Menu"
  },
  "description": "View the full Purdue Dining Court Menu"
}
</script>
@foreach($data as $item)
	{{$item['food_name']}} at {{$item['hall']}} during {{$item['meal']}}<br/>
@endforeach