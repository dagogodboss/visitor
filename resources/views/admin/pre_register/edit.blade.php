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
            <div class="card-header">Edit pre-register
                <a href="{{ url('/admin/pre_register') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
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
                    'url' => ['/admin/pre_register/update', $pre_register->id],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}

                @include ('admin.pre_register.form', ['formMode' => 'edit'])

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
