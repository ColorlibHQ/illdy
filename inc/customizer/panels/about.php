<?php
// Set Panel ID
$panel_id = 'illdy_panel_about';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/********************* ABOUT  ******************/
/***********************************************/
$wp_customize->add_section( $panel_id,
    array(
        'priority'          => 102,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'About Section', 'illdy' ),
        'description'       => __( 'Control various options for about section from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/


// Show this section
$wp_customize->add_setting( $prefix . '_about_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_about_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $panel_id,
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_about_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'About', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_about_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $panel_id,
        'priority'      => 2
    )
);

// Entry
if ( get_theme_mod( $prefix .'_about_general_entry' ) ) {
    $wp_customize->add_setting( $prefix .'_about_general_entry',
        array(
            'sanitize_callback' => 'illdy_sanitize_html',
            'default'           => __( 'It is an amazing one-page theme with great features that offers an incredible experience. It is easy to install, make changes, adapt for your business. A modern design with clean lines and styling for a wide variety of content, exactly how a business design should be. You can add as many images as you want to the main header area and turn them into slider.', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix .'_about_general_entry',
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
        $prefix . '_about_general_text',
        array(
            'sanitize_callback' => 'esc_html',
            'default'           => '',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Illdy_Text_Custom_Control(
            $wp_customize, $prefix . '_about_general_text',
            array(
                'label'             => __( 'Install Illdy Companion', 'illdy' ),
                'description'       => sprintf(__( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_tgmpa_url()),
                'section'           => $panel_id,
                'settings'          => $prefix . '_about_general_text',
                'priority'          => 3,
            )
        )
    );

}
