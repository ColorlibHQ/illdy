<?php
/**
 * Actions required
 */

wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">

	<?php
	global $illdy_required_actions;

	if ( ! empty( $illdy_required_actions ) ):

		/* illdy_show_required_actions is an array of true/false for each required action that was dismissed */
		$illdy_show_required_actions = get_option( "illdy_show_required_actions" );
		$hooray = true;

		foreach ( $illdy_required_actions as $illdy_required_action_key => $illdy_required_action_value ):
			$hidden = false;
			if ( @$illdy_show_required_actions[ $illdy_required_action_value['id'] ] === false ) {
				$hidden = true;
			}
			if ( @$illdy_required_action_value['check'] ) {
				continue;
			}
			?>
			<div class="illdy-action-required-box">
				<?php if ( ! $hidden ): ?>
					<span data-action="dismiss" class="dashicons dashicons-visibility illdy-required-action-button"
					      id="<?php echo $illdy_required_action_value['id']; ?>"></span>
				<?php else: ?>
					<span data-action="add" class="dashicons dashicons-hidden illdy-required-action-button" id="<?php echo $illdy_required_action_value['id']; ?>"></span>
				<?php endif; ?>
				<h3><?php if ( ! empty( $illdy_required_action_value['title'] ) ): echo $illdy_required_action_value['title']; endif; ?></h3>
				<p>
					<?php if ( ! empty( $illdy_required_action_value['description'] ) ): echo $illdy_required_action_value['description']; endif; ?>
					<?php if ( ! empty( $illdy_required_action_value['help'] ) ): echo '<br/>' . $illdy_required_action_value['help']; endif; ?>
				</p>
				<?php
				if ( ! empty( $illdy_required_action_value['plugin_slug'] ) ) {
					$active = $this->check_active( $illdy_required_action_value['plugin_slug'] );
					$url    = $this->create_action_link( $active['needs'], $illdy_required_action_value['plugin_slug'] );
					$label  = '';

					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = __( 'Install', 'illdy' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = __( 'Activate', 'illdy' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = __( 'Deactivate', 'illdy' );
							break;
					}

					?>
					<p class="plugin-card-<?php echo esc_attr( $illdy_required_action_value['plugin_slug'] ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
						<a data-slug="<?php echo esc_attr( $illdy_required_action_value['plugin_slug'] ) ?>"
						   class="<?php echo $class; ?>"
						   href="<?php echo esc_url( $url ) ?>"> <?php echo $label ?> </a>
					</p>
					<?php
				};
				?>
			</div>
			<?php
			$hooray = false;
		endforeach;
	endif;

	if ( $hooray ):
		echo '<span class="hooray">' . __( 'Hooray! There are no required actions for you right now.', 'illdy' ) . '</span>';
	endif;
	?>

</div>
