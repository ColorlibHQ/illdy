<?php
/**
 * Template part for the recommended plugins tab in welcome screen
 *
 * @package Epsilon Framework
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
add_thickbox();
?>

<div class="feature-section recommended-plugins three-col demo-import-boxed" id="plugin-filter">
	<?php
	foreach ( $this->plugins as $plugin => $rec ) {
		$info      = $this->get_plugin_information( $plugin );
		$icon      = $info['icon'];
		$active    = $info['active'];
		$installed = $info['installed'];

		if ( $active ) {
			continue;
		}
		
		// Set a default title if not provided in the plugin config
		$plugin_title = isset($rec['title']) ? $rec['title'] : (is_wp_error($info['info']) ? $plugin : $info['info']->name);
		
		// Format author with clickable link
		$author_html = is_wp_error($info['info']) ? 'N/A' : $info['info']->author;
		?>
		<div class="col plugin_box <?php echo esc_attr( $plugin ); ?>">
			<!-- Plugin Icon -->
			<img src="<?php echo esc_url( $icon ); ?>" alt="plugin box image">
			
			<!-- Version and Author on same line -->
			<div class="version-author-wrapper">
				<span class="version"><?php echo esc_html__( 'Version:', 'epsilon-framework' ); ?> <?php echo is_wp_error($info['info']) ? 'N/A' : esc_html( $info['info']->version ); ?></span>
				<span class="separator">|</span> 
				<span class="author-container"><?php echo wp_kses_post( $author_html ); ?></span>
			</div>
			
			<!-- Plugin Title -->
			<div class="action_bar">
				<span class="plugin_name"><?php echo esc_html( $plugin_title ); ?></span>
			</div>
			
			<!-- Install Button -->
			<span class="plugin-card-<?php echo esc_attr( $plugin ); ?> action_button <?php echo ( ! $installed ) ? 'active' : ''; ?>">
				<a data-slug="<?php echo esc_attr( $plugin ); ?>" class="<?php echo esc_attr( $info['class'] ); ?>" href="<?php echo esc_url( $info['url'] ); ?>">
					<?php echo esc_html( $info['label'] ); ?>
				</a>
			</span>
		</div>
	<?php } ?>
</div>
