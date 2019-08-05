@extends('front.layout')

@section('content')
<section class="section-calendar-events" style="margin-top: 100px">
	<div class="container">
		<div class="row">
			<div class="section-content">
				<div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="tab1">
						<ul class="clearfix">
							<div class="load">
						      @if (count($event) > 0)
						          @include('front.load')
						      @else
						          <h3 class="text-center">Tidal Ada Event</h3>
						      @endif
						    </div>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection