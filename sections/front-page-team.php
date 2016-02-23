<?php
/**
 *	The template for dispalying the team section in front page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php
$general_title = get_theme_mod( 'illdy_team_general_title', esc_html__( 'Team', 'illdy' ) );
$general_entry = get_theme_mod( 'illdy_team_general_entry', esc_html__( 'Meet the people that are going to take your business to the next level.', 'illdy' ) );
?>
<section id="team" class="front-page-section">
	<?php if( $general_title || $general_entry ): ?>
		<div class="section-header">
			<div class="container">
				<div class="row">
					<?php if( $general_title ): ?>
						<div class="col-sm-12">
							<h3><?php echo esc_html( $general_title ); ?></h3>
						</div><!--/.col-sm-12-->
					<?php endif; ?>
					<?php if( $general_entry ): ?>
						<div class="col-sm-10 col-sm-offset-1">
							<p><?php echo esc_html( $general_entry ); ?></p>
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
				if( is_active_sidebar( 'front-page-team-sidebar' ) ):
					dynamic_sidebar( 'front-page-team-sidebar' );
				else:
					$the_widget_args = array(
						'before_widget'	=> '<div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 widget_illdy_person">',
						'after_widget'	=> '</div>',
						'before_title'	=> '',
						'after_title'	=> ''
					);

					the_widget( 'Illdy_Widget_Person', 'title='. __( 'Mark Lawrance', 'illdy' ) .'&image='. esc_url( '/layout/images/front-page/front-page-team-1.jpg' ) .'&position='. __( 'Web Designer', 'illdy' ) .'&entry='. __( 'Creative, detail-oriented, always focused.', 'illdy' ) .'&facebook_url='. esc_url( '#' ) .'&twitter_url='. esc_url( '#' ) .'&linkedin_url='. esc_url( '#' ) .'&color=#f18b6d', $the_widget_args );
					the_widget( 'Illdy_Widget_Person', 'title='. __( 'Jane  Stenton', 'illdy' ) .'&image='. esc_url( '/layout/images/front-page/front-page-team-2.jpg' ) .'&position='. __( 'SEO Specialist', 'illdy' ) .'&entry='. __( 'Curious, tech-geeck and gets serious when it comes to work.', 'illdy' ) .'&facebook_url='. esc_url( '#' ) .'&twitter_url='. esc_url( '#' ) .'&linkedin_url='. esc_url( '#' ) .'&color=#f1d204', $the_widget_args );
					the_widget( 'Illdy_Widget_Person', 'title='. __( 'John Smith', 'illdy' ) .'&image='. esc_url( '/layout/images/front-page/front-page-team-3.jpg' ) .'&position='. __( 'Developer', 'illdy' ) .'&entry='. __( 'Enthusiastic, passionate with great sense of humor.', 'illdy' ) .'&facebook_url='. esc_url( '#' ) .'&twitter_url='. esc_url( '#' ) .'&linkedin_url='. esc_url( '#' ) .'&color=#6a4d8a', $the_widget_args );
				endif;
				?>
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.section-content-->
</section><!--/#team.front-page-section-->