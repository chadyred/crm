function notify($message, $type, $persistant) {

    var random = Math.floor(Math.random() * 9999)

    $('#alert_message').append('<div id="alert_message_'+random+'" class="notify alert alert_'+$type+'">'+$message+'</div>');
    if (!$persistant) {
        $('#alert_message_'+random).delay('3500').fadeOut(1500, function() {
            $(this).remove();
        });
    }
}

function dateTimePicker() {
    $('.datetimepicker').datetimepicker({
        inline:true,
        //value: $(this).val(),
        //mask:'31-12-9999 24:59',
        format:'d-m-Y H:i',
        dayOfWeekStart : 1,
        lang:'fr',
        step:5
    });
    $('.datepicker').datetimepicker({
        inline:true,
        //value: '01-01-1980',
        //mask:'31-12-9999 24:59',
        format:'d-m-Y',
        dayOfWeekStart : 1,
        lang:'fr',
        step:5,
        timepicker:false
    });
}

function runSelect2() {
    $('.select2').select2();
}

$('.nav_collapsible > .nav_link').click(function () {
    $(this).parent().toggleClass('nav_open');
    if ($(this).parent().siblings().hasClass('nav_open')) {
        $(this).parent().siblings().removeClass('nav_open');
    }
    return false;
});
