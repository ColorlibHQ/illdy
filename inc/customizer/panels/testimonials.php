<?php
// Set Panel ID
$panel_id = 'illdy_panel_testimonials';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/****************** TESTIMONIALS  **************/
/***********************************************/
/*
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 101,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Testimonials', 'illdy' ),
        'description'       => __( 'Control various options for testimonials section from front page.', 'illdy' ),
    )
);
*/

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_testimonials_general' ,
    array(
        'title'         => __( 'Testimonials Section', 'illdy' ),
        'description'   => __( 'Control various options for testimonials section from front page.', 'illdy' ),
        'priority'      => 104
        // 'title'     => __( 'General', 'illdy' ),
        // 'panel'     => $panel_id,
        // 'priority'  => 1
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_testimonials_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_testimonials_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_testimonials_general',
        'priority'  => 1,
        'active_callback'   => 'illdy_is_active_jetpack_testimonials'
    )
);

// Title
$wp_customize->add_setting( $prefix .'_testimonials_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Testimonials', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_testimonials_general_title',
    array(
        'label'             => __( 'Title', 'illdy' ),
        'description'       => __( 'Add the title for this section.', 'illdy'),
        'section'           => $prefix . '_testimonials_general',
        'priority'          => 2,
        'active_callback'   => 'illdy_is_active_jetpack_testimonials'
    )
);

// Background Image
$wp_customize->add_setting(
    $prefix . '_testimonials_general_background_image',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize, $prefix . '_testimonials_general_background_image',
        array(
            'label'             => __( 'Background Image', 'illdy' ),
            'section'           => $prefix .'_testimonials_general',
            'settings'          => $prefix . '_testimonials_general_background_image',
            'priority'          => 3,
            'active_callback'   => 'illdy_is_active_jetpack_testimonials'
        )
    )
);

// Number of posts
$wp_customize->add_setting( $prefix .'_testimonials_number_of_posts',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => absint( 4 ),
    )
);
$wp_customize->add_control(
    $prefix .'_testimonials_number_of_posts',
    array(
        'label'             => __( 'Number of posts', 'illdy' ),
        'description'       => __( 'Add the number of posts to show in this section.', 'illdy'),
        'section'           => $prefix . '_testimonials_general',
        'priority'          => 4,
        'active_callback'   => 'illdy_is_active_jetpack_testimonials'
    )
);

// Install JetPack
$wp_customize->add_setting(
    $prefix . '_testimonials_general_text',
    array(
        'sanitize_callback' => 'esc_html',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new Illdy_Text_Custom_Control(
        $wp_customize, $prefix . '_testimonials_general_text',
        array(
            'label'             => __( 'Install JetPack', 'illdy' ),
            'description'       => __( 'In order to get the Testimonials module working, you will have to install JetPack and enable Custom Post Type: Testimonials.', 'illdy' ),
            'section'           => $prefix .'_testimonials_general',
            'settings'          => $prefix . '_testimonials_general_text',
            'priority'          => 5,
            'active_callback'   => 'illdy_is_not_active_jetpack_testimonials'
        )
    )
);