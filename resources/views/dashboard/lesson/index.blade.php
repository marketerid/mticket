@extends('dashboard.layout')

@section('title', 'Lesson')

@section('content')
<div class="container-fluid dashboard">
    @if(Session::has('alert'))
    <div class="alert bg-{{ (Session::get('alert') == "success") ? "success" : "danger" }} text-white alert-dismissible fade show" role="alert">
        <b>{{ Session::get('message') }}</b>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lessons</h1>
        <a href="{{ url('dashboard/lesson/create') }}" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Create</a>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lesson as $l)
                        <tr>
                            <th class="align-middle">{{ $l->id }}</th>
                            <td class="align-middle">{{ $l->title }}</td>
                            <td class="align-middle">{!! $l->description !!}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ url('dashboard/lesson', $l->slug) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fas fa-eye"></i></a>&nbsp;
                                    <a href="{{ route('lesson.edit', $l->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;
                                    <button class="btn btn-danger btn-sm delete" id="{{ $l->id }}"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).on('click', '.delete', function(){
    var id = $(this).attr('id');
    $('#all-modal').modal('show');
    $('.modal-title').text('Are You Sure?');
    $('.modal-body').text('Data will be deleted after clicking OK');
    $('#modal-url').attr("href", "{{ url('dashboard/lesson/delete')}}/"+id);
});
</script>
@endsection