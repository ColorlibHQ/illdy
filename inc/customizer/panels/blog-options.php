<?php

// Set Panel ID
$panel_id = 'illdy_panel_blog_options';

// Set prefix
$prefix = 'illdy';

// Change panel for Site Title & Tagline Section
$site_title        = $wp_customize->get_section( 'title_tagline' );
$site_title->title = __( 'Blog Jumbotron Titles', 'illdy' );
$site_title->panel = $panel_id;

// Change priority for Site Title
$site_title           = $wp_customize->get_control( 'blogname' );
$site_title->label    = __( 'Default site title', 'illdy' );
$site_title->priority = 15;

// Change priority for Site Tagline
$site_title              = $wp_customize->get_control( 'blogdescription' );
$site_title->label       = __( 'Default site tagline', 'illdy' );
$site_title->description = __( 'The tagline will be shown on archive pages, in the jumbotron right below the title.', 'illdy' );
$site_title->priority    = 17;

// site title
$site_logo              = $wp_customize->get_control( 'blogname' );
$site_logo->description = __( 'This is the default WordPress title. This will be used in the jumbotron, if you don\'t specify a custom title.', 'illdy' );

$wp_customize->add_panel( $panel_id, array(
	'priority'       => 2,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => __( 'Blog Options', 'illdy' ),
	'description'    => __( 'You can change blog options ', 'illdy' ),
) );

//
$wp_customize->get_section( 'header_image' )->panel = $panel_id;
$wp_customize->get_section( 'header_image' )->title = __( 'Blog Archive Header Image', 'illdy' );

$wp_customize->add_setting(
    $prefix . '_archive_page_background_stretch',
    array(
        'sanitize_callback' => 'illdy_sanitize_select',
        'default'           => 1
    )
);
$wp_customize->add_control(
    $prefix . '_archive_page_background_stretch',
    array(
        'label'         => __( 'Background Stretch', 'illdy' ),
        'type'          => 'select',
        'section'       => 'header_image',
        'choices'       => array(
            1   => __( 'Cover', 'illdy' ),
            2   => __( 'Contain', 'illdy' ),
        )
    )
);

/***********************************************/
/************** Blog Settings  ***************/
/***********************************************/




/***********************************************/
/************** Single Blog Settings  ***************/
/***********************************************/

$wp_customize->add_section( $prefix . '_blog_global_section', array(
	'title'       => __( 'Single Post Options', 'illdy' ),
	'description' => __( 'This section allows you to control how certain elements are displayed on the blog single page.', 'illdy' ),
	'panel'       => $panel_id,
) );

/* Posted on on single blog posts */
$wp_customize->add_setting( $prefix . '_enable_post_posted_on_blog_posts', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( $prefix . '_enable_post_posted_on_blog_posts', array(
	'type'        => 'checkbox',
	'label'       => __( 'Posted on meta on single blog post', 'illdy' ),
	'description' => __( 'This will disable the posted on zone as well as the author name', 'illdy' ),
	'section'     => $prefix . '_blog_global_section',
) );

/* Post Category on single blog posts */
$wp_customize->add_setting( $prefix . '_enable_post_category_blog_posts', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_enable_post_category_blog_posts', array(
	'type'        => 'checkbox',
	'label'       => __( 'Category meta on single blog post', 'illdy' ),
	'description' => __( 'This will disable the posted in zone.', 'illdy' ),
	// 'section'       => $prefix.'_blog_global_section',
) );


/* Post Tags on single blog posts */
$wp_customize->add_setting( $prefix . '_enable_post_tags_blog_posts', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_enable_post_tags_blog_posts', array(
	'type'        => 'checkbox',
	'label'       => __( 'Tags meta on single blog post', 'illdy' ),
	'description' => __( 'This will disable the tagged with zone.', 'illdy' ),
	'section'     => $prefix . '_blog_global_section',
) );

/* Post Comments on single blog posts */
$wp_customize->add_setting( $prefix . '_enable_post_comments_blog_posts', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( $prefix . '_enable_post_comments_blog_posts', array(
	'type'        => 'checkbox',
	'label'       => __( 'Coments meta on single blog post', 'illdy' ),
	'description' => __( 'This will disable the comments header zone.', 'illdy' ),
	'section'     => $prefix . '_blog_global_section',
) );

/* Author Info Box on single blog posts */
$wp_customize->add_setting( $prefix . '_enable_author_box_blog_posts', array(
	'sanitize_callback' => $prefix . '_sanitize_checkbox',
	'default'           => 1,
	'transport'         => 'postMessage',
) );
$wp_customize->add_control( $prefix . '_enable_author_box_blog_posts', array(
	'type'        => 'checkbox',
	'label'       => __( 'Author info box on single blog post', 'illdy' ),
	'description' => __( 'Displayed right at the end of the post', 'illdy' ),
	'section'     => $prefix . '_blog_global_section',
) );

/***********************************************/
/************** Title Blog Settings  ***************/
/***********************************************/

/* Posted on on single blog posts */
$wp_customize->add_setting( $prefix . '_custom_blog_archive_title', array(
	'sanitize_callback' => $prefix . '_sanitize_html',
	'default'           => '',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( $prefix . '_custom_blog_archive_title', array(
	'label'       => __( 'Use a custom title on the blog archive.', 'illdy' ),
	'description' => __( 'Will be displayed in the Jumbotron as a custom title. Only used on the blog archive, all other pages default to the WordPress Core functionality where the archive title is displayed.', 'illdy' ),
	'section'     => 'title_tagline',
) );