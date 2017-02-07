<?php
/**
 *	The template for displaying about section in front page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
if ( current_user_can( 'edit_theme_options' ) ) {
	$general_title = get_theme_mod( 'illdy_about_general_title', __( 'About', 'illdy' ) );
	$general_entry = get_theme_mod( 'illdy_about_general_entry', __( 'It is an amazng one-page theme with great features that offers an incredible experience. It is easy to install, make changes, adapt for your business. A modern design with clean lines and styling for a wide variety of content, exactly how a business design should be. You can add as many images as you want to the main header area and turn them into slider.', 'illdy' ) );
}else{
	$general_title = get_theme_mod( 'illdy_about_general_title' );
	$general_entry = get_theme_mod( 'illdy_about_general_entry' );
}
?>

<?php if ( $general_title != '' || $general_entry != '' || is_active_sidebar( 'front-page-about-sidebar' ) ) { ?>

<section id="about" class="front-page-section" style="<?php if( !$general_title && !$general_entry ): echo 'padding-top: 130px;'; endif; ?>">
	<?php if( $general_title || $general_entry ): ?>
		<div class="section-header">
			<div class="container">
				<div class="row">
					<?php if( $general_title ): ?>
						<div class="col-sm-12">
							<h3><?php echo do_shortcode(wp_kses_post( $general_title )); ?></h3>
						</div><!--/.col-sm-12-->
					<?php endif; ?>
					<?php if( $general_entry ): ?>
						<div class="col-sm-10 col-sm-offset-1">
							<div class="section-description"><?php echo do_shortcode(wp_kses_post( $general_entry )); ?></div>
						</div><!--/.col-sm-10.col-sm-offset-1-->
					<?php endif; ?>
				</div><!--/.row-->
			</div><!--/.container-->
		</div><!--/.section-header-->
	<?php endif; ?>
	<div class="section-content">
		<div class="container">
			<div class="row">
				<?php
				if( is_active_sidebar( 'front-page-about-sidebar' ) ):
					dynamic_sidebar( 'front-page-about-sidebar' );
				elseif( current_user_can( 'edit_theme_options' ) & defined("ILLDY_COMPANION") ):
					$the_widget_args = array(
						'before_widget'	=> '<div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-0 widget_illdy_skill">',
						'after_widget'	=> '</div>',
						'before_title'	=> '',
						'after_title'	=> ''
					);

					the_widget( 'Illdy_Widget_Skill', 'title='. __( 'Typography', 'illdy' ) .'&percentage=60&icon=fa-font&color=#f18b6d', $the_widget_args );
					the_widget( 'Illdy_Widget_Skill', 'title='. __( 'Design', 'illdy' ) .'&percentage=82&icon=fa-pencil&color=#f1d204', $the_widget_args );
					the_widget( 'Illdy_Widget_Skill', 'title='. __( 'Development', 'illdy' ) .'&percentage=86&icon=fa-code&color=#6a4d8a', $the_widget_args );
				endif;
				?>
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.section-content-->
</section><!--/#about.front-page-section-->

<?php } ?>