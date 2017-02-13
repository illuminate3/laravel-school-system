<sms-settings sms_driver="{{ Settings::get('sms_driver') }}"
              :options="{{ $opts['sms_driver'] }}" inline-template>
    <div class="form-group required {{ $errors->has('sms_driver') ? 'has-error' : '' }}">
        {!! Form::label('sms_driver', trans('settings.sms_driver'), array('class' => 'control-label')) !!}
        <div class="controls">
            <select v-model="sms_driver" name="sms_driver" class="form-control">
                <option v-for="option in options" v-bind:value="option.id">
                    @{{ option.text }}
                </option>
            </select>
            <span class="help-block">{{ $errors->first('sms_driver', ':message') }}</span>
        </div>
    </div>
    <div v-if="sms_driver!='none' && sms_driver!=''">
        <div class="form-group required {{ $errors->has('sms_from') ? 'has-error' : '' }}">
            {!! Form::label('sms_from', trans('settings.sms_from'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('sms_from', old('sms_from', Settings::get('sms_from')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sms_from', ':message') }}</span>
            </div>
        </div>
    </div>
    {{-- CallFire --}}
    <div v-if="sms_driver=='callfire'">
        <div class="form-group required {{ $errors->has('callfire_app_login') ? 'has-error' : '' }}">
            {!! Form::label('callfire_app_login', trans('settings.callfire_app_login'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('callfire_app_login', old('callfire_app_login', Settings::get('callfire_app_login')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('callfire_app_login', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('callfire_app_password') ? 'has-error' : '' }}">
            {!! Form::label('callfire_app_password', trans('settings.callfire_app_password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('callfire_app_password', old('callfire_app_password', Settings::get('callfire_app_password')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('callfire_app_password', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Eztexting --}}
    <div v-if="sms_driver=='eztexting'">
        <div class="form-group required {{ $errors->has('eztexting_username') ? 'has-error' : '' }}">
            {!! Form::label('eztexting_username', trans('settings.eztexting_username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('eztexting_username', old('eztexting_username', Settings::get('eztexting_username')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('eztexting_username', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('eztexting_password') ? 'has-error' : '' }}">
            {!! Form::label('eztexting_password', trans('settings.eztexting_password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('eztexting_password', old('eztexting_password', Settings::get('eztexting_password')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('eztexting_password', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Labsmobile --}}
    <div v-if="sms_driver=='labsmobile'">
        <div class="form-group required {{ $errors->has('labsmobile_client') ? 'has-error' : '' }}">
            {!! Form::label('labsmobile_client', trans('settings.labsmobile_client'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('labsmobile_client', old('labsmobile_client', Settings::get('labsmobile_client')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('labsmobile_client', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('labsmobile_username') ? 'has-error' : '' }}">
            {!! Form::label('labsmobile_username', trans('settings.labsmobile_username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('labsmobile_username', old('labsmobile_username', Settings::get('labsmobile_username')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('labsmobile_username', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('labsmobile_password') ? 'has-error' : '' }}">
            {!! Form::label('labsmobile_password', trans('settings.labsmobile_password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('labsmobile_password', old('labsmobile_password', Settings::get('labsmobile_password')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('labsmobile_password', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Mozeo --}}
    <div v-if="sms_driver=='mozeo'">
        <div class="form-group required {{ $errors->has('mozeo_company_key') ? 'has-error' : '' }}">
            {!! Form::label('mozeo_company_key', trans('settings.mozeo_company_key'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mozeo_company_key', old('mozeo_company_key', Settings::get('mozeo_company_key')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mozeo_company_key', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mozeo_username') ? 'has-error' : '' }}">
            {!! Form::label('mozeo_username', trans('settings.mozeo_username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mozeo_username', old('mozeo_username', Settings::get('mozeo_username')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mozeo_username', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mozeo_password') ? 'has-error' : '' }}">
            {!! Form::label('mozeo_password', trans('settings.mozeo_password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mozeo_password', old('mozeo_password', Settings::get('mozeo_password')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mozeo_password', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Nexmo --}}
    <div v-if="sms_driver=='nexmo'">
        <div class="form-group required {{ $errors->has('nexmo_api_key') ? 'has-error' : '' }}">
            {!! Form::label('nexmo_api_key', trans('settings.nexmo_api_key'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('nexmo_api_key', old('nexmo_api_key', Settings::get('nexmo_api_key')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('nexmo_api_key', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('nexmo_api_secret') ? 'has-error' : '' }}">
            {!! Form::label('nexmo_api_secret', trans('settings.nexmo_api_secret'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('nexmo_api_secret', old('nexmo_api_secret', Settings::get('nexmo_api_secret')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('nexmo_api_secret', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Twilio --}}
    <div v-if="sms_driver=='twilio'">
        <div class="form-group required {{ $errors->has('twilio_account_sid') ? 'has-error' : '' }}">
            {!! Form::label('twilio_account_sid', trans('settings.twilio_account_sid'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('twilio_account_sid', old('twilio_account_sid', Settings::get('twilio_account_sid')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('twilio_account_sid', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('twilio_auth_token') ? 'has-error' : '' }}">
            {!! Form::label('twilio_auth_token', trans('settings.twilio_auth_token'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('twilio_auth_token', old('twilio_auth_token', Settings::get('twilio_auth_token')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('twilio_auth_token', ':message') }}</span>
            </div>
        </div>
    </div>

    {{-- Zenvia --}}
    <div v-if="sms_driver=='zenvia'">
        <div class="form-group required {{ $errors->has('zenvia_account_key') ? 'has-error' : '' }}">
            {!! Form::label('zenvia_account_key', trans('settings.zenvia_account_key'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('zenvia_account_key', old('zenvia_account_key', Settings::get('zenvia_account_key')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('zenvia_account_key', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('zenvia_passcode') ? 'has-error' : '' }}">
            {!! Form::label('zenvia_passcode', trans('settings.zenvia_passcode'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('zenvia_passcode', old('zenvia_passcode', Settings::get('zenvia_passcode')), array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('zenvia_passcode', ':message') }}</span>
            </div>
        </div>
    </div>
    <div v-if="sms_driver!='none' && sms_driver!=''">
        <div class="form-group">
            {!! Form::label('automatic_sms_mark', trans('settings.automatic_sms_mark'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('automatic_sms_mark', '1',(Settings::get('automatic_sms_mark')=='1')?true:false)  !!}
                        {!! Form::label('1', trans('settings.yes'))  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('automatic_sms_mark', '0', (Settings::get('automatic_sms_mark')=='0')?true:false)  !!}
                        {!! Form::label('0', trans('settings.no')) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('automatic_sms_mark', trans('settings.automatic_sms_attendance'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('automatic_sms_attendance', '1',(Settings::get('automatic_sms_attendance')=='1')?true:false)  !!}
                        {!! Form::label('1', trans('settings.yes'))  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('automatic_sms_attendance', '0', (Settings::get('automatic_sms_attendance')=='0')?true:false)  !!}
                        {!! Form::label('0', trans('settings.no')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</sms-settings>