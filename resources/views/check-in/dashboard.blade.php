@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="check-in" align="center">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    @if(setting('site_logo'))
                                        <img style="width: 250px" src="{{ asset('images/'.setting(['site_logo'])) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="heading row">
                                <div class="col-md-12 col-sm-12">
                                    <h4>Welcome,please tap on button to check-in </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                   <a href="{{ route('check-in.step-one') }}">
                                       <button class='button  btn btn-lg btn-danger'>
                                           <img  src="{{ asset('website/img/check-in-icon.png')}}"><span>Check-in</span>
                                       </button>
                                   </a>
                                </div>
                            </div>
                            <div class="heading row mt-3">
                                <div class="col-md-4 col-sm-12">
                                    <form method="POST">
                                        <a href="{{ route('check-in.return') }} ">I have been here before</a>
                                    </form>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    @if (!Auth::guest() && Auth::user()->hasRole('admin'))
                                        <a href="{{ route('admin') }}">go to admin panel</a>
                                    @elseif(!Auth::guest() && Auth::user()->employee)
                                        <a href="{{ route('dashboard') }}">go to employee panel</a>
                                    @else
                                        <a href="{{ route('login') }}">Sign in to admin panel</a>
                                    @endif
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <form method="POST">
                                        <a href="{{ route('check-in.pre.registered') }}">I have been here Pre-register</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#allemployees').hide();
            $('#allpre_registers').hide();
            $('#selectall').change(function(){
                if($('#selectall').val() == 'Visitors') {
                    $('#allvisitors').show();
                    $('.all').val('Visitors');
                    $('#allemployees').hide();
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
    </script>
@endsection