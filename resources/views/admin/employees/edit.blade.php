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
        <div class="card-header">Edit Employee
         <a href="{{ url('/admin/employees') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
         </div>
        <div class="card-body">


            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if($employee)
            {!! Form::model($employee, [
                'method' => 'PUT',
                'url' => ['/admin/employees/update', $employee->id],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}

            @include ('admin.employees.form', ['formMode' => 'edit'])

            {!! Form::close() !!}
            @else
            <div>
                <h4 align="center" style="color: #ff6666">ID Not Available</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>


        $('#photo').hide();

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