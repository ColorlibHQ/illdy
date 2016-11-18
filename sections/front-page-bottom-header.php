<?php
/**
 *    The template for displaying the bottom header section in front page.
 *
 * @package    WordPress
 * @subpackage illdy
 */
?>
<?php
if ( current_user_can( 'edit_theme_options' ) ) {
	$first_row_from_title  = get_theme_mod( 'illdy_jumbotron_general_first_row_from_title', __( 'Clean', 'illdy' ) );
	$second_row_from_title = get_theme_mod( 'illdy_jumbotron_general_second_row_from_title', __( 'Slick', 'illdy' ) );
	$third_row_from_title  = get_theme_mod( 'illdy_jumbotron_general_third_row_from_title', __( 'Pixel Perfect', 'illdy' ) );
	$entry                 = get_theme_mod( 'illdy_jumbotron_general_entry', __( 'lldy is a great one-page theme, perfect for developers and designers but also for someone who just wants a new website for his business. Try it now!', 'illdy' ) );
	$first_button_title    = get_theme_mod( 'illdy_jumbotron_general_first_button_title', __( 'Learn more', 'illdy' ) );
	$first_button_url      = get_theme_mod( 'illdy_jumbotron_general_first_button_url', esc_url( '#' ) );
	$second_button_title   = get_theme_mod( 'illdy_jumbotron_general_second_button_title', __( 'Download', 'illdy' ) );
	$second_button_url     = get_theme_mod( 'illdy_jumbotron_general_second_button_url', esc_url( '#' ) );
} else {
	$first_row_from_title  = get_theme_mod( 'illdy_jumbotron_general_first_row_from_title', get_the_title() );
	$second_row_from_title = get_theme_mod( 'illdy_jumbotron_general_second_row_from_title' );
	$third_row_from_title  = get_theme_mod( 'illdy_jumbotron_general_third_row_from_title' );
	$entry                 = get_theme_mod( 'illdy_jumbotron_general_entry' );
	$first_button_title    = get_theme_mod( 'illdy_jumbotron_general_first_button_title' );
	$first_button_url      = get_theme_mod( 'illdy_jumbotron_general_first_button_url' );
	$second_button_title   = get_theme_mod( 'illdy_jumbotron_general_second_button_title' );
	$second_button_url     = get_theme_mod( 'illdy_jumbotron_general_second_button_url' );
}

if ( $first_row_from_title || $second_row_from_title || $third_row_from_title || $entry || $first_button_title || $second_button_title ) {

	?>
	<div class="bottom-header front-page">
		<div class="container">
			<div class="row">
				<?php if ( $first_row_from_title || $second_row_from_title || $third_row_from_title ): ?>
					<div class="col-sm-12">
						<h2><?php if ( $first_row_from_title ) {
								echo '<span data-customizer="first-row-from-title">' . illdy_sanitize_html( $first_row_from_title ) . '</span><span class="span-dot first-span-dot">' . __( '.', 'illdy' ) . '</span>';
							} ?>
							<?php if ( $second_row_from_title ) {
								echo '<span data-customizer="second-row-from-title">' . illdy_sanitize_html( $second_row_from_title ) . '</span><span class="span-dot second-span-dot">' . __( '.', 'illdy' ) . '</span>';
							} ?>

							<?php if ( $third_row_from_title ) {
								echo '<span data-customizer="third-row-from-title">' . illdy_sanitize_html( $third_row_from_title ) . '</span>';
							} ?>
						</h2>
					</div><!--/.col-sm-12-->
				<?php endif; ?>
				<div class="col-sm-8 col-sm-offset-2">
					<?php if ( $entry ): ?>
						<p><?php echo illdy_sanitize_html( $entry ); ?></p>
					<?php endif; ?>
					<?php if ( $first_button_title ): ?>
						<a href="<?php echo esc_url( $first_button_url ); ?>" title="<?php echo esc_attr( $first_button_title ); ?>" class="header-button-one"><?php echo esc_html( $first_button_title ); ?></a>
					<?php endif; ?>
					<?php if ( $second_button_title ): ?>
						<a href="<?php echo esc_url( $second_button_url ); ?>" title="<?php echo esc_attr( $second_button_title ); ?>" class="header-button-two"><?php echo esc_html( $second_button_title ); ?></a>
					<?php endif; ?>
				</div><!--/.col-sm-8.col-sm-offset-2-->
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.bottom-header.front-page-->

<?php } ?>