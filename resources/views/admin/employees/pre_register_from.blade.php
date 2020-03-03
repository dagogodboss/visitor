<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
            {!! Form::label('first_name', 'First Name', ['class' => 'control-label']) !!}
            {!! Form::text('first_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
            {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
            {!! Form::text('last_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
            {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
            {!! Form::text('phone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
            {!! Form::label('company_name', 'Company Name', ['class' => 'control-label']) !!}
            {!! Form::text('company_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('expected_date') ? 'has-error' : ''}}">
            {!! Form::label('expected_date', 'Expected Date', ['class' => 'control-label']) !!}
            {!! Form::date('expected_date', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('expected_date', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group {{ $errors->has('expected_time') ? 'has-error' : ''}}">
            {!! Form::label('expected_time', 'Expected Time', ['class' => 'control-label']) !!}
            <div class="input-group bootstrap-timepicker timepicker">
            {!! Form::text('expected_time', null, ('' == 'required') ? ['class' => 'form-control', 'id'=>'timepicker1','required' => 'required'] : ['class' => 'form-control','id'=>'timepicker1']) !!}
            </div>
            {!! $errors->first('expected_time', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="row">
    @if($employees)
    <div class="col-md-6">
        <div id="div_id_hostID" class="form-group">
            <label for="id_hostID" class="control-label   requiredField"> Select Host </label>
            <div class="controls " style="margin-bottom: 10px;">
                {!! Form::select('host_id', $employees, null, ['class' => 'text-input form-control']) !!}
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
            {!! Form::label('comment', 'Comment', ['class' => 'control-label']) !!}
            {!! Form::textarea('comment', null, ['id' => 'comment', 'rows' => 3, 'cols' => 40, 'style' => 'resize:none','class' => 'form-control']) !!}
            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="invite_visitor"  class="custom-control-input form-control" id="invite_visitor_checked"  checked>
            <label class="custom-control-label" for="invite_visitor_checked">Send Invite Visitor</label>
        </div>
    </div>
</div>
<br/>

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Pre-Register Visitor', ['class' => 'btn btn-primary']) !!}
</div>
