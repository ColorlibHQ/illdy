<?php
// Set Panel ID
$panel_id = 'illdy_panel_contact_us';

// Set prefix
$prefix = 'illdy';

/***********************************************/
/**************** CONTACT US  ******************/
/***********************************************/

$wp_customize->add_panel( $panel_id,
    array(
        'priority'          => 109,
        'capability'        => 'edit_theme_options',
        'theme_supports'    => '',
        'title'             => __( 'Contact us Section', 'illdy' ),
        'description'       => __( 'Control various options for contact us section from front page.', 'illdy' ),
    )
);


/***********************************************/
/******************* General *******************/
/***********************************************/
$wp_customize->add_section( $prefix . '_contact_us_general' ,
    array(
        'title'         => __( 'Contact us', 'illdy' ),
        'description'   => __( 'Control various options for contact us section from front page.', 'illdy' ),
        'priority'      => 109,
        'title'       => __( 'General', 'illdy' ),
        'panel' 	  => $panel_id
    )
);

// Show this section
$wp_customize->add_setting( $prefix . '_contact_us_general_show',
    array(
        'sanitize_callback' => $prefix . '_sanitize_checkbox',
        'default'           => 1,
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix . '_contact_us_general_show',
    array(
        'type'      => 'checkbox',
        'label'     => __( 'Show this section?', 'illdy' ),
        'section'   => $prefix . '_contact_us_general',
        'priority'  => 1
    )
);

// Title
$wp_customize->add_setting( $prefix .'_contact_us_general_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Contact us', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_contact_us_general_title',
    array(
        'label'         => __( 'Title', 'illdy' ),
        'description'   => __( 'Add the title for this section.', 'illdy'),
        'section'       => $prefix . '_contact_us_general',
        'priority'      => 2
    )
);


// Entry
if ( get_theme_mod( $prefix .'_contact_us_general_entry' ) ) {
    $wp_customize->add_setting( $prefix .'_contact_us_general_entry',
        array(
            'sanitize_callback' => 'illdy_sanitize_html',
            'default'           => __( 'And we will get in touch as soon as possible.', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix .'_contact_us_general_entry',
        array(
            'label'         => __( 'Entry', 'illdy' ),
            'description'   => __( 'Add the content for this section.', 'illdy'),
            'section'       => $prefix . '_contact_us_general',
            'priority'      => 3,
            'type'          => 'textarea'
        )
    );
}elseif ( !defined( "ILLDY_COMPANION" ) ) {
    
    $wp_customize->add_setting(
        $prefix . '_contact_us_general_text',
        array(
            'sanitize_callback' => 'esc_html',
            'default'           => '',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Illdy_Text_Custom_Control(
            $wp_customize, $prefix . '_contact_us_general_text',
            array(
                'label'             => __( 'Install Illdy Companion', 'illdy' ),
                'description'       => sprintf(__( 'In order to edit description please install <a href="%s" target="_blank">Illdy Companion</a>', 'illdy' ), illdy_get_tgmpa_url()),
                'section'           => $prefix . '_contact_us_general',
                'settings'          => $prefix . '_contact_us_general_text',
                'priority'          => 3,
            )
        )
    );
    
}


// Address Title
$wp_customize->add_setting( $prefix .'_contact_us_general_address_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Address', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_contact_us_general_address_title',
    array(
        'label'         => __( 'Address Title', 'illdy' ),
        'description'   => __( 'Add the title for address block from this section.', 'illdy'),
        'section'       => $prefix . '_contact_us_general',
        'priority'      => 4
    )
);

// Customer Support Title
$wp_customize->add_setting( $prefix .'_contact_us_general_customer_support_title',
    array(
        'sanitize_callback' => 'illdy_sanitize_html',
        'default'           => __( 'Customer Support', 'illdy' ),
        'transport'         => 'postMessage'
    )
);
$wp_customize->add_control(
    $prefix .'_contact_us_general_customer_support_title',
    array(
        'label'         => __( 'Customer Support Title', 'illdy' ),
        'description'   => __( 'Add the title for customer support block from this section.', 'illdy'),
        'section'       => $prefix . '_contact_us_general',
        'priority'      => 5
    )
);

// Contact Form 7
$wp_customize->add_setting( 'illdy_contact_us_general_contact_form_7',
    array(
        'sanitize_callback' => 'sanitize_key'
    )
);
$wp_customize->add_control( new Illdy_CF7_Custom_Control(
    $wp_customize,
    'illdy_contact_us_general_contact_form_7',
        array(
            'label'             => __( 'Select the contact form you\'d like to display (powered by Contact Form 7)', 'illdy' ),
            'section'           => $prefix . '_contact_us_general',
            'priority'          => 6,
            'type'              => 'illdy_contact_form_7'
        )
    )
);

// Contact Form Creation
$wp_customize->add_setting(
    $prefix . '_contact_us_general_install_contact_form_7',
    array(
        'sanitize_callback' => 'esc_html',
        'default'           => '',
        'transport'         => 'refresh'
    )
);
$wp_customize->add_control(
    new Illdy_Text_Custom_Control(
        $wp_customize, $prefix . '_contact_us_general_install_contact_form_7',
        array(
            'label'             => __( 'Contact Form Creation', 'illdy' ),
            'description'       => sprintf( '%s %s %s', __( 'Install', 'illdy' ), '<a href="https://wordpress.org/plugins/contact-form-7/" title="Contact Form 7" target="_blank">Contact Form 7</a>', __( 'and select a contact form to work this setting.', 'illdy' ) ),
            'section'           => $prefix .'_contact_us_general',
            'settings'          => $prefix . '_contact_us_general_install_contact_form_7',
            'priority'          => 7,
            'active_callback'   => 'illdy_is_not_active_contact_form_7'
        )
    )
);


/***********************************************/
    /************** Contact Details  ***************/
    /***********************************************/

    $wp_customize->add_section( $prefix.'_general_contact_section' ,
        array(
            'title'         => __( 'Contact Details', 'illdy' ),
            'description'   => __( 'These are the contact details displayed in the Contact us section from front page.', 'illdy' ),
            'priority'      => 3,
            'panel'         => $panel_id
        )
    );

    /* Facebook URL */
    $wp_customize->add_setting( 'illdy_contact_bar_facebook_url',
        array(
            'sanitize_callback'  => 'esc_url_raw',
            'default'            =>  esc_url_raw('#'),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( 'illdy_contact_bar_facebook_url',
        array(
            'label'          => __( 'Facebook URL', 'illdy' ),
            'description'    => __( 'Will be displayed in the contact section from front page.', 'illdy' ),
            'section'        => $prefix.'_general_contact_section',
            'settings'       => 'illdy_contact_bar_facebook_url',
            'priority'       => 10
        )
    );

    /* Twitter URL */
    $wp_customize->add_setting( $prefix.'_contact_bar_twitter_url',
        array(
            'sanitize_callback'  => 'esc_url_raw',
            'default'            =>  esc_url_raw('#'),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_contact_bar_twitter_url',
        array(
            'label'          => __( 'Twitter URL', 'illdy' ),
            'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
            'section'        => $prefix.'_general_contact_section',
            'settings'       => $prefix.'_contact_bar_twitter_url',
            'priority'       => 10
        )
    );

    /* LinkedIN URL */
    $wp_customize->add_setting( $prefix.'_contact_bar_linkedin_url',
        array(
            'sanitize_callback'  => 'esc_url_raw',
            'default'            => esc_url_raw('#'),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_contact_bar_linkedin_url',
        array(
            'label'          => __( 'LinkedIN URL', 'illdy' ),
            'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
            'section'        => $prefix.'_general_contact_section',
            'settings'       => $prefix.'_contact_bar_linkedin_url',
            'priority'       => 10
        )
    );

	/* Google+ URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_googlep_url',
		array(
			'sanitize_callback'  => 'esc_url_raw',
			'default'            => esc_url_raw('#'),
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_googlep_url',
		array(
			'label'          => __( 'Google+ URL', 'illdy' ),
			'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_googlep_url',
			'priority'       => 10
		)
	);

	/* Pinterest URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_pinterest_url',
		array(
			'sanitize_callback'  => 'esc_url_raw',
			'default'            => esc_url_raw('#'),
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_pinterest_url',
		array(
			'label'          => __( 'Pinterest URL', 'illdy' ),
			'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_pinterest_url',
			'priority'       => 10
		)
	);

	/* Instagram URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_instagram_url',
		array(
			'sanitize_callback'  => 'esc_url_raw',
			'default'            => esc_url_raw('#'),
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_instagram_url',
		array(
			'label'          => __( 'Instagram URL', 'illdy' ),
			'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_instagram_url',
			'priority'       => 10
		)
	);

	/* YouTube URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_youtube_url',
		array(
			'sanitize_callback'  => 'esc_url_raw',
			'default'            => esc_url_raw('#'),
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_youtube_url',
		array(
			'label'          => __( 'YouTube URL', 'illdy' ),
			'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_youtube_url',
			'priority'       => 10
		)
	);

	/* Vimeo URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_vimeo_url',
		array(
			'sanitize_callback'  => 'esc_url_raw',
			'default'            => esc_url_raw('#'),
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_vimeo_url',
		array(
			'label'          => __( 'Vimeo URL', 'illdy' ),
			'description'    => __('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_vimeo_url',
			'priority'       => 10
		)
	);



    /* email */
    $wp_customize->add_setting( $prefix.'_email',
        array(
            'sanitize_callback'  => 'sanitize_text_field',
            'default'            => __( 'contact@site.com', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_email',
        array(
            'label'         => __( 'Email addr.', 'illdy' ),
            'description'   => __( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix.'_general_contact_section',
            'settings'      => $prefix.'_email',
            'priority'      => 10
        )
    );


    /* phone number */
    $wp_customize->add_setting( $prefix.'_phone',
        array(
            'sanitize_callback'  => 'illdy_sanitize_html',
            'default'            => __( '(555) 555-5555', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_phone',
        array(
            'label'         => __( 'Phone number', 'illdy' ),
            'description'   => __( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix.'_general_contact_section',
            'settings'      => $prefix.'_phone',
            'priority'      => 12
        )
    );

    // Address 1
    $wp_customize->add_setting(
        $prefix . '_address1',
        array(
            'sanitize_callback'  => 'illdy_sanitize_html',
            'default'            => __( 'Street 221B Baker Street, ', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_address1',
        array(
            'label'         => __( 'Address 1', 'illdy' ),
            'description'   => __( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix . '_general_contact_section',
            'priority'      => 13
        )
    );

    // Address 2
    $wp_customize->add_setting(
        $prefix . '_address2',
        array(
            'sanitize_callback'  => 'illdy_sanitize_html',
            'default'            => __( 'London, UK', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_address2',
        array(
            'label'         => __( 'Address 2', 'illdy' ),
            'description'   => __( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix . '_general_contact_section',
            'priority'      => 13
        )
    );