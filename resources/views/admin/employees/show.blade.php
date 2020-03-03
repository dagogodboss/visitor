@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.employees.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/employees/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Employee View
        <span class="pull-right">
            <a href="{{ url('/admin/employees') }}" title="Back"><button class="btn btn-default btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            <a href="{{ url('/admin/employees/' . $employee->id . '/edit') }}" title="Edit Employee"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
        </span>
        </div>
        @if($employee)
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Employee Profile</div>
                        <div class="card-body">
                            <div class="" style="margin: auto" align="center">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                <div class="cardss hovercard">
                                    <div class="cardheader">

                                    </div>
                                    <div class="avatar">
                                        <img alt="" src="{{ asset('storage/images/'.$employee->employee->photo) }}">
                                    </div>
                                    <div class="info">
                                        <div class="title">
                                            <a target="_blank" href="">{{ $employee->name }}</a>
                                        </div>
                                        <div class="desc">{{ $employee->email }}</div>
                                        <div class="desc">{{ $employee->employee->phone }}</div>
                                        <div class="desc">{{ $employee->employee->department}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    </div>
                 </div>
                </div>
                <div class="col-md-7">

                    <div class="card">
                        <div class="card-header">Employee Attendance</div>
                         <div id="hide-table">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @if($attendance)
                                    <tbody>
                                    @foreach($attendance as $attend)
                                        <tr>
                                            <td data-title="Date">{{$attend->date}}</td>
                                            <td data-title="Check In">{{$attend->checkin}}</td>
                                            <td data-title="Check Out">{{$attend->checkout}}</td>
                                            @if($attend->status == 2)
                                                <td> in </td>
                                            @elseif($attend->status == 1)
                                                <td> Out </td>
                                            @else
                                                <td data-title="Action"> <p style="collapse: red">Absent</p>Absent </td>
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
        </div>
            @else
            <div>
                <h4 align="center" style="color: #ff6666">ID Not Available</h4>
            </div>
        @endif
    </div>
</div>
@endsection
