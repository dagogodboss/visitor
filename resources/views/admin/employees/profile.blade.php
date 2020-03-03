@extends('layouts.backend')

@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Profile
            <span class="pull-right">
                <a href="{{ url('/employees') }}" title="Back"><button class="btn btn-default btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            <a href="{{ url('/employees/' . $employee->id . '/edit') }}" title="Edit Employee"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
            </span>
        </div>
        <div class="card-body">
            @if($employee)

             <div class="" style="margin: auto" align="center">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                <div class="cardss hovercard">
                                    <div class="cardheader">

                                    </div>
                                    <div class="avatar">
                                        <img alt="" src="{{ asset('storage/img/'.$employee->employee->photo) }}">
                                    </div>
                                    <div class="info">
                                        <div class="title">
                                            <a target="_blank" href="">{{ $employee->name }}</a>
                                        </div>
                                        <div class="desc">{{ $employee->email }}</div>
                                        <div class="desc">{{ $employee->employee->phone }}</div>
                                        <div class="desc">{{ $employee->employee->department}}</div>
                                    </div>
                                    <div class="bottom">
                                        @if($employee->employee->status == 1)
                                            {!! Form::open(['method' => 'POST', 'url' => '/employees/checkin_out/'.$employee->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                            <input type="hidden" name="_method" value="PUT" />
                                            <a href="" title="Check-in"><button class=" btn-success "><i class="fa fa-sign-in" aria-hidden="true"></i> Check in</button></a>
                                            <input type="hidden" name="status" value="2">
                                            {!! Form::close() !!}
                                        @elseif($employee->employee->status == 2)
                                            {!! Form::open(['method' => 'POST', 'url' => '/employees/checkin_out/'.$employee->id, 'class' => 'form','style' => 'display:inline'])  !!}
                                            <input type="hidden" name="_method" value="PUT" />
                                            <a href="" title="Check-out"><button class=" btn-danger "><i class="fa fa-sign-out" aria-hidden="true"></i>Check Out </button></a>
                                            <input type="hidden" name="status" value="1">
                                            {!! Form::close() !!}
                                            @else
                                            {!! Form::open(['method' => 'POST', 'url' => '/employees/checkin_out/'.$employee->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                            <input type="hidden" name="_method" value="PUT" />
                                            <a href="" title="Check-in"><button class=" btn-success "><i class="fa fa-sign-in" aria-hidden="true"></i> Check in</button></a>
                                            <input type="hidden" name="status" value="2">
                                            {!! Form::close() !!}

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
             @endif
        </div>
    </div>
</div>
@endsection
