@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 offset-2">
            <div class="card"  style="margin-top:40px;">
                <div class="card-header" id="Details" align="center">
                    <h4 style="color: #111570;font-weight: bold">Return Visitor Details</h4>
                </div>
                <div class="card-body">
                    <div style="margin: 10px;">
                        {!! Form::open(['route' => 'check-in.find.visitor', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="save">
                            <div class="visitor" id="visitor">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                            {!!  Html::decode(Form::label('email', "Visitor's Email <span class='text-danger'>*</span>", ['class' => 'control-label'])) !!}
                                            {!! Form::text('email', null, ('' == 'required') ? ['class' => 'form-control input','id '=>'email','required' => 'required', 'placeholder'=>"Search email.."] : ['class' => 'form-control input','id '=>'email', 'placeholder'=>"Search email.."]) !!}
                                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
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
