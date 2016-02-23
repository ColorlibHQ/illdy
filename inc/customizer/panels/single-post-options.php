<?php
    // Set Panel ID
    $panel_id = 'illdy_panel_blog';

    // Set prefix
    $prefix = 'illdy';

    /***********************************************/
    /************** BLOG OPTIONS  ***************/
    /***********************************************/


    $wp_customize->add_panel( $panel_id,
        array(
            'priority'          => 111,
            'capability'        => 'edit_theme_options',
            'theme_supports'    => '',
            'title'             => esc_html__( 'Single Post Options', 'illdy' ),
            'description'       => esc_html__( 'Control various blog options from here. Most of the options from this panel refer to the blog single page view. If you\'re not familiar with that term, please perform a Google search.', 'illdy' ),
        )
    );

    /***********************************************/
    /************** Global Blog Settings  ***************/
    /***********************************************/

    $wp_customize->add_section( $prefix.'_blog_global_section' ,
        array(
            'title'       => esc_html__( 'Global', 'illdy' ),
            'description' => esc_html__( 'This section allows you to control how certain elements are displayed on the blog single page.', 'illdy' ),
            'panel' 	  => $panel_id
        )
    );

    /* Posted on on single blog posts */
    $wp_customize->add_setting( $prefix.'_enable_post_posted_on_blog_posts',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_enable_post_posted_on_blog_posts',
        array(
            'type'	         => 'checkbox',
            'label'         => esc_html__('Posted on meta on single blog post', 'illdy'),
            'description'   => esc_html__('This will disable the posted on zone as well as the author name', 'illdy'),
            'section'       => $prefix.'_blog_global_section',
        )
    );

    /* Post Category on single blog posts */
    $wp_customize->add_setting( $prefix.'_enable_post_category_blog_posts',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_enable_post_category_blog_posts',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__('Category meta on single blog post', 'illdy'),
            'description'   => esc_html__('This will disable the posted in zone.', 'illdy'),
            // 'section'       => $prefix.'_blog_global_section',
        )
    );



    /* Post Tags on single blog posts */
    $wp_customize->add_setting( $prefix.'_enable_post_tags_blog_posts',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_enable_post_tags_blog_posts',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__('Tags meta on single blog post', 'illdy'),
            'description'   => esc_html__('This will disable the tagged with zone.', 'illdy'),
            'section'       => $prefix.'_blog_global_section',
        )
    );

    /* Post Comments on single blog posts */
    $wp_customize->add_setting( $prefix.'_enable_post_comments_blog_posts',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix.'_enable_post_comments_blog_posts',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__('Coments meta on single blog post', 'illdy'),
            'description'   => esc_html__('This will disable the comments header zone.', 'illdy'),
            'section'       => $prefix.'_blog_global_section',
        )
    );

    /* Social Sharing on single blog posts */
    $wp_customize->add_setting(
        $prefix . '_enable_social_sharing_blog_posts',
        array(
            'sanitize_callback' => $prefix . '_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_enable_social_sharing_blog_posts',
        array(
            'type'              => 'checkbox',
            'label'             => esc_html__( 'Social sharing?', 'illdy' ),
            'description'       => esc_html__('Displayed right under the post title', 'illdy'),
            'section'           => $prefix . '_blog_global_section',
        )
    );

    /* Author Info Box on single blog posts */
    $wp_customize->add_setting( $prefix.'_enable_author_box_blog_posts',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_enable_author_box_blog_posts',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__('Author info box on single blog post', 'illdy'),
            'description'   => esc_html__('Displayed right at the end of the post', 'illdy'),
            'section'       => $prefix.'_blog_global_section',
        )
    );

    /***********************************************/
    /************** Social Blog Settings  ***************/
    /***********************************************/


    $wp_customize->add_section( $prefix.'_blog_social_section' ,
        array(
            'title'       => esc_html__( 'Social Sharing', 'illdy' ),
            'description' => esc_html__( 'Control visibility of various social sharing networks. The changes made here will reflect on the blog single post view.', 'illdy' ),
            'panel'      => $panel_id
        )
    );

    /* Facebook visibility */
    $wp_customize->add_setting($prefix.'_facebook_visibility',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_facebook_visibility',
        array(
            'type'  => 'checkbox',
            'label' => esc_html__('Display share on Facebook ?', 'illdy'),
            'section' => $prefix.'_blog_social_section',
        )
    );

    /* Twitter visibility */
    $wp_customize->add_setting($prefix.'_twitter_visibility',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_twitter_visibility',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Display share on Twitter ?', 'illdy'),
            'section'   => $prefix.'_blog_social_section',
        )
    );

    /* LinkedIN visibility */
    $wp_customize->add_setting($prefix.'_linkein_visibility',
        array(
            'sanitize_callback' => $prefix.'_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix.'_linkein_visibility',
        array(
           'type'       => 'checkbox',
           'label'      => esc_html__('Display share on LinkedIN ?', 'illdy'),
           'section'    => $prefix.'_blog_social_section',
        )
    );