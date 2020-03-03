@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.pre_register.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/pre_register/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Pre Register View
                <span class="pull-right">
                        <a href="{{ url('/admin/pre_register') }}" title="Back"><button class="btn btn-default btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/pre_register/' . $pre_register->id . '/edit') }}" title="Edit pre_register"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    </span>
            </div>
            <div class="card-body">
                <div class="box">
                    <div class="box-body box-profile">
                        <img class="rounded mx-auto d-block profile-user-img img-responsive img-circle" src="{{ asset('images/no-image.png') }}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $pre_register->full_name }}</h3>

                        <p class="text-muted text-center">{{ $pre_register->email }}r</p>

                        <ul class="list-group">
                            <li class="list-group-item">
                                <b>VisitorID</b> <span class="pull-right">{{ $pre_register->visitorID }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <span class="pull-right">{{ $pre_register->phone }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Host</b><a class="pull-right" href="{{ url("admin/employees/$pre_register->host_id/show") }}">{{ $pre_register->host_name }} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Expected Date</b> <span class="pull-right">{{ $pre_register->expected_date }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Expected Time</b> <span class="pull-right">{{ $pre_register->expected_time }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Date</b> <span class="pull-right">{{ $pre_register->date }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
