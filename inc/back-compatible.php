<?php

$theme = wp_get_theme();
if( version_compare( $theme->version, '1.0.17', '>' ) ) {

	$current_logo = get_theme_mod( 'illdy_img_logo', '' );
	$logo = get_custom_logo();
	if ( $current_logo != '' && !$logo ) {
		$logoID = attachment_url_to_postid($current_logo);
		if ( $logoID ) {
			set_theme_mod( 'custom_logo', $logoID );
			remove_theme_mod( 'illdy_img_logo' );
		}
	}

}