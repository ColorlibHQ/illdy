<?php
// Set Panel ID
$panel_id = 'illdy_panel_projects';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/****************** PROJECTS  ******************/
/***********************************************/
$wp_customize->add_section( $panel_id,
    array(
        'priority'          => 103,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Projects Section', 'illdy' ),
        'description'       => __( 'Control various options for projects section from front page.', 'illdy' ),
        'panel'             => 'illdy_frontpage_panel'
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/


// Show this section
$wp_customize->add_setting( $prefix . '_projects_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(  new Epsilon_Control_Toggle( $wp_customize,
    $prefix . '_projects_general_show',
    array(
        'type'      => 'mte-toggle',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1,
    ) )
);
$wp_customize->add_setting( $prefix . '_projects_lightbox',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 0,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(  new Epsilon_Control_Toggle( $wp_customize,
    $prefix . '_projects_lightbox',
    array(
        'type'      => 'mte-toggle',
        'label'     => __( 'Enable Lightbox ?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1,
    ) )
);

// Title
$wp_customize->add_setting( $prefix .'_projects_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Projects', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_projects_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $panel_id,
        'priority'      => 2,
    )
);
$wp_customize->selective_refresh->add_partial( $prefix .'_projects_general_title', array(
    'selector' => '#projects .section-header h3',
) );

// Entry
if ( get_theme_mod( $prefix .'_projects_general_entry' ) ) {
    
    $wp_customize->add_setting( $prefix .'_projects_general_entry',
        array(
            'sanitize_callback' => 'illdy_sanitize_html',
            'default'           => __( 'You\'ll love our work. Check it out!', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix .'_projects_general_entry',
        array(
            'label'         => __( 'Entry', 'illdy' ),
            'description'   => __( 'Add the content for this section.', 'illdy'),
            'section'       => $panel_id,
            'priority'      => 3,
            'type'          => 'textarea'
        )
    );

    $wp_customize->selective_refresh->add_partial( $prefix .'_projects_general_entry', array(
        'selector' => '#projects .section-header p',
    ) );
    
}elseif ( !defined( "ILLDY_COMPANION" ) ) {
    
    $wp_customize->add_setting(
        $prefix . '_projects_entry_text',
        array(
            'sanitize_callback' => 'esc_html',
            'default'           => '',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Illdy_Text_Custom_Control(
            $wp_customize, $prefix . '_projects_entry_text',
            array(
                'label'             => __( 'Install Illdy Companion', 'illdy' ),
                'description'       => sprintf(__( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_recommended_actions_url()),
                'section'           => $panel_id,
                'settings'          => $prefix . '_projects_entry_text',
                'priority'          => 3,
            )
        )
    );
}
$wp_customize->add_setting( $prefix .'_projects_widget_button',
    array(
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    new Epsilon_Control_Button(
        $wp_customize,
        $prefix .'_projects_widget_button',
        array(
            'text'         => __( 'Add & Edit Projects', 'illdy' ),
            'section_id'    => 'sidebar-widgets-front-page-projects-sidebar',
            'icon'          => 'dashicons-plus',
            'section'       => $panel_id,
            'priority'      => 5
        )
    )
);