<?php
/**
 *	The template for displaying the projects section in front page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
if ( current_user_can( 'edit_theme_options' ) ) {
	$general_title = get_theme_mod( 'illdy_projects_general_title', esc_html__( 'Projects', 'illdy' ) );
	$general_entry = get_theme_mod( 'illdy_projects_general_entry', esc_html__( 'You\'ll love our work. Check it out!', 'illdy' ) );
}else{
	$general_title = get_theme_mod( 'illdy_projects_general_title' );
	$general_entry = get_theme_mod( 'illdy_projects_general_entry' );
}

?>

<?php if ( $general_title != '' || $general_entry != '' || is_active_sidebar( 'front-page-projects-sidebar' ) ) { ?>

<section id="projects" class="front-page-section" style="<?php if( !$general_title && !$general_entry ): echo 'padding-top: 0;'; endif; ?>">
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
		<div class="container-fluid">
			<div class="row inline-columns">
				<?php
				if( is_active_sidebar( 'front-page-projects-sidebar' ) ):
					dynamic_sidebar( 'front-page-projects-sidebar' );
				elseif( current_user_can( 'edit_theme_options' ) & defined("ILLDY_COMPANION") ):
					$the_widget_args = array(
						'before_widget'	=> '<div class="col-sm-3 col-xs-6 no-padding widget_illdy_project">',
						'after_widget'	=> '</div>',
						'before_title'	=> '',
						'after_title'	=> ''
					);
					the_widget( 'Illdy_Widget_Project', 'title='. __( 'Project 1', 'illdy' ) .'&image='. get_template_directory_uri().esc_url( '/layout/images/front-page/front-page-project-1.png' ) .'&url='. esc_url( '#' ), $the_widget_args );
					the_widget( 'Illdy_Widget_Project', 'title='. __( 'Project 2', 'illdy' ) .'&image='. get_template_directory_uri().esc_url( '/layout/images/front-page/front-page-project-2.png' ) .'&url='. esc_url( '#' ), $the_widget_args );
					the_widget( 'Illdy_Widget_Project', 'title='. __( 'Project 3', 'illdy' ) .'&image='. get_template_directory_uri().esc_url( '/layout/images/front-page/front-page-project-3.png' ) .'&url='. esc_url( '#' ), $the_widget_args );
					the_widget( 'Illdy_Widget_Project', 'title='. __( 'Project 4', 'illdy' ) .'&image='. get_template_directory_uri().esc_url( '/layout/images/front-page/front-page-project-4.png' ) .'&url='. esc_url( '#' ), $the_widget_args );
				endif;
				?>
			</div><!--/.row-->
		</div><!--/.container-fluid-->
	</div><!--/.section-content-->
</section><!--/#projects.front-page-section-->

<?php } ?>