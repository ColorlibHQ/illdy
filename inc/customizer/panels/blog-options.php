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
$site_title->priority = 15;

// Change priority for Site Tagline
$site_title              = $wp_customize->get_control( 'blogdescription' );
$site_title->description = __( 'The tagline will be shown on archive pages, in the blog page right below the title.', 'illdy' );
$site_title->priority    = 17;

$wp_customize->add_panel(
	$panel_id, array(
		'priority'       => 2,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Blog Options', 'illdy' ),
		'description'    => __( 'You can change blog options ', 'illdy' ),
	)
);

//
$wp_customize->get_section( 'header_image' )->panel = $panel_id;
$wp_customize->get_section( 'header_image' )->title = __( 'Blog Archive Header Image', 'illdy' );

$wp_customize->add_setting(
	$prefix . '_archive_page_background_stretch', array(
		'sanitize_callback' => 'illdy_sanitize_select',
		'default'           => 1,
	)
);
$wp_customize->add_control(
	$prefix . '_archive_page_background_stretch', array(
		'label'   => __( 'Background Stretch', 'illdy' ),
		'type'    => 'select',
		'section' => 'header_image',
		'choices' => array(
			1 => __( 'Cover', 'illdy' ),
			2 => __( 'Contain', 'illdy' ),
		),
	)
);

/***********************************************/
/************** Blog Settings  ***************/
/***********************************************/

$wp_customize->add_section(
	$prefix . '_blog_featured_section', array(
		'title'       => __( 'Blog Featured Image', 'illdy' ),
		'description' => __( 'From this section you\'ll be able to control various single post (blog) settings.', 'illdy' ),
		'panel'       => $panel_id,
	)
);

$wp_customize->add_setting(
	$prefix . '_disable_random_featured_image', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 0,
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_disable_random_featured_image', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Random featured image', 'illdy' ),
			'description' => __( 'Toggling this to off will disable theme provided blog images. These images are used in the theme when users don\'t provide a featured image. It\'s purposes is merely cosmetic and meant to improve the blog layout.', 'illdy' ),
			'section'     => $prefix . '_blog_featured_section',
		)
	)
);


/***********************************************/
/************** Single Blog Settings  ***************/
/***********************************************/

$wp_customize->add_section(
	$prefix . '_blog_global_section', array(
		'title'       => __( 'Single Post Options', 'illdy' ),
		'description' => __( 'This section allows you to control how certain elements are displayed on the blog single page.', 'illdy' ),
		'panel'       => $panel_id,
	)
);

/* Posted on on single blog posts */
$wp_customize->add_setting(
	$prefix . '_enable_post_posted_on_blog_posts', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_enable_post_posted_on_blog_posts', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Show Posted on', 'illdy' ),
			'description' => __( 'This will disable the posted on zone as well as the author name', 'illdy' ),
			'section'     => $prefix . '_blog_global_section',
		)
	)
);

/* Post Category on single blog posts */
$wp_customize->add_setting(
	$prefix . '_enable_post_category_blog_posts', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_enable_post_category_blog_posts', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Show category', 'illdy' ),
			'description' => __( 'This will disable the posted in zone.', 'illdy' ),
			'section'     => $prefix . '_blog_global_section',
		)
	)
);


/* Post Tags on single blog posts */
$wp_customize->add_setting(
	$prefix . '_enable_post_tags_blog_posts', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_enable_post_tags_blog_posts', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Show tags', 'illdy' ),
			'description' => __( 'This will disable the tagged with zone.', 'illdy' ),
			'section'     => $prefix . '_blog_global_section',
		)
	)
);

/* Post Comments on single blog posts */
$wp_customize->add_setting(
	$prefix . '_enable_post_comments_blog_posts', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_enable_post_comments_blog_posts', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Show comments number', 'illdy' ),
			'description' => __( 'This will disable the comments header zone.', 'illdy' ),
			'section'     => $prefix . '_blog_global_section',
		)
	)
);

/* Author Info Box on single blog posts */
$wp_customize->add_setting(
	$prefix . '_enable_author_box_blog_posts', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_enable_author_box_blog_posts', array(
			'type'        => 'epsilon-toggle',
			'label'       => __( 'Show author box', 'illdy' ),
			'description' => __( 'Displayed right at the end of the post', 'illdy' ),
			'section'     => $prefix . '_blog_global_section',
		)
	)
);
