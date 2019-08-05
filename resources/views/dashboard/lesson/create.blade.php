@extends('dashboard.layout')

@section('title', 'Create lesson - Edu-tech.id')

@section('content')
<div class="container-fluid dashboard">
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-5">
            <div class="card">
                <form action="{{ route('lesson.store') }}" method="post">
                    <div class="card-header text-center">Create lesson Code</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" name="description" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-block">KIRIM</button>
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
CKEDITOR.replace('description');
CKEDITOR.config.toolbar = [
    ['Font','FontSize','Bold','Italic','Underline'],
    ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
];
</script>
@endsection