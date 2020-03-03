<div class="form-group {{ $errors->has('site_name') ? 'has-error' : ''}}">
{!! Html::decode(Form::label('site_name', 'Company Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
{!! Form::text('site_name', setting('site_name'), ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
{!! $errors->first('site_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('site_email') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('site_email', 'Company Email <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('site_email', setting('site_email'), ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
    {!! $errors->first('site_email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('site_phone') ? 'has-error' : ''}}">
{!! Html::decode(Form::label('site_phone', 'Company Phone <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
{!! Form::text('site_phone', setting('site_phone'), ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
{!! $errors->first('site_phone', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('site_address') ? 'has-error' : ''}}">
    {!! Html::decode(Form::label('site_address', 'Address <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
    {!! Form::text('site_address', setting('site_address'), ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
    {!! $errors->first('site_address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
</div>
