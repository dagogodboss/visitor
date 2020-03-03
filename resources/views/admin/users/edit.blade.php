@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.users.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/users/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Edit User
            <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            {!! Form::model($user, [
                'method' => 'PATCH',
                'url' => ['/admin/users', $user->id],
                'class' => 'form-horizontal'
            ]) !!}
            @include ('admin.users.form', ['formMode' => 'edit'])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
