<?php
/**
 * Colour scheme (palette) Customizer control.
 *
 * Replaces Epsilon_Control_Color_Scheme. The stored value is unchanged: the palette id
 * string held by `illdy_color_scheme`. Choosing a palette also writes the five
 * `epsilon_*_color` settings, exactly as before.
 *
 * Unlike the control it replaces, an unrecognised stored id falls back to the first
 * palette instead of indexing a missing array key, which previously produced PHP
 * warnings on any site whose saved palette had been removed.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Control_Color_Scheme' ) ) {

	class Illdy_Control_Color_Scheme extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'illdy-color-scheme';

		/**
		 * Available palettes: each with 'id', 'name' and 'colors' (setting id => hex).
		 *
		 * @var array
		 */
		public $choices = array();

		/**
		 * Loads the shared control assets.
		 */
		public function enqueue() {
			wp_enqueue_script(
				'illdy-customizer-controls',
				trailingslashit( get_template_directory_uri() ) . 'inc/customizer/assets/js/illdy-customizer-controls.js',
				array( 'jquery', 'customize-controls' ),
				defined( 'ILLDY_VERSION' ) ? ILLDY_VERSION : false,
				true
			);

			wp_enqueue_style(
				'illdy-customizer-controls',
				trailingslashit( get_template_directory_uri() ) . 'inc/customizer/assets/css/illdy-customizer-controls.css',
				array(),
				defined( 'ILLDY_VERSION' ) ? ILLDY_VERSION : false
			);
		}

		/**
		 * Resolves the stored value to a palette that actually exists.
		 *
		 * @return string
		 */
		protected function selected_id() {
			$value = (string) $this->value();

			foreach ( (array) $this->choices as $choice ) {
				if ( isset( $choice['id'] ) && $choice['id'] === $value ) {
					return $value;
				}
			}

			$first = reset( $this->choices );

			return ( is_array( $first ) && isset( $first['id'] ) ) ? $first['id'] : '';
		}

		/**
		 * Renders the control.
		 */
		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}

			$selected = $this->selected_id();
			$name     = '_customize-illdy-color-scheme-' . $this->id;
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="illdy-color-schemes">
				<?php foreach ( (array) $this->choices as $choice ) : ?>
					<?php
					if ( empty( $choice['id'] ) ) {
						continue;
					}
					$colors = isset( $choice['colors'] ) ? (array) $choice['colors'] : array();
					?>
					<label class="illdy-color-scheme<?php echo $choice['id'] === $selected ? ' is-selected' : ''; ?>">
						<input
							type="radio"
							name="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $choice['id'] ); ?>"
							data-colors="<?php echo esc_attr( wp_json_encode( $colors ) ); ?>"
							<?php checked( $choice['id'], $selected ); ?>
							<?php $this->link(); ?> />

						<span class="illdy-color-scheme-swatches">
							<?php foreach ( array_slice( $colors, 0, 5 ) as $hex ) : ?>
								<span class="illdy-color-scheme-swatch" style="background-color: <?php echo esc_attr( sanitize_hex_color( $hex ) ); ?>"></span>
							<?php endforeach; ?>
						</span>

						<span class="illdy-color-scheme-name"><?php echo esc_html( isset( $choice['name'] ) ? $choice['name'] : $choice['id'] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}
