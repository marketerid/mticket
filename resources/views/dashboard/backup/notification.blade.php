<div class="hd-mg-tt">
    @if($notifications->count() == 0)
        <p class="text-center">
            Anda tidak mempunyai pemberitahuan
        </p>
    @else
        <h2>Pemberitahuan</h2>
    @endif
</div>
<div class="hd-message-info">
    @foreach($notifications as $notification)
        <a href="{{ url('dashboard/user/notification/' . $notification->id) }}">
            <div class="hd-message-sn">
                <div class="hd-mg-ctn">
                    <h3>{{ $notification->title }}</h3>
                    <p>{{ url($notification->link) }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>
<div class="hd-mg-va">
    <a href="{{ url('dashboard/user/notification') }}">Lihat Semua</a>
</div>