@extends('layouts.frontend')
@section('style')
    <style>
        #myOnlineCamera video{width:320px;height:240px;margin:15px;float:left;}
        #myOnlineCamera canvas{width:320px;height:240px;margin:15px;float:left;}
        #myOnlineCamera button{clear:both;margin:30px;}
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-2">
                <div class="card"  style="margin-top:40px;">
                    <div class="card-header" id="Details" align="center">
                        <h4 style="color: #111570;font-weight: bold">Take Visitor Photo</h4>
                    </div>
                    {!! Form::open(['route' => 'check-in.step-two.next', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 style="color: #111570;font-weight: bold">Visitor Details</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($visitor->photo))
                                        <div class="row">
                                            <div class="text-center">
                                                <img src="{{ asset('storage/img'.'/'.$visitor->photo) }}" class="rounded " alt="Visitor Image" style="width: 150px; height: 150px; margin:10px 20px; border: 5px solid #d3d9df;">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12 px-4 mt-1">
                                                <p style="line-height: 8.05px;  font-weight: bold;  font-size: 18px;">{{$visitor->first_name}} {{$visitor->last_name}}</p>
                                                <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->phone}}</p>
                                                <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->company_name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div style="margin: auto" align="center">
                                                <video width="180" height="140" id="videos" style="border:5px solid #d3d3d3;" autoplay></video>
                                                <canvas id="canvas" width="160" height="130" style="border:5px solid #d3d3d3;"></canvas>
                                                <input type="hidden" id="image" name="photo" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-md-12">
                                            <button type="button" id="playvideo" class='retakephoto btn btn-md btn-dark float-left'>
                                                Re-Take Image
                                            </button>
                                            <button type="button" id="snap" class='retakephoto btn btn-md btn-danger float-right'>
                                                Capture User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-center">{!! $errors->first('photo', '<p class="text-danger">:message</p>') !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('check-in.step-one') }}" class="btn btn-primary float-left text-white">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> back
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success float-right" id="hide">
                                    Continue <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/photo.js') }}"></script>
@endsection