@extends('front.layout')

@section('content')
<section class="section-page-content" style="padding-top: 30px">
    <div class="container">
        <div class="row">
            <div id="primary" class="col-sm-12 col-md-12">
                <div class="section-select-payment-method">
                    <h3 style="text-align: center;">Please Insert</h3>
                    <form id="form-search">
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
                        </div>
                        <div class="section-select-payment-method-action">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="primary-link">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>  
    </div>  
</section>
@endsection