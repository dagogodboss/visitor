@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('employees.pre-register.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('employees/pre-register/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Edit Pre Register
            <a href="{{ url('/employees/pre-register') }}" title="Back"><button class="btn btn-default pull-right btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            {!! Form::model($pre_register, [
                'method' => 'PUT',
                'url' => ['/employees/pre_register/update', $pre_register->id],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}

            @include ('admin.employees.pre_register_from', ['formMode' => 'edit'])

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
