@extends('layouts.backend')

@section('sub-menu')
    <li class="nav-item {{ $type == null || $type == "general" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/general') }}">
            General
        </a>
    </li>
    <li class="nav-item {{ $type == "notifications" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/notifications') }}">
            Notification
        </a>
    </li>
    <li class="nav-item {{ $type == "photo_id_card" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/photo_id_card') }}">
            Photo & ID Card
        </a>
    </li>
    <li class="nav-item {{ $type == "template" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/template') }}">
            Invitation msg
        </a>
    </li>
    <li class="nav-item {{ $type == "front-end" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/front-end') }}">
            Front-end
        </a>
    </li>
    <li class="nav-item {{ $type == "front-end-ed" ? "active" : ""}}" role="presentation">
        <a class="nav-link" href="{{ url('admin/settings/front-end-ed') }}">
            front-end-Enable-Disable
        </a>
    </li>
@endsection

@section('content')
<div class="col-md-9">
        <div class="card">
            <div class="card-header">Setting</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <ul class="nav flex-column">
                            <li class="nav-item {{ $type == null || $type == "general" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/general') }}">
                                    General
                                </a>
                            </li>
                            <li class="nav-item {{ $type == "notifications" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/notifications') }}">
                                    Notification
                                </a>
                            </li>
                            <li class="nav-item {{ $type == "photo_id_card" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/photo_id_card') }}">
                                    Photo & ID Card
                                </a>
                            </li>
                            <li class="nav-item {{ $type == "template" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/template') }}">
                                    Invitation msg
                                </a>
                            </li>
                            <li class="nav-item {{ $type == "front-end" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/front-end') }}">
                                    Front-end
                                </a>
                            </li>
                            <li class="nav-item {{ $type == "front-end-ed" ? "active" : ""}}" role="presentation">
                                <a class="nav-link" href="{{ url('admin/settings/front-end-ed') }}">
                                    front-end-Enable-Disable
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        @if(isset($type))
                            @if($type=='general')
                                @include('admin.settings.general')
                            @elseif($type=='notifications')
                                @include('admin.settings.notifications')
                            @elseif($type=='photo_id_card')
                                @include('admin.settings.photo_id_card')
                            @elseif($type=='template')
                                @include('admin.settings.template')
                            @elseif($type=='front-end')
                                @include('admin.settings.front-end')
                            @elseif($type=='front-end-ed')
                                @include('admin.settings.front-end-ed')
                            @else
                                @include('admin.settings.general')
                            @endif
                        @else
                            @include('admin.settings.general')
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Hello ',
                tabsize: 2,
                height: 100
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.img-preview').attr('src', e.target.result);
                        var img = e.target.result;
                        document.getElementById('image').value =img;
                        console.log(img);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#logo-id").change(function() {
                readURL(this);
            });

            function readURLimg(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
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
            var countchacked1 =0;
            var countchacked2 =0;
            $("#checkIt").click(function () {
                if($(this).val()==1){
                    countchacked1 +=1;
                    $("#card_Unchecked").prop("checked", false);
                    console.log('k'+countchacked1);
                }else if($(this).val()=='checked'){
                    $("#card_Unchecked").prop("checked", true);
                    countchacked2 +=1;
                    console.log('ck'+ countchacked2);
                }

                if(countchacked1 == 2){
                    $("#card_Unchecked").prop("checked", false);
                    countchacked1 =0;
                }else if (countchacked2==2) {
                    $("#card_Unchecked").prop("checked", false);
                    countchacked2 =0;
                }else if(countunchacked2 == 1){
                    $("#card_Unchecked").prop("checked", false);

                }
            });
            var countunchacked1 =0;
            var countunchacked2 =0;
            $("#card_Unchecked").click(function () {
                if($(this).val()==2){
                    countunchacked1 +=1;
                    $("#checkIt").prop("checked", false);
                    console.log('u'+countunchacked1);
                }else if($(this).val()=='unchecked'){
                    $("#checkIt").prop("checked", true);
                    countunchacked2 +=1;
                    console.log('un'+countunchacked2);
                }
                if(countunchacked1 == 2){
                    $("#checkIt").prop("checked", true);
                    countunchacked1 =0;
                }else if(countunchacked2 == 1){
                    $("#checkIt").prop("checked", false);

                }else if(countunchacked2 == 2){
                    $("#checkIt").prop("checked", false);
                    countunchacked2 =0;

                }

            });

        });

    </script>
@endsection