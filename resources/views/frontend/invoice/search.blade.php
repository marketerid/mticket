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
                    <h3 class="text-center">Please Insert invoice & email</h3>
                    <form action="{{ url('search-invoice/check') }}" method="post" id="form-search">
                        <div class="tab-content clearfix">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Invoice</label>
                                    <input type="text" name="invoice" class="form-control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" required>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>  
    </div>  
</section>
@endsection