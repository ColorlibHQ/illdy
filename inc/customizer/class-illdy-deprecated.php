<?php
/**
 * Backwards-compatibility shims for the removed Epsilon Framework classes.
 *
 * Illdy 2.2.0 replaced the Epsilon controls with core WordPress controls and a small
 * set of theme-owned ones. A child theme or snippet that still instantiates the old
 * class names keeps working through the wrappers below, and gets a deprecation notice
 * pointing at the replacement rather than a fatal error.
 *
 * These are intentionally thin. They exist so nobody's site breaks on update; new code
 * should use the Illdy_* classes or the core control types directly.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'illdy_deprecated_control' ) ) {
	/**
	 * Emits a single deprecation notice for a removed class.
	 *
	 * @param string $old Removed class name.
	 * @param string $new Suggested replacement.
	 */
	function illdy_deprecated_control( $old, $new ) {
		_deprecated_function( esc_html( $old ), '2.2.0', esc_html( $new ) );
	}
}

if ( ! class_exists( 'Epsilon_Control_Text_Editor' ) && class_exists( 'Illdy_Control_Text_Editor' ) ) {
	class Epsilon_Control_Text_Editor extends Illdy_Control_Text_Editor {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Control_Text_Editor' );
			$args['type'] = 'illdy-text-editor';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Color_Scheme' ) && class_exists( 'Illdy_Control_Color_Scheme' ) ) {
	class Epsilon_Control_Color_Scheme extends Illdy_Control_Color_Scheme {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Control_Color_Scheme' );
			$args['type'] = 'illdy-color-scheme';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Repeater' ) && class_exists( 'Illdy_Control_Repeater' ) ) {
	class Epsilon_Control_Repeater extends Illdy_Control_Repeater {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Control_Repeater' );
			$args['type'] = 'illdy-repeater';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Tab' ) && class_exists( 'Illdy_Control_Tab' ) ) {
	class Epsilon_Control_Tab extends Illdy_Control_Tab {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Control_Tab' );
			$args['type'] = 'illdy-tab';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Button' ) && class_exists( 'Illdy_Control_Button' ) ) {
	class Epsilon_Control_Button extends Illdy_Control_Button {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Control_Button' );
			$args['type'] = 'illdy-button';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Section_Pro' ) && class_exists( 'Illdy_Section_Pro' ) ) {
	class Epsilon_Section_Pro extends Illdy_Section_Pro {
		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Section_Pro' );
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Toggle' ) ) {
	/**
	 * The toggle is now a plain core checkbox, so this maps onto that.
	 */
	class Epsilon_Control_Toggle extends WP_Customize_Control {
		public $type = 'checkbox';

		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, "add_control( \$id, array( 'type' => 'checkbox' ) )" );
			$args['type'] = 'checkbox';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Control_Slider' ) ) {
	/**
	 * The slider is now a core range input; 'choices' maps onto 'input_attrs'.
	 */
	class Epsilon_Control_Slider extends WP_Customize_Control {
		public $type = 'range';

		public function __construct( $manager, $id, array $args = array() ) {
			illdy_deprecated_control( __CLASS__, "add_control( \$id, array( 'type' => 'range' ) )" );

			if ( ! empty( $args['choices'] ) && empty( $args['input_attrs'] ) ) {
				$args['input_attrs'] = $args['choices'];
			}
			unset( $args['choices'] );

			$args['type'] = 'range';
			parent::__construct( $manager, $id, $args );
		}
	}
}

if ( ! class_exists( 'Epsilon_Color_Scheme' ) && class_exists( 'Illdy_Color_Scheme' ) ) {
	class Epsilon_Color_Scheme extends Illdy_Color_Scheme {
		/**
		 * The old class was a singleton; keep that entry point working.
		 *
		 * @param string $handler Stylesheet handle.
		 * @param array  $args    Configuration.
		 *
		 * @return Illdy_Color_Scheme
		 */
		public static function get_instance( $handler = '', $args = array() ) {
			illdy_deprecated_control( __CLASS__, 'Illdy_Color_Scheme' );

			return new Illdy_Color_Scheme( $handler, $args );
		}
	}
}
