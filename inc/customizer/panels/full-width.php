<?php
// Set Panel ID
$panel_id = 'illdy_full_width';

// Set prefix
$prefix = 'illdy';

$wp_customize->add_section( $panel_id,
    array(
        'priority'          => illdy_get_section_position($panel_id),
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Full Width Section', 'illdy' ),
        'description'       => __( 'Control title and description of full width section.', 'illdy' ),
        'panel'             => 'illdy_frontpage_panel'
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_full_width_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 
    $prefix . '_full_width_general_show',
    array(
        'type'      => 'mte-toggle',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1
    ) )
);

// Show this section
$wp_customize->add_setting( $prefix . '_full_width_padding',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 
    $prefix . '_full_width_padding',
    array(
        'type'      => 'mte-toggle',
        'label'     => __( 'Add padding to section ?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1
    ) )
);

// Title
$wp_customize->add_setting( $prefix .'_full_width_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_full_width_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $panel_id,
        'priority'      => 2
    )
);
$wp_customize->selective_refresh->add_partial( $prefix .'_full_width_general_title', array(
    'selector' => '#full-width .section-header h3',
) );

$wp_customize->add_setting( $prefix .'_full_width_general_entry',
    array(
        'sanitize_callback' => 'wp_kses_post',
        'default'           => '',
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control( new Epsilon_Editor_Custom_Control(
    $wp_customize,
    $prefix .'_full_width_general_entry',
    array(
        'label'         => __( 'Entry', 'illdy' ),
        'description'   => __( 'Add the content for this section.', 'illdy'),
        'section'       => $panel_id,
        'priority'      => 3,
    ) )
);
$wp_customize->add_setting( $prefix .'_full_width_widget_button',
    array(
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new Epsilon_Control_Button(
        $wp_customize,
        $prefix .'_full_width_widget_button',
        array(
            'text'         => __( 'Add & Edit widgets', 'illdy' ),
            'section_id'    => 'sidebar-widgets-front-page-full-width-sidebar',
            'icon'          => 'dashicons-plus',
            'section'       => $panel_id,
            'priority'      => 5
        )
    )
);