<?php
/**
 *  Customizer
 */

require_once get_template_directory() . '/inc/customizer/class-epsilon-color-scheme.php';

if ( ! function_exists( 'illdy_customize_register' ) ) {
	function illdy_customize_register( $wp_customize ) {

		// Get Settings
		$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
		$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
		$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

		$wp_customize->get_control( 'custom_logo' )->section = 'illdy_general_section';


		/**********************************************/
		/*************** INIT ************************/
		/**********************************************/

		// Custom Controls
		require_once get_template_directory() . '/inc/customizer/custom-controls.php';
		require_once get_template_directory() . '/inc/customizer/custom-section.php';
		require_once get_template_directory() . '/inc/customizer/custom-recommend-action-section.php';
		require_once get_template_directory() . '/inc/customizer/control-epsilon-color-scheme.php';
		
		$wp_customize->register_control_type( 'Epsilon_Control_Tab' );
		$wp_customize->register_control_type( 'Epsilon_Control_Button' );
		$wp_customize->register_section_type( 'Illdy_Customize_Section_Pro' );
		$wp_customize->register_section_type( 'Illdy_Customize_Section_Recommend' );

		// Recomended Actions
		$wp_customize->add_section(
			new Illdy_Customize_Section_Recommend(
				$wp_customize,
				'illdy-recomended-section',
				array(
					'title'    => esc_html__( 'Recomended Actions', 'illdy' ),
					'social_text'	=> esc_html__( 'We are social :', 'illdy' ),
					'plugin_text'	=> esc_html__( 'Recomended Plugins :', 'illdy' ),
					'facebook' => 'https://www.facebook.com/colorlib',
					'twitter' => 'https://twitter.com/colorlib',
					'wp_review' => true,
					'priority' => 0
				)
			)
		);
		// Pro Section
		$wp_customize->add_section(
			new Illdy_Customize_Section_Pro(
				$wp_customize,
				'illdy-pro-section',
				array(
					'title'    => esc_html__( 'Illdy', 'illdy' ),
					'pro_text' => esc_html__( 'Documentation',         'illdy' ),
					'pro_url'  => 'https://colorlib.com/wp/support/illdy/',
					'priority' => 0
				)
			)
		);

		// Front Page sections panel
		$wp_customize->add_panel( 'illdy_frontpage_panel', array(
		    'priority'       => 2,
		    'title'          => esc_html__( 'Front Page Sections', 'illdy' ),
		    'description'	 => esc_html__( 'Drag & drop to reorder front-page sections', 'illdy' ),
		) );

		// Color Scheme
		$wp_customize->add_setting( 'illdy_color_scheme',
	                    array(
	                        'sanitize_callback' => 'esc_html',
	                        'default'           => 'default',
	                        'transport'         => 'postMessage',
	                    ) );
		$wp_customize->add_control( new Epsilon_Control_Color_Scheme(
                        $wp_customize,
                        'illdy_color_scheme',
                        array(
                            'label'       => esc_html__( 'Color scheme', 'illdy' ),
                            'description' => esc_html__( 'Select a color scheme', 'illdy' ),
                            'choices'     => array(
	                            array(
		                            'id'     => 'Illdy',
		                            'name'   => 'Default',
		                            'colors' => array(
			                            'accent'        		=> '#f1d204',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#6a4d8a',
		                            ),
	                            ),
	                            array(
		                            'id'     => 'palette-1',
		                            'name'   => 'Palette 1',
		                            'colors' => array(
			                            'accent'        		=> '#ff004f',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#482c54',
		                            ),
	                            ),
	                            array(
		                            'id'     => 'palette-2',
		                            'name'   => 'Palette 2',
		                            'colors' => array(
			                            'accent'        		=> '#f66f6d',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#195962',
		                            ),
	                            ),
	                            array(
		                            'id'     => 'palette-3',
		                            'name'   => 'Palette 3',
		                            'colors' => array(
			                            'accent'        		=> '#f79e27',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#e95e4e',
		                            ),
	                            ),
	                            array(
		                            'id'     => 'palette-4',
		                            'name'   => 'Palette 4',
		                            'colors' => array(
			                            'accent'        		=> '#6ebbdc',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#2e3d51',
		                            ),
	                            ),
	                            array(
		                            'id'     => 'palette-5',
		                            'name'   => 'Palette 5',
		                            'colors' => array(
			                            'accent'        		=> '#507fe2',
			                            'secondary_accent'		=> '#f18b6d',
			                            'text' 					=> '#545454',
			                            'contrast'            	=> '#8c9597',
			                            'hover'  				=> '#1acdcb',
		                            ),
	                            ),
                            ),
                            'priority'    => 0,
                            'default'     => 'red',
                            'section'     => 'colors',
                        )
                    )
		);

		// General Options
		require_once get_template_directory() . '/inc/customizer/panels/general-options.php';

		// Blog Options
		require_once get_template_directory() . '/inc/customizer/panels/blog-options.php';

		// Jumbotron
		require_once get_template_directory() . '/inc/customizer/panels/jumbotron.php';

		// About
		require_once get_template_directory() . '/inc/customizer/panels/about.php';

		// Testimonials
		require_once get_template_directory() . '/inc/customizer/panels/testimonials.php';

		// Projects
		require_once get_template_directory() . '/inc/customizer/panels/projects.php';

		// Services
		require_once get_template_directory() . '/inc/customizer/panels/services.php';

		// Latest News
		require_once get_template_directory() . '/inc/customizer/panels/latest-news.php';

		// Counter
		require_once get_template_directory() . '/inc/customizer/panels/counter.php';

		// Team
		require_once get_template_directory() . '/inc/customizer/panels/team.php';

		// Contact Us
		require_once get_template_directory() . '/inc/customizer/panels/contact-us.php';

		// Full Width
		require_once get_template_directory() . '/inc/customizer/panels/full-width.php';
	}

	add_action( 'customize_register', 'illdy_customize_register' );
}

/**
 *  Customizer Live Preview
 */
if ( ! function_exists( 'illdy_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'illdy_customizer_live_preview' );

	function illdy_customizer_live_preview() {
		wp_enqueue_script( 'illdy-handlebars', get_template_directory_uri() . '/inc/customizer/assets/js/handlebars.js', array(), '1.0', true );
		wp_enqueue_script( 'illdy-customizer-live-preview', get_template_directory_uri() . '/inc/customizer/assets/js/illdy-customizer-live-preview.js', array( 'customize-preview' ), '1.0', true );

		wp_localize_script( 'illdy-customizer-live-preview', 'WPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		) );

	}

}

if ( ! function_exists( 'illdy_customizer_css_load' ) ) {
	function illdy_customizer_css_load() {
		wp_enqueue_style( 'illdy-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/css/illdy-customizer.css' );
	}

	add_action( 'customize_controls_print_styles', 'illdy_customizer_css_load' );
}

if ( ! function_exists( 'illdy_customizer_js_load' ) ) {
	function illdy_customizer_js_load() {
		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );
		wp_localize_script( 'updates', '_wpUpdatesItemCounts', array(
			'totals'  => wp_get_update_data(),
		) );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "plugin-install";' );
		wp_enqueue_script( 'illdy-customizer', get_template_directory_uri() . '/inc/customizer/assets/js/illdy-customizer.js', array( 'customize-controls' ), '1.0', true );

		$IlldyCustomizer = array();
		$IlldyCustomizer['sections'] = illdy_get_sections_position();
		$IlldyCustomizer['ajax_url'] = admin_url( 'admin-ajax.php' );
		$IlldyCustomizer['template_directory'] = get_template_directory_uri();

		wp_localize_script( 'illdy-customizer', 'IlldyCustomizer', $IlldyCustomizer );

	}

	add_action( 'customize_controls_enqueue_scripts', 'illdy_customizer_js_load', 99 );
}

/**
 *  Sanitize Radio Buttons
 */
if ( ! function_exists( 'illdy_sanitize_radio_buttons' ) ) {
	function illdy_sanitize_radio_buttons( $input, $setting ) {
		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );

		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}

/**
 *  Customizer CSS
 */
if ( ! function_exists( 'illdy_customizer_css' ) ) {
	add_action( 'wp_head', 'illdy_customizer_css' );
	function illdy_customizer_css() {
		$preloader_primary_color    = esc_attr( get_theme_mod( 'illdy_preloader_primary_color', '#f1d204' ) );
		$preloader_secondly_color   = esc_attr( get_theme_mod( 'illdy_preloader_secondly_color', '#ffffff' ) );
		$preloader_background_color = esc_attr( get_theme_mod( 'illdy_preloader_background_color', '#ffffff' ) );

		$output = '';

		$output .= '<style type="text/css">';
		$output .= ( $preloader_primary_color ? '.pace .pace-progress {background-color: ' . $preloader_primary_color . '; color: ' . $preloader_primary_color . ';}' : '' );
		$output .= ( $preloader_primary_color || $preloader_secondly_color ? '.pace .pace-activity {box-shadow: inset 0 0 0 2px ' . $preloader_primary_color . ', inset 0 0 0 7px ' . $preloader_secondly_color . ';}' : '' );
		$output .= ( $preloader_background_color ? '.pace-overlay {background-color: ' . $preloader_background_color . ';}' : '' );
		$output .= '</style>';

		echo $output;
	}
}

if ( ! function_exists( 'illdy_sanitize_checkbox' ) ) {
	/**
	 * Function to sanitize checkboxes
	 *
	 * @param $value
	 *
	 * @return int
	 */
	function illdy_sanitize_checkbox( $value ) {
		if ( $value == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}
}

/**
 *  Active Callback: Is not active Contact Form 7
 */
if ( ! function_exists( 'illdy_is_not_active_contact_form_7' ) ) {
	function illdy_is_not_active_contact_form_7() {
		if ( ! class_exists( 'WPCF7' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 *  Active Callback: Without Contact Form 7
 */
if ( ! function_exists( 'illdy_have_not_contact_form_7' ) ) {
	function illdy_have_not_contact_form_7() {
		if ( class_exists( 'WPCF7' ) ) {
			$args = array(
					'post_type' => 'wpcf7_contact_form',
					'post_status' => 'publish',
					'posts_per_page' => -1
				);
			$posts = get_posts($args);
			if ( count($posts) > 0 ) {
				return false;
			}else{
				return true;
			}
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'illdy_create_contact_tab_sections' ) ) {
	function illdy_create_contact_tab_sections() {
		$prefix = 'illdy';
		$sections = array(
            $prefix . '_contact_us_show',
            $prefix . '_contact_us_general_title',
            $prefix . '_contact_us_entry',
            $prefix . '_contact_us_general_address_title',
            $prefix . '_contact_us_general_customer_support_title',
        );

		if ( illdy_is_not_active_contact_form_7() ) {
			$sections[] = $prefix . '_contact_us_install_contact_form_7';
		}elseif ( illdy_have_not_contact_form_7() ) {
			$sections[] = $prefix . '_contact_us_create_contact_form_7';
		}else{
			$sections[] = $prefix . '_contact_us_general_contact_form_7';
		}
		return $sections;
	}
}

/**
 *  Sanitize HTML
 */
if ( ! function_exists( 'illdy_sanitize_html' ) ) {
	function illdy_sanitize_html( $input ) {
		$input = force_balance_tags( $input );

		$allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'img'    => array(
				'alt'    => array(),
				'src'    => array(),
				'srcset' => array(),
				'title'  => array(),
			),
			'strong' => array(),
		);
		$output       = wp_kses( $input, $allowed_html );

		return $output;
	}
}

/**
 *  Sanitize Select
 */
if ( ! function_exists( 'illdy_sanitize_select' ) ) {
	function illdy_sanitize_select( $input ) {
		if ( is_numeric( $input ) ) {
			return intval( $input );
		}
	}
}

if ( ! function_exists( 'illdy_about_general_title' ) ) {
	function illdy_about_general_title() {
		return get_theme_mode( 'illdy_about_general_title' );
	}
}

if ( ! function_exists( 'illdy_about_general_entry' ) ) {
	function illdy_about_general_entry() {
		return get_theme_mode( 'illdy_about_general_entry' );
	}
}

if ( ! function_exists( 'illdy_contact_us_general_title' ) ) {
	function illdy_contact_us_general_title() {
		return get_theme_mode( 'illdy_contact_us_general_title' );
	}
}

if ( ! function_exists( 'illdy_contact_us_general_text' ) ) {
	function illdy_contact_us_general_text() {
		return get_theme_mode( 'illdy_contact_us_general_text' );
	}
}

if ( ! function_exists( 'illdy_contact_us_general_address_title' ) ) {
	function illdy_contact_us_general_address_title() {
		return get_theme_mode( 'illdy_contact_us_general_address_title' );
	}
}

if ( ! function_exists( 'illdy_contact_us_general_customer_support_title' ) ) {
	function illdy_contact_us_general_customer_support_title() {
		return get_theme_mode( 'illdy_contact_us_general_customer_support_title' );
	}
}

if ( ! function_exists( 'illdy_address2' ) ) {
	function illdy_address2() {
		return get_theme_mode( 'illdy_address2' );
	}
}

if ( ! function_exists( 'illdy_address1' ) ) {
	function illdy_address1() {
		return get_theme_mode( 'illdy_address1' );
	}
}

if ( ! function_exists( 'illdy_phone' ) ) {
	function illdy_phone() {
		return get_theme_mode( 'illdy_phone' );
	}
}

if ( ! function_exists( 'illdy_email' ) ) {
	function illdy_email() {
		return get_theme_mode( 'illdy_email' );
	}
}

if ( ! function_exists( 'illdy_footer_copyright' ) ) {
	function illdy_footer_copyright() {
		return get_theme_mode( 'illdy_footer_copyright' );
	}
}

if ( ! function_exists( 'illdy_jumbotron_general_first_row_from_title' ) ) {
	function illdy_jumbotron_general_first_row_from_title() {
		return get_theme_mode( 'illdy_jumbotron_general_first_row_from_title' );
	}
}

if ( ! function_exists( 'illdy_jumbotron_general_second_row_from_title' ) ) {
	function illdy_jumbotron_general_second_row_from_title() {
		return get_theme_mode( 'illdy_jumbotron_general_second_row_from_title' );
	}
}

// New
if ( ! function_exists( 'illdy_img_footer_logo' ) ) {
	function illdy_img_footer_logo() {
		$img_footer_logo   = get_theme_mod( 'illdy_img_footer_logo' );
		if ( $img_footer_logo ) {
			$html = '<img src="'.esc_url( $img_footer_logo ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" title="'.esc_attr( get_bloginfo( 'name' ) ).'" />';
		}else{
			$html = '';
		}
		
		return $html;
	}
}

if ( ! function_exists( 'illdy_custom_logo' ) ) {
	function illdy_custom_logo() {
		$logo_id                   = get_theme_mod( 'custom_logo' );
		$logo_image                = wp_get_attachment_image_src( $logo_id, 'full' );
		
		return '<img src="' . esc_url( $logo_image[0] ) . '" />';
	}
}
if ( ! function_exists( 'illdy_contact_us_social' ) ) {
	function illdy_contact_us_social() {

		$contact_bar_facebook_url  = get_theme_mod( 'illdy_contact_bar_facebook_url' );
		$contact_bar_twitter_url   = get_theme_mod( 'illdy_contact_bar_twitter_url' );
		$contact_bar_linkedin_url  = get_theme_mod( 'illdy_contact_bar_linkedin_url' );
		$contact_bar_googlep_url   = get_theme_mod( 'illdy_contact_bar_googlep_url' );
		$contact_bar_youtube_url   = get_theme_mod( 'illdy_contact_bar_youtube_url' );
		$contact_bar_vimeo_url     = get_theme_mod( 'illdy_contact_bar_vimeo_url' );
		$contact_bar_pinterest_url = get_theme_mod( 'illdy_contact_bar_pinterest_url' );
		$contact_bar_instagram_url = get_theme_mod( 'illdy_contact_bar_instagram_url' );

		$html = '';
		if ( $contact_bar_twitter_url ):
			$html .= '<a href="'.esc_url( $contact_bar_twitter_url ).'" title="'.__( 'Twitter', 'illdy' ).'" target="_blank"><i class="fa fa-twitter"></i></a>';
		endif;
		if ( $contact_bar_facebook_url ):
			$html .= '<a href="'.esc_url( $contact_bar_facebook_url ).'" title="'.__( 'Facebook', 'illdy' ).'" target="_blank"><i class="fa fa-facebook"></i></a>';
		endif;
		if ( $contact_bar_linkedin_url ):
			$html .= '<a href="'.esc_url( $contact_bar_linkedin_url ).'" title="'.__( 'LinkedIn', 'illdy' ).'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		endif;
		if ( $contact_bar_googlep_url ):
			$html .= '<a href="'.esc_url( $contact_bar_googlep_url ).'" title="'.__( 'Google+', 'illdy' ).'" target="_blank"><i class="fa fa-google-plus"></i></a>';
		endif;
		if ( $contact_bar_pinterest_url ):
			$html .= '<a href="'.esc_url( $contact_bar_pinterest_url ).'" title="'.__( 'Pinterest', 'illdy' ).'" target="_blank"><i class="fa fa-pinterest"></i></a>';
		endif;
		if ( $contact_bar_instagram_url ):
			$html .= '<a href="'.esc_url( $contact_bar_instagram_url ).'" title="'.__( 'Instagram', 'illdy' ).'" target="_blank"><i class="fa fa-instagram"></i></a>';
		endif;
		if ( $contact_bar_youtube_url ):
			$html .= '<a href="'.esc_url( $contact_bar_youtube_url ).'" title="'.__( 'YouTube', 'illdy' ).'" target="_blank"><i class="fa fa-youtube"></i></a>';
		endif;
		if ( $contact_bar_vimeo_url ):
			$html .= '<a href="'.esc_url( $contact_bar_vimeo_url ).'" title="'.__( 'Vimeo', 'illdy' ).'" target="_blank"><i class="fa fa-vimeo"></i></a>';
		endif;

		return $html;
	}
}

add_action( 'wp_ajax_illdy_order_sections', 'illdy_order_sections' );

function illdy_order_sections() {

	if ( isset($_POST['sections']) ) {
		
		set_theme_mod( 'illdy_frontpage_sections', $_POST['sections'] );
		echo 'succes';

	}

	wp_die(); // this is required to terminate immediately and return a proper response
}

if ( ! function_exists( 'illdy_get_sections_position' ) ) {
	function illdy_get_sections_position() {
		$defaults = array(
				'illdy_panel_about',
				'illdy_panel_projects',
				'illdy_testimonials_general',
				'illdy_panel_services',
				'illdy_latest_news_general',
				'illdy_counter_general',
				'illdy_panel_team',
				'illdy_contact_us',
				'illdy_full_width'
			);
		$sections = get_theme_mod( 'illdy_frontpage_sections', $defaults );
		return $sections;
	}
}

if ( ! function_exists( 'illdy_get_section_position' ) ) {
	function illdy_get_section_position( $key ) {
		$sections = illdy_get_sections_position();
		$position = array_search( $key, $sections );
		$return = ($position+1)*10;
		return $return;
	}
}

function illdy_sanitize_background_repeat( $value, $setting ) {
	if ( ! in_array( $value, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ) ) ) {
		return new WP_Error( 'invalid_value', __( 'Invalid value for background repeat.', 'illdy' ) );
	}
	return $value;
}

function illdy_sanitize_background_preset( $value, $setting ) {
 	if ( ! in_array( $value, array( 'default', 'fill', 'fit', 'repeat', 'custom' ), true ) ) {
		return new WP_Error( 'invalid_value', __( 'Invalid value for background size.', 'illdy' ) );
	}

	return $value;
}

function illdy_sanitize_background_size( $value, $setting ) {
	if ( ! in_array( $value, array( 'auto', 'contain', 'cover' ), true ) ) {
		return new WP_Error( 'invalid_value', __( 'Invalid value for background size.', 'illdy' ) );
	}
	return $value;
}


// Wp Editor
class Epsilon_Editor_Scripts {
    /**
     * Enqueue scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function enqueue() {
        if ( ! class_exists( '_WP_Editors' ) ) {
            require(ABSPATH . WPINC . '/class-wp-editor.php');
        }
        add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'enqueue_editor' ),  2 );
        add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'editor_js' ), 50 );
        add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'enqueue_scripts' ), 1 );
    }
    public  static function enqueue_editor(){
        if( ! isset( $GLOBALS['__wp_mce_editor__'] ) || ! $GLOBALS['__wp_mce_editor__'] ) {
            $GLOBALS['__wp_mce_editor__'] = true;
            ?>
            <script id="_wp-mce-editor-tpl" type="text/html">
                <?php wp_editor('', '__wp_mce_editor__'); ?>
            </script>
            <?php
        }
    }
}
add_action( 'customize_controls_enqueue_scripts', array( 'Epsilon_Editor_Scripts', 'enqueue' ), 95 );

add_action( 'wp_footer', 'illdy_print_customizer_templates' );

function illdy_print_customizer_templates() {

	if ( !is_customize_preview() ) {
		return;
	}

	//Jumbotron Template
	?>

	<script id="illdy-jumbotron-section" type="text/x-handlebars-template">
		{{#if illdy_jumbotron_general_image }}
			#header{ background-image: url({{illdy_jumbotron_general_image}}) !important; }
		{{else}}
			#header{ background-image: none !important; }
		{{/if}}
		{{#if illdy_jumbotron_background_position_y }}
			#header{ background-position-y: {{illdy_jumbotron_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_jumbotron_background_position_x }}
			#header{ background-position-x: {{illdy_jumbotron_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_jumbotron_background_attachment }}
			#header{ background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_jumbotron_background_repeat }}
			#header{ background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_jumbotron_background_size }}
			#header{ background-size: {{illdy_jumbotron_background_size}} !important; }
		{{/if}}
		{{#if illdy_jumbotron_general_color }}
			#header{ background-color: {{illdy_jumbotron_general_color}}; }
		{{/if}}
		{{#if illdy_jumbotron_first_button_background }}
			#header .bottom-header .header-button-one{ background-color: {{illdy_jumbotron_first_button_background}}; }
		{{/if}}
		{{#if illdy_jumbotron_first_button_background_hover }}
			#header .bottom-header .header-button-one:hover{ background-color: {{illdy_jumbotron_first_button_background_hover}}; }
		{{/if}}
		{{#if illdy_jumbotron_first_border_color }}
			#header .bottom-header .header-button-one{ border-color: {{illdy_jumbotron_first_border_color}}; }
		{{/if}}
		{{#if illdy_jumbotron_second_button_background }}
			#header .bottom-header .header-button-two{ background-color: {{illdy_jumbotron_second_button_background}}; }
		{{/if}}
		{{#if  illdy_jumbotron_second_button_background_hover }}
			#header .bottom-header .header-button-two:hover{ background-color: {{illdy_jumbotron_second_button_background_hover}}; }
		{{/if}}
		{{#if  illdy_jumbotron_title_color }}
			#header .bottom-header h1{ color: {{illdy_jumbotron_title_color}}; }
		{{/if}}
		{{#if  illdy_jumbotron_points_color }}
			#header .bottom-header span.span-dot{ color: {{illdy_jumbotron_points_color}}; }
		{{/if}}
		{{#if  illdy_jumbotron_descriptions_color }}
			#header .bottom-header .section-description{ color: {{illdy_jumbotron_descriptions_color}}; }
		{{/if}}
		{{#if  illdy_jumbotron_first_button_color }}
			#header .bottom-header .header-button-one{ color: {{illdy_jumbotron_first_button_color}}; }
		{{/if}}
		{{#if  illdy_jumbotron_right_button_color }}
			#header .bottom-header .header-button-two{ color: {{illdy_jumbotron_right_button_color}}; }
		{{/if}}
	</script>

	<script id="illdy-latestnews-section" type="text/x-handlebars-template">
		{{#if illdy_latest_news_general_image }}
			#latest-news{ background-image: url({{illdy_latest_news_general_image}}) !important; }
		{{/if}}
		{{#if illdy_latest_news_background_position_y }}
			#latest-news{ background-position-y: {{illdy_latest_news_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_latest_news_background_position_x }}
			#latest-news{ background-position-x: {{illdy_latest_news_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_latest_news_background_attachment }}
			#latest-news{ background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_latest_news_background_repeat }}
			#latest-news{ background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_latest_news_background_size }}
			#latest-news{ background-size: {{illdy_latest_news_background_size}} !important; }
		{{/if}}
		{{#if illdy_latest_news_general_color }}
			#latest-news{ background-color: {{illdy_latest_news_general_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_title_color }}
			#latest-news .section-header h3 { color: {{illdy_latest_news_title_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_descriptions_color }}
			#latest-news .section-header .section-description { color: {{illdy_latest_news_descriptions_color}}; }
		{{/if}}
		{{#if illdy_latest_news_button_background }}
			#latest-news .latest-news-button { background-color: {{illdy_latest_news_button_background}}; }
		{{/if}}
		{{#if illdy_latest_news_button_background_hover }}
			#latest-news .latest-news-button:hover { background-color: {{illdy_latest_news_button_background_hover}}; }
		{{/if}}
		{{#if illdy_latest_news_button_color }}
			#latest-news .latest-news-button { color: {{illdy_latest_news_button_color}}; }
		{{/if}}
		{{#if illdy_latest_news_post_bakground_color }}
			#latest-news .section-content .post{ background-color: {{illdy_latest_news_post_bakground_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_post_text_color }}
			#latest-news .section-content .post .post-title { color: {{illdy_latest_news_post_text_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_post_text_hover_color }}
			#latest-news .section-content .post .post-title:hover { color: {{illdy_latest_news_post_text_hover_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_post_content_color }}
			#latest-news .section-content .post .post-entry { color: {{illdy_latest_news_post_content_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_post_button_color }}
			#latest-news .section-content .post .post-button { color: {{illdy_latest_news_post_button_color}}; }
		{{/if}}
		{{#if  illdy_latest_news_post_button_hover_color }}
			#latest-news .section-content .post .post-button:hover { color: {{illdy_latest_news_post_button_hover_color}}; }
		{{/if}}
	</script>

	<script id="illdy-fullwidth-section" type="text/x-handlebars-template">
		{{#if illdy_full_width_general_image }}
			#full-width { background-image: url({{illdy_full_width_general_image}}) !important; }
		{{/if}}
		{{#if illdy_full-width_background_position_y }}
			#full-width{ background-position-y: {{illdy_full-width_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_full-width_background_position_x }}
			#full-width{ background-position-x: {{illdy_full-width_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_full_width_background_attachment }}
			#full-width { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_full_width_background_repeat }}
			#full-width { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_full_width_background_size }}
			#full-width { background-size: {{illdy_full_width_background_size}} !important; }
		{{/if}}
		{{#if illdy_full_width_general_color }}
			#full-width { background-color: {{illdy_full_width_general_color}}; }
		{{/if}}
		{{#if  illdy_full_width_title_color }}
			#full-width .section-header h3 { color: {{illdy_full_width_title_color}}; }
		{{/if}}
		{{#if  illdy_full_width_descriptions_color }}
			#full-width .section-header .section-description { color: {{illdy_full_width_descriptions_color}}; }
		{{/if}}
		{{#if  illdy_full_width_descriptions_color }}
			#full-width .top-parallax-section h1, #full-width .top-parallax-section p { color: {{illdy_full_width_full_text}}; }
		{{/if}}
	</script>

	<script id="illdy-about-section" type="text/x-handlebars-template">
		{{#if illdy_about_general_image }}
			#about { background-image: url({{illdy_about_general_image}}) !important; }
		{{/if}}
		{{#if illdy_about_background_position_y }}
			#about{ background-position-y: {{illdy_about_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_about_background_position_x }}
			#about{ background-position-x: {{illdy_about_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_about_background_attachment }}
			#about { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_about_background_repeat }}
			#about { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_about_background_size }}
			#about { background-size: {{illdy_about_background_size}} !important; }
		{{/if}}
		{{#if illdy_about_general_color }}
			#about { background-color: {{illdy_about_general_color}}; }
		{{/if}}
		{{#if  illdy_about_title_color }}
			#about .section-header h3 { color: {{illdy_about_title_color}}; }
		{{/if}}
		{{#if  illdy_about_descriptions_color }}
			#about .section-header .section-description { color: {{illdy_about_descriptions_color}}; }
		{{/if}}
	</script>

	<script id="illdy-projects-section" type="text/x-handlebars-template">
		{{#if illdy_projects_general_image }}
			#projects { background-image: url({{illdy_projects_general_image}}) !important; }
		{{/if}}
		{{#if illdy_projects_background_position_y }}
			#projects{ background-position-y: {{illdy_projects_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_projects_background_position_x }}
			#projects{ background-position-x: {{illdy_projects_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_projects_background_attachment }}
			#projects { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_projects_background_repeat }}
			#projects { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_projects_background_size }}
			#projects { background-size: {{illdy_projects_background_size}} !important; }
		{{/if}}
		{{#if illdy_projects_general_color }}
			#projects { background-color: {{illdy_projects_general_color}}; }
		{{/if}}
		{{#if  illdy_projects_title_color }}
			#projects .section-header h3 { color: {{illdy_projects_title_color}}; }
		{{/if}}
		{{#if  illdy_projects_descriptions_color }}
			#projects .section-header .section-description { color: {{illdy_projects_descriptions_color}}; }
		{{/if}}
	</script>

	<script id="illdy-services-section" type="text/x-handlebars-template">
		{{#if illdy_services_general_image }}
			#services { background-image: url({{illdy_services_general_image}}) !important; }
		{{/if}}
		{{#if illdy_services_background_position_y }}
			#services{ background-position-y: {{illdy_services_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_services_background_position_x }}
			#services{ background-position-x: {{illdy_services_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_services_background_attachment }}
			#services { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_services_background_repeat }}
			#services { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_services_background_size }}
			#services { background-size: {{illdy_services_background_size}} !important; }
		{{/if}}
		{{#if illdy_services_general_color }}
			#services { background-color: {{illdy_services_general_color}}; }
		{{/if}}
		{{#if  illdy_services_title_color }}
			#services .section-header h3 { color: {{illdy_services_title_color}}; }
		{{/if}}
		{{#if  illdy_services_descriptions_color }}
			#services .section-header .section-description { color: {{illdy_services_descriptions_color}}; }
		{{/if}}
	</script>

	<script id="illdy-team-section" type="text/x-handlebars-template">
		{{#if illdy_team_general_image }}
			#team { background-image: url({{illdy_team_general_image}}) !important; }
		{{/if}}
		{{#if illdy_team_background_position_y }}
			#team{ background-position-y: {{illdy_team_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_team_background_position_x }}
			#team{ background-position-x: {{illdy_team_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_team_background_attachment }}
			#team { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_team_background_repeat }}
			#team { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_team_background_size }}
			#team { background-size: {{illdy_team_background_size}} !important; }
		{{/if}}
		{{#if illdy_team_general_color }}
			#team { background-color: {{illdy_team_general_color}}; }
		{{/if}}
		{{#if  illdy_team_title_color }}
			#team .section-header h3 { color: {{illdy_team_title_color}}; }
		{{/if}}
		{{#if  illdy_team_descriptions_color }}
			#team .section-header .section-description { color: {{illdy_team_descriptions_color}}; }
		{{/if}}
	</script>

	<script id="illdy-testimonials-section" type="text/x-handlebars-template">
		{{#if illdy_testimonials_general_background_image }}
			#testimonials { background-image: url({{illdy_testimonials_general_background_image}}) !important; }
		{{/if}}
		{{#if illdy_testimonials_background_position_y }}
			#testimonials{ background-position-y: {{illdy_testimonials_background_position_y}} !important; }
		{{/if}}
		{{#if illdy_testimonials_background_position_x }}
			#testimonials{ background-position-x: {{illdy_testimonials_background_position_x}} !important; }
		{{/if}}
		{{#if illdy_testimonials_background_attachment }}
			#testimonials { background-attachment: scroll !important; }
		{{/if}}
		{{#if illdy_testimonials_background_repeat }}
			#testimonials { background-repeat: repeat !important; }
		{{/if}}
		{{#if illdy_testimonials_background_size }}
			#testimonials { background-size: {{illdy_testimonials_background_size}} !important; }
		{{/if}}
		{{#if illdy_testimonials_general_color }}
			#testimonials { background-color: {{illdy_testimonials_general_color}}; }
		{{/if}}
		{{#if  illdy_testimonials_title_color }}
			#testimonials .section-header h3 { color: {{illdy_testimonials_title_color}}; }
		{{/if}}
		{{#if  illdy_testimonials_author_text_color }}
			#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-meta { color: {{illdy_testimonials_author_text_color}}; }
		{{/if}}
		{{#if  illdy_testimonials_text_color }}
			#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-content blockquote { color: {{illdy_testimonials_text_color}}; }
		{{/if}}
		{{#if  illdy_testimonials_container_background_color }}
			#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-content { background-color: {{illdy_testimonials_container_background_color}}; }
			#testimonials .section-content .testimonials-carousel .carousel-testimonial .testimonial-content:after { border-color: {{illdy_testimonials_container_background_color}} transparent transparent transparent; }
		{{/if}}
		{{#if  illdy_testimonials_dots_color }}
			#testimonials .section-content .testimonials-carousel .owl-controls .owl-dots .owl-dot:hover, #testimonials .section-content .testimonials-carousel .owl-controls .owl-dots .owl-dot.active { border-color: {{illdy_testimonials_dots_color}}; }
			#testimonials .section-content .testimonials-carousel .owl-controls .owl-dots .owl-dot { background-color: {{illdy_testimonials_dots_color}}; }
		{{/if}}
	</script>

	<?php

}