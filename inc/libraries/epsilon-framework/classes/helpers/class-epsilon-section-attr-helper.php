<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Section_Attr_Helper
 */
class Epsilon_Section_Attr_Helper {
	/**
	 * Options array
	 *
	 *
	 * @var array
	 */
	public $options = array();
	/**
	 * @var null
	 */
	public $section_manager = null;


	/**
	 * Epsilon_Section_Attr_Helper constructor.
	 *
	 * @param array  $fields
	 * @param string $key
	 * @param null   $section_manager
	 */
	public function __construct( $fields = array(), $key = '', $section_manager = null ) {
		$this->key             = $key;
		$this->section_manager = $section_manager->sections;
		$this->options         = $this->set_options( $fields );
	}

	/**
	 * @param array $fields
	 */
	public function set_options( $fields = array() ) {
		$defaults = array(
			$this->key . '_background_parallax' => $this->section_manager[ $this->key ]['customization']['styling']['background-parallax']['default'],
		);

		foreach ( $this->section_manager[ $this->key ]['customization']['layout'] as $k => $v ) {
			$defaults[ $this->key . '_' . str_replace( '-', '_', $k ) ] = $v['default'];
		}

		$fields = wp_parse_args( $fields, $defaults );

		return $fields;
	}

	/**
	 * Generate attributes
	 *
	 * @param array $arr
	 */
	public function generate_attributes( $arr = array() ) {
		foreach ( $arr as $k => $v ) {
			$method = $k . '_attribute_generator';

			if ( method_exists( $this, $method ) ) {
				is_array( $v ) ? $this->$method( $v ) : $this->$method();
			}
		}
	}

	/**
	 * I know that we can't have more than one IDS on a html tag
	 *
	 * @param array $element
	 */
	public function id_attribute_generator( $element = array() ) {
		if ( empty( $element ) ) {
			return false;
		}

		echo $this->generate_attribute( 'id', $element );
	}

	/**
	 * @param array $element
	 */
	public function class_attribute_generator( $element = array() ) {
		$classes = array_merge( $element, $this->generate_section_class() );
		echo $this->generate_attribute( 'class', $classes );
	}

	/**
	 * Style attribute generators
	 */
	public function style_attribute_generator( $element = array() ) {
		echo $this->generate_style_attribute( 'style', $element );
	}

	/**
	 * Generates attributes based on a wrapper and its content
	 *
	 * @param string $wrap
	 * @param array  $content
	 */
	private function generate_attribute( $wrap = '', $content = array() ) {
		$css = $wrap . '="';
		$css .= esc_attr( implode( ' ', $content ) );
		$css .= '"';

		return $css;
	}

	/**
	 * Generates style attributes
	 *
	 * @param string $wrap
	 * @param array  $content
	 */
	private function generate_style_attribute( $wrap = 'style', $content = array() ) {
		if ( in_array( 'background-image', $content ) && empty( $this->options[ $this->key . '_background_image' ] ) ) {
			return '';
		}

		$css = $wrap . '="';
		foreach ( $content as $key ) {
			$option = $this->key . '_' . str_replace( '-', '_', $key );
			if ( empty( $this->options[ $option ] ) ) {
				continue;
			}

			$key = 'background-color-opacity' === $key ? 'opacity' : $key;

			$css .= 'background-image' === $key ? $key . ':url(' . esc_url( $this->options[ $option ] ) . ');' : $key . ':' . esc_attr( $this->options[ $option ] ) . ';';
		}
		$css .= '"';

		return $css;
	}

	/**
	 * Generate a set of classes to be applied on a section
	 *
	 * @param $key
	 * @param $fields
	 */
	public function generate_section_class() {
		$additional = array();

		if ( ! empty( $this->options[ $this->key . '_section_class' ] ) ) {
			$additional[] = $this->options[ $this->key . '_section_class' ];
		}
		if ( ! empty( $this->options[ $this->key . '_column_vertical_alignment' ] ) ) {
			if ($this->options[ $this->key . '_column_vertical_alignment' ] != 'top'){
				$additional[] = 'ewf-valign--' . $this->options[ $this->key . '_column_vertical_alignment' ];
			}
		}
		if ( ! empty( $this->options[ $this->key . '_column_alignment' ] ) ) {
			$additional[] = 'ewf-text-align--' . $this->options[ $this->key . '_column_alignment' ];
		}
		if ( ! empty( $this->options[ $this->key . '_row_spacing_top' ] ) ) {
			$additional[] = 'ewf-section--spacing-' . $this->options[ $this->key . '_row_spacing_top' ] . '-top';
		}
		if ( ! empty( $this->options[ $this->key . '_row_spacing_bottom' ] ) ) {
			$additional[] = 'ewf-section--spacing-' . $this->options[ $this->key . '_row_spacing_bottom' ] . '-bottom';
		}
		if ( ! empty( $this->options[ $this->key . '_background_parallax' ] ) ) {
			$additional[] = 'ewf-section--parallax';
		}		
		if ( ! empty( $this->options[ $this->key . '_row_title_align' ] ) ) {
			$additional[] = 'ewf-section--title-'. $this->options[ $this->key . '_row_title_align' ];
		}

		return $additional;
	}

	/**
	 * @param string $wrap
	 * @param array  $additional
	 * @param array  $children
	 */
	public function generate_html_tag( $wrap = 'div', $additional = array(), $children = array() ) {
		$css = "<{$wrap} {$this->generate_attribute('class', $additional['class'])} {$this->generate_style_attribute('style', $additional['style'])}>";
		foreach ( $children as $tag => $props ) {
			$css .= "<{$tag} {$this->generate_attribute('class', $props['class'])}";
			if ( ! empty( $props['data-source'] ) ) {
				$css .= "{$this->generate_attribute('data-source', $props['data-source'])}";
			}
			$css .= ">";
			$css .= "</{$tag}>";
		}

		$css .= "</{$wrap}>";

		echo $css;
	}

	/**
	 * @return string
	 */
	public function generate_video_overlay() {
		if ( empty( $this->options[ $this->key . '_background_video' ] ) ) {
			return '';
		}

		$arr = array(
			'class' => array( 'ewf-section__video-background-yt' ),
			'style' => array(),
		);

		$children = array(
			'a' => array(
				'data-source' => array( $this->options[ $this->key . '_background_video' ] ),
				'class'       => array( 'ewf-section__video-background-yt-source' ),
			),
		);

		echo $this->generate_html_tag( 'div', $arr, $children );
	}

	/**
	 * @return string
	 */
	public function generate_color_overlay() {
		$arr = array(
			'class' => array( 'ewf-section__overlay-color' ),
			'style' => array(
				'background-color',
				'background-color-opacity'
			),
		);

		if ( empty( $this->options[ $this->key . '_background_color' ] ) ) {
			return '';
		}

		echo $this->generate_html_tag( 'div', $arr );
	}
}
