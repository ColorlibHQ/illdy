<?php
// Set prefix
$prefix = 'illdy';


/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_jumbotron_general', array(
	'title'       => __( 'Jumbotron Section', 'illdy' ),
	'description' => __( 'Control various jumbotron related settings. Will only be displayed if a <strong>custom front-page is set in Settings -> Reading.</strong>', 'illdy' ),
	'priority'    => 10,
	'panel'       => 'illdy_frontpage_panel'
) );

// Image
$wp_customize->add_setting( $prefix . '_jumbotron_general_image', array(
	'sanitize_callback' => 'esc_url_raw',
	'default'           => esc_url_raw( get_template_directory_uri() . '/layout/images/front-page/front-page-header.png' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix . '_jumbotron_general_image', array(
	'label'    => __( 'Background Image', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
	'settings' => $prefix . '_jumbotron_general_image',
) ) );

// Featured image in header
$wp_customize->add_setting( $prefix . '_jumbotron_enable_featured_image', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 0,
	'transport'         => 'postMessage',
) );

$wp_customize->add_control(  new Epsilon_Control_Toggle( $wp_customize, $prefix . '_jumbotron_enable_featured_image', array(
	'type'        => 'mte-toggle',
	'label'       => __( 'Featured image as jumbotron ?', 'illdy' ),
	'description' => __( 'This will remove the featured image from inside the post content and use it in the jumbotron as a background image. Works for single posts & pages.', 'illdy' ),
	'section'     => $prefix . '_jumbotron_general',
) ) );

// Featured image in header
$wp_customize->add_setting( $prefix . '_jumbotron_enable_parallax_effect', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );

$wp_customize->add_control(  new Epsilon_Control_Toggle( $wp_customize, $prefix . '_jumbotron_enable_parallax_effect', array(
	'type'        => 'mte-toggle',
	'label'       => __( 'Parallax effect on header image ?', 'illdy' ),
	'description' => __( 'Enabling this will add a parallax scrolling effect for the header image.', 'illdy' ),
	'section'     => $prefix . '_jumbotron_general',
) ) );

// First word from title
$wp_customize->add_setting( $prefix . '_jumbotron_general_first_row_from_title', array(
	'sanitize_callback' => 'illdy_sanitize_html',
	'default'           => __( 'Clean', 'illdy' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_jumbotron_general_first_row_from_title', array(
	'label'    => __( 'First word from title', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
) );

$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_first_row_from_title', array(
    'selector' => '#header .bottom-header h1 span:nth-child(1)',
    'render_callback' => $prefix .'_jumbotron_general_first_row_from_title',
) );

// Second word from title
$wp_customize->add_setting( $prefix . '_jumbotron_general_second_row_from_title', array(
	'sanitize_callback' => 'illdy_sanitize_html',
	'default'           => __( 'Slick', 'illdy' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_jumbotron_general_second_row_from_title', array(
	'label'    => __( 'Second word from title', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
) );

$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_second_row_from_title', array(
    'selector' => '#header .bottom-header h1 span:nth-child(3)',
    'render_callback' => $prefix .'_jumbotron_general_second_row_from_title',
) );

// Third word from title
$wp_customize->add_setting( $prefix . '_jumbotron_general_third_row_from_title', array(
	'sanitize_callback' => 'illdy_sanitize_html',
	'default'           => __( 'Pixel Perfect', 'illdy' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_jumbotron_general_third_row_from_title', array(
	'label'    => __( 'Third word from title', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
) );

$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_third_row_from_title', array(
    'selector' => '#header .bottom-header h1 span:nth-child(5)',
    // 'render_callback' => $prefix .'_jumbotron_general_second_row_from_title',
) );

// Entry
if ( get_theme_mod( $prefix . '_jumbotron_general_entry' ) ) {

	$wp_customize->add_setting( $prefix . '_jumbotron_general_entry', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => __( 'lldy is a great one-page theme, perfect for developers and designers but also for someone who just wants a new website for his business. Try it now!', 'illdy' ),
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control(  new Epsilon_Editor_Custom_Control(
        $wp_customize, $prefix . '_jumbotron_general_entry', array(
		'label'       => __( 'Entry', 'illdy' ),
		'description' => __( 'The content added in this field will show below the title.', 'illdy' ),
		'section'     => $prefix . '_jumbotron_general',
	) ) );

}

$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_entry', array(
    'selector' => '#header .bottom-header .col-sm-8 p',
) );


// First button text
$wp_customize->add_setting( $prefix . '_jumbotron_general_first_button_title', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'           => __( 'Learn more', 'illdy' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_jumbotron_general_first_button_title', array(
	'label'    => __( 'First button title', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
) );
$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_first_button_title', array(
    'selector' => '#header .bottom-header .col-sm-8 .header-button-one',
) );

// First button URL
$wp_customize->add_setting( 'illdy_jumbotron_general_first_button_url', array(
	'sanitize_callback' => 'esc_url_raw',
	'default'           => esc_url( '#' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( 'illdy_jumbotron_general_first_button_url', array(
	'label'    => __( 'First button URL', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
	'settings' => 'illdy_jumbotron_general_first_button_url',
) );


// Second button text
$wp_customize->add_setting( $prefix . '_jumbotron_general_second_button_title', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'           => __( 'Download', 'illdy' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_jumbotron_general_second_button_title', array(
	'label'    => __( 'Second button title', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
) );
$wp_customize->selective_refresh->add_partial( $prefix .'_jumbotron_general_second_button_title', array(
    'selector' => '#header .bottom-header .col-sm-8 .header-button-two',
) );

// Second button URL
$wp_customize->add_setting( 'illdy_jumbotron_general_second_button_url', array(
	'sanitize_callback' => 'esc_url_raw',
	'default'           => esc_url( '#' ),
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( 'illdy_jumbotron_general_second_button_url', array(
	'label'    => __( 'Second button URL', 'illdy' ),
	'section'  => $prefix . '_jumbotron_general',
	'settings' => 'illdy_jumbotron_general_second_button_url',
) );