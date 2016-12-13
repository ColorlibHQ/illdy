<?php
// Set Panel ID
$panel_id = 'illdy_panel_jumbotron';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/***************** JUMBOTRON  ******************/
/***********************************************/
/*
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 100,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Jumbotron', 'illdy' ),
        'description'       => __( 'Control various options for header image from front page.', 'illdy' ),
    )
);
*/

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_jumbotron_general', array(
	'title'       => __( 'Jumbotron Section', 'illdy' ),
	'description' => __( 'Control various jumbotron related settings. Will only be displayed if a <strong>custom front-page is set in Settings -> Reading.</strong>', 'illdy' ),
	'priority'    => 100
	// 'title'     => __( 'General', 'illdy' ),
	// 'panel'     => $panel_id
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

$wp_customize->add_control( $prefix . '_jumbotron_enable_featured_image', array(
	'type'        => 'checkbox',
	'label'       => __( 'Featured image as jumbotron ?', 'illdy' ),
	'description' => __( 'This will remove the featured image from inside the post content and use it in the jumbotron as a background image. Works for single posts & pages.', 'illdy' ),
	'section'     => $prefix . '_jumbotron_general',
) );

// Featured image in header
$wp_customize->add_setting( $prefix . '_jumbotron_enable_parallax_effect', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( $prefix . '_jumbotron_enable_parallax_effect', array(
	'type'        => 'checkbox',
	'label'       => __( 'Parallax effect on header image ?', 'illdy' ),
	'description' => __( 'Enabling this will add a parallax scrolling effect for the header image.', 'illdy' ),
	'section'     => $prefix . '_jumbotron_general',
) );

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

// Entry
if ( get_theme_mod( $prefix . '_jumbotron_general_entry' ) ) {

	$wp_customize->add_setting( $prefix . '_jumbotron_general_entry', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'lldy is a great one-page theme, perfect for developers and designers but also for someone who just wants a new website for his business. Try it now!', 'illdy' ),
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( $prefix . '_jumbotron_general_entry', array(
		'label'       => __( 'Entry', 'illdy' ),
		'description' => __( 'The content added in this field will show below the title.', 'illdy' ),
		'section'     => $prefix . '_jumbotron_general',
		'type'        => 'textarea',
	) );

}


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