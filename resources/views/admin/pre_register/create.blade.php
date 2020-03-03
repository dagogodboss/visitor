@extends('layouts.backend')
@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Add New Pre Register
                <a href="{{ url('/admin/pre_register') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => '/admin/pre_register/store', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @include ('admin.pre_register.form', ['formMode' => 'create'])
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