
<h4>
    Tambah/Edit Jadwal <b>AKTIF</b> Shift
</h4>
<p>
    Nama CS = {{ $sub->name }} ({{ $sub->phone }})
</p>
{{ Form::open(['url' => url('dashboard/rotate/schedule-save/' . (!is_null($sub) ? $sub->id : "") . '/' . (!is_null($schedule) ? $schedule->id : '')), 'method' => 'post']) }}
<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
    <div class="nk-int-st">
        <label for="type">Type</label>
        <select name="type" class="form-control" id="schedule-type" required>
            <option value="weekly" {{ (isset($schedule) AND $schedule->type == 'weekly') ? "selected" : '' }}>Rutin Mingguan</option>
            <option value="custom" {{ (isset($schedule) AND $schedule->type == 'custom') ? "selected" : '' }}>Custom Date</option>
        </select>
        @if($errors->has('type'))
            <p class="help-block">{{ $errors->first('type') }}</p>
        @endif
    </div>
</div>
<div id="schedule-weekly" class="{{ (!isset($schedule) OR isset($schedule) AND $schedule->type == 'weekly') ? "" : "hide" }}">
    <div class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="start_day">Mulai Setiap Hari</label>
            <select name="start_day" class="form-control">
                @foreach(weeklyList() as $key => $value)
                    <option value="{{ $key }}" {{ (isset($schedule) AND $schedule->start_day == $key OR (!isset($schedule)) AND $key == 'Monday') ? 'selected' : ""  }}>{{ $value }}</option>
                @endforeach
            </select>
            @if($errors->has('start_day'))
                <p class="help-block">{{ $errors->first('start_day') }}</p>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('start_day') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="to_day">Sampai Setiap Hari</label>
            <select name="to_day" class="form-control">
                @foreach(weeklyList() as $key => $value)
                    <option value="{{ $key }}" {{ (isset($schedule) AND $schedule->to_day == $key OR (!isset($schedule)) AND $key == 'Saturday') ? 'selected' : ""  }}>{{ $value }}</option>
                @endforeach
            </select>
            @if($errors->has('to_day'))
                <p class="help-block">{{ $errors->first('to_day') }}</p>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('start_hour') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="to_day">Mulai Pukul</label>
            <input type="text" class="form-control time" name="start_hour" value="{{ isset($schedule) ? $schedule->start_hour : "09:00" }}">
            @if($errors->has('start_hour'))
                <p class="help-block">{{ $errors->first('start_hour') }}</p>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('to_hour') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="to_hour">Sampai Pukul</label>
            <input type="text" class="form-control time" name="to_hour" value="{{ isset($schedule) ? $schedule->to_hour : "18:00" }}">
            @if($errors->has('to_hour'))
                <p class="help-block">{{ $errors->first('to_hour') }}</p>
            @endif
        </div>
    </div>
</div>
<div id="schedule-custom" class="{{ (isset($schedule) AND $schedule->type == 'custom') ? "" : 'hide' }}">
    <div class="form-group{{ $errors->has('start_custom') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="to_day">Mulai Tanggal dan Jam</label>
            <input type="text" class="form-control datetime" name="start_custom" value="{{ isset($schedule) ? $schedule->start_custom : date('Y-m-d H:i') }}">
            @if($errors->has('start_hour'))
                <p class="help-block">{{ $errors->first('start_hour') }}</p>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('to_custom') ? ' has-error' : '' }}">
        <div class="nk-int-st">
            <label for="to_custom">Sampai Tanggal dan Jam</label>
            <input type="text" class="form-control datetime" name="to_custom" value="{{ isset($schedule) ? $schedule->to_custom : date('Y-m-d H:i') }}">
            @if($errors->has('to_custom'))
                <p class="help-block">{{ $errors->first('to_custom') }}</p>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <button type="button" class="btn btn-warning back-sub-schedule" data-sub="{{ json_encode($sub) }}">
        <i class="fa fa-step-backward"></i> Kembali
    </button>
    @if(!is_null($user->active_order))
        <button type="submit" class="btn btn-success notika-btn-success waves-effect">
            <i class="fa fa-save"></i> Simpan
        </button>
    @else
        <button type="submit" class="btn btn-success notika-btn-success waves-effect" disabled>
            <i class="fa fa-save"></i> Simpan
        </button>
        <p class="label label-danger">Harap Upgrade akun Anda untuk menggunakan fitur ini</p>
    @endif
</div>

{{ Form::close() }}