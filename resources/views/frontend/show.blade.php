@extends('layouts.frontend')

@section('content')
    <div class="container">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-sm-12">
                                <div class="card" style="border: 0px;">
                                    <div class="card-body">
                                        @if($visitor)
                                            <div class="card" style="border: 0px;">
                                                <div class="card-body">
                                                    <div style="margin: auto; width: 340px;">
                                                        @if($settings[0]->id_card==1)
                                                            <div class="imgcards" id="printidcard">
                                                                <div style="width: 330px;height: 270px; margin: auto;border: 1px solid black">
                                                                    <div style="background-color:#111570;padding: 5px;">
                                                                        <div align="center" style="margin: auto">
                                                                            <h4 style="color: white">Visitor</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div style="margin-top: 5px; width: 130px; float: left">
                                                                        <div>
                                                                            <img src="{{ asset('storage/img/'.$visitor->photo) }}"  style="width: 125px; height: 124px;border-radius: 50%;margin: 18px;" >
                                                                        </div>
                                                                    </div>
                                                                    <div style="margin-top: 5px; width: 190px; float: right">
                                                                        <div class="photocards" style="margin-left: 30px;">
                                                                            <img src="{{ asset('img/'.$settings[0]->id_card_logo) }}" class="media-photo" style="width: 60px;height: 60px;">
                                                                            <div style="margin-top: 10px">
                                                                                <p style="line-height: 8.05px;  font-weight: bold;  font-size: 18px;" class="textnames" >{{$visitor->first_name}} {{$visitor->last_name}}</p>
                                                                                <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->visitorID}}</p>
                                                                                <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->company_name}}</p>
                                                                                <p style="line-height: 8.05px; font-size: 14px;">Host: {{$visitor->host_name}}</p>
                                                                                <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->date}} {{$visitor->checkin}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif($settings[0]->id_card==0)
                                                            <div class="imgcard" id="printidcard">
                                                                <div style=" width: 330px; height:auto; border:1px solid #000">
                                                                    <div class="row" style="margin-top: 5px;">
                                                                        <div  style="margin:auto" align="center">
                                                                            <div class="photocard">
                                                                                <div style="margin-top: 10px">
                                                                                    <img src="{{ asset('img/'.$settings[0]->id_card_logo) }}" class="media-photo" style="width: 70px;height: 70px;">
                                                                                </div>
                                                                                <div style="margin-top: 10px">
                                                                                    <p style="line-height: 8.05px;  font-weight: bold;  font-size: 18px;" class="textname" >{{$visitor->first_name}} {{$visitor->last_name}}</p>
                                                                                    <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->visitorID}}</p>
                                                                                    <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->company_name}}</p>
                                                                                    <p style="line-height: 8.05px; font-size: 14px;">Host: {{$visitor->host_name}}</p>
                                                                                    <p style="line-height: 8.05px; font-size: 14px;">{{$visitor->date}} {{$visitor->checkin}}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="footer">
                                                                        <div style="background-color:#111570;padding: 5px;">
                                                                            <div align="center" style="margin: auto">
                                                                                <h4 style="color: white;margin-top: 5px">Visitor</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div style="margin-top: 10px;">

                                                            <a href="{{ url('/frontend') }}"><button  class="btn btn-primary">
                                                                    <i class="fa fa-left" aria-hidden="true"></i> Back
                                                                </button></a>
                                                            @if($visitor)
                                                                <a href="{{ url('/frontend/visitors/' . $visitor->id . '/edit') }}"><button  class="btn btn-primary">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i> Edit
                                                                    </button></a>
                                                                <a ><button id="print"   class="btn btn-success" >
                                                                        <i class="fa fa-print" aria-hidden="true"></i> Print
                                                                    </button></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>visitor Card</title>');
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

