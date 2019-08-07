@extends('front.layout')

@section('content')
<section class="section-artist-featured-header">
	<div class="container">
		<div class="section-content">
			<h1>List of available events</h1>
			<p>Total 22 Events</p>
		</div>
	</div>
</section>
<section class="section-refine-search">
	<div class="container">
		<div class="row">
			<form>
				<div class="keyword col-sm-6 col-md-4">
					<label>Search Keyword</label>
					<input type="text" class="form-control hasclear" placeholder="Search">
					<span class="clearer"><img src="images/clear.png" alt="clear"></span>
				</div>
				<div class="location col-sm-6 col-md-3">
					<label>Location</label>
					<select class="selectpicker dropdown">
					  <option>Select Location</option>
					  <option>San Francisco</option>
					  <option>Foxborough </option>
					  <option>Buffalo</option>
					  <option>Auburn Hills</option>
					</select>
				</div>
				<div class="event-date col-sm-6 col-md-3">
					<label>Event Date</label>
					<select class="selectpicker dropdown">
					  <option>Select Date</option>
					  <option>August 1st, 2016</option>
					  <option>August 2nd, 2016</option>
					  <option>August 3rd, 2016</option>
					  <option>August 4th, 2016</option>
					</select>
				</div>
				<div class="col-sm-6 col-md-2">
					<input type="submit" value="Search">
				</div>
			</form>
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