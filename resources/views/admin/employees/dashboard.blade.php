@extends('layouts.backend')

@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">All Visitors</div>
        <div class="card-body">
            <div id="hide-table">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th >ID</th>
                        <th >Photo</th>
                        <th >Name</th>
                        <th >Email</th>
                        <th >Phone</th>
                        <th >Visitor ID</th>
                        <th >Date</th>
                        <th >Status</th>
                        <th >Actions</th>
                    </tr>
                    </thead>
                    @if($visitors)
                        <tbody>
                        @php $id =0; @endphp
                        @foreach($visitors as $visitor)
                            <tr>
                                <td data-title="ID">{{$id +=1}}</td>
                                <td data-title="Photo">
                                    @if($visitor->photo==null)
                                        <img src="{{ asset('images/no-image.png') }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @else
                                        <img src="{{ asset('storage/img/'.$visitor->photo) }}" class="img-responsive img-thumbnail" style="height: 35px;" alt="">
                                    @endif
                                </td>
                                <td data-title="Name">{{ $visitor->first_name}} {{ $visitor->last_name}}</td>
                                <td data-title="Email">{{ $visitor->email }}</td>
                                <td data-title="Phone">{{ $visitor->phone }}</td>
                                <td data-title="Visitor ID">{{ $visitor->visitorID }}</td>
                                <td data-title="Date">{{date('d-m-y',strtotime($visitor->updated_at))}}</td>
                                <td data-title="Status">
                                    @if ($visitor->status == 1)
                                        <button  class="btn btn-primary btn-sm " data-original-title="" title="">
                                            in
                                        </button>
                                    @elseif($visitor->status == 0)
                                        <button  class="btn btn-danger btn-sm " data-original-title="" title="">
                                            out
                                        </button>
                                    @endif
                                </td>
                                <td data-title="Action">
                                    <a href="{{ url('/employees/visitors/show/'.$visitor->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
                <div class="pagination"> {!! $visitors->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
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

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D YYYY') + ' - ' + end.format('MMMM D YYYY'));
            $('#date').val(start.format('MMMM D YYYY')+ '-' +end.format('MMMM D YYYY'));
            $('#dates').val(start.format('MMMM D YYYY')+ '-' +end.format('MMMM D YYYY'));

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
    </script>

@endsection