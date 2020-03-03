@extends('layouts.backend')
@section('sub-menu')
    <li class="nav-item {{ str_is('admin.users.create', Route::currentRouteName()) ? 'active' : '' }}" role="presentation">
        <a class="nav-link" href="{{ url('admin/users/create') }}">
            Create
        </a>
    </li>
@endsection
@section('content')
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            User
            <span class="pull-right">
            <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-default btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
            {!! Form::open([
                'method' => 'DELETE',
                'url' => ['/admin/users', $user->id],
                'style' => 'display:inline'
            ]) !!}
                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-sm',
                        'title' => 'Delete User',
                        'onclick'=>'return confirm("Confirm delete?")'
                ))!!}
            {!! Form::close() !!}
            </span>
        </div>
        <div class="card-body">
            <div id="hide-table">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th> <th>Name</th><th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-title="ID">{{ $user->id }}</td>
                                <td data-title="Name"> {{ $user->name }} </td>
                                <td data-title="Email"> {{ $user->email }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
