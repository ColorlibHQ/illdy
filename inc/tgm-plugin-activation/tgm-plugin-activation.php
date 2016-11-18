<?php

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Illdy Companion
		array(
			'name'     => esc_html__( 'Illdy Companion', 'illdy' ),
			'slug'     => 'illdy-companion',
			'version'  => '1.0.4',
			'required' => false,
		),

		// JetPack
		array(
			'name'     => esc_html__( 'JetPack', 'illdy' ),
			'slug'     => 'jetpack',
			'required' => false,
		),

		// Contact Form 7
		array(
			'name'     => esc_html__( 'Contact Form 7', 'illdy' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		// Kiwi Social Share 
		array(
			'name'     => esc_html__( 'Kiwi Social Share', 'illdy' ),
			'slug'     => 'kiwi-social-share',
			'version'  => '1.0.4',
			'required' => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'illdy',
		// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',
		// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',
		// Menu slug.
		'parent_slug'  => 'themes.php',
		// Parent menu slug.
		'capability'   => 'edit_theme_options',
		// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,
		// Show admin notices or not.
		'dismissable'  => true,
		// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',
		// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,
		// Automatically activate plugins after installation or not.
		'message'      => '',
		// Message to output right before the plugins table.


		'strings' => array(
			'page_title'                      => __( 'Install Required Plugins', 'illdy' ),
			'menu_title'                      => __( 'Install Plugins', 'illdy' ),
			'installing'                      => __( 'Installing Plugin: %s', 'illdy' ),
			// %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'illdy' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %1$s plugin.', 'Sorry, but you do not have the correct permissions to install the %1$s plugins.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop( 'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %1$s plugin.', 'Sorry, but you do not have the correct permissions to update the %1$s plugins.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'illdy' ),
			// %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %1$s plugin.', 'Sorry, but you do not have the correct permissions to activate the %1$s plugins.', 'illdy' ),
			// %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'illdy' ),
			'update_link'                     => _n_noop( 'Begin updating plugin', 'Begin updating plugins', 'illdy' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'illdy' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'illdy' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'illdy' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'illdy' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'illdy' ),
			// %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'illdy' ),
			// %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'illdy' ),
			// %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'illdy' ),

			'nag_type' => 'updated',
			// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),

	);

	tgmpa( $plugins, $config );
}
