<div class="form-group {{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Html::decode(Form::label('name', 'Name: <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
    {!!  Html::decode(Form::label('email', 'Email: <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('password') ? ' has-error' : ''}}">
    {!!  Html::decode(Form::label('password', 'Password: <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    @php
        $passwordOptions = ['class' => 'form-control'];
        if ($formMode === 'create') {
            $passwordOptions = array_merge($passwordOptions);
        }
    @endphp
    {!! Form::password('password', $passwordOptions) !!}
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('roles') ? ' has-error' : ''}}">
    {!! Form::label('role', 'Role: ', ['class' => 'control-label']) !!}
    {!! Form::select('roles[]', $roles, isset($user_roles) ? $user_roles : [], ['class' => 'form-control', 'multiple' => true]) !!}
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
