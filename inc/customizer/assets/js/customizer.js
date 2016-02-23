/**
 *	jQuery Document Ready
 */
jQuery( document ).ready( function($) {
	// Front page - About Sidebar
	wp.customize.section( 'sidebar-widgets-front-page-about-sidebar' ).panel( 'illdy_panel_about' );
	wp.customize.section( 'sidebar-widgets-front-page-about-sidebar' ).priority( '2' );

	// Front page - Projects Sidebar
	wp.customize.section( 'sidebar-widgets-front-page-projects-sidebar' ).panel( 'illdy_panel_projects' );
	wp.customize.section( 'sidebar-widgets-front-page-projects-sidebar' ).priority( '2' );

	// Front page - Testimonials Sidebar
	wp.customize.section( 'sidebar-widgets-front-page-services-sidebar' ).panel( 'illdy_panel_services' );
	wp.customize.section( 'sidebar-widgets-front-page-services-sidebar' ).priority( '2' );

	// Front page - Counter Sidebar
	wp.customize.section( 'sidebar-widgets-front-page-counter-sidebar' ).panel( 'illdy_panel_counter' );
	wp.customize.section( 'sidebar-widgets-front-page-counter-sidebar' ).priority( '3' );

	// Front page - Team Sidebar
	wp.customize.section( 'sidebar-widgets-front-page-team-sidebar' ).panel( 'illdy_panel_team' );
	wp.customize.section( 'sidebar-widgets-front-page-team-sidebar' ).priority( '2' );
});