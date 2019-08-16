@extends('frontend.layout')

@section('content')
<section class="section-page-content">
    <div class="container">
        <div class="row">
            <div id="primary" class="col-md-6">
                <div class="section-order-details-event-title">
                    <span class="event-caption">{{ $event->title }}</span>
                    <img class="event-img" src="https://importir.com/public-images/ambon.png" alt="image">
                </div>
            </div>  
            
            <div id="secondary" class="col-md-6">
                <form action="{{ url('registration') }}" method="POST">
                    <div class="section-order-details-event-info" style="margin-bottom: 20px;">
                        <div class="venue-details">
                            <h3>Venue & Event Information</h3>
                            <div class="venue-details-info">
                                <p>{!! $event->description !!}</p>
                            </div>
                        </div>
                        
                        <div class="seat-details">
                            <div class="seat-details-info">
                                <h3>Fill Your Personal Details</h3>
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required><br>
                                <input type="number" class="form-control" name="phone" placeholder="Phone" required><br>
                                <input type="email" class="form-control" name="email" placeholder="Email" required><br>
                                <select name="total" id="total" class="form-control" required>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 Person</option>
                                </select>
                                <input type="hidden" name="event_id" value="{{ $event->source_id }}">
                                <input type="hidden" name="reference" value="{{ request()->get('utm') ? request()->get('utm') : 'None' }}">
                                {{ csrf_field() }}
                            </div>
                            <div class="seat-details-info-price">
                                <table class="table total-price">
                                    <tbody>
                                        <tr>
                                            <td>PRICE / PERSON</td>
                                            <td class="price">IDR <span id="sumtotal">{{ number_format($event->price, 0) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="section-order-details-event-action">
                        <ul class="row">
                            <li class="col">
                                <input type="submit" name="submit" class="primary-link btn-block" value="SUBMIT">
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
var price   = {{ $event->price }};
$("#total").change(function(){
    var qty = $(this).val();
    $('#sumtotal').html(qty*price);
});
</script>
@endsection