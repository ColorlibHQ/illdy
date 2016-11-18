jQuery(document).ready(function() {
    var illdy_aboutpage = illdyLiteWelcomeScreenCustomizerObject.aboutpage;
    var illdy_nr_actions_required = illdyLiteWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof illdy_aboutpage !== 'undefined') && (typeof illdy_nr_actions_required !== 'undefined') && (illdy_nr_actions_required != '0') && _wpCustomizeSettings.theme.active && _wpCustomizeSettings.theme.stylesheet == 'illdy' ) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + illdy_aboutpage + '"><span class="illdy-actions-count">' + illdy_nr_actions_required + '</span></a>');
    }

});
