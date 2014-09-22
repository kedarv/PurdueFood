<div itemscope itemtype="http://schema.org/EmailMessage">
  <div itemprop="action" itemscope itemtype="http://schema.org/ViewAction">
    <link itemprop="url" href="https://purduefood.com"/>
    <meta itemprop="name" content="View Full Menu"/>
  </div>
  <meta itemprop="description" content="View the full Purdue Dining Court Menu"/>
</div>
@foreach($data as $item)
	{{$item['food_name']}} at {{$item['hall']}} during {{$item['meal']}}<br/>
@endforeach