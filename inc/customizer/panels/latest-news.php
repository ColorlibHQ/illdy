<?php

// Set prefix
$prefix = 'illdy';

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_latest_news_general' ,
    array(
        'title'         => __( 'Latest News Section', 'illdy' ),
        'description'   => __( 'Control various options for latest news section from front page.', 'illdy' ),
        'priority'      => illdy_get_section_position($prefix . '_latest_news_general'),
        'panel' 	    => 'illdy_frontpage_panel'
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
$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize,
    $prefix . '_latest_news_general_show',
    array(
        'type'      => 'mte-toggle',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_latest_news_general',
        'priority'  => 1
    ) )
);

// Title
$wp_customize->add_setting( $prefix .'_latest_news_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Latest News', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 2
    )
);
$wp_customize->selective_refresh->add_partial( $prefix .'_latest_news_general_title', array(
    'selector' => '#latest-news .section-header h3',
) );

// Entry
if ( get_theme_mod( $prefix .'_latest_news_general_entry' ) ) {
    $wp_customize->add_setting( $prefix .'_latest_news_general_entry',
        array(
            'sanitize_callback' => 'illdy_sanitize_html',
            'default'           => __( 'If you are interested in the latest articles in the industry, take a sneak peek at our blog. You have nothing to loose!', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix .'_latest_news_general_entry',
        array(
            'label'         => __( 'Entry', 'illdy' ),
            'description'   => __( 'Add the content for this section.', 'illdy'),
            'section'       => $prefix . '_latest_news_general',
            'priority'      => 3,
            'type'          => 'textarea'
        )
    );
}elseif ( !defined( "ILLDY_COMPANION" ) ) {
    
    $wp_customize->add_setting(
        $prefix . '_latest_news_general_text',
        array(
            'sanitize_callback' => 'esc_html',
            'default'           => '',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Illdy_Text_Custom_Control(
            $wp_customize, $prefix . '_latest_news_general_text',
            array(
                'label'             => __( 'Install Illdy Companion', 'illdy' ),
                'description'       => sprintf(__( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_recommended_actions_url()),
                'section'           => $panel_id,
                'settings'          => $prefix . '_latest_news_general_text',
                'priority'          => 3,
            )
        )
    );
    
}
$wp_customize->selective_refresh->add_partial( $prefix .'_latest_news_general_text', array(
    'selector' => '#latest-news .section-header p',
) );

// Button Text
$wp_customize->add_setting( $prefix .'_latest_news_button_text',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => __( 'See blog', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_latest_news_button_text',
    array(
        'label'         => __( 'Button Text', 'illdy' ),
        'description'   => __( 'Add the button text for this section.', 'illdy'),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 4
    )
);
$wp_customize->selective_refresh->add_partial( $prefix .'_latest_news_button_text', array(
    'selector' => '#latest-news .latest-news-button',
) );


// Number of posts
$wp_customize->add_setting( $prefix .'_latest_news_number_of_posts',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 3,
    )
);

$wp_customize->add_control( new Epsilon_Control_Slider(
    $wp_customize,
    $prefix .'_latest_news_number_of_posts',
    array(
        'label'       => esc_html__( 'Number of posts', 'illdy' ),
        'description' => esc_html__( 'Add the number of posts to show in this section.', 'illdy'),
        'choices'     => array(
            'min'  => 3,
            'max'  => 9,
            'step' => 3,
        ),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 5
    )
)
);

$wp_customize->add_setting( $prefix .'_latest_news_words_number',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 20,
    )
);

$wp_customize->add_control( new Epsilon_Control_Slider(
    $wp_customize,
    $prefix .'_latest_news_words_number',
    array(
        'label'       => esc_html__( 'Number of words in post entry', 'illdy' ),
        'choices'     => array(
            'min'  => 20,
            'max'  => 100,
            'step' => 10,
        ),
        'section'       => $prefix . '_latest_news_general',
        'priority'      => 6
    )
)
);