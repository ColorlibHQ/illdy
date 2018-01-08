<?php
// Set prefix
$prefix   = 'illdy';
$panel_id = $prefix . '_testimonials_general';

/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section(
	$prefix . '_testimonials_general',
	array(
		'title'       => __( 'Testimonials Section', 'illdy' ),
		'description' => __( 'Control various options for testimonials section from front page.', 'illdy' ),
		'priority'    => illdy_get_section_position( $prefix . '_testimonials_general' ),
		'panel'       => 'illdy_frontpage_panel',
	)
);

// Show this section
$wp_customize->add_setting(
	$prefix . '_testimonials_general_show', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_testimonials_general_show', array(
			'type'     => 'epsilon-toggle',
			'label'    => __( 'Show this section?', 'illdy' ),
			'section'  => $prefix . '_testimonials_general',
			'priority' => 1,
		)
	)
);

// Title
$wp_customize->add_setting(
	$prefix . '_testimonials_general_title', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'Testimonials', 'illdy' ),
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	$prefix . '_testimonials_general_title', array(
		'label'       => __( 'Title', 'illdy' ),
		'description' => __( 'Add the title for this section.', 'illdy' ),
		'section'     => $prefix . '_testimonials_general',
		'priority'    => 2,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_testimonials_general_title', array(
		'selector' => '#testimonials .section-header h3',
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonial_widget_button',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Button(
		$wp_customize, $prefix . '_testimonial_widget_button', array(
			'text'       => __( 'Add & Edit Testimonials', 'illdy' ),
			'section_id' => 'sidebar-widgets-front-page-testimonials-sidebar',
			'icon'       => 'dashicons-plus',
			'section'    => $panel_id,
			'priority'   => 5,
		)
	)
);


$wp_customize->add_setting(
	$prefix . '_testimonials_tab', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Tab(
		$wp_customize, $prefix . '_testimonials_tab', array(
			'type'    => 'epsilon-tab',
			'section' => $panel_id,
			'buttons' => array(
				array(
					'name'   => __( 'Colors', 'illdy' ),
					'fields' => array(
						$prefix . '_testimonials_title_color',
						$prefix . '_testimonials_dots_color',
						$prefix . '_testimonials_general_color',
						$prefix . '_testimonials_author_text_color',
						$prefix . '_testimonials_text_color',
						$prefix . '_testimonials_container_background_color',
					),
					'active' => true,
				),
				array(
					'name'   => __( 'Backgrounds', 'illdy' ),
					'fields' => array(
						$prefix . '_testimonials_general_background_image',
						$prefix . '_testimonials_background_size',
						$prefix . '_testimonials_background_repeat',
						$prefix . '_testimonials_background_attachment',
						$prefix . '_testimonials_background_position',
					),
				),
			),
		)
	)
);

// Background Image
$wp_customize->add_setting(
	$prefix . '_testimonials_general_background_image', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( get_template_directory_uri() . '/layout/images/testiomnials-background.jpg' ),
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize, $prefix . '_testimonials_general_background_image', array(
			'label'    => __( 'Background Image', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_general_background_image',
		)
	)
);
$wp_customize->add_setting(
	$prefix . '_testimonials_background_position_x', array(
		'default'           => 'center',
		'sanitize_callback' => 'esc_html',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_setting(
	$prefix . '_testimonials_background_position_y', array(
		'default'           => 'center',
		'sanitize_callback' => 'esc_html',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Background_Position_Control(
		$wp_customize, $prefix . '_testimonials_background_position', array(
			'label'    => __( 'Background Position', 'illdy' ),
			'section'  => $prefix . '_testimonials_general',
			'settings' => array(
				'x' => $prefix . '_testimonials_background_position_x',
				'y' => $prefix . '_testimonials_background_position_y',
			),
		)
	)
);
$wp_customize->add_setting(
	$prefix . '_testimonials_background_size', array(
		'default'           => 'cover',
		'sanitize_callback' => 'illdy_sanitize_background_size',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	$prefix . '_testimonials_background_size', array(
		'label'   => __( 'Image Size', 'illdy' ),
		'section' => $panel_id,
		'type'    => 'select',
		'choices' => array(
			'auto'    => __( 'Original', 'illdy' ),
			'contain' => __( 'Fit to Screen', 'illdy' ),
			'cover'   => __( 'Fill Screen', 'illdy' ),
		),
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_background_repeat', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 0,
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_testimonials_background_repeat', array(
			'type'    => 'epsilon-toggle',
			'label'   => __( 'Repeat Background Image', 'illdy' ),
			'section' => $panel_id,
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_background_attachment', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_testimonials_background_attachment', array(
			'type'    => 'epsilon-toggle',
			'label'   => __( 'Scroll with Page', 'illdy' ),
			'section' => $panel_id,
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_general_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#fff',
		'transport'         => 'postMessage',

	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_general_color', array(
			'label'    => __( 'Background Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_general_color',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_title_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#fff',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_title_color', array(
			'label'    => __( 'Title Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_title_color',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_container_background_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#6a4d8a',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_container_background_color', array(
			'label'    => __( 'Testimonial Container Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_container_background_color',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_text_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#fff',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_text_color', array(
			'label'    => __( 'Testimonial Content Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_text_color',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_author_text_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#fff',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_author_text_color', array(
			'label'    => __( 'Testimonial Author Text Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_author_text_color',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_testimonials_dots_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => '#fff',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, $prefix . '_testimonials_dots_color', array(
			'label'    => __( 'Testimonial Dots Color', 'illdy' ),
			'section'  => $panel_id,
			'settings' => $prefix . '_testimonials_dots_color',
		)
	)
);
