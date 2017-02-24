<?php

if ( ! class_exists( 'MT_Notify_System' ) ) {
	/**
	 * Class MT_Notify_System
	 */
	class MT_Notify_System {

		public static function get_plugins( $plugin_folder = '' ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			return get_plugins( $plugin_folder );
		}

		public static function _get_plugin_basename_from_slug( $slug ) {
			$keys = array_keys( MT_Notify_System::get_plugins() );

			foreach ( $keys as $key ) {
				if ( preg_match( '|^' . $slug . '/|', $key ) ) {
					return $key;
				}
			}

			return $slug;
		}

		/**
		 * @param $ver
		 *
		 * @return mixed
		 */
		public static function version_check( $ver ) {
			$illdy = wp_get_theme();

			return version_compare( $illdy['Version'], $ver, '>=' );
		}

		/**
		 * @return bool
		 */
		public static function is_not_static_page() {
			return 'page' == get_option( 'show_on_front' ) ? true : false;
		}

		/**
		 * @return bool
		 */
		public static function has_widgets() {
			if ( ! is_active_sidebar( 'homepage-slider' ) && ! is_active_sidebar( 'content-area' ) ) {
				return false;
			}

			return true;
		}

		/**
		 * @return bool
		 */
		public static function illdy_has_posts() {
			$args  = array( "s" => 'Gary Johns: \'What is Aleppo\'' );
			$query = get_posts( $args );

			if ( ! empty( $query ) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function has_content() {
			$check = array(
				'widgets' => self::has_widgets(),
				'posts'   => self::illdy_has_posts(),
			);

			if ( $check['widgets'] && $check['posts'] ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function check_wordpress_importer() {
			if ( file_exists( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				return is_plugin_active( 'wordpress-importer/wordpress-importer.php' );
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function check_plugin_is_installed( $slug ) {
			$plugin_path = MT_Notify_System::_get_plugin_basename_from_slug( $slug );
			if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_path ) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function check_plugin_is_active( $slug ) {
			$plugin_path = MT_Notify_System::_get_plugin_basename_from_slug( $slug );
			if ( file_exists( ABSPATH . 'wp-content/plugins/' .$plugin_path ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				return is_plugin_active( $plugin_path );
			}
		}

		public static function has_import_plugin( $slug = NULL ) {
			$return = self::has_content();

			if ( $return ) {
				return true;
			}
			$check = array(
				'installed' => self::check_plugin_is_installed( $slug ),
				'active'    => self::check_plugin_is_active( $slug )
			);

			if ( ! $check['installed'] || ! $check['active'] ) {
				return false;
			}

			return true;
		}

		public static function check_plugin_need_update( $slug ) {

			$update_plugin_transient = get_site_transient('update_plugins');

			if ( isset($update_plugin_transient->response) ) {
				$plugins = $update_plugin_transient->response;

				foreach ( $plugins as $key => $plugin ) {
					if ( preg_match( '|^' . $slug . '/|', $key ) ) {
						return false;
					}
				}
			}

			return true;

		}

		public static function check_plugin_update( $slug ) {

			$check = array(
				'installed' => self::check_plugin_is_installed( $slug ),
				'active'    => self::check_plugin_is_active( $slug ),
				'update'	=> self::check_plugin_need_update( $slug )
			);

			if ( ! $check['installed'] || ! $check['active'] || ! $check['update'] ) {
				return false;
			}

			return true;

		}

		public static function has_import_plugins() {
			$check = array(
				'wordpress-importer'       => array( 'installed' => false, 'active' => false ),
				'widget-importer-exporter' => array( 'installed' => false, 'active' => false )
			);

			$content = self::has_content();
			$return  = false;
			if ( $content ) {
				return true;
			}

			$stop = false;
			foreach ( $check as $plugin => $val ) {
				if ( $stop ) {
					continue;
				}

				$check[ $plugin ]['installed'] = self::check_plugin_is_installed( $plugin );
				$check[ $plugin ]['active']    = self::check_plugin_is_active( $plugin );

				if ( ! $check[ $plugin ]['installed'] || ! $check[ $plugin ]['active'] ) {
					$return = true;
					$stop   = true;
				}

			}

			return $return;
		}

		public static function widget_importer_exporter_title() {
			$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
			if ( ! $installed ) {
				return __( 'Install: Widget Importer Exporter Plugin', 'illdy' );
			}

			$active = self::check_plugin_is_active( 'widget-importer-exporter' );
			if ( $installed && ! $active ) {
				return __( 'Activate: Widget Importer Exporter Plugin', 'illdy' );
			}

			return __( 'Install: Widget Importer Exporter Plugin', 'illdy' );
		}

		public static function wordpress_importer_title() {
			$installed = self::check_plugin_is_installed( 'wordpress-importer' );
			if ( ! $installed ) {
				return __( 'Install: WordPress Importer', 'illdy' );
			}

			$active = self::check_plugin_is_active( 'wordpress-importer' );
			if ( $installed && ! $active ) {
				return __( 'Activate: WordPress Importer', 'illdy' );
			}

			return __( 'Install: WordPress Importer', 'illdy' );
		}

		/**
		 * @return string
		 */
		public static function wordpress_importer_description() {
			$installed = self::check_plugin_is_installed( 'wordpress-importer' );
			if ( ! $installed ) {
				return __( 'Please install the WordPress Importer to create the demo content.', 'illdy' );
			}

			$active = self::check_plugin_is_active( 'wordpress-importer' );
			if ( $installed && ! $active ) {
				return __( 'Please activate the WordPress Importer to create the demo content.', 'illdy' );
			}

			return __( 'Please install the WordPress Importer to create the demo content.', 'illdy' );
		}

		public static function widget_importer_exporter_description() {
			$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
			if ( ! $installed ) {
				return __( 'Please install the WordPress widget importer to create the demo content', 'illdy' );
			}

			$active = self::check_plugin_is_active( 'widget-importer-exporter' );
			if ( $installed && ! $active ) {
				return __( 'Please activate the WordPress Widget Importer to create the demo content.', 'illdy' );
			}

			return __( 'Please install the WordPress widget importer to create the demo content', 'illdy' );

		}

		public static function create_plugin_requirement_title( $install_text, $activate_text, $plugin_slug ){

			if ( $plugin_slug == '' ) {
				return;
			}
			if ( $install_text == '' && $activate_text = '' ) {
				return;
			}
			if ( $install_text == '' &&  $activate_text != '' ) {
				$install_text = $activate_text;
			}elseif ( $activate_text == '' &&  $install_text != '' ) {
				$activate_text = $install_text;
			}

			$installed = self::check_plugin_is_installed( $plugin_slug );
			if ( ! $installed ) {
				return $install_text;
			}elseif ( ! self::check_plugin_is_active( $plugin_slug ) && $installed ) {
				return $activate_text;
			}else{
				return '';
			}

		}

		public static function create_plugin_title( $plugin_title, $plugin_slug ){
			$installed = self::check_plugin_is_installed( $plugin_slug );
			if ( ! $installed ) {
				return __( 'Install : ', 'illdy' ).$plugin_title;
			}elseif ( ! self::check_plugin_is_active( $plugin_slug ) && $installed ) {
				return __( 'Activate : ', 'illdy' ).$plugin_title;
			}else{
				return __( 'Update : ', 'illdy' ).$plugin_title;
			}
		}

		/**
		 * @return bool
		 */
		public static function is_not_template_front_page() {
			$page_id = get_option( 'page_on_front' );

			return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
		}
	}
}