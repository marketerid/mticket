@extends('front.layout')

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
                            <h3>Seats Order Information</h3>
                            <div class="seat-details-info">                            
                                <table class="table number-tickets">
                                    <thead>
                                        <tr>
                                            <th>Delivery</th>
                                            <th>Number of Tickets</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tickets</td>
                                            <td>
                                                <div class="qty-select">
                                                    <div class="qty-minus"> 
                                                        <a class="qty-btn" href="#">-</a>
                                                    </div>
                                                    <div class="qty-input">
                                                        <input type="text" name="total" class="quantity-input" value="1" />
                                                    </div>
                                                    <div class="qty-plus"> 
                                                        <a class="qty-btn" href="#">+</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required><br>
                                <input type="number" class="form-control" name="phone" placeholder="Phone" required><br>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>

                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="reference" value="{{ request()->get('utm') ? request()->get('utm') : 'None' }}">
                                {{ csrf_field() }}
                            </div>
                            <div class="seat-details-info-price">
                                <table class="table total-price">
                                    <tbody>
                                        <tr>
                                            <td>PRICE / PERSON</td>
                                            <td class="price">IDR {{ number_format($event->price, 0) }}</td>
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