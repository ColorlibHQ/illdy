<?php
if ( ! class_exists( 'Epsilon_Color_Scheme' ) ) {
	/**
	 * Class Epsilon_Color_Scheme
	 */
	class Epsilon_Color_Scheme {
		/**
		 * If there isn't any inline style, we don't need to generate the CSS
		 *
		 * @var bool
		 */
		protected $terminate = false;
		/**
		 * Options with defaults
		 *
		 * @var array
		 */
		protected $options = array();
		/**
		 * Array that defines the controls/settings to be added in the customizer
		 *
		 * @var array
		 */
		protected $customizer_controls = array();
		/**
		 * Epsilon_Color_Scheme constructor.
		 */
		public function __construct() {
			$this->options             = $this->get_options();
			$this->customizer_controls = $this->get_customizer_controls();
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'customize_register', array( $this, 'add_controls_settings' ) );
		}
		public function get_options() {
			return array(
				'epsilon_accent_color'               => '#f1d204',
				'epsilon_secondary_accent_color' 	 => '#101c24',
				'epsilon_text_color'                 => '#545454',
				'epsilon_contrast_color'             => '#8c9597',
				'epsilon_hover_color'  				 => '#6a4d8a',
			);
		}
		public function get_customizer_controls() {
			return array(
				'epsilon_accent_color' => array(
					'label'       => __( 'Accent Color', 'illdy' ),
					'description' => __( 'The main color used in Illdy.', 'illdy' ),
					'default'     => '#f1d204',
					'section'     => 'colors'
				),
				'epsilon_secondary_accent_color' => array(
					'label'       => __( 'Secondary Accent Color', 'illdy' ),
					'description' => __( 'The secondary color used in Illdy.', 'illdy' ),
					'default'     => '#f18b6d',
					'section'     => 'colors'
				),
				'epsilon_text_color' => array(
					'label'       => __( 'Text Color', 'illdy' ),
					'description' => __( 'The color used for headings.', 'illdy' ),
					'default'     => '#545454',
					'section'     => 'colors'
				),
				
				'epsilon_contrast_color' => array(
					'label'       => __( 'Contrast Color', 'illdy' ),
					'description' => __( 'The color used for paragraphs.', 'illdy' ),
					'default'     => '#8c9597',
					'section'     => 'colors'
				),
				'epsilon_hover_color' => array(
					'label'       => __( 'Hover Color', 'illdy' ),
					'description' => __( 'The color used for hover on elements.', 'illdy' ),
					'default'     => '#6a4d8a',
					'section'     => 'colors'
				),
			);
		}
		/**
		 * When the function is called through AJAX, we update the colors by merging the 2 arrays
		 *
		 * @param $args
		 */
		public function update_colors( $args ) {
			if ( $args !== NULL ) {
				$array = array_merge( $this->options, $args );
				$this->options = $array;
			}
		}
		/**
		 * Grabs the instance of the epsilon color scheme class
		 *
		 * @param null $args
		 *
		 * @return Epsilon_Color_Scheme
		 */
		public static function get_instance( $args = NULL ) {
			static $inst;
			if ( ! $inst ) {
				$inst = new Epsilon_Color_Scheme( $args );
			}
			return $inst;
		}
		/**
		 * Create the array with the new settings
		 *
		 * @return array
		 */
		public function get_color_scheme() {
			$colors = array();
			foreach ( $this->options as $k => $v ) {
				$color        = sanitize_hex_color(get_theme_mod( $k, $v ));
				$colors[ $k ] = $color;
			}
			/**
			 * small check
			 */
			$a = serialize( $this->options );
			$b = serialize( $colors );
			if ( $a === $b ) {
				$this->terminate = true;
			}
			return $colors;
		}
		/**
		 * Returns the whole CSS string
		 * 1 - Accent Color
		 * 2 - Text Color
		 * 3 - Content Widget Title
		 * 4 - Footer BG Color
		 * 5 - Footer Widget Title
		 * 6 - Footer Link Color
		 * 7 - Hover Accent Color
		 * 8 - Hover Footer Link
		 *
		 * @return string
		 */
		public function css_template() {
			if ( $this->terminate ) {
				return '';
			}
			$css = '
				#header .top-header .header-logo:hover,
				#header .top-header .header-navigation ul li.menu-item-has-children .sub-menu li:hover > a,
				#latest-news .section-content .post .post-title:hover,
				#latest-news .section-content .post .post-button,
				#contact-us .section-content .contact-us-box .box-left,
				.recentcomments > a,
				#blog .blog-post .blog-post-title:hover,
				#blog .blog-post .blog-post-meta .post-meta-author,
				#blog .blog-post .blog-post-meta .post-meta-author .fa,
				#blog .blog-post .blog-post-meta .post-meta-time .fa,
				#blog .blog-post .blog-post-meta .post-meta-categories .fa,
				#blog .blog-post .blog-post-meta .post-meta-comments .fa,
				#blog .blog-post .blog-post-author h4,
				.widget table td#prev a,
				.widget table td#next a,
				.widget .widget-recent-post .recent-post-button,
				span.rss-date:before,
				.post-date:before,
				.blog-post-related-articles .related-post:hover .related-post-title,
				#comments #comments-list ul.comments .comment .url,
				#comments #comments-list ul.comments .comment .comment-reply-link,
				#header .bottom-header span.span-dot,
				#header .top-header .header-navigation ul li:hover a,
				input[type=submit] { color: %1$s; }
				#header .top-header .header-navigation ul li.menu-item-has-children .sub-menu li:hover > a { border-color: %1$s; }
				#header .bottom-header .header-button-two,
				#comments #respond .comment-form #input-submit,
				#latest-news .latest-news-button,
				#contact-us .section-content .wpcf7-form p .wpcf7-submit,
				#blog .blog-post .blog-post-button,
				.widget table caption,
				.widget table#wp-calendar tbody tr td a { background-color: %1$s; }
				@media only screen and (max-width: 992px) { .header-front-page nav ul.sub-menu { background-color: %1$s; } }
				a:hover,
				a:focus,
				#latest-news .section-content .post .post-button:hover,
				#latest-news .section-content .post .post-button:focus,
				.recentcomments a:hover,
				.widget:not(.widget_rss):not(.widget_recent_comments):not(.widget_recent_entries) ul li:hover:before,
				.widget:not(.widget_recent_comments) ul li:hover > a,
				.widget.widget_recent_comments ul li a:hover,
				.widget table td#prev a:hover:before,
				.widget table td#next a:hover:before,
				.widget table td#prev a:focus:before,
				.widget table td#next a:focus:before,
				.widget_categories ul li:hover,
				.widget_archive ul li:hover { color: %5$s; }
				#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-content,
				.widget table#wp-calendar tbody tr td a:hover,
				#comments #respond .comment-form #input-submit:hover,
				input[type=submit]:hover,
				#latest-news .latest-news-button:hover,
				#contact-us .section-content .wpcf7-form p .wpcf7-submit:hover,
				#header .bottom-header .header-button-two:hover,
				#blog .blog-post .blog-post-button:hover { background-color: %5$s; }
				#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-content:after  { border-color: %5$s transparent transparent transparent; }
				input:focus,
				input:hover,
				textarea:focus,
				textarea:hover { border-color: %5$s; }
				.front-page-section .section-header .section-description,
				#header .top-header .header-navigation ul li.menu-item-has-children .sub-menu li a,
				#services .section-content .service .service-entry,
				#latest-news .section-content .post .post-entry,
				#team .section-content .person .person-content p,
				#contact-us .section-content .contact-us-box .box-right span,
				#contact-us .section-content .contact-us-box .box-right span a,
				#contact-us .section-content .contact-us-social a,
				#contact-us .section-content .wpcf7-form p .wpcf7-text,
				#footer .copyright,
				#footer .copyright a,
				.widget table tbody,
				input,
				textarea,
				.markup-format h1, 
				.markup-format h2, 
				.markup-format h3, 
				.markup-format h4, 
				.markup-format h5, 
				.markup-format h6,
				body { color: %4$s; }
				#contact-us .section-content .wpcf7-form p .wpcf7-text::-webkit-input-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-text::-moz-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-text:-ms-input-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-text:-moz-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-textarea,
				#contact-us .section-content .wpcf7-form p .wpcf7-textarea::-webkit-input-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-textarea::-moz-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-textarea:-ms-input-placeholder,
				#contact-us .section-content .wpcf7-form p .wpcf7-textarea:-moz-placeholder{ color: %4$s; }
				.front-page-section .section-header h3,
				#latest-news .section-content .post .post-button:active,
				#blog .blog-post .blog-post-title,
				.widget table thead th,
				#team .section-content .person .person-content h6,
				.widget_rss cite,
				.illdy_home_parallax h3 { color: %3$s; }
			';
			return $css;
		}
		/**
		 * Return the css inline styles for the AJAX function (through the customizer)
		 *
		 * @return string
		 */
		public function generate_live_css() {
			return vsprintf( $this->css_template(), $this->options );
		}
		/**
		 * Return the css string for the live website
		 *
		 * @return string
		 */
		public function generate_css() {
			$color_scheme = $this->get_color_scheme();
			return vsprintf( $this->css_template(), $color_scheme );
		}
		/**
		 * Enqueue the inline style CSS string
		 */
		public function enqueue() {
			$css = $this->generate_css();
			wp_add_inline_style( 'illdy-main', $css );
		}
		/**
		 * Add the controls to the customizer
		 *
		 * @todo - nu cred ca merge translation stuff
		 */
		public function add_controls_settings() {
			global $wp_customize;
			$i = 3;
			foreach ( $this->customizer_controls as $control => $properties ) {
				$wp_customize->add_setting( $control, array(
					'default'           => $properties['default'],
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				) );
				$wp_customize->add_control( $control, array() );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control, array(
					'label'       => $properties['label'],
					'description' => $properties['description'],
					'section'     => $properties['section'],
					'settings'    => $control,
					'priority'    => $i,
				) ) );
				$i ++;
			}
		}
		public function adjust_brightness( $hex, $steps ) {
			$steps = max( - 255, min( 255, $steps ) );
			$hex   = str_replace( '#', '', $hex );
			if ( strlen( $hex ) == 3 ) {
				$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
			}
			$color_parts = str_split( $hex, 2 );
			$return      = '#';
			foreach ( $color_parts as $color ) {
				$color = hexdec( $color ); // Convert to decimal
				$color = max( 0, min( 255, $color + $steps ) ); // Adjust color
				$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
			}
			return $return;
		}
	}
	/**
	 * Instantiate the object
	 */
	Epsilon_Color_Scheme::get_instance();
	/**
	 * Add the actions for the customizer previewer
	 */
	add_action( 'wp_ajax_epsilon_generate_css', 'epsilon_generate_css' );
	add_action( 'wp_ajax_nopriv_epsilon_generate_css', 'epsilon_generate_css' );
	function epsilon_generate_css() {
		$args = array();
		/**
		 * Sanitize the $_POST['args']
		 */
		foreach ( $_POST['args'] as $k => $v ) {
			$args[ $k ] = sanitize_hex_color( $v );
		}
		/**
		 * Grab the instance of the Epsilon Color Scheme
		 */
		$color_scheme = Epsilon_Color_Scheme::get_instance();
		/**
		 * Update the option array
		 */
		$color_scheme->update_colors( $args );
		/**
		 * Echo the css inline sheet
		 */
		echo $color_scheme->generate_live_css();
		wp_die();
	}
}