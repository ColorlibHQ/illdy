<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * @since 1.1.0
 * Class Epsilon_Ajax_Controller
 */
class Epsilon_Ajax_Controller {
	/**
	 * Epsilon_Ajax_Controller constructor.
	 */
	public function __construct() {
		/**
		 * Action for easier AJAX handling
		 */
		add_action( 'wp_ajax_epsilon_framework_ajax_action', array(
			$this,
			'epsilon_framework_ajax_action',
		) );
	}

	/**
	 * Ajax handler
	 */
	public function epsilon_framework_ajax_action() {
		if ( !isset( $_POST['args'], $_POST['args']['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['args']['nonce'] ), 'epsilon_nonce' ) ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
					)
				)
			);
		}

		if ( ! current_user_can( 'manage_options' ) ) {
		    wp_die(
				json_encode(
					array(
						'status' => false,
						'error'  => 'Not allowed',
					)
				)
			);
		}

		$args_action = array_map( 'sanitize_text_field', wp_unslash( $_POST['args']['action'] ) );

		if ( count( $args_action ) !== 2 ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
					)
				)
			);
		}

        $class = Epsilon_Ajax_Controller::sanitize_class_name( $args_action[0] );

		if ( ! $class || ! class_exists( $class )) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Class does not exist', 'epsilon-framework' ),
					)
				)
			);
		}

		$method = $args_action[1];

		if ( ! Epsilon_Ajax_Controller::is_allowed_call( $class, $method ) ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
					)
				)
			);
		}

		if ( 'generate_partial_section' === $method ) {
			$args = array_map( 'Epsilon_Ajax_Controller::sanitize_arguments_for_output', wp_unslash( $_POST['args']['args'] ) );
		} else {
			$args = isset( $_POST['args']['args'] ) ? $_POST['args']['args'] : $_POST['args'];
			$args = array_map( 'Epsilon_Ajax_Controller::sanitize_arguments', wp_unslash( $args ) );
		}

		$response = $class::$method( $args );

		if ( is_array( $response ) ) {
			wp_die( wp_json_encode( $response ) );
		}

		if ( 'ok' === $response ) {
			wp_die(
				wp_json_encode(
					array(
						'status'  => true,
						'message' => 'ok',
					)
				)
			);
		}

		wp_die(
			wp_json_encode(
				array(
					'status'  => false,
					'message' => 'nok',
				)
			)
		);
	}

	/**
	 * Sanitize arguments
	 *
	 * @param $args
	 */
	public static function sanitize_arguments( $args ) {
		if ( is_array( $args ) ) {
			return array_map( 'sanitize_text_field', $args );
		} else {
			return sanitize_text_field( $args );
		}
	}

	/**
	 * Whether a class/method pair may be dispatched over AJAX.
	 *
	 * The class name was already checked against an allowlist, but the method was taken
	 * straight from the request, so any public static method on those classes could be
	 * reached. Pairing them removes that and turns a mistyped method into a clean error
	 * response instead of a fatal.
	 *
	 * @param string $class  Allowlisted class name.
	 * @param string $method Requested method name.
	 *
	 * @return bool
	 */
	public static function is_allowed_call( $class, $method ) {
		// Epsilon_Page_Generator and Epsilon_Typography were unused by this theme and
		// have been removed, so their entries are gone too.
		$allowed = array(
			'Epsilon_Helper'        => array( 'get_image_sizes' ),
			'Epsilon_Notifications' => array( 'dismiss_notice' ),
			'Epsilon_Notify_System' => array( 'dismiss_required_action' ),
			'Epsilon_Color_Scheme'  => array( 'epsilon_generate_color_scheme_css' ),
		);

		/**
		 * Filters the dispatchable AJAX method map.
		 *
		 * @param array $allowed Class name => list of method names.
		 */
		$allowed = apply_filters( 'epsilon_framework_allowed_ajax_methods', $allowed );

		if ( ! isset( $allowed[ $class ] ) || ! in_array( $method, $allowed[ $class ], true ) ) {
			return false;
		}

		return is_callable( array( $class, $method ) );
	}

    /**
     * Sanitize class name
     *
     * @param $args
     */
    public static function sanitize_class_name( $class ) {
        $allowed_classes = array( 'Epsilon_Helper', 'Epsilon_Notify_System', 'Epsilon_Color_Scheme', 'Epsilon_Notifications' );
        if ( in_array( $class, $allowed_classes ) ) {
            return $class;
        }else{
            return false;
        }
    }

	/**
	 * Sanitize arguments for output
	 *
	 * @param $args
	 */
	public static function sanitize_arguments_for_output( $args ) {
		if ( is_array( $args ) ) {
			return array_map( 'Epsilon_Ajax_Controller::sanitize_arguments_for_output', $args );
		} else {
			return wp_kses_post( $args );
		}
	}
}
