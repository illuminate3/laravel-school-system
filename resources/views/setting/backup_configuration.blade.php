<backup-settings backup_type="{{ Settings::get('backup_type') }}"
                 :options="{{ $opts['backup_type'] }}" inline-template>
    <div class="form-group required {{ $errors->has('backup_type') ? 'has-error' : '' }}">
        {!! Form::label('backup_type', trans('settings.backup_type'), array('class' => 'control-label')) !!}
        <div class="controls">
            <select v-model="backup_type" name="backup_type" class="form-control">
                <option v-for="option in options" v-bind:value="option.id">
                    @{{ option.text }}
                </option>
            </select>
            <span class="help-block">{{ $errors->first('backup_type', ':message') }}</span>
        </div>
    </div>

    {{-- Dropbox --}}
    <div v-if="backup_type=='dropbox'">
        <div class="form-group required {{ $errors->has('disk_dbox_key') ? 'has-error' : '' }}">
            {!! Form::label('disk_dbox_key', trans('settings.disk_dbox_key'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_dbox_key', old('disk_dbox_key', Settings::get('disk_dbox_key')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_dbox_key', ':message') }}</span>
            </div>
        </div>


        <div class="form-group required {{ $errors->has('disk_dbox_secret') ? 'has-error' : '' }}">
            {!! Form::label('disk_dbox_secret', trans('settings.disk_dbox_secret'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_dbox_secret', old('disk_dbox_secret', Settings::get('disk_dbox_secret')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_dbox_secret', ':message') }}</span>
            </div>
        </div>

        <div class="form-group required {{ $errors->has('disk_dbox_token') ? 'has-error' : '' }}">
            {!! Form::label('disk_dbox_token', trans('settings.disk_dbox_token'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_dbox_token', old('disk_dbox_token', Settings::get('disk_dbox_token')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_dbox_token', ':message') }}</span>
            </div>
        </div>

        <div class="form-group required {{ $errors->has('disk_dbox_app') ? 'has-error' : '' }}">
            {!! Form::label('disk_dbox_app', trans('settings.disk_dbox_app'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_dbox_app', old('disk_dbox_app', Settings::get('disk_dbox_app')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_dbox_app', ':message') }}</span>
            </div>
        </div>
    </div>

    <div v-if="backup_type=='s3'">
        {{-- AWS S3 --}}
        <div class="form-group required {{ $errors->has('disk_aws_key') ? 'has-error' : '' }}">
            {!! Form::label('disk_aws_key', trans('settings.disk_aws_key'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_aws_key', old('disk_aws_key', Settings::get('disk_aws_key')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_aws_key', ':message') }}</span>
            </div>
        </div>

        <div class="form-group required {{ $errors->has('disk_aws_secret') ? 'has-error' : '' }}">
            {!! Form::label('disk_aws_secret', trans('settings.disk_aws_secret'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_aws_secret', old('disk_aws_secret', Settings::get('disk_aws_secret')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('disk_aws_secret', ':message') }}</span>
            </div>
        </div>


        <div class="form-group required {{ $errors->has('disk_aws_bucket') ? 'has-error' : '' }}">
            {!! Form::label('disk_aws_bucket', trans('settings.disk_aws_bucket'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_aws_bucket', old('disk_aws_bucket', Settings::get('disk_aws_bucket')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('site_nbucket', ':message') }}</span>
            </div>
        </div>


        <div class="form-group required {{ $errors->has('disk_aws_region') ? 'has-error' : '' }}">
            {!! Form::label('disk_aws_region', trans('settings.disk_aws_region'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('disk_aws_region', old('disk_aws_region', Settings::get('disk_aws_region')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('site_nregion', ':message') }}</span>
            </div>
        </div>
    </div>
</backup-settings>