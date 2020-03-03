@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('users.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/users/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Create New User
        <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            </div>
        <div class="card-body">

            {!! Form::open(['url' => '/admin/users', 'class' => 'form-horizontal']) !!}

            @include ('admin.users.form', ['formMode' => 'create'])

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
