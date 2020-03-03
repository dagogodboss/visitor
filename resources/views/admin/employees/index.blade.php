@extends('layouts.backend')
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Employees</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="btn-group">
                        <a class="btn btn-outline-info" href="{{ url('admin/employees/create') }}">
                            Create
                        </a>
                        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#myModal">
                            Email <span class="caret"></span>
                        </button>
                    </div>

                    {!! Form::open(['method' => 'POST', 'url' => 'admin/employees/export', 'class' => 'form',  'style' => 'display:inline'])  !!}
                        <input type="hidden" name="_method" value="POST" />
                        <input type="hidden" name="date" id="date" value="">
                        <button   class="btn btn-outline-info">XLS</button>
                    {!! Form::close() !!}
                </div>

                <div class="col-sm-7">
                    {!! Form::open(['method' => 'GET',  'url' => '/admin/employees', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div id="hide-table" class="mt-3">
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
                        @if(count($employees))
                        <tbody>
                        @php $id =0; @endphp

                        @foreach($employees as $employ)
                            <tr>
                                <td data-title="ID">{{$id +=1}}</td>
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
                                <td data-title="Actions">
                                    @if($employ->employee->status == 1)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_in/'.$employ->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @elseif($employ->employee->status == 2)
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_out/'.$employ->id, 'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-out"><button class="btn btn-danger btn-sm"><i class="fa fa-sign-out" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="1">
                                        {!! Form::close() !!}
                                    @else
                                        {!! Form::open(['method' => 'POST', 'url' => '/admin/employees/check_in/'.$employ->id,  'class' => 'form','style' => 'display:inline'])  !!}
                                        <input type="hidden" name="_method" value="PUT" />
                                        <a href="" title="Check-in"><button class="btn btn-success btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>
                                        <input type="hidden" name="status" value="2">
                                        {!! Form::close() !!}
                                    @endif
                                    <a href="{{ url('/admin/employees/' . $employ->id . '/show') }}" title="View employee"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                    <a href="{{ url('/admin/employees/' . $employ->id . '/edit') }}" title="Edit employee"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                   <a class=" waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('admin.employees.destroy', $employ->id) !!}" data-id="{{$employ->id}}" data-target="#custom-width-modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @endif
                    </table>
                    <div class="pagination"> {!! $employees->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Delete Model--}}
<form action="" method="POST" class="remove-record-model">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />

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
                Email
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                {!! Form::open(['url' => '/admin/employees/sendEmail', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="send-mail">
                    <input type="hidden" name="date" id="dates" value="">
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

        $('#datepicker').change(function () {


        });

        var start = moment().subtract(6, 'days');
        var end = moment();

        function cb(start, end) {
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        $('#date').val(start.format('D MMMM YYYY')+ '-' +end.format('D MMMM YYYY'));
        $('#dates').val(start.format('D MMMM YYYY')+ '-' +end.format('D MMMM YYYY'));

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




        $('.remove-record').click(function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            $(".remove-record-model").attr("action",url);
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        });

        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
        $('.modal').click(function() {
            // $('body').find('.remove-record-model').find( "input" ).remove();
        });
    </script>
@endsection