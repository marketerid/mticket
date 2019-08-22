@extends('frontend.layout')

@section('content')
<section class="section-artist-featured-header">
	<div class="container">
		<div class="section-content">
			<h1>List of available events</h1>
		</div>
	</div>
</section>

<section class="section-calendar-events">
	<div class="container">
		<div class="row">
			<div class="section-content">
			  <div class="tab-content">
			    <ul class="clearfix">
					@foreach ($event as $e)
					<li>
						<a href="{{ url('event',$e->type) }}/{{ $e->id }}">
						  <div class="date">
						    <span class="day">{{ date('j', strtotime($e->event_date)) }}</span>
						    <span class="month">{{ date('M', strtotime($e->event_date)) }}</span>
						    <span class="year">{{ date('Y', strtotime($e->event_date)) }}</span>
						  </div>
						  <img src="{{ $e->image }}" alt="image">
						  <div class="info">
						    <p>{{ $e->title }} <span>{{ number_format($e->price, 0) }}</span></p>
						    <a href="{{ url('event',$e->type) }}/{{ $e->id }}" class="get-ticket">Sign Up</a>
						  </div>
						</a>
					</li>
					@endforeach
				</ul>
			  </div>
			</div>
		</div>
	</div>
</section>
@endsection