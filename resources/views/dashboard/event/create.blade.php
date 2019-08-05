@extends('backend.layout')

@section('title', 'Create lecture - Edu-tech.id')

@section('content')
<div class="container-fluid dashboard">
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-5">
            <div class="card">
                <form action="{{ route('lecture.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card-header text-center">Create lecture Code</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" name="description" class="form-control ckeditor" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="image" id="image" class="custom-file-input" required>
                            <label class="custom-file-label" for="image">Choose image...</label>
                        </div>
                        <img src="http://demo.codovel.com/images/noimage.jpg" id="preview" class="img-thumbnail mx-auto d-block" width="300">
                    </div>
                    <div class="card-footer text-center">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('static/ckeditor/ckeditor.js') }}"></script>
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
</script>
@endsection