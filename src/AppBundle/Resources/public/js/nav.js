var Nav = {

    get : function (url, container, back) {

        if (!container)
            container = 'content';

        jQuery.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            cache: true,
            success : function(code_html, statut){
                if (!back)
                    window.history.pushState(document.title,code_html.title, code_html.url);
                else
                    window.history.replaceState(document.title,code_html.title, code_html.url);
                jQuery('#'+container).html(code_html.content);
            },

            error : function(resultat, statut, erreur){
                window.history.pushState(document.title,document.title, document.URL);
                window.location.href = url;
            },

            complete : function(resultat, statut) {
                jQuery('body').trigger("NavLoad")
                jQuery('#'+container).find('a.speednav').click(function() {
                    Nav.get(jQuery(this).attr('href'));
                    return false;
                });
                jQuery('#'+container).find('form.speednav').submit(function() {
                    if (jQuery(this).hasClass('speednav_error'))
                        return true;
                    else {
                        Nav.post(jQuery(this));
                        return false;
                    }
                });
            }
        });

        return false;
    },

    post : function (form, container) {

        if (!container)
            container = 'content';

        var url = jQuery(form).attr('action');
        if (!url)
            url = document.URL;

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            cache: true,
            data: form.serialize(),
            success : function(code_html, statut){
                jQuery('#'+container).html(code_html.content);
            },

            error : function(resultat, statut, erreur){
                jQuery(form).addClass('speednav_error');
                jQuery(form).submit();
                //window.location.href = url;
            },

            complete : function(resultat, statut) {
                jQuery('body').trigger("NavLoad")
                jQuery('#'+container).find('a.speednav').click(function() {
                    Nav.get(jQuery(this).attr('href'));
                    return false;
                });
                jQuery('#'+container).find('form.speednav').submit(function() {
                    if (jQuery(this).hasClass('speednav_error'))
                        return true;
                    else {
                        Nav.post(jQuery(this));
                        return false;
                    }
                });
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
                jQuery('body').trigger("NavLoad")
                jQuery('#'+container).find('a.speednav').click(function() {
                    Nav.get(jQuery(this).attr('href'));
                    return false;
                });
                jQuery('#'+container).find('form.speednav').submit(function() {
                    Nav.post(jQuery(this));
                    return false;
                });
            }
        });

        return false;
    }
};

jQuery(window).on('popstate', function() {
    Nav.get(window.location.href, null, true);
});

jQuery('a.speednav').click(function() {
    Nav.get(jQuery(this).attr('href'));
    return false;
});

jQuery('form.speednav').submit(function() {
    if (jQuery(this).hasClass('speednav_error'))
        return true;
    else {
        Nav.post(jQuery(this));
        return false;
    }
});