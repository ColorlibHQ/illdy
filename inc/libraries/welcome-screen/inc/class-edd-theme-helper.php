<?php
/**
 * MedZone EDD Related Theme Helpers
 *
 * @package MedZone
 * @since   1.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class EDD_Theme_Helper
 */
class EDD_Theme_Helper {
	/**
	 * Returns a translation string array
	 *
	 * @return array
	 */
	public static function get_strings() {
		return array(
			/* Translators: Registration */
			'theme-license'             => __( 'Registration', 'epsilon-framework' ),
			/* Translators: Enter Key field label */
			'enter-key'                 => __( 'Enter your theme license key.', 'epsilon-framework' ),
			/* Translators: License Key */
			'license-key'               => __( 'License Key', 'epsilon-framework' ),
			/* Translators: Action */
			'license-action'            => __( 'License Action', 'epsilon-framework' ),
			/* Translators: Deactivate License Label */
			'deactivate-license'        => __( 'Deactivate License', 'epsilon-framework' ),
			/* Translators: Activate License Label */
			'activate-license'          => __( 'Activate License', 'epsilon-framework' ),
			/* Translators: Unknown License Label */
			'status-unknown'            => __( 'License status is unknown.', 'epsilon-framework' ),
			/* Translators: Renewal Label */
			'renew'                     => __( 'Renew?', 'epsilon-framework' ),
			/* Translators: Unlimited activations */
			'unlimited'                 => __( 'unlimited', 'epsilon-framework' ),
			/* Translators: Active key */
			'license-key-is-active'     => __( 'License key is active.', 'epsilon-framework' ),
			/* Translators: expires */
			'expires%s'                 => __( 'Expires %s.', 'epsilon-framework' ),
			/* Translators: websites activated */
			'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'epsilon-framework' ),
			/* Translators: License expired*/
			'license-key-expired-%s'    => __( 'License key expired %s.', 'epsilon-framework' ),
			/* Translators: Expired License Key */
			'license-key-expired'       => __( 'License key has expired.', 'epsilon-framework' ),
			/* Translators: Match failed */
			'license-keys-do-not-match' => __( 'License keys do not match.', 'epsilon-framework' ),
			/* Translators: Inactive license */
			'license-is-inactive'       => __( 'License is inactive.', 'epsilon-framework' ),
			/* Translators: Disabled license */
			'license-key-is-disabled'   => __( 'License key is disabled.', 'epsilon-framework' ),
			/* Translators: Inactive website */
			'site-is-inactive'          => __( 'Site is inactive.', 'epsilon-framework' ),
			/* Translators: Unknown license key */
			'license-status-unknown'    => __( 'License status is unknown.', 'epsilon-framework' ),
			/* Translators: Update notice */
			'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'epsilon-framework' ),
			/* Translators: license sites, title, update link */
			'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'epsilon-framework' ),
		);
	}

	/**
	 * Initiate actions to register settings and update theme
	 */
	public static function init() {
		$instance = Epsilon_Welcome_Screen::get_instance();
		self::register_option( $instance );
		self::updater( $instance );
	}

	/**
	 * Activate or deactivate license
	 */
	public static function license_action() {
		$instance = Epsilon_Welcome_Screen::get_instance();
		if ( isset( $_POST[ $instance->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $instance->theme_slug . '_nonce', $instance->theme_slug . '_nonce' ) ) {
				self::license_activator_deactivator( 'activate_license' );
			}
		}

		if ( isset( $_POST[ $instance->theme_slug . '_license_deactivate' ] ) ) {
			if ( check_admin_referer( $instance->theme_slug . '_nonce', $instance->theme_slug . '_nonce' ) ) {
				self::license_activator_deactivator( 'deactivate_license' );
			}
		}

	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * @param object $instance Option instance.
	 */
	public static function register_option( $instance ) {
		register_setting(
			$instance->theme_slug . '-license',
			$instance->theme_slug . '_license_key',
			array(
				'EDD_Theme_Helper',
				'sanitize_license',
			)
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * @param string $new License key that was submitted.
	 *
	 * @return string $new Sanitized license key.
	 */
	public static function sanitize_license( $new ) {
		$instance = Epsilon_Welcome_Screen::get_instance();
		$old      = get_option( $instance->theme_slug . '_license_key' );

		if ( $old && $old !== $new ) {
			// New license has been entered, so must reactivate.
			delete_option( $instance->theme_slug . '_license_key_status' );
			delete_transient( $instance->theme_slug . '_license_message' );
		}

		return sanitize_text_field( $new );
	}

	/**
	 * We need to disable wporg requests at this time
	 *
	 * @param object $r   Request object.
	 * @param string $url URL String.
	 *
	 * @return mixed
	 */
	public static function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		// Decode the JSON response.
		$themes = json_decode( $r['body']['themes'] );

		// Remove the active parent and child themes from the check.
		$parent = get_option( 'template' );
		$child  = get_option( 'stylesheet' );
		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		// Encode the updated JSON response.
		$r['body']['themes'] = wp_json_encode( $themes );

		return $r;
	}

	/**
	 * Creates the theme updater class.
	 *
	 * @param object $instance Option instance.
	 */
	public static function updater( $instance ) {
		/**
		 * In case we don`t have a valid license, return here
		 */
		if ( get_option( $instance->theme_slug . '_license_key_status', false ) !== 'valid' ) {
			return;
		}

		$arr = array(
			'license' => get_option( $instance->theme_slug . '_license_key', false ),
		);

		new Epsilon_Updater_Class( $arr );
	}

	/**
	 * Returns a renewal link
	 *
	 * @return string
	 */
	public static function get_renewal_link() {
		$instance = Epsilon_Welcome_Screen::get_instance();
		$theme    = wp_get_theme();

		$license_key = trim( get_option( $instance->theme_slug . '_license_key', false ) );
		if ( '' !== $instance->download_id && $license_key ) {
			$url  = esc_url( $theme->get( 'AuthorURI' ) );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $instance->download_id;

			return $url;
		}

		// Otherwise return the remote_api_url.
		return $theme->get( 'AuthorURI' );
	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	public static function check_license() {
		$instance = Epsilon_Welcome_Screen::get_instance();
		$license  = trim( get_option( $instance->theme_slug . '_license_key' ) );
		$strings  = self::get_strings();

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => rawurlencode( $instance->theme_slug ),
			'url'        => home_url(),
		);

		$license_data = self::get_api_response( $api_params );

		// If response doesn't include license data, return.
		if ( ! isset( $license_data->license ) ) {
			$message = $strings['license-unknown'];

			return $message;
		}

		// We need to update the license status at the same time the message is updated.
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $instance->theme_slug . '_license_key_status', $license_data->license );
		}

		// Get expire date.
		$expires = false;
		if ( isset( $license_data->expires ) ) {
			$expires    = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
			$renew_link = '<a href="' . esc_url( self::get_renewal_link() ) . '" target="_blank">' . $strings['renew'] . '</a>';
		}

		// Get site counts.
		$site_count    = $license_data->site_count;
		$license_limit = $license_data->license_limit;

		// If unlimited.
		if ( 0 === $license_limit ) {
			$license_limit = $strings['unlimited'];
		}

		if ( 'valid' === $license_data->license ) {
			$message = $strings['license-key-is-active'] . ' ';
			if ( $expires ) {
				$message .= sprintf( $strings['expires%s'], $expires ) . ' ';
			}
			if ( $site_count && $license_limit ) {
				$message .= sprintf( $strings['%1$s/%2$-sites'], $site_count, $license_limit );
			}
		} elseif ( 'expired' === $license_data->license ) {
			if ( $expires ) {
				$message = sprintf( $strings['license-key-expired-%s'], $expires );
			} else {
				$message = $strings['license-key-expired'];
			}
			if ( $renew_link ) {
				$message .= ' ' . $renew_link;
			}
		} elseif ( 'invalid' === $license_data->license ) {
			$message = $strings['license-keys-do-not-match'];
		} elseif ( 'inactive' === $license_data->license ) {
			$message = $strings['license-is-inactive'];
		} elseif ( 'disabled' === $license_data->license ) {
			$message = $strings['license-key-is-disabled'];
		} elseif ( 'site_inactive' === $license_data->license ) {
			// Site is inactive.
			$message = $strings['site-is-inactive'];
		} else {
			$message = $strings['license-status-unknown'];
		}

		return $message;
	}

	/**
	 * Handles the license action.
	 *
	 * @param string $action What to do with the license.
	 */
	public static function license_activator_deactivator( $action = '' ) {
		$instance = Epsilon_Welcome_Screen::get_instance();
		$license  = trim( get_option( $instance->theme_slug . '_license_key' ) );

		if ( empty( $action ) ) {
			$action = 'activate_license';
		}

		$api_params = array(
			'edd_action' => $action,
			'license'    => $license,
			'item_name'  => rawurlencode( $instance->theme_slug ),
		);

		$license_data = self::get_api_response( $api_params );

		switch ( $action ) {
			case 'deactivate_license':
				if ( $license_data && ( 'deactivated' === $license_data->license ) ) {
					delete_option( $instance->theme_slug . '_license_key_status' );
					delete_transient( $instance->theme_slug . '_license_message' );
				}
				break;
			default:
				if ( $license_data && isset( $license_data->license ) ) {
					update_option( $instance->theme_slug . '_license_key_status', $license_data->license );
					delete_transient( $instance->theme_slug . '_license_message' );
				}
				break;
		}
	}

	/**
	 * Get a response from our website.
	 *
	 * @param array $params Configuration array.
	 *
	 * @return mixed
	 */
	public static function get_api_response( $params ) {
		$theme = wp_get_theme();

		// Call the custom API.
		$response = wp_remote_post(
			$theme->get( 'AuthorURI' ),
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $params,
			)
		);

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response;
	}
}
