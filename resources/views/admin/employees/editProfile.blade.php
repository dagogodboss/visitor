@extends('layouts.backend')

@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Edit Profile
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

            {!! Form::model($employee, [
                'method' => 'PUT',
                'url' => ['employees/update', $employee->id],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}

            @include ('admin.employees.form', ['formMode' => 'edit'])

            {!! Form::close() !!}

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