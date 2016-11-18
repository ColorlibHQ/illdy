<?php
/**
 * Getting started template
 */

$customizer_url = wp_customize_url() ;
?>

<div id="getting_started" class="illdy-tab-pane active">

	<div class="illdy-tab-pane-center">

		<h1 class="illdy-welcome-title"><?php _e('Welcome to Illdy!', 'illdy'); ?> <?php if( !empty($illdy_lite['Version']) ): ?> <sup id="illdy-theme-version"><?php echo esc_attr( $illdy_lite['Version'] ); ?> </sup><?php endif; ?></h1>

		<p><?php esc_html_e( 'Our most popular free one page WordPress theme, Illdy!','illdy'); ?></p>
		<p><?php esc_html_e( 'We want to make sure you have the best experience using Illdy and that is why we gathered here all the necessary information for you. We hope you will enjoy using Illdy, as much as we enjoy creating great products.', 'illdy' ); ?>

	</div>

	<hr />

	<div class="illdy-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'illdy' ); ?></h1>

		<h4><?php esc_html_e( 'Customize everything in a single place.' ,'illdy' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'illdy' ); ?></p>
		<p><a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'illdy' ); ?></a></p>

	</div>

	<hr />

</div>
