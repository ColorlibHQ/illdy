<?php
/**
 *    The template for dispalying the footer.
 *
 * @package    WordPress
 * @subpackage illdy
 */
?>
<?php

$show_footer           = get_theme_mod( 'illdy_show_footer', 1 );
$show_footer_copyright = get_theme_mod( 'illdy_show_footer_copyright', 1 );

if ( current_user_can( 'edit_theme_options' ) ) {
	$footer_copyright = get_theme_mod( 'illdy_footer_copyright', sprintf( __( '&copy; Copyright %s. All Rights Reserved.', 'illdy' ), date( 'Y' ) ) );
} else {
	$footer_copyright = get_theme_mod( 'illdy_footer_copyright' );
}
?>
<?php if ( 1 == $show_footer ) { ?>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<?php
				$the_widget_args = array(
					'before_widget' => '<div class="widget">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="widget-title"><h5>',
					'after_title'   => '</h5></div>',
				);
				?>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
					if ( is_active_sidebar( 'footer-sidebar-1' ) ) :
						dynamic_sidebar( 'footer-sidebar-1' );
					elseif ( current_user_can( 'edit_theme_options' ) ) :
						the_widget( 'WP_Widget_Text', 'title=' . __( 'Products', 'illdy' ) . '&text=<ul><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Our work', 'illdy' ) . '">' . __( 'Our work', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Club', 'illdy' ) . '">' . __( 'Club', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'News', 'illdy' ) . '">' . __( 'News', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Announcement', 'illdy' ) . '">' . __( 'Announcement', 'illdy' ) . '</a></li></ul>', $the_widget_args );
					endif;
					?>
				</div><!--/.col-sm-3-->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
					if ( is_active_sidebar( 'footer-sidebar-2' ) ) :
						dynamic_sidebar( 'footer-sidebar-2' );
					elseif ( current_user_can( 'edit_theme_options' ) ) :
						the_widget( 'WP_Widget_Text', 'title=' . __( 'Information', 'illdy' ) . '&text=<ul><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Pricing', 'illdy' ) . '">' . __( 'Pricing', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Terms', 'illdy' ) . '">' . __( 'Terms', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Affiliates', 'illdy' ) . '">' . __( 'Affiliates', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Blog', 'illdy' ) . '">' . __( 'Blog', 'illdy' ) . '</a></li></ul>', $the_widget_args );
					endif;
					?>
				</div><!--/.col-sm-3-->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
					if ( is_active_sidebar( 'footer-sidebar-3' ) ) :
						dynamic_sidebar( 'footer-sidebar-3' );
					elseif ( current_user_can( 'edit_theme_options' ) ) :
						the_widget( 'WP_Widget_Text', 'title=' . __( 'Support', 'illdy' ) . '&text=<ul><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Documentation', 'illdy' ) . '">' . __( 'Documentation', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'FAQs', 'illdy' ) . '">' . __( 'FAQs', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Forums', 'illdy' ) . '">' . __( 'Forums', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Contact', 'illdy' ) . '">' . __( 'Contact', 'illdy' ) . '</a></li></ul>', $the_widget_args );
					endif;
					?>
				</div><!--/.col-sm-3-->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
					if ( is_active_sidebar( 'footer-sidebar-4' ) ) :
						dynamic_sidebar( 'footer-sidebar-4' );
					elseif ( current_user_can( 'edit_theme_options' ) ) :
						the_widget( 'WP_Widget_Text', 'title=' . __( 'Support', 'illdy' ) . '&text=<ul><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Documentation', 'illdy' ) . '">' . __( 'Documentation', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'FAQs', 'illdy' ) . '">' . __( 'FAQs', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Forums', 'illdy' ) . '">' . __( 'Forums', 'illdy' ) . '</a></li><li><a href="' . esc_url( '#' ) . '" title="' . __( 'Contact', 'illdy' ) . '">' . __( 'Contact', 'illdy' ) . '</a></li></ul>', $the_widget_args );
					endif;
					?>
				</div><!--/.col-sm-3-->
			</div><!--/.row-->
		</div><!--/.container-->
	</footer>
<?php } ?>

<?php if ( 1 == $show_footer_copyright ) { ?>
	<div class="bottom-footer">
		<div class="container">
			<p class="copyright">
				<span><?php printf( '%s <a href="%s" title="%s" target="_blank">%s</a>.', __( 'Theme:', 'illdy' ), esc_url( 'http://colorlib.com/wp/themes/illdy' ), __( 'Illdy', 'illdy' ), __( 'Illdy', 'illdy' ) ); ?></span>
				<span class="bottom-copyright" data-customizer="copyright-credit"><?php echo illdy_sanitize_html( $footer_copyright ); ?></span>
			</p>
		</div>
	</div>
<?php } ?>

<?php if ( 'page' == get_option( 'show_on_front' ) && is_front_page() && get_theme_mod( 'illdy_go_to_top', false ) ) : ?>
	<a href="#" class="illdy-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<?php endif ?>

<?php wp_footer(); ?>
</body></html>
