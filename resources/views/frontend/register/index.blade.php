@extends('frontend.layout')

@section('content')
<section class="section-page-content" style="padding-top: 50px">
    <div class="container">
        <div class="row">
            <div id="primary" class="col-sm-12 col-md-12">
                <div class="section-select-payment-method">
                    @if(Session::has('status'))
                        <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                    @endif
                    <h3 class="text-center">Formulir Pendaftaran</h3>
                    <form action="//importir.org/api/custom-seminar-register" method="GET">
                        <div class="tab-content clearfix">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <select name="total" class="form-control" required>
                                        <option value="1">1 Orang</option>
                                        <option value="2">2 Orang</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="schedule_id" value="{{ $id }}">
                            <input type="hidden" name="reference" value="{{ request()->input('utm') ? request()->input('utm') : 'Tidak ada UTM' }}">
                            <input type="hidden" name="session" value="{{ request()->input('session') ? request()->input('session') : 'event' }}">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">DAFTAR SEKARANG</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection