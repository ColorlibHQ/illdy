<?php
/**
 *	Custom Control: Contact Form 7
 */
if( !class_exists( 'Illdy_CF7_Custom_Control' ) ) {
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
        public function active_callback( ) {

            if( class_exists( 'WPCF7' ) ) {
                return true;
            } else {
                return false;
            }
        }

        public function illdy_get_cf7_forms() {
            global $wpdb;

            // no more php warnings
            $contact_forms = array();

            // check if CF7 is activated
            if ( $this->active_callback()) {
                $cf7 = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'wpcf7_contact_form' ");
                if ($cf7) {

                    foreach ($cf7 as $cform) {
                        $contact_forms[$cform->ID] = $cform->post_title;
                    }
                } else {
                    $contact_forms[0] = __('No contact forms found', 'illdy');
                }
            }
            return $contact_forms;
        }

        public function render_content() {
            $Pixova_Lite_contact_forms = $this->illdy_get_cf7_forms();

            if ( !empty($Pixova_Lite_contact_forms ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <select <?php esc_url($this->link()); ?> style="width:100%;">
                <?php echo '<option value="default">'.__('Select your contact form', 'illdy').'</option>';
                foreach ($Pixova_Lite_contact_forms as $form_id => $form_title) {
                    echo '<option value="' . sanitize_key( $form_id ). '" >' . esc_html( $form_title ). '</option>';
                }
                echo '</select>';
            }
        }
    }
}

/**
 *  Custom Control: Text
 */
if( !class_exists( 'Illdy_Text_Custom_Control' ) ) {
    class Illdy_Text_Custom_Control extends WP_Customize_Control {
        public function render_content() {
            $output = '';

            $output .= '<span class="customize-control-title">'. esc_html( $this->label ) .'</span>';
            $output .= '<span class="description customize-control-description">'. $this->description .'</span>';

            echo $output;
        }
    }
}

