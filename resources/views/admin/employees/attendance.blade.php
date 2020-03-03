@extends('layouts.backend')

@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Employee Attendance
        <a href="{{ url('/employees') }}" title="Back"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
        </div>
        <div class="card-body">

            <div id="hide-table">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        @if($attendance)
                            <tbody>
                            @foreach($attendance as $attend)
                        <tr>
                            <td  data-title="Date">{{$attend->date}}</td>
                            <td  data-title="Check In">{{$attend->checkin}}</td>
                            <td  data-title="Check Out">{{$attend->checkout}}</td>
                            @if($attend->status == 2)
                                <td data-title="Status"> <button class="btn btn-danger btn-sm">in</button> </td>
                            @elseif($attend->status == 1)
                                <td data-title="Status"> <button class="btn btn-danger btn-sm">Out</button> </td>
                                @else
                                <td data-title="Status"> <p style="collapse: red">Absent</p>Absent </td>
                                @endif
                        </tr>
                            @endforeach
                            </tbody>
                         @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
