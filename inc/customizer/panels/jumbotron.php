<?php
// Set Panel ID
$panel_id = 'illdy_panel_jumbotron';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/***************** JUMBOTRON  ******************/
/***********************************************/
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 100,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => esc_html__( 'Jumbotron', 'illdy' ),
        'description'       => esc_html__( 'Control various options for header image from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix.'_jumbotron_general' ,
    array(
        'title'       => esc_html__( 'General', 'illdy' ),
        'panel' 	  => $panel_id
    )
);

// Image
$wp_customize->add_setting(
    $prefix . '_jumbotron_general_image',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'default'           => esc_url( get_template_directory_uri() . '/layout/images/front-page/front-page-header.png' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize, $prefix . '_jumbotron_general_image',
        array(
            'label'     => __( 'Image', 'illdy' ),
            'section'   => $prefix .'_jumbotron_general',
            'settings'  => $prefix . '_jumbotron_general_image',
            'priority'  => 1
        )
    )
);

// First word from title
$wp_customize->add_setting( $prefix .'_jumbotron_general_first_row_from_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Clean', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_first_row_from_title',
    array(
        'label'         => esc_html__( 'First word from title', 'illdy' ),
        'description'   => esc_html__( 'Add first word in the title.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 2
    )
);

// Second word from title
$wp_customize->add_setting( $prefix .'_jumbotron_general_second_row_from_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Slick', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_second_row_from_title',
    array(
        'label'         => esc_html__( 'Second word from title', 'illdy' ),
        'description'   => esc_html__( 'Add second word in the title.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 3
    )
);

// Thirs word from title
$wp_customize->add_setting( $prefix .'_jumbotron_general_third_row_from_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Pixel Perfect', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_third_row_from_title',
    array(
        'label'         => esc_html__( 'Third word from title', 'illdy' ),
        'description'   => esc_html__( 'Add third word in the title.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 4
    )
);

// Entry
$wp_customize->add_setting( $prefix .'_jumbotron_general_entry',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'lldy is a great one-page theme, perfect for developers and designers but also for someone who just wants a new website for his business. Try it now!', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_entry',
    array(
        'label'         => esc_html__( 'Entry', 'illdy' ),
        'description'   => esc_html__( 'The content added in this field will show below title.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 5,
        'type'          => 'textarea'
    )
);

// First button text
$wp_customize->add_setting( $prefix .'_jumbotron_general_first_button_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Learn more', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_first_button_title',
    array(
        'label'         => esc_html__( 'First button title', 'illdy' ),
        'description'   => esc_html__( 'Add the text for first button.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 6
    )
);

// First button URL
$wp_customize->add_setting( 'illdy_jumbotron_general_first_button_url',
    array(
        'sanitize_callback'  => 'esc_url_raw',
        'default'            => esc_url( '#' ),
        'transport'          => 'postMessage'
    )
);
$wp_customize->add_control( 'illdy_jumbotron_general_first_button_url',
    array(
        'label'          => esc_html__( 'First button URL', 'illdy' ),
        'description'    => esc_html__( 'Add the URL for first button.', 'illdy' ),
        'section'        => $prefix . '_jumbotron_general',
        'settings'       => 'illdy_jumbotron_general_first_button_url',
        'priority'       => 7
    )
);

// Second button text
$wp_customize->add_setting( $prefix .'_jumbotron_general_second_button_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Download', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_jumbotron_general_second_button_title',
    array(
        'label'         => esc_html__( 'Second button title', 'illdy' ),
        'description'   => esc_html__( 'Add the text for second button.', 'illdy'),
        'section'       => $prefix . '_jumbotron_general',
        'priority'      => 8
    )
);

// Second button URL
$wp_customize->add_setting( 'illdy_jumbotron_general_second_button_url',
    array(
        'sanitize_callback'  => 'esc_url_raw',
        'default'            => esc_url( '#' ),
        'transport'          => 'postMessage'
    )
);
$wp_customize->add_control( 'illdy_jumbotron_general_second_button_url',
    array(
        'label'          => esc_html__( 'Second button URL', 'illdy' ),
        'description'    => esc_html__( 'Add the URL for second button.', 'illdy' ),
        'section'        => $prefix . '_jumbotron_general',
        'settings'       => 'illdy_jumbotron_general_second_button_url',
        'priority'       => 9
    )
);