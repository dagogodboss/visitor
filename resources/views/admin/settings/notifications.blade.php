{!! Form::open(['url' => '/admin/settings/notifications', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Twilio API Settings</div>
                <div class="card-body">
                    <div id="" class="form-group">
                        <label for="twilio_sid" class="control-label">SID</label>
                        <div class="controls">
                            <input class="input-md textinput textInput form-control" id="twilio_sid" name="phone" placeholder="SID" style="margin-bottom: 10px" type="text" value="{{ setting('twilio_sid') }}"/>
                        </div>
                    </div>
                    <div id="" class="form-group ">
                        <label for="twilio_token" class="control-label ">Token</label>
                        <div class="controls">
                            <input class="input-md textinput textInput form-control" id="twilio_token" name="twilio_token" placeholder="Token" style="margin-bottom: 10px" type="text"  value="{{ setting('twilio_token') }}"/>
                        </div>
                    </div>
                    <div id="" class="form-group ">
                        <label for="twilio_phone" class="control-label ">Phone</label>
                        <div class="controls">
                            <input class="input-md textinput textInput form-control" id="twilio_phone" name="twilio_phone" placeholder="Phone" style="margin-bottom: 10px" type="text"  value="{{ setting('twilio_phone') }}"/>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Africa's Talking API Settings</div>
                <div class="card-body">
                    <div id="" class="form-group">
                        <label for="id_name" class="control-label">User Name</label>
                        <div class="controls">
                            <input class="input-md textinput textInput form-control" id="id_phone" name="phone" placeholder="User name" style="margin-bottom: 10px" type="text" value="{{ setting('phone') }}"/>
                        </div>
                    </div>
                    <div id="" class="form-group ">
                        <label for="id_name" class="control-label ">API Key</label>
                        <div class="controls">
                            <input class="input-md textinput textInput form-control" id="apikey" name="apikey" placeholder="Api Key" style="margin-bottom: 10px" type="text"  value="{{ setting('apikey') }}"/>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Host Notifications Setting</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" id="">
                                <label class="control-label" for="defaultUnchecked">Email Notifications</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="notifications_email" {{ setting('notifications_email') == true ? "checked":"" }} value="1">Enable
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="notifications_email" {{ setting('notifications_email') == false ? "checked":"" }} value="0">Disable
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="">
                                <label class="" for="defaultUnchecked">SMS Notifications</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="notifications_sms" {{ setting('notifications_sms') == true ? "checked":"" }} value="1">Enable
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="notifications_sms" {{ setting('notifications_sms') == false ? "checked":"" }} value="0">Disable
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" id="">
                                <label class="" for="defaultUnchecked">Active Gateway</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="sms_gateway" {{ setting('sms_gateway') == true ? "checked":"" }} value="1">Twilio
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="sms_gateway" {{ setting('sms_gateway') == false ? "checked":"" }} value="0">Africa's Talking
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="comment">Notifications Templates:</label>
                <textarea class="summernote" name="notify_templates" id="summernote">{{ setting('notify_templates') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
