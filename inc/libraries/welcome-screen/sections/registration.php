<?php
/**
 * Template part for the registration tab in welcome screen
 *
 * @package Epsilon Framework
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div class="featured-section">
	<?php
	$strings = $this->strings;
	$license = trim( get_option( $this->theme_slug . '_license_key' ) );
	$status  = get_option( $this->theme_slug . '_license_key_status', false );

	// Checks license status to display under license key.
	if ( ! $license ) {
		$message = $strings['enter-key'];
	} else {
		if ( ! get_transient( $this->theme_slug . '_license_message', false ) ) {
			set_transient( $this->theme_slug . '_license_message', EDD_Theme_Helper::check_license(), ( 60 * 60 * 24 ) );
		}
		$message = get_transient( $this->theme_slug . '_license_message' );
	}

	$theme = wp_get_theme();
	if ( $theme->parent_theme ) {
		$template_dir = basename( get_template_directory() );
		$theme        = wp_get_theme( $template_dir );
	}
	$macho_version = $theme->get( 'Version' );

	?>

	<form method="post" action="options.php">
		<?php settings_fields( $this->theme_slug . '-license' ); ?>

		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th valign="top">
					<?php echo esc_html( $strings['license-key'] ); ?>
				</th>
				<td>
					<input id="<?php echo esc_attr( $this->theme_slug ); ?>_license_key" name="<?php echo esc_attr( $this->theme_slug ); ?>_license_key" class="regular-text" value="<?php echo esc_attr( $license ); ?>"/>
					<p class="description">
						<?php echo esc_html( $message ); ?>
					</p>
				</td>
			</tr>

			<?php if ( $license ) { ?>
				<tr valign="top">
					<th valign="top">
						<?php echo esc_html( $strings['license-action'] ); ?>
					</th>
					<td>
						<?php
						wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' );
						?>
						<input type="submit" class="button-secondary" name="<?php echo esc_attr( $this->theme_slug ); ?> <?php echo 'valid' === $status ? '_license_deactivate' : 'license_activate'; ?>" value="<?php echo 'valid' === $status ? esc_attr( $strings['deactivate-license'] ) : esc_attr( $strings['activate-license'] ); ?>"/>
					</td>
				</tr>
			<?php } ?>

			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
