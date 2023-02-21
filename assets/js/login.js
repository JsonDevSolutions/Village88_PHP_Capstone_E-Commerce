$(document).ready(function () {
	$("input[type=text], input[type=password]").focus(function () {
		$(this).parent().css("border-bottom", "2px solid white");
	});
	$("input[type=text], input[type=password").focusout(function () {
		$(this).parent().css("border-bottom", "2px solid rgb(24, 24, 24)");
	});
    $('#show_password').change(function() {
        if ($(this).prop('checked')) {
            $("#billing").attr('type', 'text');
        } else {
            // $("#password").attr('type', 'password');
        }
    });
});
