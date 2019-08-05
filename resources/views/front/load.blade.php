<?php use Illuminate\Support\Str;?>
<ul class="clearfix">
@foreach ($event as $e)
  <li>
    <a href="{{ url('event',$e->type) }}/{{ $e->id }}">
      <div class="date">
        <span class="day">25</span>
        <span class="month">May</span>
        <span class="year">2016</span>
      </div>
      <img src="{{ $e->image }}" alt="image">
      <div class="info">
        <p>{{ ucfirst($e->city) }} <span>Rp {{ number_format($e->price,0) }}</span></p>
        <a href="{{ url('event',$e->type) }}/{{ $e->id }}" class="get-ticket">Buy Now</a>
      </div>
    </a>
  </li>
@endforeach
</ul>
<div class="text-center">
    {!! $event->render() !!}
</div>