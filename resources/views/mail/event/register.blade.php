@extends('mail.email-main')

@section('main')
    <table>
        <tr>
            <td>
                <h4>Hallo {{ $user->name }} / {{ $user->email }}</h4>
                <p class="lead">

                </p>
                <p class="callout">
                    Anda telah melakukan pendaftaran gathering di kota <b>{{ $user->city }}</b>, Berikut informasi Anda:
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
                {{--<p class="callout">
                    Atau silahkan transfer manual ke nomor rekening
                    <br/>
                    <b>BCA 593-053-5305 a/n Margareta Chandra</b>
                    <br/>
                    <br/>
                </p>

                <p>
                    Dengan jumlah transfer sebesar <b style="color:red">Rp {{ number_format($user->total,0) }}</b>
                </p>

                <p>
                    Pembayaran otomatis akan diproses ketika Anda memasukan nominal sesuai jumlah diatas, <span style="color:red"
                    >Jika tidak</span>, kemungkinan besar sistem tidak dapat memprosesnya
                </p>
                <p>
                    Setelah melakukan pembayaran harap <b style="color:red">Tunggu proses otomatis pembayaran sekitar 30 menit</b>
                </p>
                <p>
                    Jika dalam waktu <span style="color:red">-+30 menit Setelah pembayaran</span> namun Anda masih belum mendapatkan konfirmasi email

                    Silahkan konfirmasi pembayaran melalui <a href="mailto:sales@importir.org">sales@importir.org</a> dengan melampirkan bukti transfer
                </p>
                <p>
                    <b>Atau Anda juga bisa membawa bukti transfer ketika datang seminar sebagai tanda valid pembayaran.</b>
                </p>--}}
            </td>
        </tr>
    </table>
@endsection