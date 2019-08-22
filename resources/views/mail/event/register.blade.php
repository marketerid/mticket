@extends('mail.email-main')

@section('main')
    <table>
        <tr>
            <td>
                <h4>Hallo {{ $user->name }} / {{ $user->email }}</h4>
                <p class="lead">

                </p>
                <p class="callout">
                    Anda telah melakukan pendaftaran event di kota <b>{{ $user->city }}</b>, Berikut informasi Anda:
                </p>

                <h4>
                    Data Anda
                </h4>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            Nama
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Phone
                        </td>
                        <td>
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sesi
                        </td>
                        <td>
                            {{ $user->session }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b style="color:red">Rp{{ number_format($user->total,0) }}</b>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <br/>

                <p class="callout">
                    Silahkan melakukan pembayaran ke link berikut <a href="{{ $user->payment_link }}">BAYAR</a>
                </p>
                <br/>
                <p class="callout">
                    Atau jika ada kendala silahkan copy/paste link berikut {{ $user->payment_link }}
                </p>
            </td>
        </tr>
    </table>
@endsection