@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.employees.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/employees/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Create New Employee
        <a href="{{ url('/admin/employees') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        </div>
        <div class="card-body">
            {!! Form::open(['url' => '/admin/employees/store', 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="row">
                <div class="col-sm-12">
                    @include ('admin.employees.form', ['formMode' => 'create'])
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection

@section('scripts')
    <script>
        function readURLimg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo').show();
                    $('.visitorlogo-id').attr('src', e.target.result);
                    var img = e.target.result;
                    document.getElementById('visitorLogo').value =img;

                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#visitorlogo-id").change(function() {
            readURLimg(this);
        });

    </script>
@stop
