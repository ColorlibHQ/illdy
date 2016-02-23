<?php
// Set Panel ID
$panel_id = 'illdy_panel_team';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/********************** TEAM  ******************/
/***********************************************/
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 101,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => esc_html__( 'Team', 'illdy' ),
        'description'       => esc_html__( 'Control various options for team section from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_team_general' ,
    array(
        'title'     => esc_html__( 'General', 'illdy' ),
        'panel'     => $panel_id,
        'priority'  => 1
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_team_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_team_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_team_general',
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_team_general_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Team', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_team_general_title',
    array(
        'label'         => esc_html__( 'Title', 'illdy' ),
        'description'   => esc_html__( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_team_general',
        'priority'      => 2
    )
);

// Entry
$wp_customize->add_setting( $prefix .'_team_general_entry',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Meet the people that are going to take your business to the next level.', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_team_general_entry',
    array(
        'label'         => esc_html__( 'Entry', 'illdy' ),
        'description'   => esc_html__( 'Add the content for this section.', 'illdy'),
        'section'       => $prefix . '_team_general',
        'priority'      => 3,
        'type'          => 'textarea'
    )
);