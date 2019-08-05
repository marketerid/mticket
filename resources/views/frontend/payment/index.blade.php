@extends('frontend.layout')

@section('title', 'Payment - Mticket.asia')

@section('content')
<section style="margin-top: 100px; margin-bottom: 30px">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <h5 class="text-center mb-3">Halaman Pembayaran</h5>
                              <tbody>
                                <tr>
                                  <th width="200">Invoice</th>
                                  <td width="20">:</td>
                                  <td>{{ $payment->invoice }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Kota</th>
                                  <td width="20">:</td>
                                  <td>{{ ucfirst($payment->city) }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Name</th>
                                  <td width="20">:</td>
                                  <td>{{ $payment->name }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Email</th>
                                  <td width="20">:</td>
                                  <td>{{ $payment->email }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Session</th>
                                  <td width="20">:</td>
                                  <td>{{ $payment->event[0]->type }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Tanggal</th>
                                  <td width="20">:</td>
                                  <td>{{ $payment->event[0]->event_date }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Total</th>
                                  <td width="20">:</td>
                                  <td>Rp{{ $payment->total }}</td>
                                </tr>
                                <tr>
                                  <th width="200">Status Pembayaran</th>
                                  <td width="20">:</td>
                                  <td>
                                  @if ($payment->status_paid === 'pending')
                                      <span class="badge badge-secondary">Pending</span>
                                  @elseif ($payment->status_paid === 'failed')
                                      <span class="badge badge-secondary">Failed</span>
                                  @elseif ($payment->status_paid === 'expired')
                                      <span class="badge badge-secondary">Expired</span>
                                  @elseif ($payment->status_paid === 'success')
                                      <span class="badge badge-success">Sudah Lunas</span>
                                  @else
                                    <span class="badge badge-secondary">Belum Lunas</span>
                                  @endif
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            @if ($payment->status_paid !== 'success')
                            <div class="text-center mb-3">
                              <button type="button" id="pay-button" class="btn btn-success btn-sm btn-pay">Bayar Online</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@if (env('APP_ENV')!='Production')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@else
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endif
<script type="text/javascript">
var token = '{!! csrf_token() !!}';
var loading = '<i class="fa fa-sync fa-spin" style="font-size:15px;color:black"></i> Loading ...';
document.getElementById('pay-button').onclick = function(){
    $("#pay-button").prop("disabled", true).html(loading);
    var requestBody =
        {
            invoice: '{{ $payment->invoice }}',
            order_id: '{{ $payment->id }}',
            type:"PAY_EVENT"
        };

    getSnapToken(requestBody, function(response){
        var result = JSON.parse(response);
        var options = {
            showOrderId: false
        };
        snap.pay(result.token, {
            onSuccess: function(result){
                console.log('success');
                console.log(result);
            },
            onPending: function(result){
                $.ajax({
                    url: "{{ url('api/save-payment-midtrans', $payment->invoice) }}",
                    type: "post",
                    data: {
                        "data":result,
                        "_token":token
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // alert("Update error");
                    }
                });
                console.log('pending');
                console.log(result);
            },
            onError: function(result){console.log('error');console.log(result);},
            onClose: function(){console.log('customer closed the popup without finishing the payment');}
        });
    })
};
function getSnapToken(requestBody, callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            $("#pay-button").prop("disabled", false).html("Bayar Online");
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open("post", "{{ url('api/checkout-midtrans') }}");
    xmlHttp.send(JSON.stringify(requestBody));
}
</script>
@endsection