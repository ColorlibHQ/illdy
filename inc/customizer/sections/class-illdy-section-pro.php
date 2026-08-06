<?php
/**
 * Non-expanding Customizer section that just links somewhere.
 *
 * Replaces Epsilon_Section_Pro. Used for the theme's documentation link at the top of
 * the Customizer; it holds no settings, so nothing is stored and nothing can be lost.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Section_Pro' ) ) {

	class Illdy_Section_Pro extends WP_Customize_Section {

		/**
		 * Section type.
		 *
		 * @var string
		 */
		public $type = 'illdy-section-pro';

		/**
		 * Link target.
		 *
		 * @var string
		 */
		public $button_url = '';

		/**
		 * Link text.
		 *
		 * @var string
		 */
		public $button_text = '';

		/**
		 * Registers the section type so WordPress prints its JS template.
		 *
		 * Without this the render_template() below is never output and the section
		 * silently fails to appear.
		 *
		 * @param WP_Customize_Manager $manager Customizer manager.
		 * @param string               $id      Section id.
		 * @param array                $args    Section arguments.
		 */
		public function __construct( $manager, $id, array $args = array() ) {
			parent::__construct( $manager, $id, $args );

			$manager->register_section_type( 'Illdy_Section_Pro' );
		}

		/**
		 * Passes the button through to the JS template.
		 *
		 * @return array
		 */
		public function json() {
			$json = parent::json();

			$json['button_url']  = esc_url( $this->button_url );
			$json['button_text'] = esc_html( $this->button_text );

			return $json;
		}

		/**
		 * Renders the section as a single non-expandable row.
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}"
				class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<h3 class="accordion-section-title illdy-pro-section-title">
					{{ data.title }}
					<# if ( data.button_url ) { #>
						<a href="{{ data.button_url }}" class="button alignright" target="_blank" rel="noopener noreferrer">{{ data.button_text }}</a>
					<# } #>
				</h3>
			</li>
			<?php
		}
	}
}
