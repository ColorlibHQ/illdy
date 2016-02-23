<?php
// Set Panel ID
$panel_id = 'illdy_panel_latest_news';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/*************** LATEST NEWS  ******************/
/***********************************************/
$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 101,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => esc_html__( 'Latest News', 'illdy' ),
        'description'       => esc_html__( 'Control various options for latest news section from front page.', 'illdy' ),
    )
);

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_latest_news_general' ,
    array(
        'title'       => esc_html__( 'General', 'illdy' ),
        'panel' 	  => $panel_id
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_latest_news_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_latest_news_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_latest_news_general',
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_latest_news_general_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Latest News', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_general_title',
    array(
        'label'         => esc_html__( 'Title', 'illdy' ),
        'description'   => esc_html__( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 2
    )
);

// Entry
$wp_customize->add_setting( $prefix .'_latest_news_general_entry',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'If you are interested in the latest articles in the industry, take a sneak peek at our blog. You’ve got nothing to loose!', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_general_entry',
    array(
        'label'         => esc_html__( 'Entry', 'illdy' ),
        'description'   => esc_html__( 'Add the content for this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 3,
        'type'          => 'textarea'
    )
);

// Button Text
$wp_customize->add_setting( $prefix .'_latest_news_button_text',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'See blog', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_button_text',
    array(
        'label'         => esc_html__( 'Button Text', 'illdy' ),
        'description'   => esc_html__( 'Add the button text for this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 4
    )
);

// Button URL
$wp_customize->add_setting( 'illdy_latest_news_button_url',
    array(
        'sanitize_callback'  => 'esc_url',
        'default'            => esc_url( '#' ),
        'transport'          => 'postMessage'
    )
);
$wp_customize->add_control( 'illdy_latest_news_button_url',
    array(
        'label'          => esc_html__( 'Button Text', 'illdy' ),
        'description'    => esc_html__( 'Add the button URL for this section.', 'illdy'),
        'section'        => $prefix . '_latest_news_general',
        'settings'       => 'illdy_latest_news_button_url',
        'priority'       => 5
    )
);

// Number of posts
$wp_customize->add_setting( $prefix .'_latest_news_number_of_posts',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 3,
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_number_of_posts',
    array(
        'label'         => esc_html__( 'Number of posts', 'illdy' ),
        'description'   => esc_html__( 'Add the number of posts to show in this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 5
    )
);