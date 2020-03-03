@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.visitors.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/visitors/create') }}">
            Create
        </a>
    </li>
@endsection
@push('extra-css')
    <link rel="stylesheet" href="{{ asset('css/id-card-print.css') }}">
@endpush
@section('content')
<div class="col-md-9">
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Visitor View
                    <span class="pull-right">
                        <a href="{{ url('/admin/visitors') }}" title="Back"><button class="btn btn-default btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/visitors/' . $visitor->id . '/edit') }}" title="Edit visitor"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    </span>
                </div>
                <div class="card-body">
                    @if($visitor)
                        @if($settings)
                        <div class="card" style="border: 0px;">
                            <div class="card-body">
                                @if(setting('id_card_template')==1)
                                    {{--<div class="id-card-hook"></div>--}}
                                    {{--<div class="imgcards" id="printidcard">--}}
                                        {{--<div class="id-card-holder card">--}}
                                            {{--<div class="id-card card-body" >--}}
                                                {{--<div class="row">--}}
                                                    {{--<div class="col-lg-4">--}}
                                                        {{--<div class="photo">--}}
                                                            {{--<img src="{{ asset('storage/img/'.$visitor->photo) }}" alt="">--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="header">--}}
                                                        {{--<img style="width: 150px; height: 50px;" src="{{ asset('images/'.setting('id_card_logo')) }}" alt=""/>--}}
                                                        {{--<div class="panel-body" style="padding-top: 60px;">--}}
                                                            {{--<h2 style="float: left;">{{$visitor->first_name}} {{$visitor->last_name}}</h2>--}}
                                                            {{--<br>--}}
                                                            {{--<h2 style="float: left;">{{$visitor->visitorID}}</h2>--}}
                                                            {{--<br>--}}
                                                            {{--<h2 style="float: left;">{{$visitor->company_name}}</h2>--}}
                                                            {{--<br>--}}
                                                            {{--<h2 style="float: left;">VISITED TO</h2>--}}
                                                            {{--<br>--}}
                                                            {{--<h3 style="float: left;">Host: {{$visitor->host_name}}</h3>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-lg-8">--}}
                                                        {{--<br>--}}
                                                        {{--<br>--}}
                                                    {{--</div>--}}
                                                    {{--<hr>--}}
                                                {{--</div>--}}
                                                {{--<div class="footer">--}}
                                                    {{--<p><strong>{{ setting('site_address') }} </strong></p>--}}
                                                    {{--<p>Ph: {{ setting('site_phone') }} | E-mail: {{ setting('site_email') }} </p>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="id-card-hook"></div>
                                    <div class="imgcards" id="printidcard">
                                        <div class="id-card-holder">
                                            <div class="id-card">
                                                <div class="header">
                                                    <img src="{{ asset('images/'.setting('id_card_logo')) }}">
                                                </div>
                                                <div class="photo">
                                                    <img src="{{ asset('storage/img/'.$visitor->photo) }}">
                                                </div>
                                                <h2>{{$visitor->first_name}} {{$visitor->last_name}}</h2>
                                                <h3>{{$visitor->visitorID}}</h3>
                                                <h3>{{$visitor->company_name}}</h3>
                                                <h2>VISITED TO</h2>
                                                <h3>Host: {{$visitor->host_name}}</h3>
                                                <hr>
                                                <p><strong>{{ setting('site_address') }} </strong></p>
                                                <p>Ph: {{ setting('site_phone') }} | E-mail: {{ setting('site_email') }} </p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(setting('id_card_template') == 0)
                                    <div class="id-card-hook"></div>
                                    <div class="imgcards" id="printidcard">
                                        <div class="id-card-holder">
                                            <div class="id-card">
                                                <div class="header">
                                                    <img src="{{ asset('images/'.setting('id_card_logo')) }}">
                                                </div>
                                                <div class="photo">
                                                    <img src="{{ asset('storage/img/'.$visitor->photo) }}">
                                                </div>
                                                <h2>{{$visitor->first_name}} {{$visitor->last_name}}</h2>
                                                <h3>{{$visitor->visitorID}}</h3>
                                                <h3>{{$visitor->company_name}}</h3>
                                                <h2>VISITED TO</h2>
                                                <h3>Host: {{$visitor->host_name}}</h3>
                                                <hr>
                                                <p><strong>{{ setting('site_address') }} </strong></p>
                                                <p>Ph: {{ setting('site_phone') }} | E-mail: {{ setting('site_email') }} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div style="margin-top: 10px;">
                                    @if($visitor)
                                        <div style="margin: auto" align="center">
                                            <button  id="print" class="btn btn-primary" >
                                                <i class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div>
                            <p align="center" style="color: red">Plz Your ID Card Settings</p>
                        </div>
                        @endif
                    @else
                    <div>
                        <p align="center" style="color: red">ID Not Available</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function printData(data)
    {
        var frame1 = $('<iframe />');
        var css = "{{ asset('css/id-card-print.css') }}";
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>visitor Card</title>');
        frameDoc.document.write('<link href="'+css+'" rel="stylesheet" type="text/css" />');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        //Append the DIV contents.
        frameDoc.document.write(data);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    }

    $('#print').on('click',function(){
        var data = $("#printidcard").html();
        printData(data);
    });
</script>
@endsection
