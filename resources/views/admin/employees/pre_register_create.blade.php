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
        <div class="card-header">Add New Pre Register</div>
        <div class="card-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            {!! Form::open(['url' => '/employees/pre_register/store', 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    @include ('admin.employees.pre_register_from', ['formMode' => 'create'])
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('#timepicker1').timepicker();
    </script>
@endsection