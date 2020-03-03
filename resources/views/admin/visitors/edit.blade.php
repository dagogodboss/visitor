@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.visitors.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/visitors/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Edit visitor
                <a href="{{ url('/admin/visitors') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if($visitor)

                {!! Form::model($visitor, [
                    'method' => 'PUT',
                    'url' => ['/admin/visitors/update', $visitor->id],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}
                <div class="row">
                    <div class="col-sm-6">
                        @include ('admin.visitors.form', ['formMode' => 'edit'])
                    </div>
                    <div class="col-sm-6">
                        <div class="panel-body">
                            <form  class="form-horizontal" method="post">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <video id="video" width="200" height="200" autoplay  style="width: 200px;height: 200px;"></video>
                                        <div>
                                            <button type="button" id="snap" class="btn btn-success btn-add-new">pictures capture</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <canvas id="canvas" width="180" height="175"></canvas>
                                        <input type="hidden" id="image" name="photo" value="">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {!! Form::close() !!}

                @else
                    <div>
                        <p align="center" style="color: red">ID Not Available</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var video = document.getElementById('video');

        // Get access to the camera!
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Not adding `{ audio: true }` since we only want video now
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                video.srcObject = stream;
                video.play();
            });
        }

        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');

        // Trigger photo take
        document.getElementById("snap").addEventListener("click", function() {
            context.drawImage(video, 0, 0, 180, 175);
            var img = canvas.toDataURL('image/png');
            console.log(img);
            document.getElementById('image').value =img;
        });
    </script>
@stop
