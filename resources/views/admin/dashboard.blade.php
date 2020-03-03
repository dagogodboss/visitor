@extends('layouts.backend')
<style type="text/css">
    .btn {
        margin-bottom: 2px;
    }
</style>
@section('content')
    <div class="col-md-9">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card bg-success" style="margin-bottom: 2px;">
                            <div class="card-body">
                                <div class="count" align="center" style="margin: auto">
                                    <h3 class="p">{{$allCounts[0]}}</h3>
                                    <p>Visitors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card bg-secondary" style="margin-bottom: 2px;">
                            <div class="card-body">
                                <div class="count" align="center" style="margin: auto">
                                    <h3 class="p">{{$allCounts[1]}}</h3>
                                    <p>Employees</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card bg-dark" style="margin-bottom: 2px;">
                            <div class="card-body">
                                <div class="count" align="center" style="margin: auto">
                                    <h3 class="p">{{$allCounts[2]}}</h3>
                                    <p>Pre Registers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="btn-group" style="float: right; margin: 2px">
                    <button class="btn btn-outline-info  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       New Entry
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/admin/visitors/create') }}">New visitors</a>
                        <a class="dropdown-item" href="{{url('/admin/employees/create') }}">New Employees</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            {!! Form::open(['method' => 'POST', 'url' => '/admin/export', 'class' => 'form',  'style' => 'display:inline'])  !!}
                                    <input type="hidden" name="_method" value="POST" />
                                    <input type="hidden" name="date" id="datevalue" value="">
                                    <input type="hidden" id="all" class="all" name="all" value="Visitors">
                                    <button class="btn btn-default border border-primary">XLS</button>
                                    {!! Form::close() !!}
                            <button type="button" class="btn btn-default border border-primary" data-toggle="modal" data-target="#myModal">Email</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search" style="float: right">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin', 'class' => 'form-inline my-2 my-lg-0 float-left', 'role' => 'search'])  !!}
                            <div class="input-group" >
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <input type="hidden" id="all" class="all" name="all" value="Visitors">

                                <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            </span>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-3" style="margin-top: 2px">
                        <div id="dtrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>

                    </div>

                    <div class="col-sm-4" style="margin-top: 2px">

                        <select id="selectall" name="selectall" class="form-control">
                            <option  value="Visitors" name="Visitors" >All Visitors</option>
                            <option value="Employees" name="Employees" >All Employees</option>
                            <option value="pre_registers" name="pre_registers" >All Pre Registers</option>
                        </select>

                    </div>


                    <div class="col-md-5" style="margin-top: 2px">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp
                            <span></span><i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <br>
                <div id="hide-table">
                <div id="allvisitors">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Visitor ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        @if($visitors)
                        <tbody>
                        @php $i=0; @endphp
                        @foreach($visitors as $visitor)
                            <tr>
                                <td data-title="ID">{{$i +=1}}</td>
                                <td data-title="Photo">
                                    @if($visitor->photo==null)
                                        <img src="{{ asset('images/no-image.png') }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @else
                                        <img src="{{ asset('storage/img/'.$visitor->photo) }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @endif
                                </td>
                                <td data-title="Name"><a>{{ $visitor->first_name}} {{ $visitor->last_name}}</a></td>
                                <td data-title="Email">{{ $visitor->email }}</td>
                                <td data-title="Phone">{{ $visitor->phone }}</td>
                                <td data-title="Visitor ID">{{ $visitor->visitorID }}</td>
                                <td data-title="Date">{{date('d-m-y',strtotime($visitor->updated_at))}}</td>
                                <td data-title="Status">
                                    @if ($visitor->status == 2)
                                        <button  class="btn btn-primary btn-sm " data-original-title="" title="">
                                            in
                                        </button>
                                    @elseif($visitor->status == 1)
                                        <button  class="btn btn-danger btn-sm " data-original-title="" title="">
                                            out
                                        </button>
                                    @endif
                                </td>
                                <td data-title="Action">

                                    @if($visitor->status == 1)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/visitors/check_in/'.$visitor->visitorID, 'class' => 'form-inline my-2 my-lg-0 float-right'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @elseif($visitor->status == 2)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/visitors/check_out', 'class' => 'form-inline my-2 my-lg-0 float-right'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-out"><button class="btn btn-danger btn-sm"><i class="fa fa-sign-out" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="visitor_ID" value="{{$visitor->visitorID}}">
                                        {!! Form::close() !!}
                                    @else
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/visitors/check_in/'.$visitor->visitorID, 'class' => 'form-inline my-2 my-lg-0 float-right'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @endif
                                    <a href="{{ url('/admin/visitors/show/'.$visitor->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                    <a href="{{ url('/admin/visitors/' . $visitor->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                        <a class=" waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('admin.destroy', $visitor->id) !!}" data-id="{{$visitor->id}}" data-target="#custom-width-modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @endif
                    </table>
                    </div>
                    <div class="pagination"> {!! $visitors->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>

                <div id="allemployees">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th >ID</th>
                            <th >Photo</th>
                            <th >Name</th>
                            <th >Email</th>
                            <th >Phone</th>
                            <th >Employee ID</th>
                            <th >Date</th>
                            <th >Status</th>
                            <th >Actions</th>
                        </tr>
                        </thead>
                        @if($employees)
                        <tbody>
                        @php $i=0; @endphp

                        @foreach($employees as $employ)
                            <tr>
                                <td data-title="ID">{{$i +=1}}</td>
                                <td data-title="Photo">
                                    @if($employ->employee->photo==null)
                                        <img src="{{ asset('images/no-image.png') }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @else
                                        <img src="{{ asset('storage/images/'.$employ->employee->photo) }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @endif
                                </td>
                                <td data-title="Name">{{ $employ->name}}</td>
                                <td data-title="Email">{{ $employ->email }}</td>
                                <td data-title="Phone">{{ $employ->employee->phone }}</td>
                                <td data-title="Employee ID">{{ $employ->employee->employeeID }}</td>
                                <td data-title="Date">{{date('d-m-y',strtotime($employ->created_at))}}</td>
                                <td data-title="Status">
                                    @if ($employ->employee->status == 2)
                                        <button  class="btn btn-primary btn-sm" data-original-title="" title="">
                                            in
                                        </button>
                                    @elseif($employ->employee->status == 1)
                                        <button  class="btn btn-danger btn-sm " data-original-title="" title="">
                                            out
                                        </button>
                                    @endif
                                </td>
                                <td data-title="Action">
                                    @if($employ->employee->status == 1)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_in/'.$employ->employee->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @elseif($employ->employee->status == 2)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_out/'.$employ->employee->id, 'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-out"><button class="btn btn-danger btn-sm"><i class="fa fa-sign-out" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="1">
                                        {!! Form::close() !!}
                                    @else
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_in/'.$employ->employee->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @endif
                                        <a href="{{ url('/admin/employees/' . $employ->id . '/show') }}" title="View employee"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        <a href="{{ url('/admin/employees/' . $employ->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                        <a class=" waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('admin.destroy', $employ->id) !!}" data-id="{{$employ->id}}" data-target="#custom-width-modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @endif
                    </table>
                    <div class="pagination"> {!! $employees->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>
                </div>

                <div id="allpre_registers">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th >ID</th>
                            <th >Name</th>
                            <th >Email</th>
                            <th >Phone</th>
                            <th >Date</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        @if($pre_registers)
                        <tbody>
                        @php $i=0; @endphp
                        @foreach($pre_registers as $item)
                            <tr>
                                <td data-title="ID">{{$i +=1}}</td>
                                <td data-title="Name">{{ $item->full_name }}</td>
                                <td data-title="Email">{{ $item->email }}</td>
                                <td data-title="Phone">{{ $item->phone }}</td>
                                <td data-title="Date">{{date('d-m-y',strtotime($item->updated_at))}}</td>
                                <td data-title="Action">
                                    <a href="{{ url('/admin/pre_register/' . $item->id) }}" title="View pre_register"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                    <a href="{{ url('/admin/pre_register/' . $item->id . '/edit') }}" title="Edit pre_register"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                    <a class=" waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('admin.destroy', $item->id) !!}" data-id="{{$item->id}}" data-target="#custom-width-modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @endif
                    </table>
                    <div class="pagination"> {!! $pre_registers->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="POST" class="remove-record-model">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <input type="hidden" id="all" class="all" name="all" value="Visitors">

        <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <h4>You Want You Sure Delete This Record?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5>Mail</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    {!! Form::open(['url' => '/admin/send/email', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="send-mail">
                        <input type="hidden" id="all" class="all" name="all" value="Visitors">
                        <input type="hidden" name="date" id="xlsdate" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('to') ? 'has-error' : ''}}">
                                    {!! Form::label('to', 'To', ['class' => 'control-label']) !!}
                                    {!! Form::text('to', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                    {!! $errors->first('to', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                    {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
                                    {!! Form::text('subject', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
                                    {!! Form::label('body', 'Body', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('body', null, ['id' => 'body', 'rows' => 3, 'cols' => 40, 'style' => 'resize:none','class' => 'form-control']) !!}
                                    {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            {!! Form::submit('Send Email', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#datepicker').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker').datepicker("setDate", new Date());
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            $('#datevalue').val(start.format('D MMMM YYYY')+ '-' +end.format('D MMMM YYYY'));
            $('#xlsdate').val(start.format('D MMMM YYYY')+ '-' +end.format('D MMMM YYYY'));

        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        var starts = moment().subtract(29, 'days');
        var ends = moment();
        function cbs(ends) {
            $('#dtrange span').html(ends.format('D MMMM YYYY'));

        }
        $('#dtrange').daterangepicker({
            startDate: starts,
            endDate: ends,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').endOf('month')]
            }
        }, cbs);
        cbs(ends);
        $(document).ready(function() {

            $('#allemployees').hide();
            $('#allpre_registers').hide();
            $('#selectall').change(function(){
                if($('#selectall').val() == 'Visitors') {
                    $('#allvisitors').show();
                    $('.all').val('Visitors');
                    $('#allemployees').hide()
                    $('#allpre_registers').hide();
                }
                if($('#selectall').val() == 'Employees') {
                    $('#allemployees').show();
                    $('.all').val('Employees');
                    $('#allvisitors').hide();
                    $('#allpre_registers').hide();
                }
                if($('#selectall').val() == 'pre_registers') {
                    $('#allpre_registers').show();
                    $('.all').val('pre_registers');
                    $('#allvisitors').hide();
                    $('#allemployees').hide();
                }

            });
        });
        $('.remove-record').click(function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            $(".remove-record-model").attr("action",url);
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="POST">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        });
        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
        $('.modal').click(function() {});
    </script>
@endsection