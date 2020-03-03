@extends('layouts.backend')
@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ url('admin/users/create') }}" class="btn btn-default border border-primary">
                            Create
                        </a>
                    </div>
                    <div class="col-md-6">
                        {!! Form::open(['method' => 'GET', 'url' => '/admin/users', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="hide-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 0; @endphp
                                    @foreach($users as $item)
                                        <tr>
                                            <td data-title="ID">{{ $i +=1}}</td>
                                            <td data-title="Name"><a href="{{ url('/admin/users', $item->id) }}" >{{ $item->name }}</a></td>
                                            <td data-title="Email">{{ $item->email }}</td>
                                            <td data-title="Actions">
                                                <a href="{{ url('/admin/users/' . $item->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'url' => ['/admin/users', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete User',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
