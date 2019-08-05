<p>
    Info Jadwal/Shift Nama CS = {{ $sub->name }} ({{ $sub->phone }})
</p>

<button type="button" class="btn btn-primary btn-xs pull-right add-schedule" data-sub-id="{{ $sub->id }}" data-sub="{{ json_encode($sub) }}" data-schedule="{{ json_encode([]) }}">
    <i class="fa fa-plus"></i> Tambah Shift/Jadwal
</button>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>
            Type
        </th>
        <th>
            Shift Aktif
        </th>
        <th>
            Is Active
        </th>
        <th>
            #
        </th>
    </tr>
    </thead>
    <tbody>
        @if(!$sub->schedules->count())
            <tr>
                <td colspan="4" class="text-center">
                    <span class="label label-info">
                        NOMOR CS SELALU AKTIF
                    </span>
                </td>
            </tr>
        @endif
        @foreach($sub->schedules as $schedule)
            <tr>
                <td>
                    {!! $schedule->type_html !!}
                </td>
                <td>
                    {!! $schedule->start_to_html !!}
                </td>
                <td>
                    {!! $schedule->is_active_html !!}
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-xs edit-schedule" data-sub-id="{{ $sub->id }}" data-sub="{{ json_encode($sub) }}" data-schedule-id="{{ $schedule->id }}" data-schedule="{{ json_encode($schedule) }}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <a href="{{ url('dashboard/rotate/schedule-delete/' . $sub->id . '/' . $schedule->id) }}" class="btn btn-danger btn-xs delete" data-schedule-id="{{ $schedule->id }}">
                        <i class="fa fa-close"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>