<?php
/**
 * Backwards-compatibility shims for the removed onboarding subsystem.
 *
 * Illdy 2.3.0 removed the Epsilon Framework, the Recommended Actions Customizer section
 * and the framework's welcome screen. None of that held user content: the front page is
 * built from widgets and theme mods, both untouched. What it did hold was a handful of
 * public class names that a child theme or a snippet might still reference, so those
 * keep resolving here instead of fataling.
 *
 * The About Illdy screen itself still exists, rebuilt on core admin markup — see
 * inc/admin/class-illdy-welcome.php. Only the Epsilon implementation is gone.
 *
 * Every method below is either a no-op or a thin wrapper over a core function. They
 * exist so nobody's site white-screens on update; nothing new should call them.
 *
 * Loaded from functions.php rather than from the Customizer bootstrap because the
 * originals were available on every admin request, not just `customize_register`.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'illdy_deprecated_onboarding' ) ) {
	/**
	 * Emits a deprecation notice for a removed onboarding class.
	 *
	 * @param string $old         Removed class/method name.
	 * @param string $replacement What to do instead.
	 */
	function illdy_deprecated_onboarding( $old, $replacement = '' ) {
		_deprecated_function( esc_html( $old ), '2.3.0', esc_html( $replacement ) );
	}
}

if ( ! class_exists( 'Epsilon_Framework' ) ) {
	/**
	 * The framework bootstrap. Nothing is left for it to boot.
	 */
	class Epsilon_Framework {
		public function __construct( $args = array() ) {
			illdy_deprecated_onboarding( __CLASS__ );
		}

		public function init_controls( $wp_customize = null ) {}
	}
}

if ( ! class_exists( 'Epsilon_Ajax_Controller' ) ) {
	/**
	 * Generic AJAX dispatcher. Removed: it existed only to reach the two dismiss
	 * handlers below, and a class/method dispatcher driven by request data is not
	 * something to keep around once its last caller is gone.
	 */
	class Epsilon_Ajax_Controller {
		public function __construct() {
			illdy_deprecated_onboarding( __CLASS__ );
		}
	}
}

if ( ! class_exists( 'Epsilon_Notifications' ) ) {
	/**
	 * Rendered the "Welcome to Illdy" admin notice. Removed with the welcome screen.
	 */
	class Epsilon_Notifications {
		public static function get_instance() {
			illdy_deprecated_onboarding( __CLASS__ );

			static $inst;
			if ( null === $inst ) {
				$inst = new self();
			}

			return $inst;
		}

		public function add_notice( $args = array() ) {}

		public static function dismiss_notice( $args = array() ) {
			return 'ok';
		}
	}
}

if ( ! class_exists( 'Epsilon_Sanitizers' ) ) {
	/**
	 * The one helper here that was genuinely useful, kept working rather than stubbed.
	 */
	class Epsilon_Sanitizers {
		/**
		 * Applies a callback to every scalar in a nested array.
		 *
		 * @param callable $callback Sanitiser.
		 * @param mixed    $value    Value or array of values.
		 *
		 * @return mixed
		 */
		public static function array_map_recursive( $callback, $value ) {
			if ( is_array( $value ) ) {
				return array_map(
					function ( $item ) use ( $callback ) {
						return Epsilon_Sanitizers::array_map_recursive( $callback, $item );
					},
					$value
				);
			}

			return call_user_func( $callback, $value );
		}
	}
}

if ( ! class_exists( 'Epsilon_Welcome_Screen' ) ) {
	/**
	 * The five-tab "About Illdy" screen. Removed.
	 *
	 * get_instance() stays callable and returns an object so chained calls degrade to
	 * no-ops instead of "call to a member function on null".
	 */
	class Epsilon_Welcome_Screen {
		public $theme_name = '';
		public $theme_slug = 'illdy';
		public $actions    = array();
		public $plugins    = array();

		public static function get_instance( $config = array() ) {
			illdy_deprecated_onboarding( __CLASS__ );

			static $inst;
			if ( null === $inst ) {
				$inst = new self();
			}

			return $inst;
		}

		public function __call( $name, $arguments ) {
			return null;
		}

		public static function __callStatic( $name, $arguments ) {
			return null;
		}
	}
}

if ( ! class_exists( 'Epsilon_Notify_System' ) ) {
	/**
	 * Plugin install/activate state helpers used by the recommended actions list.
	 *
	 * Backed by core rather than stubbed, so a stray caller still gets true answers.
	 */
	class Epsilon_Notify_System {
		public static function _get_plugin_basename_from_slug( $slug ) {
			return Illdy_Plugin_State::basename_from_slug( $slug );
		}

		public static function check_plugin_is_installed( $slug ) {
			return Illdy_Plugin_State::is_installed( $slug );
		}

		public static function check_plugin_is_active( $slug ) {
			return Illdy_Plugin_State::is_active( $slug );
		}

		public static function dismiss_required_action( $args = array() ) {
			return 'ok';
		}
	}
}

if ( ! class_exists( 'MT_Notify_System' ) ) {
	/**
	 * Colorlib's own wrapper around the same plugin-state checks.
	 *
	 * Only the state helpers are reproduced. The title/description builders it also
	 * carried produced markup for the recommended actions list and have no meaning
	 * without it, so they return plain strings.
	 */
	class MT_Notify_System {
		public static function get_plugins( $plugin_folder = '' ) {
			return Illdy_Plugin_State::all();
		}

		public static function _get_plugin_basename_from_slug( $slug ) {
			return Illdy_Plugin_State::basename_from_slug( $slug );
		}

		public static function check_plugin_is_installed( $slug ) {
			return Illdy_Plugin_State::is_installed( $slug );
		}

		public static function check_plugin_is_active( $slug ) {
			return Illdy_Plugin_State::is_active( $slug );
		}

		public static function check_plugin_update( $slug ) {
			return Illdy_Plugin_State::is_active( $slug );
		}

		public static function is_not_static_page() {
			return 'page' !== get_option( 'show_on_front' );
		}

		public static function create_plugin_title( $plugin_title, $plugin_slug ) {
			return $plugin_title;
		}

		public static function create_plugin_requirement_title( $install_text, $activate_text, $plugin_slug ) {
			return Illdy_Plugin_State::is_installed( $plugin_slug ) ? $activate_text : $install_text;
		}
	}
}
