<?php
/**
 * Changelog
 */

$illdy = wp_get_theme( 'illdy' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$illdy_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$illdy_changelog_lines = explode( PHP_EOL, $illdy_changelog );
	foreach ( $illdy_changelog_lines as $illdy_changelog_line ) {
		if ( substr( $illdy_changelog_line, 0, 3 ) === "###" ) {
			echo '<h4>' . substr( $illdy_changelog_line, 3 ) . '</h4>';
		} else {
			echo $illdy_changelog_line, '<br/>';
		}


	}

	echo '<hr />';


	?>

</div>