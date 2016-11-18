<?php
// Set Panel ID
$panel_id = 'illdy_panel_team';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/********************** TEAM  ******************/
/***********************************************/
$wp_customize->add_section( $panel_id,
    array(
        'priority'          => 108,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Team Section', 'illdy' ),
        'description'       => __( 'Control various options for team section from front page.', 'illdy' ),
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
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_team_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Team', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_team_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $panel_id,
        'priority'      => 2
    )
);

// Entry
if ( get_theme_mod( $prefix .'_team_general_entry' ) ) {

    $wp_customize->add_setting( $prefix .'_team_general_entry',
        array(
            'sanitize_callback' => 'illdy_sanitize_html',
            'default'           => __( 'Meet the people that are going to take your business to the next level.', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix .'_team_general_entry',
        array(
            'label'         => __( 'Entry', 'illdy' ),
            'description'   => __( 'Add the content for this section.', 'illdy'),
            'section'       => $panel_id,
            'priority'      => 3,
            'type'          => 'textarea'
        )
    );
}elseif ( !defined( "ILLDY_COMPANION" ) ) {
    
    $wp_customize->add_setting(
        $prefix . '_team_entry_text',
        array(
            'sanitize_callback' => 'esc_html',
            'default'           => '',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Illdy_Text_Custom_Control(
            $wp_customize, $prefix . '_team_entry_text',
            array(
                'label'             => __( 'Install Illdy Companion', 'illdy' ),
                'description'       => sprintf(__( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_tgmpa_url()),
                'section'           => $panel_id,
                'settings'          => $prefix . '_team_entry_text',
                'priority'          => 3,
            )
        )
    );
}
