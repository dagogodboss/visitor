{!! Form::open(['url' => '/admin/settings/general', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-6">
            @include ('admin.settings.form', ['formMode' => 'create'])
        </div>
        <div class="col-sm-6">
            <div>
                <div style="margin: auto" align="center">
                    <h5>Company Logo</h5>
                </div>
                <br>
                <div style="width: 200px;height: 200px;border: 1px solid #2a2a2a;margin: auto" align="center">
                    <img class="thumbnail img-preview" src="{{ asset('images/'.setting('site_logo')) }}" />
                </div>
                <br>
                <div style="width: 200px; margin: auto;" align="center">
                    <div class="form-group">
                        <div class="input-group">
                            <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
                            <div class="input-group-btn">
                                <div class="fileUpload btn btn-info fake-shadow" style="border-radius: 0px;">
                                    <span><i class="glyphicon glyphicon-upload"></i> Upload Logo</span>
                                    <input id="logo-id" name="site_logo" type="file" class="attachment_upload">
                                </div>
                            </div>
                        </div>
                        <p class="help-block">* Upload your company logo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}