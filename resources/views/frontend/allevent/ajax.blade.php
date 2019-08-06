<div id="primary" class="col-sm-12 col-md-8">
	@foreach ($event as $e)
	<div class="artist-event-item">
		<div class="row">
			<div class="artist-event-item-info col-sm-9">
				<h3>Seminar IMPORTIR.ORG - {{ ucfirst($e->city) }}</h3>
				<ul class="row">
					<li class="col-sm-5">
						<img src="{{ $e->image }}" class="img-fluid" alt="">
					</li>
					<li class="col-sm-7">
						<p>{!! $e->description !!}</p>
					</li>
				</ul>
			</div>
			<div class="artist-event-item-price col-sm-3">
				<span>Price From</span>
				<strong>IDR {{ number_format($e->price ,0)}}</strong>
				<a href="{{ url('event', $e->type) }}/{{ $e->id }}">Sign Up</a>
			</div>
		</div>
	</div>
	@endforeach
	<div class="artist-event-footer">
		{!! $event->render('vendor.pagination.default') !!}
	</div>
</div>