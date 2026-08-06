<?php
/**
 *  Custom Control: Text
 */
if ( ! class_exists( 'Illdy_Text_Custom_Control' ) ) {
	class Illdy_Text_Custom_Control extends WP_Customize_Control {
		public function render_content() {
			$output  = '';
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
			$output .= '<span class="description customize-control-description">' . $this->description . '</span>';
			echo $output;
		}
	}
}
