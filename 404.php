<?php
/**
 *  The template for dispalying the archive.
 *
 *  @package WordPress
 *  @subpackage illdy
 */
?>
<?php get_header(); ?>
<?php


$page_subtitle     = get_theme_mod( 'illdy_404_subtitle', esc_html__( 'OOOPS!', 'illdy' ) );
$page_content      = get_theme_mod( 'illdy_404_content', esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet lorem ac orci dictum sodales et eget orci. Vestibulum a laoreet dolor. Sed finibus vulputate nisl, at pulvinar nisi commodo ac. Proin placerat auctor libero. Phasellus nec suscipit mi, sed faucibus purus.', 'illdy' ) );
$page_button_label = get_theme_mod( 'illdy_404_button_label', esc_html__( 'Home', 'illdy' ) );

?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<section id="blog">
				<div class="row row-404">
					<div class="col-md-2 text-right">
						<span class="error-code"><?php _e( '404', 'illdy' ); ?></span>
					</div>
					<div class="col-md-10">
						<h2 class="subheading-404"><?php echo wp_kses_post( $page_subtitle ); ?></h2>
						<div class="content-404"><?php echo wp_kses_post( $page_content ); ?></div>
						<a href="<?php echo site_url(); ?>" class="button button-404"><?php echo esc_html( $page_button_label ); ?></a>
					</div>
				</div>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>
