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
            foreach ($this->buttons as $button) {
                $fields = array();
                $active = isset($button['active']) ? $button['active'] : false;
                if ( $active && $first ) {
                    $first = false;
                }elseif ( $active && !$first ) {
                    $active = false;
                }

                foreach ($button['fields'] as $field) {
                    $fields[] = '#customize-control-'.$field;
                }
                $formatted_buttons[] = array(
                        'name'      => $button['name'],
                        'fields'    => implode(',',$fields),
                        'active'    => $active
                    );
            }
            $this->json['buttons']  = $formatted_buttons;
        }

        public function content_template() { ?>
            <div class="epsilon-tabs">
                <# if ( data.buttons ) { #>
                    <div class="tabs">
                        <# for (button in data.buttons) { #>
                            <a href="#" class="epsilon-tab <# if ( data.buttons[button].active ) { #> active <# } #>" data-fields="{{ data.buttons[button].fields }}">{{ data.buttons[button].name }}</a>
                        <# } #>
                    </div>

                <# } #>
            </div>
             <div class="epsilon-after-tab"><div></div></div>
        <?php }
    }
endif;

if ( class_exists( 'WP_Customize_Control' ) ) {
    /**
     * Multiple checkbox customize control class.
     *
     * @since  1.0.0
     * @access public
     *
     */
    class Epsilon_Control_Toggle extends WP_Customize_Control {
        /**
         * The type of customize control being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'mte-toggle';
        /**
         * Displays the control content.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function render_content() {
            ?>
            <div class="checkbox_switch">
                <span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?>
                    <?php if ( !empty($this->description) ): ?>
                    <i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
                        <span class="mte-tooltip"><?php echo wp_kses_post( $this->description ); ?></span>
                    </i>
                    <?php endif; ?>
                </span>
                <div class="onoffswitch">
                    <input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>"
                           name="<?php echo esc_attr( $this->id ); ?>" class="onoffswitch-checkbox"
                           value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link();
                    checked( $this->value() ); ?>>
                    <label class="onoffswitch-label" for="<?php echo esc_attr( $this->id ); ?>"></label>
                </div>
            </div>
            <?php
        }
    }
}

if ( class_exists( 'WP_Customize_Control' ) ) {
    /**
     * Slider control
     *
     * @since  1.0.0
     * @access public
     *
     */
    class Epsilon_Control_Slider extends WP_Customize_Control {
        /**
         * The type of customize control being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'mte-slider';
        /**
         * Enqueue scripts/styles.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function enqueue() {
            wp_enqueue_script( 'jquery-ui' );
            wp_enqueue_script( 'jquery-ui-slider' );
        }
        /**
         * Displays the control content.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function render_content() { ?>
            <label>

                <span class="customize-control-title">
                    <?php echo esc_attr( $this->label ); ?>
                    <?php if ( !empty($this->description) ): ?>
                        <i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
                        <span class="mte-tooltip"><?php echo wp_kses_post( $this->description ); ?></span>
                    </i>
                    <?php endif; ?>
                </span>

                <input disabled type="text" class="rl-slider" id="input_<?php echo $this->id; ?>"
                       value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>/>

            </label>

            <div id="slider_<?php echo $this->id; ?>" class="ss-slider"></div>
            <script>
                jQuery(document).ready(function ($) {
                    $('[id="slider_<?php echo $this->id; ?>"]').slider({
                        value: <?php echo esc_attr( $this->value() ); ?>,
                        range: 'min',
                        min  : <?php echo $this->choices['min']; ?>,
                        max  : <?php echo $this->choices['max']; ?>,
                        step : <?php echo $this->choices['step']; ?>,
                        slide: function (event, ui) {
                            $('[id="input_<?php echo $this->id; ?>"]').val(ui.value).keyup();
                        }
                    });
                    $('[id="input_<?php echo $this->id; ?>"]').val($('[id="slider_<?php echo $this->id; ?>"]').slider("value"));
                    $('[id="input_<?php echo $this->id; ?>"]').change(function () {
                        $('[id="slider_<?php echo $this->id; ?>"]').slider({
                            value: $(this).val()
                        });
                    });
                });
            </script>
            <?php
        }
    }
}
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

if ( ! class_exists( 'Epsilon_Editor_Custom_Control' ) ):
    class Epsilon_Editor_Custom_Control extends WP_Customize_Control {

        public $type = 'wp_editor';

        public $mod;
        public function render_content() {
            $this->mod = strtolower( $this->mod );
            if( ! $this->mod = 'html' ) {
                $this->mod = 'tmce';
            }
            ?>
            <div class="wp-js-editor">
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                </label>
                <textarea class="wp-js-editor-textarea large-text" data-editor-mod="<?php echo esc_attr( $this->mod ); ?>" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                <p class="description"><?php echo $this->description ?></p>
            </div>
        <?php
        }
}
endif;