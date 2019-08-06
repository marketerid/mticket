<?php use Illuminate\Support\Str;?>

@foreach ($event as $e)
<div class="search-result-item">
  <div class="row">
    <div class="search-result-item-info col-sm-9">
      <h3>{{ $e->title }}</h3>
      <ul class="row">
        <li class="col-sm-5">
          <img src="{{ $e->image }}" class="img-fluid" alt="">
        </li>
        <li class="col-sm-4">
          <span>{{ date('l', strtotime($e->event_date)) }}</span>
          {{ date('j F Y', strtotime($e->event_date)) }}
        </li>
        <li class="col-sm-3">
          <span>Time</span>
          09:00 WIB
        </li>
      </ul>
    </div>
    <div class="search-result-item-price col-sm-3">
      <span>Price From</span>
      <strong>IDR {{ number_format($e->price, 0) }}</strong>
      <a href="{{ url('event',$e->type) }}/{{ $e->id }}">Sign Up</a>
    </div>
  </div>
</div>
@endforeach
</ul>
<div class="search-result-footer">
  {!! $event->render('vendor.pagination.default') !!}
</div>