<?php
// Set Panel ID
$panel_id = 'illdy_panel_services';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/****************** SERVICES  ******************/
/***********************************************/
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 101,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => esc_html__( 'Services', 'illdy' ),
        'description'       => esc_html__( 'Control various options for services section from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_services_general' ,
    array(
        'title'     => esc_html__( 'General', 'illdy' ),
        'panel'     => $panel_id,
        'priority'  => 1
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_services_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_services_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_services_general',
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_services_general_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Services', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_services_general_title',
    array(
        'label'         => esc_html__( 'Title', 'illdy' ),
        'description'   => esc_html__( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_services_general',
        'priority'      => 2
    )
);

// Entry
$wp_customize->add_setting( $prefix .'_services_general_entry',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'In order to help you grow your business, our carefully selected experts can advise you in in the following areas:', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_services_general_entry',
    array(
        'label'         => esc_html__( 'Entry', 'illdy' ),
        'description'   => esc_html__( 'Add the content for this section.', 'illdy'),
        'section'       => $prefix . '_services_general',
        'priority'      => 3,
        'type'          => 'textarea'
    )
);