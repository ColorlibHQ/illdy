<?php
/**
 *	Sets up theme defaults and registers support for various WordPress features.
 *
 *	Note that this function is hooked into the after_setup_theme hook, which
 *	runs before the init hook. The init hook is too late for some features, such
 *	as indicating support for post thumbnails.
 */
if(!function_exists('illdy_setup')) {
	add_action( 'after_setup_theme', 'illdy_setup' );

	function illdy_setup() {
		// Extras
		require_once( 'inc/extras.php' );

		// Template Tags
		require_once( 'inc/template-tags.php' );

		// Customizer
		require_once( 'inc/customizer/customizer.php' );

		// JetPack
		require_once( 'inc/jetpack.php' );

		require_once( 'inc/tgm-plugin-activation/tgm-plugin-activation.php' );

		// Coponents
		require_once( 'inc/components/pagination/class.mt-pagination.php' );
		require_once( 'inc/components/entry-meta/class.mt-entry-meta.php' );
		require_once( 'inc/components/social-sharing/class.mt-social-sharing.php' );
		require_once( 'inc/components/author-box/class.mt-author-box.php' );
		require_once( 'inc/components/related-posts/class.mt-related-posts.php' );
		require_once( 'inc/components/nav-walker/class.mt-nav-walker.php' );

		// Widgets
		require_once( 'widgets/class-widget-recent-posts.php' );
		require_once( 'widgets/class-widget-skill.php' );
		require_once( 'widgets/class-widget-project.php' );
		require_once( 'widgets/class-widget-service.php' );
		require_once( 'widgets/class-widget-counter.php' );
		require_once( 'widgets/class-widget-person.php' );

		// Load Theme Textdomain
		load_theme_textdomain( 'illdy', get_template_directory() . '/languages' );

		// Add Theme Support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'custom-header', array(
				'default-image'		=> esc_url( get_template_directory_uri() . '/layout/images/blog/blog-header.png' ),
				'width'				=> 1920,
				'height'			=> 532,
				'flex-height'		=> true,
				'random-default'	=> false,
				'header-text'		=> false
		) );

		// Add Image Size
		add_image_size( 'illdy-blog-list', 653, 435, true );
		add_image_size( 'illdy-widget-recent-posts', 70, 70, true );
		add_image_size( 'illdy-blog-post-related-articles', 240, 206, true );
		add_image_size( 'illdy-front-page-latest-news', 360, 213, true );
		add_image_size( 'illdy-front-page-testimonials', 127, 127, true );
		add_image_size( 'illdy-front-page-projects', 476, 476, true );
		add_image_size( 'illdy-front-page-person', 125, 125, true );

		// Register Nav Menus
		register_nav_menus( array(
			'primary-menu'	=> esc_html__( 'Primary Menu', 'illdy' ),
		) );
	}
}


/**
 *	Set the content width in pixels, based on the theme's design and stylesheet.
 *
 *	Priority 0 to make it available to lower priority callbacks.
 *
 *	@global int $content_width
 */
if(!function_exists('illdy_content_width')) {
	add_action( 'after_setup_theme', 'illdy_content_width', 0 );
	function illdy_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'illdy_content_width', 640 );
	}
}

/**
 *	WP Enqueue Stylesheets
 */
if(!function_exists('illdy_enqueue_stylesheets')) {
	add_action( 'wp_enqueue_scripts', 'illdy_enqueue_stylesheets' );

	function illdy_enqueue_stylesheets() {
		// Google Fonts
		$google_fonts_args = array(
			'family'	=> 'Source+Sans+Pro:400,900,700,300,300italic'
		);

		// WP Register Style
		wp_register_style( 'illdy-google-fonts', add_query_arg( $google_fonts_args, 'https://fonts.googleapis.com/css' ), array(), null );

		// WP Enqueue Style
		if( get_theme_mod( 'illdy_preloader_enable', 1 ) == 1 ) {
			wp_enqueue_style( 'illdy-pace', get_template_directory_uri() . '/layout/css/pace.min.css', array(), '', 'all' );
		}
		wp_enqueue_style( 'illdy-google-fonts' );
		wp_enqueue_style( 'illdy-bootstrap', get_template_directory_uri() . '/layout/css/bootstrap.min.css', array(), '3.3.6', 'all' );
		wp_enqueue_style( 'illdy-bootstrap-theme', get_template_directory_uri() . '/layout/css/bootstrap-theme.min.css', array(), '3.3.6', 'all' );
		wp_enqueue_style( 'illdy-font-awesome', get_template_directory_uri() . '/layout/css/font-awesome.min.css', array(), '4.5.0', 'all' );
		wp_enqueue_style( 'illdy-owl-carousel', get_template_directory_uri() . '/layout/css/owl-carousel.min.css', array(), '2.0.0', 'all' );
		wp_enqueue_style( 'illdy-style', get_stylesheet_uri(), array(), '1.0.0', 'all' );
	}
}


/**
 *	WP Enqueue JavaScripts
 */
if(!function_exists('illdy_enqueue_javascripts')) {
	add_action( 'wp_enqueue_scripts', 'illdy_enqueue_javascripts' );

	function illdy_enqueue_javascripts() {
		if( get_theme_mod( 'illdy_preloader_enable', 1 ) == 1 ) {
			wp_enqueue_script( 'illdy-pace', get_template_directory_uri() . '/layout/js/pace/pace.min.js', array( 'jquery' ), '', false );
		}
		wp_enqueue_script( 'jquery-ui-progressbar', '', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-bootstrap', get_template_directory_uri() . '/layout/js/bootstrap/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
		wp_enqueue_script( 'illdy-owl-carousel', get_template_directory_uri() . '/layout/js/owl-carousel/owl-carousel.min.js', array( 'jquery' ), '2.0.0', true );
		wp_enqueue_script( 'illdy-count-to', get_template_directory_uri() . '/layout/js/count-to/count-to.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-visible', get_template_directory_uri() . '/layout/js/visible/visible.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-plugins', get_template_directory_uri() . '/layout/js/plugins.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-scripts', get_template_directory_uri() . '/layout/js/scripts.min.js', array( 'jquery' ), '', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}


/**
 *	Widgets
 */
if(!function_exists('illdy_widgets')) {
	add_action( 'widgets_init', 'illdy_widgets' );

	function illdy_widgets() {
		
		// Blog Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Blog Sidebar', 'illdy' ),
			'id'			=> 'blog-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in blog page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widget-title"><h3>',
			'after_title'	=> '</h3></div>',
		) );

		// Footer Sidebar 1
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer Sidebar 1', 'illdy' ),
			'id'			=> 'footer-sidebar-1',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in first block from footer.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widget-title"><h3>',
			'after_title'	=> '</h3></div>',
		) );

		// Footer Sidebar 2
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer Sidebar 2', 'illdy' ),
			'id'			=> 'footer-sidebar-2',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in second block from footer.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widget-title"><h3>',
			'after_title'	=> '</h3></div>',
		) );

		// Footer Sidebar 3
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer Sidebar 3', 'illdy' ),
			'id'			=> 'footer-sidebar-3',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in third block from footer.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widget-title"><h3>',
			'after_title'	=> '</h3></div>',
		) );

		// About Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Front page - About Sidebar', 'illdy' ),
			'id'			=> 'front-page-about-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in about section from front page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-0 %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '',
			'after_title'	=> '',
		) );

		// Projects Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Front page - Projects Sidebar', 'illdy' ),
			'id'			=> 'front-page-projects-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in projects section from front page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="col-sm-3 col-xs-6 no-padding %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '',
			'after_title'	=> '',
		) );

		// Services Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Front page - Services Sidebar', 'illdy' ),
			'id'			=> 'front-page-services-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in services section from front page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="col-sm-4 %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '',
			'after_title'	=> '',
		) );

		// Counter Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Front page - Counter Sidebar', 'illdy' ),
			'id'			=> 'front-page-counter-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in counter section from front page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="col-sm-4 %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '',
			'after_title'	=> '',
		) );

		// Team Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Front page - Team Sidebar', 'illdy' ),
			'id'			=> 'front-page-team-sidebar',
			'description'	=> esc_html__( 'The widgets added in this sidebar will appear in team section from front page.', 'illdy' ),
			'before_widget'	=> '<div id="%1$s" class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '',
			'after_title'	=> '',
		) );
	}
}

/**
 *  Checkbox helper function
 */
if( !function_exists( 'illdy_value_checkbox_helper' ) ) {
	function illdy_value_checkbox_helper( $value ) {
	    if ($value == 1) {
	        return 1;
	    } else {
	        return 0;
	    }
	}
}