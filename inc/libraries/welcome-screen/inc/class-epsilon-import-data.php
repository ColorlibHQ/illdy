<?php
/**
 * Epsilon Import Data Class
 *
 * @package Illdy
 * @since   1.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Import_Data
 */
class Epsilon_Import_Data {
	/**
	 * Array of plugins to register
	 *
	 * @var array
	 */
	public $plugins = array();
	/**
	 * Array of content to register
	 *
	 * @var array
	 */
	public $content = array();
	/**
	 * Array of sections to register
	 *
	 * @var array
	 */
	public $sections = array();
	/**
	 * Array of options to register
	 *
	 * @var array
	 */
	public $options = array();
	/**
	 * Array of widgets
	 *
	 * @var array
	 */
	public $widgets = array();
	/**
	 * How to import content, save as post meta or through theme mods
	 *
	 * @var string
	 */
	public $mode = 'post_meta';
	/**
	 * Slug of the demo, will default to "standard"
	 *
	 * @var string
	 */
	public $slug = 'standard';
	/**
	 * All demo slugs, so we can build our HTML
	 *
	 * @var array
	 */
	public $all_slugs = array();

	/**
	 * Epsilon_Import_Data constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$this->handle_json();
	}

	/**
	 * @param array $args
	 *
	 * @return Epsilon_Import_Data
	 */
	public static function get_instance( $args = array() ) {
		static $inst;
		if ( ! $inst ) {
			$inst = new Epsilon_Import_Data( $args );
		}

		return $inst;
	}

	/**
	 * Get the JSON, Parse IT and figure out content
	 *
	 * @param string $path
	 *
	 * @return bool|array|mixed
	 */
	public function handle_json( $path = '' ) {
		if ( empty( $path ) ) {
			$path = dirname( dirname( __FILE__ ) ) . '/data/demo.json';
		}

		if ( ! file_exists( $path ) ) {
			return false;
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$json = $wp_filesystem->get_contents( $path );
		$json = json_decode( $json, true );

		/**
		 * In case the json could not be decoded, we return a new stdClass
		 */
		if ( null === $json ) {
			return false;
		}

		return $this->_parse_json( $json );
	}

	/**
	 * Build our object
	 *
	 * @param $json
	 *
	 * @return bool
	 */
	private function _parse_json( $json ) {
		foreach ( $json as $k => $v ) {
			$this->all_slugs[] = $k;
			foreach ( $v as $type => $content ) {
				$this->{$type}[ $k ] = $content;

				$this->check_content( $type, $k );
			}
		}

		return true;
	}

	/**
	 * @param $type
	 * @param $id
	 */
	private function check_content( $type, $id ) {
		foreach ( $this->{$type}[ $id ] as $index => $data ) {
			if ( ! is_array( $data ) ) {
				continue;
			}

			if ( ! isset( $data['content'] ) ) {
				continue;
			}

			if ( ! is_array( $data['content'] ) ) {
				continue;
			}

			foreach ( $data['content'] as $k => $v ) {
				if ( ! is_array( $v ) ) {
					if ( false !== strpos( $k, '_image' ) || ( false !== strpos( $k, '_background' ) && false === strpos( $k, '_color' ) ) ) {
						$this->{$type}[ $id ][ $index ]['content'][ $k ] = get_template_directory_uri() . $v;
					}

					continue;
				}

				foreach ( $v as $fid => $fields ) {
					if ( false !== strpos( $fid, '_image' ) || false !== strpos( $fid, '_background' ) ) {
						$this->{$type}[ $id ][ $index ]['content'][ $k ][ $fid ] = get_template_directory_uri() . $fields;
					}
				}
			}
		}
	}

	/**
	 * Build the HTML Container
	 */
	public function generate_import_data_container() {
		$html  = '<p><a class="button button-primary epsilon-ajax-button" id="add_default_sections" href="#">' . __( 'Import Demo Content', 'epsilon-framework' ) . '</a>';
		$html .= '<a class="button epsilon-hidden-content-toggler" href="#" data-toggle="welcome-hidden-content">' . __( 'Advanced', 'epsilon-framework' ) . '</a></p>';
		$html .= '<div class="import-content-container" id="welcome-hidden-content">';

		foreach ( $this->all_slugs as $demo_slug ) {
			$html .= '<div class="demo-content-container" data-slug="' . esc_attr( $demo_slug ) . '" >';
			if ( defined( 'WPCF7_VERSION' ) ) {
				unset( $this->plugins[ $demo_slug ]['contact-form-7'] );
			}
			if ( ! empty( $this->plugins[ $demo_slug ] ) ) {
				$html .= '<div class="checkbox-group">';
				$html .= '<h4>' . __( 'Plugins', 'epsilon-framework' ) . '</h4>';
				foreach ( $this->plugins[ $demo_slug ] as $k => $v ) {
					$html .= $this->generate_checkbox( $k, 'plugins', $v );
				}
				$html .= '</div>';
			}

			if ( ! empty( $this->content[ $demo_slug ] ) ) {
				$html .= '<div class="checkbox-group">';
				$html .= '<h4>' . __( 'Content', 'illdy' ) . '</h4>';
				foreach ( $this->content[ $demo_slug ] as $k => $v ) {
					$html .= $this->generate_checkbox( $k, 'content', $v['label'] );
				}
				$html .= '</div>';
			}

			if ( ! empty( $this->sections[ $demo_slug ] ) ) {
				$html .= '<div class="checkbox-group">';
				$html .= '<h4>' . __( 'Sections', 'illdy' ) . '</h4>';
				foreach ( $this->sections[ $demo_slug ] as $k => $v ) {
					$html .= $this->generate_checkbox( $k, 'sections', $v['label'] );
				}
				$html .= '</div>';
			}

			if ( ! empty( $this->widgets[ $demo_slug ] ) ) {
				$html .= '<div class="checkbox-group">';
				$html .= '<h4>' . __( 'Widgets', 'illdy' ) . '</h4>';
				foreach ( $this->widgets[ $demo_slug ] as $k => $v ) {
					foreach ( $v as $id => $props ) {
						$html .= $this->generate_checkbox( $k . '|' . $id, 'widgets', $props['title'] );
					}
				}
				$html .= '</div>';
			}

			if ( ! empty( $this->options[ $demo_slug ] ) ) {
				$html .= '<div class="checkbox-group">';
				$html .= '<h4>' . __( 'Frontpage settings', 'illdy' ) . '</h4>';
				foreach ( $this->options[ $demo_slug ] as $k => $v ) {
					$html .= $this->generate_checkbox( $k, 'options', $v['label'] );
				}
				$html .= '</div>';
			}
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Generate HTML for a checkbox
	 *
	 * @param $id
	 * @param index
	 * @param $label
	 *
	 * @return string
	 */
	private function generate_checkbox( $id, $index, $label ) {
		$string = '<label><input checked data-slug="%1$s" type="checkbox" class="demo-checkboxes" value="%1$s" name="%2$s"/>%3$s</label>';

		return sprintf( $string, $id, $index, $label );
	}

	/**
	 * Check if we have a static page
	 */
	public function check_static_page() {
		$front = get_option( 'show_on_front' );
		if ( 'posts' === $front ) {
			update_option( 'show_on_front', 'page' );
			$id = wp_insert_post(
				array(
					'post_title'  => __( 'Homepage', 'epsilon-framework' ),
					'post_type'   => 'page',
					'post_status' => 'publish',
				)
			);
			update_option( 'page_on_front', $id );
		}

		return 'ok';
	}

	/**
	 * Upload custom logo image
	 *
	 * @param $image
	 *
	 * @return int|object|void
	 */
	public function upload_logo( $image ) {
		$logo = get_theme_mod( 'custom_logo', false );
		/**
		 * If there is a logo, don`t overwrite it
		 */
		if ( false !== $logo ) {
			return;
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/post.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$tmp = download_url( get_template_directory_uri() . $image );

		$file = array(
			'name'     => basename( 'machothemes-logo' . rand( 1, 123123123 ) ) . '.png',
			'tmp_name' => $tmp,
		);

		if ( is_wp_error( $tmp ) ) {
			unlink( $file['tmp_name'] );

			return $tmp;
		}

		$id = media_handle_sideload( $file, 0, 'Custom Logo' );

		if ( is_wp_error( $id ) ) {
			unlink( $file['tmp_name'] );

			return $id;
		}

		set_theme_mod( 'custom_logo', $id );
	}

	/**
	 * Add the predefined sections automatically
	 *
	 * @param string $args JSON String
	 *
	 * @return string
	 *
	 * @todo receive "argument" with demo slug and import accordingly
	 */
	public static function add_default_sections( $args = '' ) {
		$arr      = array();
		$instance = self::get_instance();

		foreach ( $args as $type => $what ) {
			switch ( $type ) {
				case 'sections':
					$temp = $instance->add_theme_sections( $what );
					break;
				case 'content':
					$temp = $instance->add_theme_content( $what );
					break;
				case 'options':
					$temp = $instance->add_theme_options( $what );
					break;
				case 'widgets':
					$temp = $instance->add_theme_widgets( $what );
					break;
				default:
					$temp = null;
					break;
			}
			$arr[ $type ] = $temp;
		}

		return 'ok';
	}

	/**
	 * Add default widgets
	 *
	 * @param $what
	 *
	 * @return string
	 */
	public function add_theme_widgets( $what ) {
		$import = array();
		foreach ( $what as $widget ) {
			$temp = explode( '|', $widget );
			if ( 2 === count( $temp ) ) {
				$import[ $temp[0] ] = $temp[1];
			}
		}

		global $wp_registered_sidebars;

		foreach ( $import as $sidebar => $widget ) {
			$widget_type = preg_replace( '/-[0-9]+$/', '', $widget );
			$widget_id   = str_replace( $widget_type . '-', '', $widget );

			$prop = array(
				'available'            => false,
				'sidebar_id'           => 'wp_inactive_widgets',
				'sidebar_message_type' => 'error',
			);

			if ( isset( $wp_registered_sidebars[ $sidebar ] ) ) {
				$prop['available']            = true;
				$prop['sidebar_id']           = $sidebar;
				$prop['sidebar_message_type'] = 'success';
			}

			$widget_instance   = get_option( 'widget_' . $widget_type );
			$widget_instance   = ! empty( $widget_instance ) ? $widget_instance : array( '_multiwidget' => 1 );
			$widget_instance[] = $this->widgets[ $this->slug ][ $sidebar ][ $widget ];

			// Get the key it was given.
			end( $widget_instance );
			$new_id = key( $widget_instance );

			if ( '0' === strval( $new_id ) ) {
				$new_id = 1;

				$widget_instance[ $new_id ] = $widget_instance[0];
				unset( $widget_instance[0] );
			}

			if ( isset( $widget_instance['_multiwidget'] ) ) {
				$multiwidget = $widget_instance['_multiwidget'];
				unset( $widget_instance['_multiwidget'] );
				$widget_instance['_multiwidget'] = $multiwidget;
			}

			// Update option with new widget.
			update_option( 'widget_' . $widget_type, $widget_instance );

			$sidebars_widgets = get_option( 'sidebars_widgets' );
			if ( ! $sidebars_widgets ) {
				$sidebars_widgets = array();
			}

			$new_instance_id = $widget_type . '-' . $new_id;

			// Add new instance to sidebar.
			$sidebars_widgets[ $prop['sidebar_id'] ][] = $new_instance_id;
			// Save the amended data.
			update_option( 'sidebars_widgets', $sidebars_widgets );
		}

		return 'ok';
	}

	/**
	 * Add default options
	 *
	 * @param $what
	 *
	 * @return string
	 */
	public function add_theme_options( $what ) {
		$import = array();

		foreach ( $what as $id ) {
			if ( 'frontpage' === $id ) {
				$this->check_static_page();
				continue;
			}

			if ( 'logo' === $id ) {
				if ( isset( $this->options[ $this->slug ][ $id ] ) ) {
					$this->upload_logo( $this->options[ $this->slug ][ $id ]['content'] );
				}

				continue;
			}

			if ( isset( $this->options[ $this->slug ][ $id ] ) ) {
				$import[ $this->options[ $this->slug ][ $id ]['setting'] ] = $this->options[ $this->slug ][ $id ]['content'];
			}
		}

		foreach ( $import as $k => $v ) {
			set_theme_mod( $k, $v );
		}

		return 'ok';
	}

	/**
	 * Imports selected sections
	 *
	 * @todo later on, when we`ll move away from the "DRAFT PAGE" we need to modify
	 *       Epsilon_Content_Backup::get_instance()->setting_page,
	 *
	 * @param $what
	 *
	 * @return string
	 */
	public function add_theme_sections( $what ) {
		$import  = array();
		$setting = '';
		foreach ( $what as $id ) {
			if ( isset( $this->sections[ $this->slug ][ $id ] ) ) {
				$import[] = $this->sections[ $this->slug ][ $id ]['content'];
				$setting  = $this->sections[ $this->slug ][ $id ]['setting'];
			}
		}

		/**
		 * Determine if we're saving theme options in post meta or in theme mods
		 */
		if ( 'post_meta' === $this->mode ) {
			update_post_meta(
				Epsilon_Content_Backup::get_instance()->setting_page,
				$setting, array(
					$setting => $import,
				)
			);

			return 'ok';
		}

		set_theme_mod( $setting, $import );

		return 'ok';
	}

	/**
	 * Import sample content
	 *
	 * @todo later on, when we`ll move away from the "DRAFT PAGE" we need to modify
	 *       Epsilon_Content_Backup::get_instance()->setting_page,
	 */
	public function add_theme_content( $what ) {
		$import = array();
		foreach ( $what as $id ) {
			if ( isset( $this->content[ $this->slug ][ $id ] ) ) {
				$import[ $this->content[ $this->slug ][ $id ]['setting'] ] = $this->content[ $this->slug ][ $id ]['content'];
			}
		}

		/**
		 * Determine if we're saving theme options in post meta or in theme mods
		 */
		if ( 'post_meta' === $this->mode ) {
			foreach ( $import as $k => $v ) {
				update_post_meta(
					Epsilon_Content_Backup::get_instance()->setting_page,
					$k, array(
						$k => $v,
					)
				);
			}

			return 'ok';
		}

		foreach ( $import as $k => $v ) {
			set_theme_mod( $k, $v );
		}

		return 'ok';
	}
}
