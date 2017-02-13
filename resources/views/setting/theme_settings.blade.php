<div class="form-group">
    {!! Form::label('theme_name', trans('settings.theme_name'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::select('theme_name', $themes, null, array('id'=>'theme_name', 'class' => 'form-control select2')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('menu_bg_color', trans('settings.menu_bg_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('menu_bg_color', old('menu_bg_color', Settings::get('menu_bg_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('menu_active_bg_color', trans('settings.menu_active_bg_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('menu_active_bg_color', old('menu_active_bg_color', Settings::get('menu_active_bg_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('menu_active_border_right_color', trans('settings.menu_active_border_right_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('menu_active_border_right_color', old('menu_active_border_right_color', Settings::get('menu_active_border_right_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('menu_color', trans('settings.menu_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('menu_color', old('menu_color', Settings::get('menu_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('menu_active_color', trans('settings.menu_active_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('menu_active_color', old('menu_active_color', Settings::get('menu_active_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('frontend_menu_bg_color', trans('settings.frontend_menu_bg_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('frontend_menu_bg_color', old('frontend_menu_bg_color', Settings::get('frontend_menu_bg_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('frontend_bg_color', trans('settings.frontend_bg_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('frontend_bg_color', old('frontend_bg_color', Settings::get('frontend_bg_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('frontend_text_color', trans('settings.frontend_text_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('frontend_text_color', old('frontend_text_color', Settings::get('frontend_text_color')), array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('frontend_link_color', trans('settings.frontend_link_color'), array('class' => 'control-label')) !!}
    <div class="controls">
        {!! Form::text('frontend_link_color', old('frontend_link_color', Settings::get('frontend_link_color')), array('class' => 'form-control')) !!}
    </div>
</div>
@section('scripts')
    <script>
        $( document ).ready(function() {

            $('#menu_bg_color').colorpicker();
            $('#menu_active_bg_color').colorpicker();
            $('#menu_active_border_right_color').colorpicker();
            $('#menu_color').colorpicker();
            $('#menu_active_color').colorpicker();
            $('#frontend_bg_color').colorpicker();
            $('#frontend_text_color').colorpicker();
            $('#frontend_link_color').colorpicker();
            $('#frontend_menu_bg_color').colorpicker();

            $('#theme_name').change(function () {
                $('#menu_bg_color').val("");
                $('#menu_active_bg_color').val("");
                $('#menu_active_border_right_color').val("");
                $('#menu_color').val("");
                $('#menu_active_color').val("");
                $('#frontend_bg_color').val("");
                $('#frontend_text_color').val("");
                $('#frontend_link_color').val("");
                $('#frontend_menu_bg_color').val("");
                if ($(this).val() != "") {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('/setting/get_theme_colors') }}/' + $(this).val(),
                        success: function (result) {
                            $('#menu_bg_color').val(result.menu_bg_color);
                            $('#menu_active_bg_color').val(result.menu_active_bg_color);
                            $('#menu_active_border_right_color').val(result.menu_active_border_right_color);
                            $('#menu_color').val(result.menu_color);
                            $('#menu_active_color').val(result.menu_active_color);
                            $('#frontend_bg_color').val(result.frontend_bg_color);
                            $('#frontend_text_color').val(result.frontend_text_color);
                            $('#frontend_link_color').val(result.frontend_link_color);
                            $('#frontend_menu_bg_color').val(result.frontend_menu_bg_color);
                        }
                    });
                }
            });
        });
    </script>
@endsection