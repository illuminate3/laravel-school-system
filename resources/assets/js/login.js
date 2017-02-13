(function($) {
    $('#login-box').fadeIn(2000);
    $('#forgot').on('click', function(e) {
        e.preventDefault();
        $('#login-box').fadeOut(1000);
        $('#forgot-box').delay(1005).fadeIn(2000);
    });
    $('#login').on('click', function(e) {
        onClick = "clickedButton()";
        e.preventDefault();
        $('#forgot-box').fadeOut(1000);
        $('#login-box').delay(1005).fadeIn(2000);
    });
})(jQuery);
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_minimal',
    radioClass: 'iradio_minimal',
    increaseArea: '20%' // optional
  });
});
