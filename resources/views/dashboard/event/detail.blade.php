@extends('dashboard.layout')

@section('title', 'Edit Event '.$event->title)

@section('content')
<div class="container-fluid dashboard">
    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header text-center">Detail {{ $event->title }}</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th width="50">Type</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->type }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Judul</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Description</th>
                                    <td width="20">:</td>
                                    <td>{!! $event->description !!}</td>
                                </tr>
                                <tr>
                                    <th width="50">city</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->city }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Biaya</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->price }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Event Date</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->event_date }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Before Paid SMS</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->before_paid_sms }}</td>
                                </tr>
                                <tr>
                                    <th width="50">After Paid SMS</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->after_paid_sms }}</td>
                                </tr>
                                <tr>
                                    <th width="50">Before Paid Email</th>
                                    <td width="20">:</td>
                                    <td>{!! $event->before_paid_email !!}</td>
                                </tr>
                                <tr>
                                    <th width="50">After Paid Email</th>
                                    <td width="20">:</td>
                                    <td>{!! $event->after_paid_email !!}</td>
                                </tr>
                                <tr>
                                    <th width="50">Status</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Registration {{ $event->title }}</div>
                    <div class="card-body">
                        <img src="{{ url('assets/img', $event->images) }}" id="preview" class="img-thumbnail mx-auto d-block" width="300"><br>
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th width="200">Total Registration</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->status }}</td>
                                </tr>
                                <tr>
                                    <th width="200">Total Paid</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->status }}</td>
                                </tr>
                                <tr>
                                    <th width="200">Total Income</th>
                                    <td width="20">:</td>
                                    <td>{{ $event->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ url('dashboard/registration') }}?event_id={{ $event->id }}" class="btn btn-primary btn-block"><i class="fas fa-eye"></i> List Registration</a>
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

function changeProfile() {
    $('#image').click();
}
$('#image').change(function () {
    var imgPath = this.value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
        readURL(this);
    else
        alert("Please select image file (jpg, jpeg, png).")
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        };
    }
}
function removeImage() {
    $('#preview').attr('src', 'http://demo.codovel.com/images/noimage.jpg');
}
console.log($('image').val());

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