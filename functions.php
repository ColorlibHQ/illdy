<?php
/**
 *    Sets up theme defaults and registers support for various WordPress features.
 *
 *    Note that this function is hooked into the after_setup_theme hook, which
 *    runs before the init hook. The init hook is too late for some features, such
 *    as indicating support for post thumbnails.
 */
if ( ! function_exists( 'illdy_setup' ) ) {
	add_action( 'after_setup_theme', 'illdy_setup' );
	function illdy_setup() {

		// Extras
		require_once trailingslashit( get_template_directory() ) . 'inc/extras.php';

		// Customizer
		require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer.php';

		// JetPack
		require_once trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

		// Components
		require_once trailingslashit( get_template_directory() ) . 'inc/components/entry-meta/class-illdy-entry-meta-output.php';
		require_once trailingslashit( get_template_directory() ) . 'inc/components/author-box/class-illdy-author-box-output.php';
		require_once trailingslashit( get_template_directory() ) . 'inc/components/related-posts/class-illdy-related-posts-output.php';

		// Load Theme Textdomain
		load_theme_textdomain( 'illdy', get_template_directory() . '/languages' );

		// Add Theme Support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'custom-logo', array(
				'height'      => 75,
				'flex-height' => false,
				'flex-width'  => true,
			)
		);
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support(
			'custom-header', array(
				'default-image'  => esc_url( get_template_directory_uri() . '/layout/images/blog/blog-header.png' ),
				'width'          => 1920,
				'height'         => 532,
				'flex-height'    => true,
				'flex-width'     => true,
				'random-default' => true,
				'header-text'    => false,
			)
		);
		add_theme_support( 'customize-selective-refresh-widgets' );
		register_default_headers(
			array(
				'default' => array(
					'url'           => '%s/layout/images/blog/blog-header.png',
					'thumbnail_url' => '%s/layout/images/blog/blog-header.png',
					'description'   => __( 'Coffe', 'illdy' ),
				),
			)
		);

		// Add Image Size
		add_image_size( 'illdy-blog-list', 750, 500, true );
		add_image_size( 'illdy-widget-recent-posts', 70, 70, true );
		add_image_size( 'illdy-blog-post-related-articles', 240, 206, true );
		add_image_size( 'illdy-front-page-latest-news', 250, 213, true );
		add_image_size( 'illdy-front-page-testimonials', 127, 127, true );
		add_image_size( 'illdy-front-page-projects', 476, 476, true );
		add_image_size( 'illdy-front-page-person', 125, 125, true );

		// Register Nav Menus
		register_nav_menus(
			array(
				'primary-menu' => __( 'Primary Menu', 'illdy' ),
			)
		);

		/**
		 *  Back compatible
		 */
		require get_template_directory() . '/inc/back-compatible.php';

		/*******************************************/
		/*************  Welcome screen *************/
		/*******************************************/

	}

	// Add Editor Style
	add_editor_style( 'illdy-google-fonts' );

}// End if().

if ( ! function_exists( 'illdy_is_not_latest_posts' ) ) {
	function illdy_is_not_latest_posts() {
		return ( 'page' == get_option( 'show_on_front' ) ? true : false );
	}
}

if ( ! function_exists( 'illdy_is_not_imported' ) ) {
	function illdy_is_not_imported() {

		if ( defined( 'ILLDY_COMPANION' ) ) {
			$illdy_show_required_actions = get_option( 'illdy_show_required_actions' );
			if ( isset( $illdy_show_required_actions['illdy-req-import-content'] ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}

	}
}


/**
 *    Set the content width in pixels, based on the theme's design and stylesheet.
 *
 *    Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! function_exists( 'illdy_content_width' ) ) {
	add_action( 'after_setup_theme', 'illdy_content_width', 0 );
	function illdy_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'illdy_content_width', 640 );
	}
}

/**
 *    WP Enqueue Stylesheets
 */
if ( ! function_exists( 'illdy_enqueue_stylesheets' ) ) {
	add_action( 'wp_enqueue_scripts', 'illdy_enqueue_stylesheets' );

	function illdy_enqueue_stylesheets() {

		// Google Fonts
		$google_fonts_args = array(
			'family' => 'Source+Sans+Pro:400,900,700,300,300italic|Lato:300,400,700,900|Poppins:300,400,500,600,700',
		);

		// WP Register Style
		wp_register_style( 'illdy-google-fonts', add_query_arg( $google_fonts_args, 'https://fonts.googleapis.com/css' ), array(), null );

		// WP Enqueue Style
		if ( 1 == get_theme_mod( 'illdy_preloader_enable', 1 ) && ! is_customize_preview() ) {
			wp_enqueue_style( 'illdy-pace', get_template_directory_uri() . '/layout/css/pace.min.css', array(), '', 'all' );
		}

		wp_enqueue_style( 'illdy-google-fonts' );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/layout/css/bootstrap.min.css', array(), '3.3.6', 'all' );
		wp_enqueue_style( 'bootstrap-theme', get_template_directory_uri() . '/layout/css/bootstrap-theme.min.css', array(), '3.3.6', 'all' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/layout/css/font-awesome.min.css', array(), '4.5.0', 'all' );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/layout/css/owl-carousel.min.css', array(), '2.0.0', 'all' );
		if ( get_theme_mod( 'illdy_projects_lightbox', 0 ) == 1 ) {
			wp_enqueue_style( 'illdy-fancybox', get_template_directory_uri() . '/layout/css/jquery-fancybox.min.css', array(), '3.3.5', 'all' );
		}
		wp_enqueue_style( 'illdy-main', get_template_directory_uri() . '/layout/css/main.css', array(), '', 'all' );
		if ( get_theme_mod( 'illdy_sticky_header_enable', false ) ) {
			$background_color = get_theme_mod( 'illdy_sticky_header_background_color', '#000000' );
			if ( '#000000' != $background_color ) {
				$custom_css = '#header .is-sticky .top-header {background-color: ' . esc_attr( $background_color ) . ';}';
				wp_add_inline_style( 'illdy-main', $custom_css );
			}
		}
		wp_enqueue_style( 'illdy-custom', get_template_directory_uri() . '/layout/css/custom.css', array(), '', 'all' );
		wp_enqueue_style( 'illdy-style', get_stylesheet_uri(), array(), '1.0.16', 'all' );
	}
}


/**
 *    WP Enqueue JavaScripts
 */
if ( ! function_exists( 'illdy_enqueue_javascripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'illdy_enqueue_javascripts' );

	function illdy_enqueue_javascripts() {
		if ( get_theme_mod( 'illdy_preloader_enable', 1 ) == 1 ) {
			wp_enqueue_script( 'illdy-pace', get_template_directory_uri() . '/layout/js/pace/pace.min.js', array( 'jquery' ), '', false );
			$pace_options = array(
				'restartOnRequestAfter' => 0,
				'restartOnPushState'    => 0,
			);
			wp_localize_script( 'illdy-pace', 'paceOptions', $pace_options );
		}
		wp_enqueue_script( 'jquery-ui-progressbar', '', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-bootstrap', get_template_directory_uri() . '/layout/js/bootstrap/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
		wp_enqueue_script( 'illdy-owl-carousel', get_template_directory_uri() . '/layout/js/owl-carousel/owl-carousel.min.js', array( 'jquery' ), '2.0.0', true );
		wp_enqueue_script( 'illdy-count-to', get_template_directory_uri() . '/layout/js/count-to/count-to.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'illdy-visible', get_template_directory_uri() . '/layout/js/visible/visible.min.js', array( 'jquery' ), '', true );
		if ( get_theme_mod( 'illdy_projects_lightbox', 0 ) == 1 ) {
			wp_enqueue_script( 'illdy-fancybox', get_template_directory_uri() . '/layout/js/fancybox/jquery-fancybox.min.js', array( 'jquery' ), '3.3.5', true );
			wp_add_inline_script( 'illdy-fancybox', 'jQuery(".fancybox").fancybox();' );
		}
		if ( get_theme_mod( 'illdy_sticky_header_enable', false ) ) {
			wp_enqueue_script( 'illdy-stickyheader', get_template_directory_uri() . '/layout/js/stickyjs/jquery.sticky.js', array( 'jquery' ), '', true );
			wp_add_inline_script( 'illdy-stickyheader', 'jQuery(".top-header").sticky({topSpacing:0,zIndex:99});' );
		}
		wp_enqueue_script( 'illdy-parallax', get_template_directory_uri() . '/layout/js/parallax/parallax.min.js', array( 'jquery' ), '1.0.16', true );
		wp_enqueue_script( 'illdy-plugins', get_template_directory_uri() . '/layout/js/plugins.min.js', array( 'jquery' ), '1.0.16', true );
		wp_enqueue_script( 'illdy-scripts', get_template_directory_uri() . '/layout/js/scripts.js', array( 'jquery' ), '1.0.16', true );
		if ( is_front_page() ) {
			wp_add_inline_script( 'illdy-scripts', 'if( jQuery(\'.blog-carousel > .illdy-blog-post\').length > 3 ){jQuery(\'.blog-carousel\').owlCarousel({\'items\': 3,\'loop\': true,\'dots\': false,\'nav\' : true, \'navText\':[\'<i class="fa fa-angle-left" aria-hidden="true"></i>\',\'<i class="fa fa-angle-right" aria-hidden="true"></i>\'], responsive : { 0 : { items : 1 }, 480 : { items : 2 }, 900 : { items : 3 } }});}' );
			$jumbotron_type = get_theme_mod( 'illdy_jumbotron_background_type', 'image' );
			if ( 'video' == $jumbotron_type ) {
				wp_enqueue_script( 'wp-custom-header' );
				wp_localize_script( 'wp-custom-header', '_wpCustomHeaderSettings', illdy_get_video_settings() );
			}
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}


/**
 *    Widgets
 */
if ( ! function_exists( 'illdy_widgets' ) ) {
	add_action( 'widgets_init', 'illdy_widgets' );

	function illdy_widgets() {

		// Blog Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Blog Sidebar', 'illdy' ),
				'id'            => 'blog-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in blog page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Page Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Page Sidebar', 'illdy' ),
				'id'            => 'page-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear on single pages.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Footer Sidebar 1
		register_sidebar(
			array(
				'name'          => __( 'Footer Sidebar 1', 'illdy' ),
				'id'            => 'footer-sidebar-1',
				'description'   => __( 'The widgets added in this sidebar will appear in first block from footer.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Footer Sidebar 2
		register_sidebar(
			array(
				'name'          => __( 'Footer Sidebar 2', 'illdy' ),
				'id'            => 'footer-sidebar-2',
				'description'   => __( 'The widgets added in this sidebar will appear in second block from footer.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Footer Sidebar 3
		register_sidebar(
			array(
				'name'          => __( 'Footer Sidebar 3', 'illdy' ),
				'id'            => 'footer-sidebar-3',
				'description'   => __( 'The widgets added in this sidebar will appear in third block from footer.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Footer Sidebar 4
		register_sidebar(
			array(
				'name'          => __( 'Footer Sidebar 4', 'illdy' ),
				'id'            => 'footer-sidebar-4',
				'description'   => __( 'The widgets added in this sidebar will appear in fourth block from footer.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// About Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - About Sidebar', 'illdy' ),
				'id'            => 'front-page-about-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in about section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-0 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Projects Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - Projects Sidebar', 'illdy' ),
				'id'            => 'front-page-projects-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in projects section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="col-sm-3 col-xs-6 no-padding %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Services Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - Services Sidebar', 'illdy' ),
				'id'            => 'front-page-services-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in services section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="col-sm-4 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Counter Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - Counter Sidebar', 'illdy' ),
				'id'            => 'front-page-counter-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in counter section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="col-sm-4 col-xs-12 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Team Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - Team Sidebar', 'illdy' ),
				'id'            => 'front-page-team-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in team section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// Full Width
		register_sidebar(
			array(
				'name'          => __( 'Front page - Full Width Section', 'illdy' ),
				'id'            => 'front-page-full-width-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in full width section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h5>',
				'after_title'   => '</h5></div>',
			)
		);

		// Testimonial Sidebar
		register_sidebar(
			array(
				'name'          => __( 'Front page - Testimonials Sidebar', 'illdy' ),
				'id'            => 'front-page-testimonials-sidebar',
				'description'   => __( 'The widgets added in this sidebar will appear in testimonials section from front page.', 'illdy' ),
				'before_widget' => '<div id="%1$s" class="%2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		// WooCommerce Sidebar
		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar(
				array(
					'name'          => __( 'WooCommerce Sidebar', 'illdy' ),
					'id'            => 'woocommerce-sidebar',
					'description'   => __( 'The widgets added in this sidebar will appear in WooCommerce pages.', 'illdy' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="widget-title"><h5>',
					'after_title'   => '</h5></div>',
				)
			);
		}
	}
}// End if().


/**
 *  Checkbox helper function
 */
if ( ! function_exists( 'illdy_value_checkbox_helper' ) ) {
	function illdy_value_checkbox_helper( $value ) {
		if ( 1 == $value ) {
			return 1;
		} else {
			return 0;
		}
	}
}

add_action( 'illdy_after_content_above_footer', 'illdy_pagination', 1 );

function illdy_pagination() {
	the_posts_pagination(
		array(
			'prev_text'          => '<i class="fa fa-angle-left"></i>',
			'next_text'          => '<i class="fa fa-angle-right"></i>',
			'screen_reader_text' => '',
		)
	);
}


if ( ! function_exists( 'illdy_get_random_featured_image' ) ) {
	function illdy_get_random_featured_image() {
		$featured_image_list = array(
			'random-blog-post-1.jpg',
			'random-blog-post-2.jpg',
			'random-blog-post-3.jpg',
			'random-blog-post-4.jpg',
			'random-blog-post-5.jpg',
		);
		$number              = rand( 0, 4 );
		return get_template_directory_uri() . '/layout/images/blog/' . $featured_image_list[ $number ];
	}
}

if ( ! function_exists( 'illdy_get_recommended_actions_url' ) ) {
	function illdy_get_recommended_actions_url() {
		return self_admin_url( 'themes.php?page=illdy-welcome&tab=recommended_actions' );
	}
}

// Include theme files
require get_template_directory() . '/inc/libraries/epsilon-framework/class-epsilon-autoloader.php';
require get_template_directory() . '/inc/class-mt-notify-system.php';
require get_template_directory() . '/inc/libraries/welcome-screen/class-epsilon-welcome-screen.php';
require get_template_directory() . '/inc/class-illdy.php';
