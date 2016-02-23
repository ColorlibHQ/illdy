<?php
    // Set Panel ID
    $panel_id = 'illdy_panel_general';

    // Set prefix
    $prefix = 'illdy';

    // Change panel for Site Title & Tagline Section
    $site_title        = $wp_customize->get_section( 'title_tagline' );
    $site_title->panel = $panel_id;

    // Remove sections from customizer front-view
    $wp_customize->remove_section('colors');

    // Change panel for Background Image
    $site_title        = $wp_customize->get_section( 'background_image' );
    $site_title->panel = $panel_id;

    // Change panel for Static Front Page
    $site_title        = $wp_customize->get_section( 'static_front_page' );
    $site_title->panel = $panel_id;


    // Change priority for Site Title
    $site_title           = $wp_customize->get_control( 'blogname' );
    $site_title->priority = 15;

    // Change priority for Site Tagline
    $site_title           = $wp_customize->get_control( 'blogdescription' );
    $site_title->priority = 17;


    /***********************************************/
    /************** GENERAL OPTIONS  ***************/
    /***********************************************/


    $wp_customize->add_panel( $panel_id,
        array(
            'priority' => 1,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'General Options', 'illdy' ),
            'description' => esc_html__('You can change the site layout in this area as well as your contact details (the ones displayed in the header & footer) ', 'illdy'),
        )
    );

    /***********************************************/
    /****************** Preloader  *****************/
    /***********************************************/

    $wp_customize->add_section( $prefix . '_preloader_section',
        array(
            'title'       => esc_html__( 'Preloader', 'illdy' ),
            'priority'    => 1,
            'panel'       => $panel_id
        )
    );

    // Enable the preloader?
    $wp_customize->add_setting( $prefix . '_preloader_enable',
        array(
            'sanitize_callback' => $prefix . '_value_checkbox_helper',
            'default'           => 1
        )
    );
    $wp_customize->add_control(
        $prefix . '_preloader_enable',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Enable the preloader?', 'illdy' ),
            'section'       => $prefix . '_preloader_section',
            'priority'      => 1
        )
    );

    // Primary Color
    $wp_customize->add_setting(
        $prefix . '_preloader_primary_color',
        array(
            'sanitize_callback' => 'sanitize_hex_color',
            'default'           => '#f1d204',
        )
    );
    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
        $wp_customize, 
        $prefix . '_preloader_primary_color',
        array(
            'label'     => __( 'Primary Color', 'illdy' ),
            'section'   => $prefix . '_preloader_section',
            'settings'  => $prefix . '_preloader_primary_color',
            'priority'  => 2
        ) ) 
    );

    // Secondly Color
    $wp_customize->add_setting(
        $prefix . '_preloader_secondly_color',
        array(
            'sanitize_callback' => 'sanitize_hex_color',
            'default'           => '#ffffff',
        )
    );
    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
        $wp_customize, 
        $prefix . '_preloader_secondly_color',
        array(
            'label'     => __( 'Secondly Color', 'illdy' ),
            'section'   => $prefix . '_preloader_section',
            'settings'  => $prefix . '_preloader_secondly_color',
            'priority'  => 3
        ) ) 
    );

    /***********************************************/
    /*********** General Site Settings  ************/
    /***********************************************/

    /* Logo */
    $wp_customize->add_section( $prefix.'_general_section' ,
        array(
            'title'       => esc_html__( 'Logo', 'illdy' ),
            'priority'    => 2,
            'panel' 	  => $panel_id
        )
    );


    /* Company text logo */
    $wp_customize->add_setting($prefix.'_text_logo',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__('Illdy', 'illdy'),
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix.'_text_logo',
        array(
            'label' 		=> esc_html__('Enter company name', 'illdy'),
            'description'   => esc_html__('This field is best used when you don\'t have a professional image logo', 'illdy'),
            'section' 		=> $prefix.'_general_section',
            'priority' 		=> 2
        )
    );

    /* Company image logo */
    $wp_customize->add_setting(
        $prefix . '_img_logo',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => esc_url( get_template_directory_uri() . '/layout/images/header-logo.png' ),
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, $prefix . '_img_logo',
            array(
                'label'     => __( 'Image Site Logo', 'illdy' ),
                'section'   => $prefix.'_general_section',
                'settings'  => $prefix . '_img_logo',
                'priority'  => 2
            )
        )
    );


    /***********************************************/
    /************** Contact Details  ***************/
    /***********************************************/

    $wp_customize->add_section( $prefix.'_general_contact_section' ,
        array(
            'title'       => esc_html__( 'Contact Details', 'illdy' ),
            'description' => esc_html__( 'These are the contact details displayed in the header & footer of the website.', 'illdy' ),
            'priority'    => 3,
            'panel' => $panel_id
        )
    );

	/* Facebook URL */
	$wp_customize->add_setting( 'illdy_contact_bar_facebook_url',
		array(
			'sanitize_callback'  => 'esc_url',
			'default'            => esc_url('#'),
            'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( 'illdy_contact_bar_facebook_url',
		array(
			'label'          => esc_html__( 'Facebook URL', 'illdy' ),
			'description'    => esc_html__( 'Will be displayed in the contact section from front page.', 'illdy' ),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => 'illdy_contact_bar_facebook_url',
			'priority'       => 10
		)
	);

	/* Twitter URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_twitter_url',
		array(
			'sanitize_callback'  => 'esc_url',
			'default'            => esc_html('#'),
            'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_twitter_url',
		array(
			'label'          => esc_html__( 'Twitter URL', 'illdy' ),
			'description'    => esc_html__('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_twitter_url',
			'priority'       => 10
		)
	);

	/* LinkedIN URL */
	$wp_customize->add_setting( $prefix.'_contact_bar_linkedin_url',
		array(
			'sanitize_callback'  => 'esc_url',
			'default'            => esc_html('#'),
            'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control( $prefix.'_contact_bar_linkedin_url',
		array(
			'label'          => esc_html__( 'LinkedIN URL', 'illdy' ),
			'description'    => esc_html__('Will be displayed in the contact section from front page.', 'illdy'),
			'section'        => $prefix.'_general_contact_section',
			'settings'       => $prefix.'_contact_bar_linkedin_url',
			'priority'       => 10
		)
	);

	/* email */
    $wp_customize->add_setting( $prefix.'_email',
        array(
            'sanitize_callback'  => 'sanitize_email',
            'default'            => esc_html__( 'contact@site.com', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_email',
        array(
            'label'         => esc_html__( 'Email addr.', 'illdy' ),
            'description'   => esc_html__( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix.'_general_contact_section',
            'settings'      => $prefix.'_email',
            'priority'      => 10
        )
    );


    /* phone number */
    $wp_customize->add_setting( $prefix.'_phone',
        array(
            'sanitize_callback'  => $prefix.'_sanitize_number',
            'default'            => esc_html__( '(555) 555-5555', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control( $prefix.'_phone',
        array(
            'label'         => esc_html__( 'Phone number', 'illdy' ),
            'description'   => esc_html__( 'Will be displayed in the contact section from front page.', 'illdy'),
            'section'       => $prefix.'_general_contact_section',
            'settings'      => $prefix.'_phone',
            'priority'      => 12
        )
    );

    // Address 1
    $wp_customize->add_setting(
        $prefix . '_address1',
        array(
            'sanitize_callback'  => 'sanitize_text_field',
            'default'            => esc_html__( 'Street 221B Baker Street, ', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_address1',
        array(
            'label'     => esc_html__( 'Address 1', 'illdy' ),
            'section'   => $prefix . '_general_contact_section',
            'priority'  => 13
        )
    );

    // Address 2
    $wp_customize->add_setting(
        $prefix . '_address2',
        array(
            'sanitize_callback'  => 'sanitize_text_field',
            'default'            => esc_html__( 'London, UK', 'illdy' ),
            'transport'          => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_address2',
        array(
            'label'     => esc_html__( 'Address 2', 'illdy' ),
            'section'   => $prefix . '_general_contact_section',
            'priority'  => 13
        )
    );

    /***********************************************/
    /************** Footer Details  ***************/
    /***********************************************/
    $wp_customize->add_section( $prefix.'_general_footer_section' ,
        array(
            'title'       => esc_html__( 'Footer Details', 'illdy' ),
            'description' => esc_html__( 'Change the footer copyright message from here. Note: no HTML allowed.', 'illdy'),
            'priority'    => 4,
            'panel' => $panel_id
        )
    );

    // Display theme copyright in the footer?
    $wp_customize->add_setting( $prefix . '_general_footer_display_copyright',
        array(
            'sanitize_callback' => $prefix . '_sanitize_checkbox',
            'default'           => 1,
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        $prefix . '_general_footer_display_copyright',
        array(
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Display theme copyright in the footer?', 'illdy' ),
            'section'       => $prefix . '_general_footer_section',
            'priority'      => 1
        )
    );

    /* Footer Copyright */
    $wp_customize->add_setting(
        $prefix . '_footer_copyright',
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => esc_html__( '&copy; Copyright 2016. All Rights Reserved.', 'illdy' ),
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        $prefix . '_footer_copyright',
        array(
            'label'     => esc_html__( 'Footer Copyright', 'illdy' ),
            'section'   => $prefix . '_general_footer_section',
            'priority'  => 2
        )
    );

    /* Footer Image Logo */
    $wp_customize->add_setting(
        $prefix . '_img_footer_logo',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => esc_url( get_template_directory_uri() . '/layout/images/footer-logo.png' ),
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, $prefix . '_img_footer_logo',
            array(
                'label'     => __( 'Image Site Logo', 'illdy' ),
                'section'   => $prefix.'_general_footer_section',
                'settings'  => $prefix . '_img_footer_logo',
                'priority'  => 3
            )
        )
    );