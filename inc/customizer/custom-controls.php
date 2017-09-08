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

if ( ! class_exists( 'Epsilon_Control_Tab' ) ):
    class Epsilon_Control_Tab extends WP_Customize_Control {
        public $type = 'epsilon-tab';
        public $buttons = '';
        public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
            parent::__construct( $manager, $id, $args );
        }
        public function to_json() {
            parent::to_json();
            $first = true;
            $formatted_buttons = array();
            $all_fields = array();
            foreach ($this->buttons as $button) {
                $fields = array();
                $active = isset($button['active']) ? $button['active'] : false;
                if ( $active && $first ) {
                    $first = false;
                }elseif ( $active && ! $first ) {
                    $active = false;
                }

                $formatted_buttons[] = array(
                    'name'      => $button['name'],
                    'fields'    => $button['fields'],
                    'active'    => $active
                );
                $all_fields = array_merge($all_fields, $button['fields']);
            }
            $this->json['buttons']  = $formatted_buttons;
            $this->json['fields']  = $all_fields;

        }

        public function content_template() { ?>
            <div class="epsilon-tabs">
                <# if ( data.buttons ) { #>
                    <div class="tabs">
                        <# for (tab in data.buttons) { #>
                            <a href="#" class="epsilon-tab <# if ( data.buttons[tab].active ) { #> active <# } #>" data-tab="{{ tab }}">{{ data.buttons[tab].name }}</a>
                        <# } #>
                    </div>

                <# } #>
            </div>
             <div class="epsilon-after-tab"><div></div></div>
        <?php }
    }
endif;

if ( ! class_exists( 'Epsilon_Control_Button' ) ):
    class Epsilon_Control_Button extends WP_Customize_Control {
        public $type = 'epsilon-button';
        public $text = '';
        public $section_id = '';
        public $icon = '';
        public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
            parent::__construct( $manager, $id, $args );
        }
        public function to_json() {
            parent::to_json();
            $this->json['text']  = $this->text;
            $this->json['section_id']  = $this->section_id;
            $this->json['icon']  = $this->icon;
        }

        public function content_template() { ?>
            <div class="epsilon-button">
                <# if ( data.section_id ) { #>
                    <a href="#" class="epsilon-button" data-section="{{ data.section_id }}">
                        <# if ( data.icon ) { #>
                            <span class="dashicons {{ data.icon }}"></span>
                        <# } #>
                        {{ data.text }}</a>
                <# } #>
            </div>
        <?php }
    }
endif;
