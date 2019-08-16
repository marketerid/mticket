@extends('invoice.main')
@section('main')
    <main>
        <table>
            <thead>
            <tr>
                <th class="service">Item</th>
                <th style="text-align: center;">Payment</th>
                <th>TOTAL IDR</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="service">{{ $user->session . "-" . $user->city }}</td>
                <td style="text-align: center;">{{ $user->payment }}</td>
                <td class="qty">IDR {{ number_format($user->total,0) }}</td>
            </tr>
        </table>
        <h3 style="text-align: center;color:green">
            {{ ($user->status == 'PAID') ? "LUNAS" : "BELUM LUNAS" }}
        </h3>
        <div id="notices" style="text-align: center">
            <div>
                Harap untuk datang tepat waktu dan tunjukan QR code berikut pada saat berada ditempat seminar
            </div>
            <br />
            <div class="notice text-center">
                <img src="{{ $user->image_qr_code }}" width="300px" height="300px">
            </div>
        </div>
    </main>
@endsection