<?php
// Set prefix
$prefix = 'illdy';


/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section(
	$prefix . '_contact_us', array(
		'title'       => __( 'Contact us Section', 'illdy' ),
		'description' => __( 'Control various options for contact us section from front page.', 'illdy' ),
		'priority'    => illdy_get_section_position( $prefix . '_contact_us' ),
		'panel'       => 'illdy_frontpage_panel',
	)
);

$wp_customize->add_setting(
	$prefix . '_contact_tab', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Tab(
		$wp_customize, $prefix . '_contact_tab', array(
			'type'     => 'epsilon-tab',
			'section'  => $prefix . '_contact_us',
			'priority' => 1,
			'buttons'  => array(
				array(
					'name'   => __( 'General', 'illdy' ),
					'fields' => illdy_create_contact_tab_sections(),
					'active' => true,
				),
				array(
					'name'   => __( 'Details', 'illdy' ),
					'fields' => array(
						$prefix . '_contact_bar_facebook_url',
						$prefix . '_contact_bar_twitter_url',
						$prefix . '_contact_bar_linkedin_url',
						$prefix . '_contact_bar_googlep_url',
						$prefix . '_contact_bar_pinterest_url',
						$prefix . '_contact_bar_instagram_url',
						$prefix . '_contact_bar_youtube_url',
						$prefix . '_contact_bar_vimeo_url',
						$prefix . '_email',
						$prefix . '_phone',
						$prefix . '_address1',
						$prefix . '_address2',
					),
				),
			),
		)
	)
);


// Show this section
$wp_customize->add_setting(
	$prefix . '_contact_us_show', array(
		'sanitize_callback' => $prefix . '_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Epsilon_Control_Toggle(
		$wp_customize, $prefix . '_contact_us_show', array(
			'type'     => 'epsilon-toggle',
			'label'    => __( 'Show this section?', 'illdy' ),
			'section'  => $prefix . '_contact_us',
			'priority' => 1,
		)
	)
);

// Title
$wp_customize->add_setting(
	$prefix . '_contact_us_general_title', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'Contact us', 'illdy' ),
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	$prefix . '_contact_us_general_title', array(
		'label'       => __( 'Title', 'illdy' ),
		'description' => __( 'Add the title for this section.', 'illdy' ),
		'section'     => $prefix . '_contact_us',
		'priority'    => 2,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_contact_us_general_title', array(
		'selector' => '#contact-us .section-header h3',
	)
);

// Entry
if ( get_theme_mod( $prefix . '_contact_us_entry' ) ) {

	$wp_customize->add_setting(
		$prefix . '_contact_us_entry', array(
			'sanitize_callback' => 'wp_kses_post',
			'default'           => __( 'And we will get in touch as soon as possible.', 'illdy' ),
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Epsilon_Control_Text_Editor(
			$wp_customize, $prefix . '_contact_us_entry', array(
				'label'    => __( 'Entry', 'illdy' ),
				'section'  => $prefix . '_contact_us',
				'priority' => 3,
				'type'     => 'epsilon-text-editor',
			)
		)
	);

} elseif ( ! defined( 'ILLDY_COMPANION' ) ) {

	$wp_customize->add_setting(
		$prefix . '_contact_us_entry', array(
			'sanitize_callback' => 'esc_html',
			'default'           => '',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new Illdy_Text_Custom_Control(
			$wp_customize, $prefix . '_contact_us_entry', array(
				'label'       => __( 'Install Illdy Companion', 'illdy' ),
				'description' => sprintf( __( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_recommended_actions_url() ),
				'section'     => $prefix . '_contact_us',
				'settings'    => $prefix . '_contact_us_entry',
				'priority'    => 3,
			)
		)
	);

}
$wp_customize->selective_refresh->add_partial(
	$prefix . '_contact_us_entry', array(
		'selector' => '#contact-us .section-header .section-description',
	)
);

// Address Title
$wp_customize->add_setting(
	$prefix . '_contact_us_general_address_title', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'Address', 'illdy' ),
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	$prefix . '_contact_us_general_address_title', array(
		'label'    => __( 'Address Title', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'priority' => 4,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_contact_us_general_address_title', array(
		'selector' => '#contact-us .section-content .row .col-sm-4 .box-left',
	)
);

// Customer Support Title
$wp_customize->add_setting(
	$prefix . '_contact_us_general_customer_support_title', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'Customer Support', 'illdy' ),
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	$prefix . '_contact_us_general_customer_support_title', array(
		'label'    => __( 'Customer Support Title', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'priority' => 5,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_contact_us_general_customer_support_title', array(
		'selector' => '#contact-us .section-content .row .col-sm-5 .box-left',
	)
);

// Contact Form 7
$wp_customize->add_setting(
	'illdy_contact_us_general_contact_form_7', array(
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Illdy_CF7_Custom_Control(
		$wp_customize, 'illdy_contact_us_general_contact_form_7', array(
			'label'    => __( 'Select the contact form you\'d like to display (powered by Contact Form 7)', 'illdy' ),
			'section'  => $prefix . '_contact_us',
			'priority' => 6,
			'type'     => 'illdy_contact_form_7',
		)
	)
);

// Contact Form Creation
$wp_customize->add_setting(
	$prefix . '_contact_us_install_contact_form_7', array(
		'sanitize_callback' => 'esc_html',
		'default'           => '',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new Illdy_Text_Custom_Control(
		$wp_customize, $prefix . '_contact_us_install_contact_form_7', array(
			'label'           => __( 'Contact Form Creation', 'illdy' ),
			'description'     => sprintf( '%s %s %s', __( 'Install', 'illdy' ), '<a href="https://wordpress.org/plugins/contact-form-7/" title="Contact Form 7" target="_blank">Contact Form 7</a>', __( 'and select a contact form to work this setting.', 'illdy' ) ),
			'section'         => $prefix . '_contact_us',
			'settings'        => $prefix . '_contact_us_install_contact_form_7',
			'priority'        => 7,
			'active_callback' => 'illdy_is_not_active_contact_form_7',
		)
	)
);

$wp_customize->add_setting(
	$prefix . '_contact_us_create_contact_form_7', array(
		'sanitize_callback' => 'esc_html',
		'default'           => '',
		'transport'         => 'refresh',
	)
);
$wp_customize->add_control(
	new Illdy_Text_Custom_Control(
		$wp_customize, $prefix . '_contact_us_create_contact_form_7', array(
			'label'           => __( 'Contact Form Creation', 'illdy' ),
			'description'     => sprintf( '%s %s', __( 'Create a contact form from ', 'illdy' ), '<a href="' . admin_url( 'admin.php?page=wpcf7-new' ) . '" title="Contact Form 7" target="_blank">here</a>' ),
			'section'         => $prefix . '_contact_us',
			'settings'        => $prefix . '_contact_us_create_contact_form_7',
			'priority'        => 7,
			'active_callback' => 'illdy_have_not_contact_form_7',
		)
	)
);

/***********************************************/
/************** Contact Details  ***************/
/***********************************************/

/* Facebook URL */
$wp_customize->add_setting(
	'illdy_contact_bar_facebook_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'illdy_contact_bar_facebook_url', array(
		'label'    => __( 'Facebook URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => 'illdy_contact_bar_facebook_url',
		'priority' => 10,
	)
);

$wp_customize->selective_refresh->add_partial(
	$prefix . '_contact_bar_facebook_url', array(
		'selector'        => '#contact-us .contact-us-social',
		'render_callback' => $prefix . '_contact_us_social',
	)
);

/* Twitter URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_twitter_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_twitter_url', array(
		'label'    => __( 'Twitter URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_twitter_url',
		'priority' => 10,
	)
);

/* LinkedIN URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_linkedin_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_linkedin_url', array(
		'label'    => __( 'LinkedIN URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_linkedin_url',
		'priority' => 10,
	)
);

/* Google+ URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_googlep_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_googlep_url', array(
		'label'    => __( 'Google+ URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_googlep_url',
		'priority' => 10,
	)
);

/* Pinterest URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_pinterest_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_pinterest_url', array(
		'label'    => __( 'Pinterest URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_pinterest_url',
		'priority' => 10,
	)
);

/* Instagram URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_instagram_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_instagram_url', array(
		'label'    => __( 'Instagram URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_instagram_url',
		'priority' => 10,
	)
);

/* YouTube URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_youtube_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_youtube_url', array(
		'label'    => __( 'YouTube URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_youtube_url',
		'priority' => 10,
	)
);

/* Vimeo URL */
$wp_customize->add_setting(
	$prefix . '_contact_bar_vimeo_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => esc_url_raw( '#' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_contact_bar_vimeo_url', array(
		'label'    => __( 'Vimeo URL', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_contact_bar_vimeo_url',
		'priority' => 10,
	)
);

/* email */
$wp_customize->add_setting(
	$prefix . '_email', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => __( 'contact@site.com', 'illdy' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_email', array(
		'label'    => __( 'Email addr.', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_email',
		'priority' => 10,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_email', array(
		'selector'        => '#contact-us .section-content .row .col-sm-5 .box-right span:first-child',
		'render_callback' => $prefix . '_email',
	)
);

/* phone number */
$wp_customize->add_setting(
	$prefix . '_phone', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( '(555) 555-5555', 'illdy' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_phone', array(
		'label'    => __( 'Phone number', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'settings' => $prefix . '_phone',
		'priority' => 12,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_phone', array(
		'selector' => '#contact-us .section-content .row .col-sm-5 .box-right span:nth-child(2)',
	)
);

// Address 1
$wp_customize->add_setting(
	$prefix . '_address1', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'Street 221B Baker Street, ', 'illdy' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_address1', array(
		'label'    => __( 'Address 1', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'priority' => 13,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_address1', array(
		'selector' => '#contact-us .section-content .row .col-sm-4 .box-right span:first-child',
	)
);

// Address 2
$wp_customize->add_setting(
	$prefix . '_address2', array(
		'sanitize_callback' => 'illdy_sanitize_html',
		'default'           => __( 'London, UK', 'illdy' ),
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	$prefix . '_address2', array(
		'label'    => __( 'Address 2', 'illdy' ),
		'section'  => $prefix . '_contact_us',
		'priority' => 13,
	)
);
$wp_customize->selective_refresh->add_partial(
	$prefix . '_address2', array(
		'selector'        => '#contact-us .section-content .row .col-sm-4 .box-right span:nth-child(2)',
		'render_callback' => $prefix . '_address2',
	)
);
