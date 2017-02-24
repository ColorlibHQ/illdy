pagenow = 'plugin-install'
jQuery(document).on( 'wp-plugin-update-success', function( evt, response ){
	location.reload();
});

jQuery(document).ready(function () {

	/* If there are required actions, add an icon with the number of required actions in the About illdy page -> Actions required tab */
	var illdy_nr_actions_required = illdyWelcomeScreenObject.nr_actions_required;

	if ( (typeof illdy_nr_actions_required !== 'undefined') && (illdy_nr_actions_required != '0') ) {
		jQuery('li.illdy-w-red-tab a').append('<span class="illdy-actions-count">' + illdy_nr_actions_required + '</span>');
	}

	/* Dismiss required actions */
	jQuery(".illdy-required-action-button").click(function () {

		var id = jQuery(this).attr('id'),
				action = jQuery(this).attr('data-action');
		jQuery.ajax({
			type      : "GET",
			data      : { action: 'illdy_dismiss_required_action', id: id, todo: action },
			dataType  : "html",
			url       : illdyWelcomeScreenObject.ajaxurl,
			beforeSend: function (data, settings) {
				jQuery('.illdy-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + illdyWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
			},
			success   : function (data) {
				location.reload();
				jQuery("#temp_load").remove();
				/* Remove loading gif */
			},
			error     : function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
			}
		});
	});

	/* Dismiss recommended plugins */
    jQuery(".illdy-recommended-plugin-button").click(function () {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type      : "GET",
            data      : { action: 'illdy_dismiss_recommended_plugins', id: id, todo: action },
            dataType  : "html",
            url       : illdyWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.illdy-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + illdyWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success   : function (data) {
                location.reload();
                jQuery("#temp_load").remove();
                /* Remove loading gif */
            },
            error     : function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    

});
