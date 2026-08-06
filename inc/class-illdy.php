<?php


class Illdy {

	public $theme_slug = 'illdy';

	function __construct() {

		$this->init_color_scheme();

		add_filter( 'sidebars_widgets', array( $this, 'remove_specific_widget' ) );

	}

	public function init_color_scheme() {

		$handler = 'illdy-style';
		$args    = array(
			'fields' => array(
				'epsilon_accent_color'           => array(
					'label'       => __( 'Accent Color', 'illdy' ),
					'description' => __( 'The main color used in Illdy.', 'illdy' ),
					'default'     => '#f1d204',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_secondary_accent_color' => array(
					'label'       => __( 'Secondary Accent Color', 'illdy' ),
					'description' => __( 'The secondary color used in Illdy.', 'illdy' ),
					'default'     => '#f18b6d',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_text_color'             => array(
					'label'       => __( 'Text Color', 'illdy' ),
					'description' => __( 'The color used for headings.', 'illdy' ),
					'default'     => '#545454',
					'section'     => 'colors',
					'hover-state' => false,
				),

				'epsilon_contrast_color'         => array(
					'label'       => __( 'Contrast Color', 'illdy' ),
					'description' => __( 'The color used for paragraphs.', 'illdy' ),
					'default'     => '#8c9597',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_hover_color'            => array(
					'label'       => __( 'Hover Color', 'illdy' ),
					'description' => __( 'The color used for hover on elements.', 'illdy' ),
					'default'     => '#6a4d8a',
					'section'     => 'colors',
					'hover-state' => false,
				),
			),
			'css'    => Illdy_Color_Scheme::load_css_overrides( get_template_directory() . '/layout/css/style-overrides.css' ),
		);

		new Illdy_Color_Scheme( $handler, $args );

	}

	/**
	 * Filter widgets, we don`t allow normal widgets in the homepage builder
	 *
	 * @param $sidebars_widgets
	 *
	 * @return mixed
	 */
	public function remove_specific_widget( $sidebars_widgets ) {

		if ( apply_filters( 'illdy_remove_custom_widgets', false ) ) {
			return $sidebars_widgets;
		}

		$front_page_sidebars = array( 'front-page-about-sidebar', 'front-page-projects-sidebar', 'front-page-services-sidebar', 'front-page-counter-sidebar', 'front-page-team-sidebar', 'front-page-full-width-sidebar', 'front-page-testimonials-sidebar' );

		/**
		 * Start filtering the widgets
		 */
		foreach ( $sidebars_widgets as $widget_area => $widget_list ) {

			/**
			 * In the content area of the frontend page, we can only use builder widgets
			 */
			/*
			 * The sidebars_widgets option also carries a scalar `array_version` key, so
			 * $widget_list is not always a list. Iterating it raised "foreach() argument
			 * must be of type array|object" on PHP 8.
			 */
			if ( ! is_array( $widget_list ) || in_array( $widget_area, $front_page_sidebars, true ) ) {
				continue;
			}

			foreach ( $widget_list as $pos => $widget_id ) {
				if ( is_string( $widget_id ) && strpos( $widget_id, 'illdy_home_parallax' ) !== false ) {
					unset( $sidebars_widgets[ $widget_area ][ $pos ] );
				}
			}
		}

		return $sidebars_widgets;
	}

}

/**
 * Boots the theme controller.
 *
 * Hooked to `after_setup_theme` at priority 15 rather than run at file-parse time:
 * `illdy_setup()` calls `load_theme_textdomain()` at priority 10, so by the time this
 * runs the `illdy` domain is already registered and no just-in-time translation
 * loading is triggered. The colour scheme labels below are translated, so this must
 * not move earlier; everything else it registers targets `wp_enqueue_scripts`,
 * `customize_*` or `sidebars_widgets`, all of which fire well after this point.
 */
if ( ! function_exists( 'illdy_boot' ) ) {
	function illdy_boot() {
		new Illdy();
	}

	add_action( 'after_setup_theme', 'illdy_boot', 15 );
}
