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
}

function runSelect2() {
    $('.select2').select2();
}