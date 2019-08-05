@extends('frontend.layout')
@section('title')
    Lead untuk Form {{ $lead->form->title }}
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="normal-table-list">
                                <div class="bsc-tbl">
                                    <h5>
                                        Detail Lead
                                    </h5>
                                    <table class="table table-sc-ex table-striped">
                                        <tbody>
                                        <tr>
                                            <td>
                                                Form
                                            </td>
                                            <td>{{ $lead->form->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Operator/CS
                                            </td>
                                            <td>
                                                {{ $lead->rotate->operator->name }}
                                                {{ $lead->rotate->operator->phone }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Campaign
                                            </td>
                                            <td>{{ $lead->campaign }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Note
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="note">{{ $lead->note }}</textarea>
                                                <br/>
                                                <a href="{{ url('auth/login-op') }}" class="btn btn-xs btn-primary pull-right">
                                                    <i class="fa fa-user"></i> Login untuk update Note
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Created At
                                            </td>
                                            <td>{{ $lead->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Last Update
                                            </td>
                                            <td>{{ $lead->updated_at }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                            <div class="normal-table-list">
                                <div class="bsc-tbl">
                                    <h5>
                                        Data Form Submit Customer
                                    </h5>
                                    <table class="table table-sc-ex table-striped">
                                        <tbody>
                                        @foreach($lead->result_objects as $object)
                                            <tr>
                                                <td>
                                                    {{ ucfirst($object->key) }}
                                                </td>
                                                <td>
                                                    @if(is_object($object->value) OR is_array($object->value))
                                                        @foreach($object->value as $value)
                                                            <span class="label label-info">{{ $value }}</span>
                                                        @endforeach
                                                    @else
                                                        {{ $object->value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection