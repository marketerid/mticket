@extends('frontend.layout')

@section('title', 'Payment - Mticket.asia')

@section('content')
<section class="section-page-content" style="padding-top: 40px">
	<div class="container">
		<div class="row">
			<div id="primary" class="col-sm-12 col-md-12">
				<div class="section-select-payment-method">
					@if(Session::has('status'))
					<p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
					@endif
					<h3 class="text-center">Payment</h3>
					<!-- Tab panes -->
					<div class="tab-content clearfix">
						<div role="tabpanel" class="tab-pane active" id="credit-card">
							<div class="table-responsive">
								<table class="table table-hover">
									<tbody>
										<tr>
											<td width="150">Invoice</td>
											<td width="20">:</td>
											<td>{{ $payment->invoice }}</td>
										</tr>
										<tr>
											<td width="150">Name</td>
											<td width="20">:</td>
											<td>{{ $payment->name }}</td>
										</tr>
										<tr>
											<td width="150">Email</td>
											<td width="20">:</td>
											<td>{{ $payment->email }}</td>
										</tr>
										<tr>
											<td width="150">City</td>
											<td width="20">:</td>
											<td>{{ ucfirst($payment->city) }}</td>
										</tr>
										<tr>
											<td width="150">Date</td>
											<td width="20">:</td>
											<td>{{ $payment->event->event_date }}</td>
										</tr>
										<tr>
											<td width="150">Total</td>
											<td width="20">:</td>
											<td>IDR {{ number_format($payment->total, 0) }}</td>
										</tr>
										<tr>
											<td width="150">Status Pembayaran</td>
											<td width="20">:</td>
											<td>
												@if ($payment->status == 'PAID')
												<span class="label label-success">Paid</span>
												@else
												<span class="label label-default">Unpaid</span>
												@endif
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="text-center">
								@php
								$inv = substr($payment->invoice, 0, 3);
								@endphp
								@if ($payment->status != 'PAID')
								<button type="button" id="pay-button" class="btn btn-success">Pay Now</button>
								@else

								@if ($inv != 'RGS')
								<a href="{{ url('tiket-download') }}?token={{ request()->get('token') }}" class="btn btn-primary" target="_blank">Download Ticket</a>
								@else
								<a href="https://importir.org/tiket-download?token={{ request()->get('token') }}" class="btn btn-primary" target="_blank">Download Ticket</a>
								@endif
								@endif
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('js')
@if (env('APP_ENV') != production)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@else
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endif

<script type="text/javascript">
	var token = '{!! csrf_token() !!}';
	var loading = '<i class="fa fa-sync fa-spin" style="font-size:15px;color:black"></i> Loading ...';

	document.getElementById('pay-button').onclick = function() {
		$("#pay-button").prop("disabled", true).html(loading);
		var requestBody = {
			invoice: '{{ $payment->invoice }}',
			order_id: '{{ $payment->id }}',
			type: "PAY_EVENT"
		};

		getSnapToken(requestBody, function(response) {
			var result = JSON.parse(response);
			var options = {
				showOrderId: false
			};
			snap.pay(result.token, {
				onSuccess: function(result) {
					console.log('success');
					console.log(result);
				},
				onPending: function(result) {
					$.ajax({
						url: "{{ url('api/save-payment-midtrans', $payment->invoice) }}",
						type: "post",
						data: {
							"data": result,
							"_token": token
						},
						success: function(response) {
							location.reload();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							// alert("Update error");
						}
					});
					console.log('pending');
					console.log(result);
				},
				onError: function(result) {
					console.log('error');
					console.log(result);
				},
				onClose: function() {
					console.log('customer closed the popup without finishing the payment');
				}
			});
		})
	};

	function getSnapToken(requestBody, callback) {
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				$("#pay-button").prop("disabled", false).html("Bayar Online");
				callback(xmlHttp.responseText);
			}
		};
		xmlHttp.open("post", "{{ url('api/checkout-midtrans') }}");
		xmlHttp.send(JSON.stringify(requestBody));
	}
</script>
@endsection