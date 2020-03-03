{!! Form::open(['url' => '/admin/settings/front-end', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Visitor Agreement</div>
                <div class="card-body">
                    <div class="form-group" id="">
                        <label class="control-label" for="defaultUnchecked">Visitor Agreement Acknowledgement</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visitor_agreement" {{ setting('visitor_agreement') == true ? "checked":"" }} value="1">Enable
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visitor_agreement" {{ setting('visitor_agreement') == false ? "checked":"" }} value="0">Disable
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Welcome Screen Setting</div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="summernote" name="welcome_screen" id="comment">{{setting('welcome_screen')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Visitor Agreement Template</div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="summernote" name="agreement_screen" id="comment">{{setting('agreement_screen')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2" >
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}