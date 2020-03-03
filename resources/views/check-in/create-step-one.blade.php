@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-2">
                <div class="card"  style="margin-top:40px;">
                    <div class="card-header" id="Details" align="center">
                        <h4 style="color: #111570;font-weight: bold">Visitor Details</h4>
                    </div>
                    <div class="card-body">
                        <div style="margin: 10px;">
                            {!! Form::open(['route' => 'check-in.step-one.next', 'class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="save">
                                <div class="visitor" id="visitor">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                                {!! Html::decode(Form::label('first_name', 'First Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::text('first_name', isset($visitor->first_name) ? $visitor->first_name : null, ('' == 'required') ? ['class' => 'form-control input','id '=>'first_name'] : ['class' => 'form-control input','id '=>'first_name']) !!}
                                                {!! $errors->first('first_name', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                                {!! Html::decode(Form::label('last_name', 'Last Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::text('last_name', isset($visitor->last_name) ? $visitor->last_name : null, ('' == 'required') ? ['class' => 'form-control input', 'id '=>'last_name'] : ['class' => 'form-control input','id '=>'last_name']) !!}
                                                {!! $errors->first('last_name', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                                                {!! Form::label('company_name', 'Company Name', ['class' => 'control-label']) !!}
                                                {!! Form::text('company_name', isset($visitor->company_name) ? $visitor->company_name : null, ('' == 'required') ? ['class' => 'form-control input', 'id '=>'company_name'] : ['class' => 'form-control input','id '=>'company_name']) !!}
                                                {!! $errors->first('company_name', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                {!! Html::decode(Form::label('email', 'Email <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::email('email', isset($visitor->email) ? $visitor->email : null, ('required' == 'required') ? ['class' => 'form-control input', 'id '=>'email'] : ['class' => 'form-control input','id '=>'email']) !!}
                                                {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                                {!! Html::decode(Form::label('phone', 'Phone <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                                                {!! Form::text('phone', isset($visitor->phone) ? $visitor->phone : null, ('required' == 'required') ? ['class' => 'form-control input', 'id '=>'phone'] : ['class' => 'form-control input','id '=>'phone']) !!}
                                                {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div id="div_id_hostID" class="form-group {{ $errors->has('host_id') ? 'has-error' : ''}}">
                                                <label for="id_hostID" class="control-label"> Select Host <span class="text-danger">*</span> </label>
                                                <div class="controls " style="margin-bottom: 10px;">
                                                    <select name="host_id" id="host_name" class="form-control" title="Select Employee">
                                                        @foreach($employees as $key => $employee)
                                                            <option value="{{ $employee->id }}" {{ isset($visitor->host_id) && $visitor->host_id == $employee->id ? "selected" : '' }}>{{ $employee->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('host_id', '<p class="text-danger">:message</p>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('check-in') }}" class="btn btn-danger float-left text-white">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Cancel
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success float-right" id="continue">
                                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Continue
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
