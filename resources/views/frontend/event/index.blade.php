@extends('frontend.layout')

@section('content')
<section style="margin-top: 100px; margin-bottom: 40px">
    <div class="container">
        <div class="card mb-3">
            <div class="row no-gutters border-bottom">
                <div class="col-md-8">
                    <img src="{{ $event->image }}" class="img-fluid w-100" alt="...">
                </div>
                <div class="col-md-4">
                    <div class="card-body">
                        @if ($event->title == '')
                            <h5 class="card-title h5 font-weight-bold text-gray-800">Seminar {{ ucfirst($event->city) }}</h5>
                        @else
                            <h5 class="card-title h5 font-weight-bold text-gray-800">{{ $event->title }}</h5>
                        @endif
                        <p class="card-text mt-3">{!! $event->description !!}</p>
                    </div>
                    <div class="card-footer">PRICE / PERSON: <span class="float-right"><span class="badge badge-warning">IDR {{ number_format($event->price,0) }}</span></div>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-md-6 offset-md-3">
                    <div class="text-center mt-3">
                        <h3>Registration Form</h3>
                        <p>Fill Your Personal Details</p>
                    </div>
                    <form class="mb-5 mt-5" action="{{ url('registration') }}" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg bg-light" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control form-control-lg bg-light" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg bg-light" required>
                        </div>
                        <div class="form-group pb-3">
                            <label for="total">Total Peserta</label>
                            <select name="total" id="total" class="form-control form-control-lg" required>
                                <option value="" disabled selected>Pilih Total Peserta...</option>
                                <option value="1">1 Peserta</option>
                                <option value="2">2 Peserta</option>
                                <option value="3">3 Peserta</option>
                                <option value="4">4 Peserta</option>
                                <option value="5">5 Peserta</option>
                                <option value="6">6 Peserta</option>
                                <option value="7">7 Peserta</option>
                                <option value="8">8 Peserta</option>
                                <option value="9">9 Peserta</option>
                                <option value="10">10 Peserta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="reference" value="{{ request()->get('utm') ? request()->get('utm') : 'None' }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-form btn-warning btn-lg btn-block m-0">DAFTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection