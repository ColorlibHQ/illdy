jQuery(document).ready(function() {

	/* If there are required actions, add an icon with the number of required actions in the About illdy page -> Actions required tab */
    var illdy_nr_actions_required = illdyLiteWelcomeScreenObject.nr_actions_required;

    if ( (typeof illdy_nr_actions_required !== 'undefined') && (illdy_nr_actions_required != '0') ) {
        jQuery('li.illdy-w-red-tab a').append('<span class="illdy-actions-count">' + illdy_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".illdy-dismiss-required-action").click(function(){

        var id= jQuery(this).attr('id');
        console.log(id);
        jQuery.ajax({
            type       : "GET",
            data       : { action: 'illdy_lite_dismiss_required_action',dismiss_id : id },
            dataType   : "html",
            url        : illdyLiteWelcomeScreenObject.ajaxurl,
            beforeSend : function(data,settings){
				jQuery('.illdy-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + illdyLiteWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success    : function(data){
				jQuery("#temp_load").remove(); /* Remove loading gif */
                jQuery('#'+ data).parent().remove(); /* Remove required action box */

                var illdy_lite_actions_count = jQuery('.illdy-actions-count').text(); /* Decrease or remove the counter for required actions */
                if( typeof illdy_lite_actions_count !== 'undefined' ) {
                    if( illdy_lite_actions_count == '1' ) {
                        jQuery('.illdy-actions-count').remove();
                        jQuery('.illdy-tab-pane#actions_required').append('<p>' + illdyLiteWelcomeScreenObject.no_required_actions_text + '</p>');
                    }
                    else {
                        jQuery('.illdy-actions-count').text(parseInt(illdy_lite_actions_count) - 1);
                    }
                }
            },
            error     : function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

	/* Tabs in welcome page */
	function illdy_welcome_page_tabs(event) {
		jQuery(event).parent().addClass("active");
        jQuery(event).parent().siblings().removeClass("active");
        var tab = jQuery(event).attr("href");
        jQuery(".illdy-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
	}

	var illdy_actions_anchor = location.hash;

	if( (typeof illdy_actions_anchor !== 'undefined') && (illdy_actions_anchor != '') ) {
		illdy_welcome_page_tabs('a[href="'+ illdy_actions_anchor +'"]');
	}

    jQuery(".illdy-nav-tabs a").click(function(event) {
        event.preventDefault();
		illdy_welcome_page_tabs(this);
    });

		/* Tab Content height matches admin menu height for scrolling purpouses */
	 $tab = jQuery('.illdy-tab-content > div');
	 $admin_menu_height = jQuery('#adminmenu').height();
	 if( (typeof $tab !== 'undefined') && (typeof $admin_menu_height !== 'undefined') )
	 {
		 $newheight = $admin_menu_height - 180;
		 $tab.css('min-height',$newheight);
	 }

});
