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
                            {!! Form::open(['route' => 'check-in.step-three.next', 'class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="save">
                                <div class="Agreement" id="Agreement">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="strp">
                                                <div class="">
                                                    {!!  setting('welcome_screen')  !!}
                                                </div>
                                                <div class="">
                                                    {!! setting('agreement_screen') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 50px">
                                        <div class="row">
                                            <div class="col-md-6" align="center">
                                                <h3 style="color: #111570;font-weight: bold">Visitor's Name</h3>
                                                <h4 id="VisitorAgreementtag">
                                                    {{ session()->get('visitor')->first_name.' '.session()->get('visitor')->last_name }}
                                                </h4>
                                            </div>
                                            <div class="col-md-6" align="center">
                                                <h3 style="color: #111570;font-weight: bold">Date</h3>
                                                <h4 id="VisitorAgreementtag">
                                                    {{ date('d M Y') }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid lightslategrey">
                                    <div class="row">
                                        <div style="margin: auto;width: 400px;">
                                            <div style="float: left">
                                                @if(setting('visitor_agreement') == 1)
                                                <div style="float: left">
                                                        <label class="switch" id="switch">
                                                            <input type="checkbox" name="agreement" id="chekbox" {{ session()->get('agreement') == "on" ? "checked" : "" }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                </div>
                                                <div style="color: #111570;font-weight: bold;float: left;margin: 8px;">
                                                    <h4>I Agree</h4>
                                                </div>
                                                @endif
                                            </div>
                                            <div style="float: right;">
                                                <div style="margin: 8px">
                                                    <input type="checkbox" id="myCheck" name="emailCheck"  onclick="myFunction()">
                                                    <span style="color: #111570;">Email Visitor Agreement</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('check-in.step-two') }}" class="btn btn-primary float-left text-white">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i> back
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            @if(setting('visitor_agreement') == 1)
                                                <button type="submit" class="btn btn-success float-right" id="show">
                                                     Finish <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success float-right" id="hide">
                                                    Finish <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                </button>
                                            @endif
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