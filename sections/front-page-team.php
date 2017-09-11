<?php
/**
 *  The template for dispalying the team section in front page.
 *
 *  @package WordPress
 *  @subpackage illdy
 */
?>
<?php
if ( current_user_can( 'edit_theme_options' ) ) {
	$general_title = get_theme_mod( 'illdy_team_general_title', __( 'Team', 'illdy' ) );
	$general_entry = get_theme_mod( 'illdy_team_general_entry', __( 'Meet the people that are going to take your business to the next level.', 'illdy' ) );
} else {
	$general_title = get_theme_mod( 'illdy_team_general_title' );
	$general_entry = get_theme_mod( 'illdy_team_general_entry' );
}

?>

<?php if ( '' != $general_title || '' != $general_entry || is_active_sidebar( 'front-page-team-sidebar' ) ) { ?>

<section id="team" class="front-page-section">
	<?php if ( $general_title || $general_entry ) : ?>
		<div class="section-header">
			<div class="container">
				<div class="row">
					<?php if ( $general_title ) : ?>
						<div class="col-sm-12">
							<h3><?php echo do_shortcode( wp_kses_post( $general_title ) ); ?></h3>
						</div><!--/.col-sm-12-->
					<?php endif; ?>
					<?php if ( $general_entry ) : ?>
						<div class="col-sm-10 col-sm-offset-1">
							<div class="section-description"><?php echo do_shortcode( wp_kses_post( $general_entry ) ); ?></div>
						</div><!--/.col-sm-10.col-sm-offset-1-->
					<?php endif; ?>
				</div><!--/.row-->
			</div><!--/.container-->
		</div><!--/.section-header-->
	<?php endif; ?>
	<div class="section-content">
		<div class="container">
			<div class="row inline-columns">
				<?php
				if ( is_active_sidebar( 'front-page-team-sidebar' ) ) :
					dynamic_sidebar( 'front-page-team-sidebar' );
				elseif ( current_user_can( 'edit_theme_options' ) & defined( 'ILLDY_COMPANION' ) ) :
					$the_widget_args = array(
						'before_widget' => '<div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 widget_illdy_person">',
						'after_widget'  => '</div>',
						'before_title'  => '',
						'after_title'   => '',
					);

					the_widget( 'Illdy_Widget_Person', 'title=' . __( 'Mark Lawrance', 'illdy' ) . '&image=' . get_template_directory_uri() . esc_url( '/layout/images/front-page/front-page-team-1.jpg' ) . '&position=' . __( 'Web Designer', 'illdy' ) . '&entry=' . __( 'Creative, detail-oriented, always focused.', 'illdy' ) . '&facebook_url=' . get_template_directory_uri() . esc_url( '#' ) . '&twitter_url=' . esc_url( '#' ) . '&linkedin_url=' . esc_url( '#' ) . '&color=#f18b6d', $the_widget_args );
					the_widget( 'Illdy_Widget_Person', 'title=' . __( 'Jane  Stenton', 'illdy' ) . '&image=' . get_template_directory_uri() . esc_url( '/layout/images/front-page/front-page-team-2.jpg' ) . '&position=' . __( 'SEO Specialist', 'illdy' ) . '&entry=' . __( 'Curious, tech-geeck and gets serious when it comes to work.', 'illdy' ) . '&facebook_url=' . esc_url( '#' ) . '&twitter_url=' . esc_url( '#' ) . '&linkedin_url=' . esc_url( '#' ) . '&color=#f1d204', $the_widget_args );
					the_widget( 'Illdy_Widget_Person', 'title=' . __( 'John Smith', 'illdy' ) . '&image=' . get_template_directory_uri() . esc_url( '/layout/images/front-page/front-page-team-3.jpg' ) . '&position=' . __( 'Developer', 'illdy' ) . '&entry=' . __( 'Enthusiastic, passionate with great sense of humor.', 'illdy' ) . '&facebook_url=' . esc_url( '#' ) . '&twitter_url=' . esc_url( '#' ) . '&linkedin_url=' . esc_url( '#' ) . '&color=#6a4d8a', $the_widget_args );
				endif;
				?>
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.section-content-->
</section><!--/#team.front-page-section-->

<?php }// End if().
	?>
