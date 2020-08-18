<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Section_Styling
 */
class Epsilon_Section_Styling {
	/**
	 * Output CSS string
	 *
	 * @var string
	 */
	public $css = '';
	/**
	 * Options that we need to gather values from
	 *
	 * @var array
	 */
	public $options = array();
	/**
	 * Option string (theme specific)
	 *
	 * @var string
	 */
	public $option = '';
	/**
	 * Section manager ( we'll need to get selectors and stuff from it )
	 *
	 * @var array
	 */
	public $manager;

	/**
	 * Epsilon_Section_Styling constructor.
	 *
	 * @param string $handle
	 * @param        $option
	 * @param        $section_manager
	 */
	public function __construct( $handle = '', $option, $section_manager ) {
		$this->manager = $section_manager;
		$this->option  = $option;

		$this->gather_options();
		$this->_render_css();

		wp_add_inline_style( $handle, $this->css );
	}

	/**
	 * Gathers all options
	 */
	public function gather_options() {
		$frontpage = Epsilon_Page_Generator::get_instance( $this->option . get_the_ID(), get_the_ID() );

		if ( ! $frontpage->sections ) {
			return;
		}

		foreach ( $frontpage->sections as $index => $section ) {
			$text    = $this->preg_grep_keys( '/text_color/', $section );
			$heading = $this->preg_grep_keys( '/heading_color/', $section );

			if ( ! empty( $text ) ) {
				$this->options[ $index ]['text'] = array(
					'selectors' => $this->manager->sections[ $section['type'] ]['customization']['colors']['text-color']['selectors'],
					'value'     => reset( $text )
				);
			}
			if ( ! empty( $heading ) ) {
				$this->options[ $index ]['headings'] = array(
					'selectors' => $this->manager->sections[ $section['type'] ]['customization']['colors']['heading-color']['selectors'],
					'value'     => reset( $heading )
				);
			}
		}

	}

	/**
	 * Simple function to return keys that match a certain pattern
	 * ( in this case, using it for text_color and heading_color )
	 *
	 * @param     $pattern
	 * @param     $input
	 * @param int $flags
	 *
	 * @return array
	 */
	public function preg_grep_keys( $pattern, $input, $flags = 0 ) {
		return array_intersect_key( $input, array_flip( preg_grep( $pattern, array_keys( $input ), $flags ) ) );
	}

	/**
	 * Renders CSS String
	 */
	private function _render_css() {
		/**
		 * Each option represents the index of a section
		 */
		foreach ( $this->options as $index => $options ) {
			/**
			 * On each section, we run a callback
			 */
			$this->css .= $this->element_callback( $index, $options );
		}
	}

	/**
	 * Each element (section) will generate a string of css
	 *
	 * @param int   $index
	 * @param array $arr
	 *
	 * @return string
	 */
	public function element_callback( $index = 0, $arr = array() ) {
		$css = '';

		/**
		 * Each section can have text-color, or heading-color so we need to iterate to handle both cases
		 */
		foreach ( $arr as $element ) {
			/**
			 * All our selectors should be scoped by the data-section attribute
			 * e.g. [data-section="1"] p { example css }
			 */
			$prefix = '[data-section="' . $index . '"] ';

			/**
			 * Run a simple preg_filter on the selector array to add the prefix created above
			 */
			$element['selectors'] = preg_filter( '/^/', $prefix, $element['selectors'] );

			/**
			 * Implode the array, glueing with ',' so we get a string similar to this:
			 * [data-section="1"] p, [data-section="1" a { css string goes here }
			 * and concatenate it on the CSS variable
			 */
			$css .= implode( ',', $element['selectors'] ) . '{ color: ' . $element['value'] . '}' . "\n";
		}

		return $css;
	}
}
