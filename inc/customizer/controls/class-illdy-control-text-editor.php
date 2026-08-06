<?php
/**
 * Rich text editor Customizer control.
 *
 * Replaces Epsilon_Control_Text_Editor using WordPress core's own editor API
 * (wp_enqueue_editor() plus wp.editor.initialize()) instead of a bundled framework.
 *
 * The stored value is unchanged: the same HTML string the setting always held, still
 * sanitised by whatever sanitize_callback the setting was registered with.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Control_Text_Editor' ) ) {

	class Illdy_Control_Text_Editor extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'illdy-text-editor';

		/**
		 * Number of rows for the underlying textarea.
		 *
		 * @var int
		 */
		public $rows = 8;

		/**
		 * Loads core's editor assets plus the small initialiser below.
		 */
		public function enqueue() {
			wp_enqueue_editor();

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
		 * Renders the control.
		 *
		 * Rendered server-side rather than through a JS template so the textarea exists
		 * in the DOM before wp.editor.initialize() runs against it.
		 */
		public function render_content() {
			$editor_id = 'illdy-editor-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<textarea
				id="<?php echo esc_attr( $editor_id ); ?>"
				class="illdy-text-editor widefat"
				rows="<?php echo absint( $this->rows ); ?>"
				<?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			<?php
		}
	}
}
