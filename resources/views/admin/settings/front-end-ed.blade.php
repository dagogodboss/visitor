{!! Form::open(['url' => '/admin/settings/front-end-ed', 'class' => 'form-horizontal', 'files' => true]) !!}
<div class="save">
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Front-end-Enable-Disable</div>
                <div class="card-body">
                    <div class="form-group" id="">
                        <label class="control-label" for="defaultUnchecked">front-end-Enable-Disable Acknowledgement</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="front_end_enable_disable" {{ setting('front_end_enable_disable') == true ? "checked":"" }} value="1">Enable
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="front_end_enable_disable" {{ setting('front_end_enable_disable') == false ? "checked":"" }} value="0">Disable
                            </label>
                        </div>
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