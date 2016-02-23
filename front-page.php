<?php
/**
 *	The template for displaying the front page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */

$about_general_show = get_theme_mod( 'illdy_about_general_show', 1 );
$projects_general_show = get_theme_mod( 'illdy_projects_general_show', 1 );
$testimonials_general_show = get_theme_mod( 'illdy_testimonials_general_show', 1 );
$services_general_show = get_theme_mod( 'illdy_services_general_show', 1 );
$latest_news_general = get_theme_mod( 'illdy_latest_news_general', 1 );
$counter_general_show = get_theme_mod( 'illdy_counter_general_show', 1 );
$team_general_show = get_theme_mod( 'illdy_team_general_show', 1 );
$contact_us_general_show = get_theme_mod( 'illdy_contact_us_general_show', 1 );

get_header();

if( get_option( 'show_on_front' ) == 'page' ):
	if( is_page_template( 'page-templates/blog.php' ) ):
		get_template_part( 'page-templates/blog' );
	elseif( is_page_template( 'page-templates/left-sidebar.php' ) ):
		get_template_part( 'page-templates/left', 'sidebar' );
	elseif( is_page_template( 'page-templates/no-sidebar.php' ) ):
		get_template_part( 'page-templates/no', 'sidebar' );
	else:
		get_template_part( 'page' );
	endif;
else:
	if( $about_general_show == 1 ):
		get_template_part( 'sections/front-page', 'about' );
	endif;

	if( $projects_general_show == 1 ):
		get_template_part( 'sections/front-page', 'projects' );
	endif;

	if( $testimonials_general_show == 1 ):
		get_template_part( 'sections/front-page', 'testimonials' );
	endif;

	if( $services_general_show == 1 ):
		get_template_part( 'sections/front-page', 'services' );
	endif;

	if( $latest_news_general == 1 ):
		get_template_part( 'sections/front-page', 'latest-news' );
	endif;

	if( $counter_general_show == 1 ):
		get_template_part( 'sections/front-page', 'counter' );
	endif;

	if( $team_general_show == 1 ):
		get_template_part( 'sections/front-page', 'team' );
	endif;

	if( $contact_us_general_show == 1 ):
		get_template_part( 'sections/front-page', 'contact-us' );
	endif;
endif;

get_footer(); ?>