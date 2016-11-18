<?php
/**
 * Changelog
 */

$illdy = wp_get_theme( 'illdy' );

?>
<div class="illdy-tab-pane" id="changelog">

	<div class="illdy-tab-pane-center">
	
		<h1>Illdy <?php if( !empty($illdy['Version']) ): ?> <sup id="illdy-theme-version"><?php echo esc_attr( $illdy['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$illdy_changelog = $wp_filesystem->get_contents( get_template_directory().'/CHANGELOG.txt' );
	$illdy_changelog_lines = explode(PHP_EOL, $illdy_changelog);
	foreach($illdy_changelog_lines as $illdy_changelog_line){
		if(substr( $illdy_changelog_line, 0, 3 ) === "###"){
			echo '<hr /><h1>'.substr($illdy_changelog_line,3).'</h1>';
		} else {
			echo $illdy_changelog_line,'<br/>';
		}
	}

	?>
	
</div>