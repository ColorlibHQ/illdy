<?php
/**
 * Repeater Customizer control.
 *
 * Replaces Epsilon_Control_Repeater for the jumbotron slides. The stored value keeps
 * exactly the shape the front end already reads:
 *
 *     array( array( 'slide_image' => 'https://…' ), … )
 *
 * so existing slides continue to render untouched.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Control_Repeater' ) ) {

	class Illdy_Control_Repeater extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'illdy-repeater';

		/**
		 * Per-row field definitions, keyed by field name.
		 *
		 * Only the 'image' field type is implemented, which is all this theme uses.
		 *
		 * @var array
		 */
		public $fields = array();

		/**
		 * Label for the "add row" button.
		 *
		 * @var string
		 */
		public $button_label = '';

		/**
		 * Label shown on each row.
		 *
		 * @var string
		 */
		public $row_label = '';

		/**
		 * Loads the media frame and the shared control assets.
		 */
		public function enqueue() {
			wp_enqueue_media();

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
		 * Normalises the stored value into a list of row arrays.
		 *
		 * Tolerates the objects an older JSON-decoded value could contain.
		 *
		 * @return array
		 */
		protected function rows() {
			$value = $this->value();

			if ( is_string( $value ) && '' !== $value ) {
				$decoded = json_decode( $value, true );
				$value   = ( null === $decoded ) ? array() : $decoded;
			}

			$rows = array();
			foreach ( (array) $value as $row ) {
				$row = (array) $row;
				$out = array();
				foreach ( $this->fields as $name => $field ) {
					$out[ $name ] = isset( $row[ $name ] ) ? (string) $row[ $name ] : '';
				}
				$rows[] = $out;
			}

			return $rows;
		}

		/**
		 * Renders the control.
		 */
		public function render_content() {
			$rows       = $this->rows();
			$row_label  = $this->row_label ? $this->row_label : esc_html__( 'Item', 'illdy' );
			$add_label  = $this->button_label ? $this->button_label : esc_html__( 'Add new', 'illdy' );
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<div class="illdy-repeater"
				data-row-label="<?php echo esc_attr( $row_label ); ?>"
				data-fields="<?php echo esc_attr( wp_json_encode( array_keys( $this->fields ) ) ); ?>">

				<ul class="illdy-repeater-rows">
					<?php foreach ( $rows as $index => $row ) : ?>
						<?php $this->render_row( $row, $index, $row_label ); ?>
					<?php endforeach; ?>
				</ul>

				<button type="button" class="button illdy-repeater-add"><?php echo esc_html( $add_label ); ?></button>

				<input type="hidden" class="illdy-repeater-value"
					value="<?php echo esc_attr( wp_json_encode( $rows ) ); ?>"
					<?php $this->link(); ?> />
			</div>

			<script type="text/html" class="illdy-repeater-template">
				<?php $this->render_row( array_fill_keys( array_keys( $this->fields ), '' ), '__i__', $row_label ); ?>
			</script>
			<?php
		}

		/**
		 * Renders a single row.
		 *
		 * @param array      $row       Field values.
		 * @param int|string $index     Row index, or the template placeholder.
		 * @param string     $row_label Row heading.
		 */
		protected function render_row( $row, $index, $row_label ) {
			?>
			<li class="illdy-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
				<div class="illdy-repeater-row-header">
					<span class="illdy-repeater-row-title"><?php echo esc_html( $row_label ); ?></span>
					<button type="button" class="button-link illdy-repeater-remove" aria-label="<?php esc_attr_e( 'Remove', 'illdy' ); ?>">
						<span class="dashicons dashicons-no-alt"></span>
					</button>
				</div>

				<?php foreach ( $this->fields as $name => $field ) : ?>
					<?php $value = isset( $row[ $name ] ) ? $row[ $name ] : ''; ?>
					<div class="illdy-repeater-field" data-field="<?php echo esc_attr( $name ); ?>">
						<?php if ( ! empty( $field['label'] ) ) : ?>
							<span class="illdy-repeater-field-label"><?php echo esc_html( $field['label'] ); ?></span>
						<?php endif; ?>

						<div class="illdy-repeater-image-preview">
							<?php if ( $value ) : ?>
								<img src="<?php echo esc_url( $value ); ?>" alt="" />
							<?php endif; ?>
						</div>

						<input type="url" class="widefat illdy-repeater-input" value="<?php echo esc_url( $value ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'illdy' ); ?>" />

						<button type="button" class="button illdy-repeater-select"><?php esc_html_e( 'Select image', 'illdy' ); ?></button>
					</div>
				<?php endforeach; ?>
			</li>
			<?php
		}
	}
}
