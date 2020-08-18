<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * @since 1.1.0
 * Class Epsilon_Helper
 */
class Epsilon_Helper {
	/**
	 * Generate an edit shortcut for the frontend sections
	 */
	public static function generate_pencil( $class_name = '', $section_type = '' ) {
		$sections = $class_name::get_instance();
		if ( ! isset( $sections->sections[ $section_type ] ) ) {
			return '';
		}

		if ( ! is_customize_preview() ) {
			return '';
		}

		if ( isset( $sections->sections[ $section_type ]['customization'] ) && ! $sections->sections[ $section_type ]['customization']['enabled'] ) {
			return '<a href="#" class="epsilon-section-editor"><span class="dashicons dashicons-edit"></span></a>';
		}

		$customization = array(
			'regular' => true,
			'styling' => ! empty( $sections->sections[ $section_type ]['customization']['styling'] ),
			'layout'  => ! empty( $sections->sections[ $section_type ]['customization']['layout'] ),
			'colors'  => ! empty( $sections->sections[ $section_type ]['customization']['colors'] ),
		);

		$icons = array(
			'regular' => 'edit',
			'layout'  => 'layout',
			'colors'  => 'admin-appearance',
			'styling' => 'admin-customizer',
		);

		$customization = array_filter( $customization );

		$html = '<div class="epsilon-pencil-button-group">';
		foreach ( $customization as $k => $v ) {
			$html .= '<a href="#" data-focus="' . $k . '"><span class="dashicons dashicons-' . $icons[ $k ] . '"></span></a>';
		}
		$html .= '</div>';

		return $html;
	}

	/**
	 * Allowed kses
	 *
	 * @return array
	 */
	public static function allowed_kses_pencil() {
		return array(
			'div'  => array(
				'class' => true,
			),
			'a'    => array(
				'class'      => true,
				'data-focus' => true,
				'href'       => true,
			),
			'span' => array(
				'class' => true,
			)
		);
	}

	/**
	 * Function that retrieves image sizes defined in theme
	 *
	 * @return array
	 */
	public static function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}

	/**
	 * Format a CSS string used in the section repeater template
	 */
	public static function get_css_string( $fields ) {
		$css        = '';
		$translator = array(
			'topleft'     => 'top left',
			'top'         => 'top',
			'topright'    => 'top right',
			'left'        => 'left',
			'center'      => 'center',
			'right'       => 'right',
			'bottomleft'  => 'bottom left',
			'bottom'      => 'bottom',
			'bottomright' => 'bottom right',
		);

		foreach ( $fields as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}
			switch ( $key ) {
				case 'background-image':
					$css .= $key . ': url(' . esc_url( $value ) . ');';
					break;
				case 'background-position':
					$css .= $key . ': ' . esc_attr( isset( $translator[ $value ] ) ? $translator[ $value ] : 'center' ) . ';';
					break;
				case 'background-size':
					$css .= $key . ': ' . esc_attr( $value ) . ';';
					break;
				case 'background-color':
					$css .= $key . ':' . esc_attr( $value ) . ';';
					break;
				default:
					$css .= '';
					break;
			}
		}

		return $css;
	}

	/**
	 * Gets an image with custom dimensions
	 */
	public static function get_image_with_custom_dimensions( $control = '' ) {
		$decoded = json_decode( get_theme_mod( $control, '{}' ), true );
		if ( empty( $decoded ) ) {
			return the_custom_logo();
		}

		$associated_image = get_theme_mod( $decoded['linked_control'], false );

		if ( ! $associated_image ) {
			return;
		}

		$image_alt = get_post_meta( $associated_image, '_wp_attachment_image_alt', true );
		$attr      = array(
			'class'    => '',
			'itemprop' => '',
		);

		if ( empty( $image_alt ) ) {
			$attr['alt'] = get_bloginfo( 'name', 'display' );
		}

		if ( 'custom_logo' === $decoded['linked_control'] ) {
			$attr['class']    = 'custom-logo logo';
			$attr['itemprop'] = 'logo';

			$image = wp_get_attachment_image_src( $associated_image, 'full' );

			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url"><img src="%2$s" alt="' . $attr['alt'] . '" itemprop="logo" width="' . $decoded['width'] . '" height="' . $decoded['height'] . ' "/></a>',
				esc_url( home_url( '/' ) ),
				$image[0]
			);
		}

		echo $html;
	}
}
