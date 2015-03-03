var Nav = {

    get : function (url, container, back, fix) {

        if (!container)
            container = 'content';

        jQuery.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            cache: true,
            success : function(code_html, statut){
                if (container == 'content') {
                    if (!back)
                        window.history.pushState(document.title, code_html.title, code_html.url);
                    else
                        window.history.replaceState(document.title, code_html.title, code_html.url);
                }
                if (!fix ) {
                    Nav.backTopTop();
                }
                jQuery('#'+container).html(code_html.content);
            },

            error : function(resultat, statut, erreur){
                window.history.pushState(document.title,document.title, document.URL);
                window.location.href = url;
            },

            complete : function(resultat, statut) {
                Nav.restartEvent('#'+container);
            }
        });

        return false;
    },

    post : function (form, container, fix) {

        if (!container)
            container = 'content';

        var url = jQuery(form).attr('action');
        if (!url)
            url = window.location.pathname;//document.URL;

        if (typeof CKEDITOR != 'undefined')
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            cache: true,
            data: form.serialize(),
            success : function(code_html, statut){
                jQuery('#'+container).html(code_html.content);
                if (container == 'content') {
                    if (code_html.url != url)
                        window.history.pushState(document.title, code_html.title, code_html.url);
                }
                if (!fix ) {
                    Nav.backTopTop();
                }
            },

            error : function(resultat, statut, erreur){
                jQuery(form).addClass('speednav_error');
                jQuery(form).submit();
            },

            complete : function(resultat, statut) {
                Nav.restartEvent('#'+container);
            }
        });

        return false;
    },

    include : function (url, container) {

        var title = document.title;

        if (!container)
            container = 'content';

        jQuery.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            cache: true,
            success : function(code_html, statut){
                jQuery('#'+container).html(code_html.content);
            },

            error : function(resultat, statut, erreur){
                jQuery('#'+container).html('Error');
            },

            complete : function(resultat, statut) {
                document.title = title;
                Nav.restartEvent('#'+container);
            }
        });

        return false;
    },

    restartEvent: function(container) {
        jQuery('body').trigger("NavLoad");
        jQuery(container).find('a.speednav').click(function() {
            var container = null;
            var fix = false;
            if (jQuery(this).attr('data-type')) {
                if (jQuery('#'+jQuery(this).attr('data-type')) != 'undefined')
                    container = jQuery(this).attr('data-type');
            }
            if (jQuery(this).hasClass('speednav_fix'))
                fix = true;

            Nav.get(jQuery(this).attr('href'), container, null,  fix);

            return false;
        });
        jQuery(container).find('form.speednav').submit(function() {
            if (jQuery(this).hasClass('speednav_error'))
                return true;
            else {
                var container = null;
                var fix = false;
                if (jQuery(this).attr('data-type')) {
                    if (jQuery('#'+jQuery(this).attr('data-type')) != 'undefined')
                        container = jQuery(this).attr('data-type');
                }
                if (jQuery(this).hasClass('speednav_fix'))
                    fix = true;

                Nav.post(jQuery(this), container, fix);

                return false;
            }
        });
    },

    backTopTop: function() {
        jQuery("html, body").animate({ scrollTop: 0 }, 350);
    }
};

jQuery(window).on('popstate', function() {
    Nav.get(window.location.href, null, true);
});
Nav.restartEvent('body');