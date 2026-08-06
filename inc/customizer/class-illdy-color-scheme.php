<?php
/**
 * Colour scheme output.
 *
 * Replaces Epsilon_Color_Scheme. Reads the same five `epsilon_*_color` theme mods and
 * feeds them, in the same order, through the same printf template
 * (layout/css/style-overrides.css), so an existing site produces byte-identical CSS.
 *
 * The setting ids deliberately keep their `epsilon_` prefix: they are what customer
 * sites already have stored, and renaming them would silently discard saved colours.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Color_Scheme' ) ) {

	class Illdy_Color_Scheme {

		/**
		 * Stylesheet handle the generated CSS is attached to.
		 *
		 * @var string
		 */
		protected $handler;

		/**
		 * Setting id => default colour. Order defines the %1$s..%5$s slots in the
		 * printf template, so it must not be reordered.
		 *
		 * @var array
		 */
		protected $options = array();

		/**
		 * Control definitions, keyed by setting id.
		 *
		 * @var array
		 */
		protected $controls = array();

		/**
		 * The printf template read from style-overrides.css.
		 *
		 * @var string
		 */
		protected $css = '';

		/**
		 * @param string $handler  Stylesheet handle to attach inline CSS to.
		 * @param array  $args     'fields' => control definitions, 'css' => template.
		 */
		public function __construct( $handler, $args ) {
			$this->handler  = $handler;
			$this->css      = isset( $args['css'] ) ? $args['css'] : '';
			$this->controls = isset( $args['fields'] ) ? (array) $args['fields'] : array();

			foreach ( $this->controls as $id => $props ) {
				$this->options[ $id ] = isset( $props['default'] ) ? $props['default'] : '';
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'customize_register', array( $this, 'register' ) );
		}

		/**
		 * Reads the stored colours, falling back to each default.
		 *
		 * @return array
		 */
		public function get_colors() {
			$colors = array();

			foreach ( $this->options as $id => $default ) {
				$value         = sanitize_hex_color( get_theme_mod( $id, $default ) );
				$colors[ $id ] = $value ? $value : $default;
			}

			return $colors;
		}

		/**
		 * Builds the stylesheet.
		 *
		 * Returns an empty string when every colour still equals its default, matching
		 * the previous behaviour of emitting no inline CSS for an untouched site.
		 *
		 * @return string
		 */
		public function generate_css() {
			if ( '' === $this->css ) {
				return '';
			}

			$colors = $this->get_colors();

			if ( $colors === $this->options ) {
				return '';
			}

			return vsprintf( $this->css, array_values( $colors ) );
		}

		/**
		 * Attaches the generated CSS to the theme stylesheet.
		 */
		public function enqueue() {
			$css = $this->generate_css();

			if ( '' !== $css ) {
				wp_add_inline_style( $this->handler, $css );
			}
		}

		/**
		 * Registers one core colour control per field.
		 *
		 * @param WP_Customize_Manager $wp_customize Customizer manager.
		 */
		public function register( $wp_customize ) {
			foreach ( $this->controls as $id => $props ) {
				$wp_customize->add_setting(
					$id, array(
						'default'           => isset( $props['default'] ) ? $props['default'] : '',
						'sanitize_callback' => 'sanitize_hex_color',
						'transport'         => 'postMessage',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize, $id, array(
							'label'       => isset( $props['label'] ) ? $props['label'] : $id,
							'description' => isset( $props['description'] ) ? $props['description'] : '',
							'section'     => isset( $props['section'] ) ? $props['section'] : 'colors',
						)
					)
				);
			}
		}

		/**
		 * Reads the printf template shipped with the theme.
		 *
		 * @param string $path Absolute path to the template.
		 *
		 * @return string
		 */
		public static function load_css_overrides( $path ) {
			if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
				return '';
			}

			$contents = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- reading a file bundled with the theme.

			return is_string( $contents ) ? $contents : '';
		}
	}
}
