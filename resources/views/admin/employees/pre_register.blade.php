@extends('layouts.backend')
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">Pre Register</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="btn-group">
                        <a class="btn btn-outline-info" href="{{ url('employees/pre-register/create') }}">
                            Create
                        </a>
                        {{--<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#myModal">--}}
                            {{--Email <span class="caret"></span>--}}
                        {{--</button>--}}
                    </div>

                    {{--{!! Form::open(['method' => 'POST', 'url' => 'employees/pre_register/export', 'class' => 'form',  'style' => 'display:inline'])  !!}--}}
                    {{--<input type="hidden" name="_method" value="POST" />--}}
                    {{--<input type="hidden" name="date" id="dates" value="">--}}
                    {{--<button   class="btn btn-outline-info">XLS</button>--}}
                    {{--{!! Form::close() !!}--}}
                </div>

                <div class="col-sm-7">
                    {!! Form::open(['method' => 'GET', 'url' => '/employees/pre_register', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
            <br>
            <div id="hide-table">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Expected Date</th>
                            <th>Expected Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @if($pre_register)
                    <tbody>
                    @php $id=0; @endphp
                    @foreach($pre_register as $item)
                        <tr>
                            <td data-title="ID">{{$id +=1 }}</td>
                            <td data-title="Full Name">{{ $item->full_name }}</td>
                            <td data-title="Email">{{ $item->email }}</td>
                            <td data-title="Phone">{{ $item->phone }}</td>
                            <td data-title="Expected Date">{{date('d-m-y',strtotime($item->expected_date))}}</td>
                            <td data-title="Expected Time">{{ $item->expected_time }}</td>
                            <td data-title="Actions">
                                <a href="{{ url('/employees/pre_register/' . $item->id . '/edit') }}" title="Edit pre_register"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                <a class=" waves-effect waves-light remove-record" data-toggle="modal" data-url="{!! URL::route('employees.pre_register.destroy', $item->id) !!}" data-id="{{$item->id}}" data-target="#custom-width-modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                     @endif
                </table>
                <div class="pagination-wrapper"> {!! $pre_register->appends(['search' => Request::get('search')])->render() !!} </div>
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

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#dates').val(start.format('MMMM D, YYYY')+ '-' +end.format('MMMM D, YYYY'));
            $('#predate').val(start.format('MMMM D, YYYY')+ '-' +end.format('MMMM D, YYYY'));

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


