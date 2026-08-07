<?php
/**
 * Install / activate state for a wordpress.org plugin.
 *
 * The old welcome screen worked this out through the Epsilon framework and a second,
 * near-identical copy in MT_Notify_System. This is the single implementation both the
 * About Illdy screen and the deprecation shims use.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Plugin_State' ) ) {

	class Illdy_Plugin_State {

		/**
		 * How long plugins_api() results are cached.
		 */
		const CACHE_TTL = 12 * HOUR_IN_SECONDS;

		/**
		 * Installed plugins keyed by basename.
		 *
		 * get_plugins() lives in an admin-only file, so it is required on demand — these
		 * helpers used to be fatal when called from a front-end request.
		 *
		 * @return array
		 */
		public static function all() {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			return get_plugins();
		}

		/**
		 * @param string $slug Plugin directory slug.
		 *
		 * @return string Plugin basename, or '' when not installed.
		 */
		public static function basename_from_slug( $slug ) {
			$slug = (string) $slug;

			if ( '' === $slug ) {
				return '';
			}

			foreach ( array_keys( self::all() ) as $basename ) {
				if ( dirname( $basename ) === $slug ) {
					return $basename;
				}
			}

			return '';
		}

		/**
		 * @param string $slug Plugin directory slug.
		 *
		 * @return bool
		 */
		public static function is_installed( $slug ) {
			return '' !== self::basename_from_slug( $slug );
		}

		/**
		 * @param string $slug Plugin directory slug.
		 *
		 * @return bool
		 */
		public static function is_active( $slug ) {
			$basename = self::basename_from_slug( $slug );

			if ( '' === $basename ) {
				return false;
			}

			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			return is_plugin_active( $basename );
		}

		/**
		 * Plugin details from wordpress.org, cached.
		 *
		 * Cached in a transient because this is an HTTP request and the About screen
		 * shows several plugins at once. A failure is cached too, for a much shorter
		 * time, so an offline site does not retry on every page load.
		 *
		 * @param string $slug Plugin directory slug.
		 *
		 * @return object|false Plugin information, or false when unavailable.
		 */
		public static function info( $slug ) {
			$slug = sanitize_key( $slug );

			if ( '' === $slug ) {
				return false;
			}

			$key    = 'illdy_plugin_info_' . $slug;
			$cached = get_transient( $key );

			if ( 'unavailable' === $cached ) {
				return false;
			}

			if ( is_object( $cached ) ) {
				return $cached;
			}

			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}

			$info = plugins_api(
				'plugin_information',
				array(
					'slug'   => $slug,
					'fields' => array(
						'short_description' => true,
						'icons'             => true,
						'reviews'           => false,
						'sections'          => false,
						'banners'           => false,
						'tags'              => false,
						'versions'          => false,
					),
				)
			);

			if ( is_wp_error( $info ) || ! is_object( $info ) ) {
				set_transient( $key, 'unavailable', HOUR_IN_SECONDS );

				return false;
			}

			set_transient( $key, $info, self::CACHE_TTL );

			return $info;
		}

		/**
		 * The icon URL for a plugin, falling back to a dashicon-styled placeholder.
		 *
		 * @param object|false $info Result of self::info().
		 *
		 * @return string
		 */
		public static function icon( $info ) {
			if ( ! is_object( $info ) || empty( $info->icons ) || ! is_array( $info->icons ) ) {
				return '';
			}

			foreach ( array( 'svg', '2x', '1x', 'default' ) as $size ) {
				if ( ! empty( $info->icons[ $size ] ) ) {
					return $info->icons[ $size ];
				}
			}

			return '';
		}

		/**
		 * The install / activate action for a plugin, as core's plugin browser renders it.
		 *
		 * The returned class names are the ones wp.updates binds to, so the buttons work
		 * over AJAX without this theme shipping any JavaScript of its own.
		 *
		 * @param string $slug Plugin directory slug.
		 *
		 * @return array {
		 *     @type string $label   Button text.
		 *     @type string $url     Target, or '#' for an AJAX-handled action.
		 *     @type string $class   Button classes.
		 *     @type bool   $enabled Whether the button does anything.
		 * }
		 */
		public static function action( $slug ) {
			$basename = self::basename_from_slug( $slug );

			if ( self::is_active( $slug ) ) {
				return array(
					'label'   => __( 'Active', 'illdy' ),
					'url'     => '#',
					'class'   => 'button button-disabled',
					'enabled' => false,
				);
			}

			if ( '' !== $basename ) {
				if ( ! current_user_can( 'activate_plugins' ) ) {
					return array(
						'label'   => __( 'Installed', 'illdy' ),
						'url'     => '#',
						'class'   => 'button button-disabled',
						'enabled' => false,
					);
				}

				return array(
					'label'   => __( 'Activate', 'illdy' ),
					'url'     => wp_nonce_url(
						self_admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $basename ) ),
						'activate-plugin_' . $basename
					),
					'class'   => 'button activate-now button-primary',
					'enabled' => true,
				);
			}

			if ( ! current_user_can( 'install_plugins' ) ) {
				return array(
					'label'   => __( 'Not installed', 'illdy' ),
					'url'     => '#',
					'class'   => 'button button-disabled',
					'enabled' => false,
				);
			}

			return array(
				'label'   => __( 'Install Now', 'illdy' ),
				'url'     => wp_nonce_url(
					self_admin_url( 'update.php?action=install-plugin&plugin=' . rawurlencode( $slug ) ),
					'install-plugin_' . $slug
				),
				'class'   => 'button install-now',
				'enabled' => true,
			);
		}
	}
}
