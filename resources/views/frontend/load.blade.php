<?php use Illuminate\Support\Str;?>
<div class="row mt-3">
@foreach ($event as $e)
  <div class="col-md-4 mb-3">
      <a href="{{ url('event', $e->type) }}/{{ $e->id }}" class="text-decoration-none text-dark">
        <div class="card shadow">
          <img src="{{ $e->image }}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ $e->title }}</h5>
            <p class="card-text">{!! Str::limit($e->description, 150) !!}</p>
          </div>
        </div>
      </a>
  </div>
@endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $event->render() !!}
</div>