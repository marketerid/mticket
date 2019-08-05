@extends('dashboard.layout')

@section('title', 'Edit Event '.$event->title)

@section('content')
<div class="container-fluid dashboard">
    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header text-center">Create Event</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Event</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="before_paid_sms">Before Paid SMS</label>
                                <textarea name="before_paid_sms" id="before_paid_sms" class="form-control" rows="2" required>{{ $event->before_paid_sms }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="after_paid_sms">After Paid Sms</label>
                                <textarea name="after_paid_sms" id="after_paid_sms" class="form-control" rows="2" required>{{ $event->after_paid_sms }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="before_paid_email">Before Paid Email</label>
                                <textarea name="before_paid_email" id="before_paid_email" class="form-control ckeditor" cols="30" rows="10" required>{{ $event->before_paid_email }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="after_paid_email">After Paid Email</label>
                                <textarea name="after_paid_email" id="after_paid_email" class="form-control ckeditor" cols="30" rows="10" required>{{ $event->after_paid_email }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control ckeditor" cols="30" rows="10" required>{{ $event->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Settings</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="{{ $event->type }}">{{ $event->type }}</option>
                                <option value="seminar">Seminar</option>
                                <option value="exhibition">Exhibition</option>
                                <option value="workshop">Workshop</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control" required>
                                <option value="{{ $event->city }}">{{ $event->city }}</option>
                                <option value="jakarta">Jakarta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Biaya</label>
                            <input type="text" class="form-control number" name="price" id="price" placeholder="0" value="{{ $event->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="event_date">Event Date</label>
                            <input type="text" class="form-control" name="event_date" id="event_date" value="{{ $event->event_date }}" required>
                        </div>
                        <img src="{{ url('assets/img', $event->images )}}" id="preview" class="img-thumbnail mx-auto d-block" width="300"><br>
                        <div class="custom-file">
                            <input type="file" name="image" id="image" class="custom-file-input" required>
                            <label class="custom-file-label" for="image">Choose image...</label>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-block">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.config.toolbar = [
    ['Font','FontSize','Bold','Italic','Underline'],
    ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
];

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#image").change(function(){
    readURL(this);
});

$(function() {
    $('#event_date').daterangepicker({
        "singleDatePicker": true,
        "alwaysShowCalendars": true,
        autoUpdateInput: false,
    }, function(valuedate) {
        $('#event_date').val(valuedate.format('DD-MM-YYYY'));
    });
});
$('.number').on('keyup', function (e) {
    $(this).val(numberWithCommas(parseFloatComma($(this).val())));
});

window.parseFloatComma = function (x) {
    var num = x.replace(/,/g, '');
    var afterDot   = num.split('.')[1];
    if(num.includes(".") === true && typeof afterDot !== 'undefined' && (afterDot.length === 0 || afterDot[afterDot.length -1] === '0')){
        return num;
    }

    if(!isNaN(num)){
        return Number(num);
    }

    return 0;
};

window.numberWithCommas = function(y) {
    if(isNaN(y)){
        return 0;
    }

    var parts = y.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
};
</script>
@endsection