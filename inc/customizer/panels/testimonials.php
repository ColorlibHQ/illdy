<?php
// Set Panel ID
$panel_id = 'illdy_panel_testimonials';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/****************** TESTIMONIALS  **************/
/***********************************************/
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 101,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => esc_html__( 'Testimonials', 'illdy' ),
        'description'       => esc_html__( 'Control various options for testimonials section from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_testimonials_general' ,
    array(
        'title'     => esc_html__( 'General', 'illdy' ),
        'panel'     => $panel_id,
        'priority'  => 1
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
        'label'     => esc_html__( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_testimonials_general',
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_testimonials_general_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Testimonials', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_testimonials_general_title',
    array(
        'label'         => esc_html__( 'Title', 'illdy' ),
        'description'   => esc_html__( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_testimonials_general',
        'priority'      => 2
    )
);

// Testimonials
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
            'label'     => __( 'Background Image', 'illdy' ),
            'section'   => $prefix .'_testimonials_general',
            'settings'  => $prefix . '_testimonials_general_background_image',
            'priority'  => 3
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
        'label'         => esc_html__( 'Number of posts', 'illdy' ),
        'description'   => esc_html__( 'Add the number of posts to show in this section.', 'illdy'),
        'section'       => $prefix . '_testimonials_general',
        'priority'      => 4
    )
);