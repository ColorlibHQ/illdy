<?php

/**
 *  Custom Control: Kaliforms
 */
if ( ! class_exists( 'Illdy_Kaliforms_Custom_Control' ) ) {
	class Illdy_Kaliforms_Custom_Control extends WP_Customize_Control {
		/**
		 * Returns true / false if the plugin: Kaliforms is activated;
		 *
		 * This right here disables the control for selecting a contact form IF the plugin isn\'t active
		 *
		 * @since Pixova Lite 1.15
		 *
		* @return bool
		 */
		public function active_callback() {

			if ( defined('KALIFORMS_VERSION') ) {
				return true;
			} else {
				return false;
			}
		}

		public function get_kaliforms_forms() {

			// no more php warnings
			$contact_forms = array();

			// check if Kaliforms is activated
			if ( $this->active_callback() ) {

				$args = array(
					'post_type'      => 'kaliforms_forms',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);

				$kali_forms = new WP_Query( $args );
				if ( $kali_forms->have_posts() ) {
					foreach ( $kali_forms->posts as $kali_form ) {
						$contact_forms[ $kali_form->ID ] = $kali_form->post_title;
					}
				} else {
					$contact_forms[0] = __( 'No contact forms found', 'illdy' );
				}
			}
			return $contact_forms;
		}

		public function render_content() {
			$contact_forms = $this->get_kaliforms_forms();

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
