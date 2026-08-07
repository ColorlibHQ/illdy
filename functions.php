<?php
/**
 *    Sets up theme defaults and registers support for various WordPress features.
 *
 *    Note that this function is hooked into the after_setup_theme hook, which
 *    runs before the init hook. The init hook is too late for some features, such
 *    as indicating support for post thumbnails.
 */
/**
 * Single source of truth for asset cache-busting.
 *
 * Replaces the hard-coded '2.1.9' strings that had drifted from the version declared
 * in style.css, so a theme update now reliably invalidates cached CSS and JS.
 */
if ( ! defined( 'ILLDY_VERSION' ) ) {
	$illdy_theme = wp_get_theme( get_template() );
	define( 'ILLDY_VERSION', $illdy_theme->get( 'Version' ) ? $illdy_theme->get( 'Version' ) : '2.1.10' );
	unset( $illdy_theme );
}

/**
 * Whether this request needs the front-page-only libraries.
 *
 * Owl Carousel, countTo, jQuery Visible, the parallax script and the jQuery UI
 * progress bar exist solely for widgets registered against the `front-page-*`
 * sidebars, so they are dead weight on every other view. The Customizer preview
 * always loads them because a section can be switched on live.
 *
 * @return bool
 */
if ( ! function_exists( 'illdy_is_legacy_widget_preview' ) ) {
	/**
	 * Whether this request is the block widget editor rendering a widget preview.
	 *
	 * WP_REST_Widget_Types_Controller::render_legacy_widget_preview_iframe() builds a
	 * whole front-end document — wp_head(), body_class(), wp_footer() — and defines
	 * IFRAME_REQUEST just before doing so. Pairing that with REST_REQUEST identifies
	 * the preview without matching the Customizer, admin-ajax or a normal page.
	 *
	 * @return bool
	 */
	function illdy_is_legacy_widget_preview() {
		return defined( 'REST_REQUEST' ) && REST_REQUEST
			&& defined( 'IFRAME_REQUEST' ) && IFRAME_REQUEST;
	}
}

if ( ! function_exists( 'illdy_legacy_widget_preview_styles' ) ) {
	/**
	 * Makes a widget legible on its own in the block widget editor's preview.
	 *
	 * The front page styles these widgets as part of a section: the counter and the
	 * testimonials are white text over a dark background image supplied by `#counter`
	 * and `#testimonials`. A preview renders one widget with no section around it on a
	 * white page, so that text came out white on white — the blank boxes the block
	 * widget editor was showing.
	 *
	 * The rules below only ever apply inside that preview iframe. Two of them are
	 * fallbacks for values the front page fills in with JavaScript on scroll, which
	 * never fires in a preview: the counter's number and the skill bar's fill.
	 */
	function illdy_legacy_widget_preview_styles() {
		if ( ! illdy_is_legacy_widget_preview() ) {
			return;
		}

		/*
		 * Name each preview. The block widget editor renders the widget's output and
		 * nothing else, so a column of previews gives no clue which widget is which —
		 * the registered name is the one thing that says what you are looking at.
		 * Scoped to this theme's widgets; other plugins' previews are left alone.
		 */
		$labels = '';

		global $wp_widget_factory;

		if ( $wp_widget_factory instanceof WP_Widget_Factory ) {
			foreach ( $wp_widget_factory->widgets as $illdy_widget ) {
				if ( ! isset( $illdy_widget->id_base ) || 0 !== strpos( $illdy_widget->id_base, 'illdy_' ) ) {
					continue;
				}

				$classname = isset( $illdy_widget->widget_options['classname'] ) ? $illdy_widget->widget_options['classname'] : '';

				if ( '' === $classname ) {
					continue;
				}

				// Tags stripped first so a name can never close the <style> element.
				$name = str_replace(
					array( '\\', '"' ),
					array( '\\\\', '\\"' ),
					wp_strip_all_tags( (string) $illdy_widget->name )
				);

				$labels .= sprintf(
					'.widget.%1$s:before{content:"%2$s";}',
					preg_replace( '/[^A-Za-z0-9_-]/', '', $classname ),
					$name
				);
			}
		}

		$css = '
		.widget[class*="widget_illdy_"]{padding:6px 0;}

		.widget[class*="widget_illdy_"]:before{
			display:block;margin:0 0 10px;padding:3px 9px;
			font:600 11px/1.7 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;
			color:#50575e;background:#f0f0f1;border-radius:3px;
			text-transform:none;letter-spacing:0;
		}
		' . $labels . '
		';

		$css .= '

		/* Supplied by the section wrapper on the front page, absent here. */
		.widget_illdy_counter .counter-number,
		.widget_illdy_counter .counter-description,
		.widget_illdy_testimonial .testimonial-content,
		.widget_illdy_testimonial .testimonial-content blockquote,
		.widget_illdy_testimonial .testimonial-meta{color:#1d2327;}

		/* Front page type scale assumes a full-width section. */
		.widget_illdy_counter .counter-number{font-size:34px;line-height:1.2;}

		/* countTo never runs in a preview, so show the target it counts to. */
		.widget_illdy_counter .counter-number:empty:after{content:attr(data-to);}

		/* Likewise the jQuery UI progress bar: show the track rather than nothing. */
		.widget_illdy_skill .skill-progress-bar:empty{display:block;height:6px;border-radius:3px;background:#dcdcde;}
		';

		wp_add_inline_style( 'illdy-main', $css );
	}

	add_action( 'wp_enqueue_scripts', 'illdy_legacy_widget_preview_styles', 20 );
}

if ( ! function_exists( 'illdy_trim_legacy_widget_preview_assets' ) ) {
	/**
	 * Drops front-end assets a widget preview cannot use.
	 *
	 * The block widget editor builds one of these iframes per widget — on a populated
	 * Illdy front page that is twenty or more full front-end documents on a single
	 * admin screen. A preview renders one widget and is never scrolled, clicked or
	 * navigated, so the preloader, the lightbox, the sticky header, the parallax
	 * backgrounds and the theme's own behaviour script have nothing to act on.
	 *
	 * Nothing declares these as dependencies — plugins.js depends on jQuery, the
	 * progress bar, Owl, countTo and Visible, all of which are kept — so removing them
	 * cannot break the render. Priority 99 so it runs after everything is enqueued.
	 */
	function illdy_trim_legacy_widget_preview_assets() {
		if ( ! illdy_is_legacy_widget_preview() ) {
			return;
		}

		foreach ( array( 'illdy-pace', 'illdy-fancybox', 'illdy-stickyheader', 'illdy-parallax', 'illdy-scripts' ) as $illdy_handle ) {
			wp_dequeue_script( $illdy_handle );
		}

		foreach ( array( 'illdy-pace', 'illdy-fancybox' ) as $illdy_handle ) {
			wp_dequeue_style( $illdy_handle );
		}
	}

	add_action( 'wp_enqueue_scripts', 'illdy_trim_legacy_widget_preview_assets', 99 );
}

if ( ! function_exists( 'illdy_needs_jquery_migrate' ) ) {
	/**
	 * Whether jQuery Migrate should load.
	 *
	 * Migrate patches jQuery APIs removed in 3.x. Neither this theme nor Illdy
	 * Companion calls one — every `.bind()` in the theme is the Customizer's own
	 * `wp.customize` API, not jQuery's deprecated method — so nothing here needs it.
	 *
	 * It still loads by default, because a theme cannot know what the site's plugins
	 * call, and a missing Migrate turns a silent deprecation into a fatal JS error.
	 * The one place it is dropped outright is the widget preview, which runs only this
	 * theme's and the Companion's code and is otherwise loaded twenty times over on a
	 * single admin screen.
	 *
	 * To drop it site-wide once you have checked your plugins:
	 *
	 *     add_filter( 'illdy_load_jquery_migrate', '__return_false' );
	 *
	 * Load the front end with the console open first: real problems announce
	 * themselves as "JQMIGRATE: <warning>" lines. "Migrate is installed" on its own
	 * means nothing is using it.
	 *
	 * @return bool
	 */
	function illdy_needs_jquery_migrate() {
		return (bool) apply_filters( 'illdy_load_jquery_migrate', ! illdy_is_legacy_widget_preview() );
	}
}

if ( ! function_exists( 'illdy_maybe_drop_jquery_migrate' ) ) {
	/**
	 * Removes jquery-migrate from jQuery's dependencies when it is not wanted.
	 *
	 * Dequeuing the handle does not work: core registers it as a dependency of
	 * `jquery`, so it is pulled straight back in. The dependency itself has to go.
	 *
	 * Deliberately not on `wp_default_scripts`, which fires the first time anything
	 * touches WP_Scripts — during a widget preview that can be before the controller
	 * defines IFRAME_REQUEST, so the context check there reads the wrong answer. This
	 * runs late on wp_enqueue_scripts instead, which is still well before scripts are
	 * printed and long after the context is settled.
	 */
	function illdy_maybe_drop_jquery_migrate() {
		// wp-admin proper is left alone: it is full of other people's code.
		if ( is_admin() || illdy_needs_jquery_migrate() ) {
			return;
		}

		$scripts = wp_scripts();

		if ( ! isset( $scripts->registered['jquery'] ) || ! is_array( $scripts->registered['jquery']->deps ) ) {
			return;
		}

		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			array( 'jquery-migrate' )
		);

		wp_dequeue_script( 'jquery-migrate' );
	}

	add_action( 'wp_enqueue_scripts', 'illdy_maybe_drop_jquery_migrate', 99 );
}

if ( ! function_exists( 'illdy_needs_front_page_assets' ) ) {
	function illdy_needs_front_page_assets() {
		/*
		 * The widget preview is not the front page, so this used to return false there
		 * and the front-page-only libraries were skipped. The Companion's widgets need
		 * them to render — the counter is drawn by countTo, the skill bars by jQuery UI
		 * progressbar — so every preview came back blank and the block widget editor
		 * looked broken for widgets that work perfectly well.
		 */
		$needed = is_front_page() || is_customize_preview() || illdy_is_legacy_widget_preview();

		/**
		 * Filters whether the front-page libraries load.
		 *
		 * Return true if you surface Illdy Companion widgets outside the front page.
		 *
		 * @param bool $needed
		 */
		return (bool) apply_filters( 'illdy_needs_front_page_assets', $needed );
	}
}

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
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		// 'style', 'script' and 'navigation-widgets' drop the legacy type="" attributes
		// and emit standards-compliant markup.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
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

		// Google Fonts. display=swap renders text in the fallback face immediately
		// instead of leaving it invisible while the webfont downloads.
		$google_fonts_args = array(
			'family'  => 'Source+Sans+Pro:400,900,700,300,300italic|Lato:300,400,700,900|Poppins:300,400,500,600,700',
			'display' => 'swap',
		);

		// WP Register Style
		wp_register_style( 'illdy-google-fonts', add_query_arg( $google_fonts_args, 'https://fonts.googleapis.com/css' ), array(), null );

		// WP Enqueue Style
		if ( 1 == get_theme_mod( 'illdy_preloader_enable', 1 ) && ! is_customize_preview() ) {
			wp_enqueue_style( 'illdy-pace', get_template_directory_uri() . '/layout/css/pace.min.css', array(), ILLDY_VERSION, 'all' );
		}

		wp_enqueue_style( 'illdy-google-fonts' );
		/*
		 * bootstrap-theme.css was dropped: it only styles .btn-*, .navbar-*, .alert-*,
		 * .panel-* and .list-group-*, none of which this theme's front-end markup uses.
		 */
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/layout/css/bootstrap.min.css', array(), '3.3.6', 'all' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/layout/css/font-awesome.min.css', array(), '4.5.0', 'all' );

		// Only the front-page sections carry carousels.
		if ( illdy_needs_front_page_assets() ) {
			wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/layout/css/owl-carousel.min.css', array(), '2.0.0', 'all' );
		}

		if ( get_theme_mod( 'illdy_projects_lightbox', 0 ) == 1 ) {
			wp_enqueue_style( 'illdy-fancybox', get_template_directory_uri() . '/layout/css/jquery-fancybox.min.css', array(), '3.3.5', 'all' );
		}
		wp_enqueue_style( 'illdy-main', get_template_directory_uri() . '/layout/css/main.min.css', array(), ILLDY_VERSION, 'all' );
		if ( get_theme_mod( 'illdy_sticky_header_enable', false ) ) {
			$background_color = sanitize_hex_color( get_theme_mod( 'illdy_sticky_header_background_color', '#000000' ) );
			if ( $background_color && '#000000' != $background_color ) {
				$custom_css = '#header .is-sticky .top-header {background-color: ' . $background_color . ';}';
				wp_add_inline_style( 'illdy-main', $custom_css );
			}
		}
		wp_enqueue_style( 'illdy-custom', get_template_directory_uri() . '/layout/css/custom.min.css', array(), ILLDY_VERSION, 'all' );
		wp_enqueue_style( 'illdy-style', get_stylesheet_uri(), array(), ILLDY_VERSION, 'all' );
	}
}

/**
 * Opens the connection to the Google Fonts CDN early.
 *
 * Core already emits a dns-prefetch for fonts.googleapis.com; the font files
 * themselves are served from fonts.gstatic.com, so preconnecting there saves a
 * DNS + TCP + TLS round trip before the first glyph can be requested.
 */
if ( ! function_exists( 'illdy_resource_hints' ) ) {
	add_filter( 'wp_resource_hints', 'illdy_resource_hints', 10, 2 );

	function illdy_resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type && wp_style_is( 'illdy-google-fonts', 'enqueued' ) ) {
			$urls[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}

		return $urls;
	}
}


/**
 *    WP Enqueue JavaScripts
 */
if ( ! function_exists( 'illdy_enqueue_javascripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'illdy_enqueue_javascripts' );

	function illdy_enqueue_javascripts() {
		$uri         = get_template_directory_uri();
		$front_page  = illdy_needs_front_page_assets();
		$plugin_deps = array( 'jquery' );
		$script_deps = array( 'jquery' );

		if ( get_theme_mod( 'illdy_preloader_enable', 1 ) == 1 ) {
			wp_enqueue_script( 'illdy-pace', $uri . '/layout/js/pace/pace.min.js', array( 'jquery' ), ILLDY_VERSION, false );
			$pace_options = array(
				'restartOnRequestAfter' => 0,
				'restartOnPushState'    => 0,
			);
			wp_localize_script( 'illdy-pace', 'paceOptions', $pace_options );
		}

		/*
		 * Bootstrap 3's JavaScript is not loaded any more. No template emits a
		 * data-toggle / data-target / data-ride / data-dismiss / data-slide attribute,
		 * so none of its plugins were ever initialised, and every published Bootstrap 3
		 * advisory (CVE-2016-10735, CVE-2018-14041, CVE-2018-14042, CVE-2019-8331) is an
		 * XSS in exactly that code. The stylesheet is unaffected.
		 *
		 * The libraries below only drive front-page widgets, so they are skipped
		 * elsewhere; plugins.js feature-detects each one before calling it.
		 */
		if ( $front_page ) {
			wp_enqueue_script( 'jquery-ui-progressbar' );
			wp_enqueue_script( 'illdy-owl-carousel', $uri . '/layout/js/owl-carousel/owl-carousel.min.js', array( 'jquery' ), '2.0.0', true );
			wp_enqueue_script( 'illdy-count-to', $uri . '/layout/js/count-to/count-to.min.js', array( 'jquery' ), ILLDY_VERSION, true );
			wp_enqueue_script( 'illdy-visible', $uri . '/layout/js/visible/visible.min.js', array( 'jquery' ), ILLDY_VERSION, true );
			wp_enqueue_script( 'illdy-parallax', $uri . '/layout/js/parallax/parallax.min.js', array( 'jquery' ), ILLDY_VERSION, true );

			/*
			 * Declare the real dependencies rather than relying on enqueue order.
			 * plugins.js drives the progress bar, carousels and counter; the inline
			 * blog-carousel initialiser attached to illdy-scripts below calls
			 * owlCarousel() directly.
			 */
			$plugin_deps = array( 'jquery', 'jquery-ui-progressbar', 'illdy-owl-carousel', 'illdy-count-to', 'illdy-visible' );
			$script_deps = array( 'jquery', 'illdy-owl-carousel' );
		}

		if ( get_theme_mod( 'illdy_projects_lightbox', 0 ) == 1 ) {
			wp_enqueue_script( 'illdy-fancybox', $uri . '/layout/js/fancybox/jquery-fancybox.min.js', array( 'jquery' ), '3.3.5', true );
			wp_add_inline_script( 'illdy-fancybox', 'jQuery(".fancybox").fancybox();' );
		}
		if ( get_theme_mod( 'illdy_sticky_header_enable', false ) ) {
			wp_enqueue_script( 'illdy-stickyheader', $uri . '/layout/js/stickyjs/jquery.sticky.js', array( 'jquery' ), ILLDY_VERSION, true );
			wp_add_inline_script( 'illdy-stickyheader', 'jQuery(".top-header").sticky({topSpacing:0,zIndex:99});' );
		}
		wp_enqueue_script( 'illdy-plugins', $uri . '/layout/js/plugins.min.js', $plugin_deps, ILLDY_VERSION, true );
		wp_enqueue_script( 'illdy-scripts', $uri . '/layout/js/scripts.min.js', $script_deps, ILLDY_VERSION, true );
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
	/**
	 * Where to send someone who still needs Illdy Companion.
	 *
	 * The callers are the Customizer descriptions shown while the Companion is
	 * inactive. About Illdy's Recommended Plugins tab installs it in place, so that is
	 * the destination; the class_exists() guard covers the front end, where the About
	 * screen is not loaded at all.
	 *
	 * @return string
	 */
	function illdy_get_recommended_actions_url() {
		if ( class_exists( 'Illdy_Welcome' ) ) {
			return Illdy_Welcome::url( 'plugins' );
		}

		return self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=illdy-companion' );
	}
}

// Include theme files
require get_template_directory() . '/inc/customizer/class-illdy-color-scheme.php';
require get_template_directory() . '/inc/admin/class-illdy-plugin-state.php';
require get_template_directory() . '/inc/class-illdy-deprecated-onboarding.php';
require get_template_directory() . '/inc/class-illdy.php';

/*
 * The About Illdy screen. Admin-only, so it is not parsed on front-end requests at all.
 * It registers on admin_menu, which is well after load_theme_textdomain(), so its
 * translated strings do not trip WordPress 6.7+'s just-in-time translation notice.
 */
if ( is_admin() ) {
	// Loaded first: the About screen links to its Front Page Sections panel URL.
	require get_template_directory() . '/inc/admin/class-illdy-widgets-admin.php';
	require get_template_directory() . '/inc/admin/class-illdy-welcome.php';
}
