@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
            @if($profile)
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">Admin Profile</div>
                        <div class="card-body">
                            <div class="" style="margin: auto" align="center">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                <div class="cardss hovercard">
                                    <div class="cardheader">

                                    </div>
                                    <div class="avatar">
                                        <img alt="" src="https://vignette.wikia.nocookie.net/fan-fiction-library/images/1/15/Admin.png/revision/latest?cb=20140917130743">
                                    </div>
                                    <div class="info">
                                        <div class="title">
                                            <a target="_blank" href="">{{ $profile->name }}</a>
                                        </div>
                                        <div class="desc">{{ $profile->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    </div>
                 </div>
                </div>
            </div>
            @endif
    </div>
@endsection
