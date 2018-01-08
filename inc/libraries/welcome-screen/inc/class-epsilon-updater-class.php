<?php
/**
 * Epsilon Theme Updater Class
 *
 * @package Epsilon Framework
 * @since   1.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Updater_Class
 */
class Epsilon_Updater_Class {
	/**
	 * Remote API URL, from where to retrieve info about the product
	 *
	 * @var string
	 */
	private $remote_api_url;
	/**
	 * Data that should be sent over the api
	 *
	 * @var array
	 */
	private $request_data;
	/**
	 * Response Key
	 *
	 * @var string
	 */
	private $response_key;
	/**
	 * Theme slug ( identifier )
	 *
	 * @var string
	 */
	private $theme_slug;
	/**
	 * Theme name
	 *
	 * @var string
	 */
	private $item_name;
	/**
	 * License key ( added in the registration tab )
	 *
	 * @var string
	 */
	private $license;
	/**
	 * Current version of the product
	 *
	 * @var string
	 */
	private $version;
	/**
	 * Product Author
	 *
	 * @var string
	 */
	private $author;
	/**
	 * Array of language strings
	 *
	 * @var array
	 */
	protected $strings = array();

	/**
	 * Epsilon_Updater_Class constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$theme = wp_get_theme();

		$defaults = array(
			'remote_api_url' => $theme->get( 'AuthorURI' ),
			'request_data'   => array(),
			'theme_slug'     => $theme->get( 'TextDomain' ),
			'item_name'      => $theme->get( 'Name' ),
			'license'        => '',
			'version'        => $theme->get( 'Version' ),
			'author'         => $theme->get( 'Author' ),
		);

		$args = wp_parse_args( $args, $defaults );

		$this->license        = $args['license'];
		$this->item_name      = $args['item_name'];
		$this->version        = $args['Version'];
		$this->theme_slug     = $args['theme_slug'];
		$this->remote_api_url = $args['remote_api_url'];
		$this->author         = $args['author'];
		$this->request_data   = $args['request_data'];
		$this->response_key   = $this->theme_slug . '-update-response';
		$this->strings        = EDD_Theme_Helper::get_strings();

		add_filter( 'site_transient_update_themes', array( $this, 'product_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( $this, 'delete_product_update_transient' ) );
		add_action( 'load-update-core.php', array( $this, 'delete_product_update_transient' ) );
		add_action( 'load-themes.php', array( $this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( $this, 'load_themes_screen' ) );
	}

	/**
	 * Check for a theme update
	 *
	 * @return array|bool
	 */
	public function check_for_update() {
		$update_data = get_transient( $this->response_key );
		if ( false === $update_data ) {
			$failed = false;

			$api_params = array(
				'edd_action' => 'get_version',
				'license'    => $this->license,
				'name'       => $this->item_name,
				'slug'       => $this->theme_slug,
				'author'     => $this->author,
			);

			$response = wp_remote_post(
				$this->remote_api_url, array(
					'timeout' => 30,
					'body'    => $api_params,
				)
			);

			// Make sure the response was successful.
			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// If the response failed, try again in 30 minutes.
			if ( $failed ) {
				$data              = new stdClass;
				$data->new_version = $this->version;
				set_transient( $this->response_key, $data, strtotime( '+30 minutes' ) );

				return false;
			}

			// If the status is 'ok', return the update arguments.
			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );
				set_transient( $this->response_key, $update_data, strtotime( '+12 hours' ) );
			}
		}// End if().

		if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}

	/**
	 * Update product transient
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public function product_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}

		return $value;
	}

	/**
	 * Delete product transient
	 */
	public function delete_product_update_transient() {
		delete_transient( $this->response_key );
	}

	/**
	 * Add a notice in the backend
	 */
	public function load_themes_screen() {
		add_thickbox();
		add_action( 'admin_notices', array( $this, 'update_nag' ) );
	}

	/**
	 * Add the notice to update theme
	 */
	public function update_nag() {

		$theme        = wp_get_theme( $this->theme_slug );
		$api_response = get_transient( $this->response_key );

		if ( false === $api_response ) {
			return;
		}

		$update_url     = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . rawurlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( $this->strings['update-notice'] ) . '\') ) {return true;}return false;"';

		if ( version_compare( $this->version, $api_response->new_version, '<' ) ) {

			echo '<div id="update-nag">';
			printf(
				$this->strings['update-available'],
				$theme->display( 'Name', false ),
				$api_response->new_version,
				'#TB_inline?width=640&amp;inlineId=' . esc_attr( $this->theme_slug ) . '_changelog',
				$theme->display( 'Name', false ),
				$update_url,
				$update_onclick
			);
			echo '</div>';
			echo '<div id="' . esc_attr( $this->theme_slug ) . '_changelog" style="display:none;">';
			echo wpautop( $api_response->sections['changelog'] );
			echo '</div>';
		}
	}
}
