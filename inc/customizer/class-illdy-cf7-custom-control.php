<?php

/**
 *  Custom Control: Contact Form 7
 */
if ( ! class_exists( 'Illdy_CF7_Custom_Control' ) ) {
	class Illdy_CF7_Custom_Control extends WP_Customize_Control {
		/**
		 * Returns true / false if the plugin: Contact Form 7 is activated;
		 *
		 * This right here disables the control for selecting a contact form IF the plugin isn\'t active
		 *
		 * @since Pixova Lite 1.15
		 *
		* @return bool
		 */
		public function active_callback() {

			if ( class_exists( 'WPCF7' ) ) {
				return true;
			} else {
				return false;
			}
		}

		public function get_cf7_forms() {

			// no more php warnings
			$contact_forms = array();

			// check if CF7 is activated
			if ( $this->active_callback() ) {

				$args = array(
					'post_type'      => 'wpcf7_contact_form',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);

				$cf7forms = new WP_Query( $args );
				if ( $cf7forms->have_posts() ) {
					foreach ( $cf7forms->posts as $cf7form ) {
						$contact_forms[ $cf7form->ID ] = $cf7form->post_title;
					}
				} else {
					$contact_forms[0] = __( 'No contact forms found', 'illdy' );
				}
			}
			return $contact_forms;
		}

		public function render_content() {
			$contact_forms = $this->get_cf7_forms();

			if ( ! empty( $contact_forms ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php esc_url( $this->link() ); ?> style="width:100%;">
				<?php
				echo '<option value="default">' . __( 'Select your contact form', 'illdy' ) . '</option>';
				foreach ( $contact_forms as $form_id => $form_title ) {
					echo '<option value="' . sanitize_key( $form_id ) . '" >' . esc_html( $form_title ) . '</option>';
				}
				echo '</select>';
			}
		}
	}
}// End if().
