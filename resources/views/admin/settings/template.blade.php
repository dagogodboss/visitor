{!! Form::open(['url' => '/admin/settings/template', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-12">
            <div class="form-group">
                <textarea class="summernote" name="invite_templates" id="invite_templates">{{setting('invite_templates')}}</textarea>
            </div>
        </div>
    </div>
    <div class="row " >
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}