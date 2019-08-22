@extends('mail.email-main')

@section('main')
    <table>
        <tr>
            <td>
                <h4>Hallo {{ $user->name }} / {{ $user->email }}</h4>
                <p class="lead">

                </p>
                <p class="callout">
                    Anda telah melakukan pembayaran sebesar <b>Rp{{ number_format($user->total,0) }}</b>, Berikut informasi Anda:
                </p>

                @if(!is_null($user->schedule) )
                    <h4>
                        Data Gathering
                    </h4>
                    <table>
                        <tbody>
                        <tr>
                            <td valign="top">
                                {!! $user->schedule->desc  !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr/>
                @endif

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
                            Jumlah Orang
                        </td>
                        <td>
                            @if(!is_null($user->event) )
                                @php
                                    $oneFee = $user->event->price;
                                @endphp
                            @else
                                @php
                                    $oneFee = 0;
                                @endphp
                            @endif
                            @if($user->total >= $oneFee AND $user->total <= ($oneFee + 9000))
                                1 Orang
                            @else
                                2 Orang
                            @endif
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
                            Total Pembayaran
                        </td>
                        <td>
                            Rp{{ number_format($user->total,0) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <br/>

                <p class="callout">
                    Harap untuk datang tepat waktu dan tunjukan QR code berikut (link download) pada saat berada ditempat seminar
                    <br/>

                    <a href="{{ $user->tiket_download }}" style="font-size: 20px;color: red;">Download Tiket</a>
                </p>
            </td>
        </tr>
    </table>
@endsection