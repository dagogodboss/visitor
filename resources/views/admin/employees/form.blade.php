<div class="row">
<div class="col-md-8 col-sm-12">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('name', 'Employee Name <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control employee','id'=>'name'] : ['class' => 'form-control employee','id'=>'name']) !!}
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('email', 'Email <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                {!! Form::text('email', null, ('' == 'required') ? ['class' => 'form-control employee','id'=>'email'] : ['class' => 'form-control employee','id'=>'email',]) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('phone', 'Phone <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                {!! Form::text('phone', ($formMode=='edit') ? $employee->employee->phone : null, ('' == 'required') ? ['class' => 'form-control employee','id'=>'phone'] : ['class' => 'form-control employee','id'=>'phone']) !!}
                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('password') ? ' has-error' : ''}}">
                {!! Html::decode(Form::label('password', 'Password <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                @php
                $passwordOptions = ['class' => 'form-control employee'];
                if ($formMode === 'create') {
                $passwordOptions = array_merge($passwordOptions);
                }
                @endphp
                {!! Form::password('password', $passwordOptions) !!}
                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('department') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('Department', 'Department <span class="text-danger">*</span>', ['class' => 'control-label'])) !!}
                {!! Form::text('department', ($formMode=='edit') ? $employee->employee->department : null, ('' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
                {!! $errors->first('department', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-12">
<div class="row">
    <div class="col-md-12">
        <div>
            <div style="width: 140px;height: 140px;border: 1px solid #2a2a2a;">
                @if($employee)
                <img class="thumbnail visitorlogo-id" src="{{ asset('storage/images/'.$employee->employee->photo) }}" />
                @else
                <img class="thumbnail visitorlogo-id" id="photo" src="{{ asset('images/no-image.png') }}" width="100" height="200"/>
                @endif
                <input type="hidden" id="visitorLogo" name="photo" value="">
            </div>
            <br>
            <div style="width: 220px;">
                <div class="form-group">
                    <div class="input-group" style="border-radius: 0px;">
                        <button id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">Choose File</button>
                        <div class="input-group-btn" >
                            <div class="fileUpload btn btn-info fake-shadow" style="border-radius: 0px;">
                                <span><i class="glyphicon glyphicon-upload"></i> Upload Image</span>
                                <input id="visitorlogo-id" name="logo" type="file" class="attachment_upload">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>  
</div>
<br/><br/>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Employee Update' : 'Employee Add', ['class' => 'btn btn-primary','id'=>'employee']) !!}
</div>