<?php
// Set Panel ID
$panel_id = 'illdy_panel_counter';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/******************* COUNTER  ******************/
/***********************************************/
// $wp_customize->add_panel( $panel_id,
//     array(
//         'priority'          => 107,
//         'capability'        => 'edit_theme_options',
//         'theme_supports'    => '',
//         'title'             => __( 'Counter Section', 'illdy' ),
//         'description'       => __( 'Control various options for counter section from front page.', 'illdy' ),
//     )
// );

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_counter_general' ,
    array(
        'priority'      => 107,
        'title'         => __( 'Counter Section', 'illdy' ),
        'description'   => __( '*In order to get this section to show up on the front-page, make sure you have: 1) enabled static front-page & 2) have a widget placed in this sidebar. More specifically go to Widgets -> Front page - counter sidebar & place the [Illdy] - Counter widget in here.', 'illdy' ),
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_counter_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_counter_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_counter_general',
        'priority'  => 1
    )
);


// Type of Background
$wp_customize->add_setting( $prefix . '_counter_background_type', array(
    'default'           => 'image',
    'sanitize_callback' => 'illdy_sanitize_radio_buttons',
    'transport'         => 'postMessage'
) );
$wp_customize->add_control( $prefix . '_counter_background_type', array(
    'label'     => __( 'Type of Background', 'illdy' ),
    'section'   => $prefix .'_counter_general',
    'settings'  => $prefix . '_counter_background_type',
    'type'      => 'radio',
    'choices'   => array(
        'image'     => __( 'Image', 'illdy' ),
        'color'     => __( 'Color', 'illdy' )
    ),
    'priority'  => 1
) );

// Image
$wp_customize->add_setting(
    $prefix . '_counter_background_image',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'default'           => esc_url( get_template_directory_uri() . '/layout/images/front-page/front-page-counter.jpg' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize, $prefix . '_counter_background_image',
        array(
            'label'     => __( 'Image', 'illdy' ),
            'section'   => $prefix .'_counter_general',
            'settings'  => $prefix . '_counter_background_image',
            'priority'  => 2
        )
    )
);

// Color
$wp_customize->add_setting(
    $prefix . '_counter_background_color',
    array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default'           => '#000000',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
    $wp_customize, 
    $prefix . '_counter_background_color',
    array(
        'label'     => __( 'Color', 'illdy' ),
        'section'   => $prefix .'_counter_general',
        'settings'  => $prefix . '_counter_background_color',
        'priority'  => 3
    ) ) 
);
