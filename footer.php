<?php
/**
 *	The template for dispalying the footer.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
$display_copyright = get_theme_mod( 'illdy_general_footer_display_copyright', 1 );
$footer_copyright = get_theme_mod( 'illdy_footer_copyright', esc_html__( '&copy; Copyright 2016. All Rights Reserved.', 'illdy' ) );
$img_footer_logo = get_theme_mod( 'illdy_img_footer_logo', esc_url( get_template_directory_uri() . '/layout/images/footer-logo.png' ) );
?>
		<footer id="footer">
			<div class="container">
				<div class="row">
					<?php
					$the_widget_args = array(
						'before_widget'	=> '<div class="widget">',
						'after_widget'	=> '</div>',
						'before_title'	=> '<div class="widget-title"><h3>',
						'after_title'	=> '</h3></div>'
					);
					?>
					<div class="col-sm-3">
						<?php
						if( is_active_sidebar( 'footer-sidebar-1' ) ):
							dynamic_sidebar( 'footer-sidebar-1' );
						else:
							the_widget( 'WP_Widget_Text', 'title='. __( 'Products', 'illdy' ) .'&text=<ul><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Our work', 'illdy' ) .'">'. __( 'Our work', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Club', 'illdy' ) .'">'. __( 'Club', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'News', 'illdy' ) .'">'. __( 'News', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Announcement', 'illdy' ) .'">'. __( 'Announcement', 'illdy' ) .'</a></li></ul>', $the_widget_args );
						endif;
						?>
					</div><!--/.col-sm-3-->
					<div class="col-sm-3">
						<?php
						if( is_active_sidebar( 'footer-sidebar-2' ) ):
							dynamic_sidebar( 'footer-sidebar-2' );
						else:
							the_widget( 'WP_Widget_Text', 'title='. __( 'Information', 'illdy' ) .'&text=<ul><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Pricing', 'illdy' ) .'">'. __( 'Pricing', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Terms', 'illdy' ) .'">'. __( 'Terms', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Affiliates', 'illdy' ) .'">'. __( 'Affiliates', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Blog', 'illdy' ) .'">'. __( 'Blog', 'illdy' ) .'</a></li></ul>', $the_widget_args );
						endif;
						?>
					</div><!--/.col-sm-3-->
					<div class="col-sm-3">
						<?php
						if( is_active_sidebar( 'footer-sidebar-3' ) ):
							dynamic_sidebar( 'footer-sidebar-3' );
						else:
							the_widget( 'WP_Widget_Text', 'title='. __( 'Support', 'illdy' ) .'&text=<ul><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Documentation', 'illdy' ) .'">'. __( 'Documentation', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'FAQs', 'illdy' ) .'">'. __( 'FAQs', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Forums', 'illdy' ) .'">'. __( 'Forums', 'illdy' ) .'</a></li><li><a href="'. esc_url( '#' ) .'" title="'. __( 'Contact', 'illdy' ) .'">'. __( 'Contact', 'illdy' ) .'</a></li></ul>', $the_widget_args );
						endif;
						?>
					</div><!--/.col-sm-3-->
					<div class="col-sm-3">
						<?php if( $img_footer_logo ): ?>
							<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="footer-logo"><img src="<?php echo esc_url( $img_footer_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
						<?php endif; ?>
						<?php if( $display_copyright == 1 ): ?>
							<p class="copyright"><span data-customizer="copyright-credit"><?php printf( '%s <a href="%s" title="%s" target="_blank">%s</a>.', __( 'Theme:', 'illdy' ), esc_url( home_url('/') ), __( 'Illdy', 'illdy' ), __( 'Illdy', 'illdy' ) ); ?></span> <?php echo esc_html( $footer_copyright ); ?></p>
						<?php else: ?>
							<p class="copyright"><?php echo esc_html( $footer_copyright ); ?></p>
						<?php endif; ?>
					</div><!--/.col-sm-3-->
				</div><!--/.row-->
			</div><!--/.container-->
		</footer><!--/#footer-->
		<?php wp_footer(); ?>
	</body>
</html>