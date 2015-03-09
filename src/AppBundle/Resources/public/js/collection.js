function collectionStart($container, $add) {

    var container = $('#'+$container);

    if (!container.hasClass('collection_init')) {
        container.addClass('collection_init');

        container.before('<a class="link_collection link_collection_add" href="javascript:collectionAdd(\''+$container+'\', true);"><span>'+(container.attr('data-text_link_add'))+'</span></a>');

        var index = container.children().length;

        var y = 0;
        container.children().each(function() {
            if (y >= parseInt(container.attr('data-min')) && container.attr('data-text_link_suppr'))
                $(this).append('<a class="link_collection link_collection_suppr" id="link_suppr_'+$container+'_'+y+'" href="javascript:collectionRemove(\'link_suppr_'+$container+'_'+y+'\');" title="Supprimer"><span>'+container.attr('data-text_link_suppr')+'</span></a><br class="clear"/>');
            y++;
        });

        if (parseInt(container.attr('data-min')) > 0 && container.attr('data-auto_add') == 'true' && $add) {
            for (var $i = 0; $i < container.attr('data-min') - index; $i++) {
                collectionAdd($container, false);
            }
        }

        if (container.attr('data-auto_add') == 'true' && parseInt(container.attr('data-min')) == 0 && index == 0 && $add)
            collectionAdd($container, false);

        if (index + 1 > parseInt(container.attr('data-max')) && parseInt(container.attr('data-max')) != 0) {
            var link_add = container.parent().children('.link_collection_add');
            link_add.hide();
        }
    }
}

function collectionAdd($container, $effet) {

    var container = $('#'+$container);

    if (container.length){

        var index = container.children().length;

        var i = 0;
        while ($('#'+$container+'_'+i).length){
            i = i + 1;
        }

        if (index < parseInt(container.attr('data-max')) || parseInt(container.attr('data-max')) == 0) {
            var regex_prototype = new RegExp(container.attr('data-prototype_name'),"g");
            var prototype = container.attr('data-prototype').replace(container.attr('data-prototype_name')+'label__', container.attr('data-title')).replace(regex_prototype, i);
            container.append(prototype).find('#'+$container+'_'+i).hide();

            if ($effet)
                container.find('#'+$container+'_'+i).slideDown(250);
            else
                container.find('#'+$container+'_'+i).show();

            $('#'+$container+' > div > label > span.required').remove();

            if (! container.attr('data-title'))
                $('#'+$container+' > div > label').html('');
            else
                $('#'+$container+' > div > label').addClass('form_collection_title');

            if (index >= parseInt(container.attr('data-min'))) {
                container.children('.form_row').last().append('<a class="link_collection link_collection_suppr hidden" id="link_suppr_'+$container+'_'+i+'" href="javascript:collectionRemove(\'link_suppr_'+$container+'_'+i+'\');" title="Supprimer"><span>'+container.attr('data-text_link_suppr')+'</span></a><br class="clear"/>');

                if ($effet)
                    container.children('.form_row').last().children('.link_collection_suppr').delay(255).fadeIn(250);
                else
                    container.children('.form_row').last().children('.link_collection_suppr').removeClass('hidden');
            }

            container.find('.form_collection').each(function() {
                collectionStart($(this).attr('id'), true);
            });


        }

        if (index + 1 >= parseInt(container.attr('data-max')) && parseInt(container.attr('data-max')) != 0) {
            var link_add = container.parent().children('.link_collection_add');
            if ($effet)
                link_add.fadeOut(250);
            else
                link_add.hide();
        }

        dateTimePicker();
        runSelect2();
    }
}

function collectionRemove($link) {

    var index = $('#'+$link).parent().parent().children().length;
    if (index - 1 <= parseInt($('#'+$link).parent().parent().attr('data-max'))) {
        $('#'+$link).parent().parent().parent().children('.link_collection_add').fadeIn(250);
    }

    $('#'+$link).parent().parent().css('height', $('#'+$link).parent().parent().height+'px');
    $('#'+$link).parent().animate({ opacity: 0 }, 100, function () {
        $('#'+$link).parent().slideUp(250, function () {
            $('#'+$link).parent().remove();
        });
    });
}
