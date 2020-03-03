<div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('first_name', 'First Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('first_name', null, ('' == 'required') ? ['class' => 'form-control visitorsAdd', 'id '=>'first_name'] : ['class' => 'form-control visitorsAdd','id '=>'first_name']) !!}
    {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('last_name', 'Last Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('last_name', null, ('' == 'required') ? ['class' => 'form-control visitorsAdd','id '=>'last_name'] : ['class' => 'form-control visitorsAdd','id '=>'last_name']) !!}
    {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('email', 'Email <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::email('email', null, ('required' == 'required') ? ['class' => 'form-control visitorsAdd','id '=>'email'] : ['class' => 'visitorsAdd form-control','id '=>'email']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('phone', 'Phone <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('phone', null, ('required' == 'required') ? ['class' => 'form-control','id '=>'phone'] : ['class' => 'form-control','id '=>'phone']) !!}
    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
    {!! Form::label('company_name', 'Company Name', ['class' => 'control-label']) !!}
    {!! Form::text('company_name', null, ('' == 'required') ? ['class' => 'form-control','id '=>'company_name'] : ['class' => 'form-control','id '=>'company_name']) !!}
    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
</div>
<div id="div_id_hostID" class="form-group">
    <label for="id_hostID" class="control-label   requiredField"> Select Host  <span class="text-danger">*</span></label>
    <div class="controls " style="margin-bottom: 10px;">
        <select name="host_id" id="host_id" class="textinput textInpu form-control visitorsAdd">
            @foreach($employees as $key => $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Visitor Update' : 'Visitor Add Create', ['class' => 'btn btn-primary','id'=>'visitorsAdd']) !!}
</div>
