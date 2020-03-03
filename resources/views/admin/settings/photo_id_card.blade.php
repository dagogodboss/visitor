{!! Form::open(['url' => '/admin/settings/photo_id_card', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Photo Setting</div>
                <div class="card-body">
                    <div class="form-group" id="">
                        <label class="control-label" for="defaultUnchecked">Visitor Photo Capture</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visitor_img_capture" {{ setting('visitor_img_capture') == true ? "checked":"" }} value="1">Enable
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visitor_img_capture" {{ setting('visitor_img_capture') == false ? "checked":"" }} value="0">Disable
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="">
                        <label class="control-label" for="defaultUnchecked">Employee Photo Capture</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="employ_img_capture" {{ setting('employ_img_capture') == true ? "checked":"" }} value="1">Enable
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="employ_img_capture" {{ setting('employ_img_capture') == false ? "checked":"" }} value="0">Disable
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Visitor ID Logo</div>
                <div class="card-body">
                    <div>
                        <div style="width: 140px;height: 140px;border: 1px solid #2a2a2a;margin: auto" align="center">
                            @if(setting('id_card_logo'))
                            <img class="thumbnail visitorlogo-id" src="{{ asset('images/'.setting('id_card_logo')) }}" />
                            @else
                            <img class="thumbnail visitorlogo-id" src="{{ asset('images/no-image.png') }}" />
                            @endif
                        </div>
                        <br>
                        <div style="width: 210px; margin: auto;" align="center">
                            <div class="form-group">
                                <div class="input-group">
                                    <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
                                    <div class="input-group-btn">
                                        <div class="fileUpload btn btn-info fake-shadow" style="border-radius: 0px">
                                            <span><i class="glyphicon glyphicon-upload"></i> Upload Logo</span>
                                            <input id="visitorlogo-id" name="id_card_logo" type="file" class="attachment_upload">
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
    {{--<div class="row" style="margin-top: 10px;">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Visitor ID Card Template</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div align="center" style="margin: auto">
                                <div class="form-group">
                                    <input type="radio" name="id_card_template" id="templateOne" value='1' {{ setting('id_card_template') == 1 ? "checked":"" }}/>
                                </div>
                            </div>
                            <div class="idcard" style="margin: auto" align="center">
                                <div style="width: 280px;height: 190px;border: 1px solid #4e555b">
                                    <div style="background-color:#007bff;padding: 5px;">
                                        <div align="center" style="margin: auto">
                                            <h4 style="color: white">Visitor</h4>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-sm-5" style="margin-top: 10px;">
                                                <div class="cardimg">

                                                </div>
                                            </div>
                                            <div class="col-sm-7" style="margin-top: 10px">
                                                <div>
                                                    <h5>iNilabs Logo</h5>
                                                    <p class="textname" >inilabs.net</p>
                                                    <p>iNilabs Company</p>
                                                    <p>Host: admin admin</p>
                                                    <p>10 oct 12.30PM</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div align="center" style="margin: auto">
                                <div class="form-group">
                                    <input type="radio" name="id_card_template" id="templateTwo"  value='0' {{ setting('id_card_template') == 0 ? "checked":"" }}/>
                                </div>
                            </div>
                            <div class="idcard" style="margin: auto" align="center">
                                <div style="width: 280px;height: 190px;border: 1px solid #4e555b">
                                    <div class="col-sm-8" style="margin-top: 21px">
                                        <div>
                                            <h5>iNilabs Logo</h5>
                                            <p class="textname" >inilabs.net</p>
                                            <p>iNilabs Company</p>
                                            <p>Host: admin admin</p>
                                            <p>10 oct 12.30PM</p>
                                        </div>
                                    </div>
                                    <div style="background-color:#007bff;padding: 5px;margin-top: 15px">
                                        <div align="center" style="margin: auto">
                                            <h4 style="color: white">Visitor</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="row mt-2" >
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}