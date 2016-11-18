<?php
/**
 * Welcome Screen Class
 */
class illdy_Welcome {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {

		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'illdy_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'illdy_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'illdy_welcome_style_and_scripts' ) );

		/* enqueue script for customizer */
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'illdy_welcome_scripts_for_customizer' ) );

		/* load welcome screen */
		add_action( 'illdy_welcome', array( $this, 'illdy_welcome_getting_started' ), 	    10 );
		add_action( 'illdy_welcome', array( $this, 'illdy_welcome_actions_required' ),        20 );
		add_action( 'illdy_welcome', array( $this, 'illdy_welcome_github' ), 		            40 );
		add_action( 'illdy_welcome', array( $this, 'illdy_welcome_changelog' ), 				50 );

		/* ajax callback for dismissable required actions */
		add_action( 'wp_ajax_illdy_lite_dismiss_required_action', array( $this, 'illdy_dismiss_required_action_callback') );

	}

	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_register_menu() {
		add_theme_page( 'About Illdy', 'About Illdy', 'activate_plugins', 'illdy-welcome', array( $this, 'illdy_welcome_screen' ) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 * @since 1.8.2.4
	 */
	public function illdy_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'illdy_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_admin_notice() {
		?>
			<div class="updated notice is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Welcome! Thank you for choosing Illdy! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'illdy' ), '<a href="' . esc_url( admin_url( 'themes.php?page=illdy-welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=illdy-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Illdy', 'illdy' ); ?></a></p>
			</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 * @since  1.8.2.4
	 */
	public function illdy_welcome_style_and_scripts( $hook_suffix ) {

		if ( 'appearance_page_illdy-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'illdy-welcome-screen-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome.css' );
			wp_enqueue_script( 'illdy-welcome-screen-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome.js', array('jquery') );

			global $illdy_required_actions;

			$nr_actions_required = 0;

			/* get number of required actions */
			if( get_option('illdy_show_required_actions') ):
				$illdy_show_required_actions = get_option('illdy_show_required_actions');
			else:
				$illdy_show_required_actions = array();
			endif;

			if( !empty($illdy_required_actions) ):
				foreach( $illdy_required_actions as $illdy_required_action_value ):
					if(( !isset( $illdy_required_action_value['check'] ) || ( isset( $illdy_required_action_value['check'] ) && ( $illdy_required_action_value['check'] == false ) ) ) && ((isset($illdy_show_required_actions[$illdy_required_action_value['id']]) && ($illdy_show_required_actions[$illdy_required_action_value['id']] == true)) || !isset($illdy_show_required_actions[$illdy_required_action_value['id']]) )) :
						$nr_actions_required++;
					endif;
				endforeach;
			endif;

			wp_localize_script( 'illdy-welcome-screen-js', 'illdyLiteWelcomeScreenObject', array(
				'nr_actions_required' => $nr_actions_required,
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'template_directory' => get_template_directory_uri(),
				'no_required_actions_text' => __( 'Hooray! There are no recomended actions for you right now.','illdy' )
			) );
		}
	}

	/**
	 * Load scripts for customizer page
	 * @since  1.8.2.4
	 */
	public function illdy_welcome_scripts_for_customizer() {

		wp_enqueue_style( 'illdy-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome_customizer.css' );
		wp_enqueue_script( 'illdy-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome_customizer.js', array('jquery'), '20120206', true );

		global $illdy_required_actions;

		$nr_actions_required = 0;

		/* get number of required actions */
		if( get_option('illdy_show_required_actions') ):
			$illdy_show_required_actions = get_option('illdy_show_required_actions');
		else:
			$illdy_show_required_actions = array();
		endif;

		if( !empty($illdy_required_actions) ):
			foreach( $illdy_required_actions as $illdy_required_action_value ):
				if(( !isset( $illdy_required_action_value['check'] ) || ( isset( $illdy_required_action_value['check'] ) && ( $illdy_required_action_value['check'] == false ) ) ) && ((isset($illdy_show_required_actions[$illdy_required_action_value['id']]) && ($illdy_show_required_actions[$illdy_required_action_value['id']] == true)) || !isset($illdy_show_required_actions[$illdy_required_action_value['id']]) )) :
					$nr_actions_required++;
				endif;
			endforeach;
		endif;

		wp_localize_script( 'illdy-welcome-screen-customizer-js', 'illdyLiteWelcomeScreenCustomizerObject', array(
			'nr_actions_required' => $nr_actions_required,
			'aboutpage' => esc_url( admin_url( 'themes.php?page=illdy-welcome#actions_required' ) ),
			'customizerpage' => esc_url( admin_url( 'customize.php#actions_required' ) ),
			'themeinfo' => __('View Theme Info','illdy'),
		) );
	}

	/**
	 * Dismiss required actions
	 * @since 1.8.2.4
	 */
	public function illdy_dismiss_required_action_callback() {

		global $illdy_required_actions;

		$illdy_dismiss_id = (isset($_GET['dismiss_id'])) ? $_GET['dismiss_id'] : 0;

		echo $illdy_dismiss_id; /* this is needed and it's the id of the dismissable required action */

		if( !empty($illdy_dismiss_id) ):

			/* if the option exists, update the record for the specified id */
			if( get_option('illdy_show_required_actions') ):

				$illdy_show_required_actions = get_option('illdy_show_required_actions');

				$illdy_show_required_actions[$illdy_dismiss_id] = false;

				update_option( 'illdy_show_required_actions',$illdy_show_required_actions );

			/* create the new option,with false for the specified id */
			else:

				$illdy_show_required_actions_new = array();

				if( !empty($illdy_required_actions) ):

					foreach( $illdy_required_actions as $illdy_required_action ):

						if( $illdy_required_action['id'] == $illdy_dismiss_id ):
							$illdy_show_required_actions_new[$illdy_required_action['id']] = false;
						else:
							$illdy_show_required_actions_new[$illdy_required_action['id']] = true;
						endif;

					endforeach;

				update_option( 'illdy_show_required_actions', $illdy_show_required_actions_new );

				endif;

			endif;

		endif;

		die(); // this is required to return a proper result
	}


	/**
	 * Welcome screen content
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_screen() {

		?>

		<ul class="illdy-nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#getting_started" aria-controls="getting_started" role="tab" data-toggle="tab"><?php esc_html_e( 'Getting started','illdy'); ?></a></li>
			<li role="presentation" class="illdy-w-red-tab"><a href="#actions_required" aria-controls="actions_required" role="tab" data-toggle="tab"><?php esc_html_e( 'Actions recomended','illdy'); ?></a></li>
			<?php if ( defined("ILLDY_COMPANION") ) { ?>
				<li role="presentation"><a href="#demo_content" aria-controls="demo_content" role="tab" data-toggle="tab"><?php esc_html_e( 'Demo Content','illdy'); ?></a></li>
			<?php } ?>
			<li role="presentation"><a href="#github" aria-controls="github" role="tab" data-toggle="tab"><?php esc_html_e( 'Contribute','illdy'); ?></a></li>
			<li role="presentation"><a href="#changelog" aria-controls="changelog" role="tab" data-toggle="tab"><?php esc_html_e( 'Changelog','illdy'); ?></a></li>
		</ul>

		<div class="illdy-tab-content">

			<?php
			/**
			 * @hooked illdy_welcome_getting_started - 10
			 * @hooked illdy_welcome_actions_required - 20
			 * @hooked illdy_welcome_child_themes - 30
			 * @hooked illdy_welcome_github - 40
			 * @hooked illdy_welcome_changelog - 50
			 */
			do_action( 'illdy_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Getting started
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_getting_started() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/getting-started.php' );
	}

	/**
	 * Actions required
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_actions_required() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/actions-required.php' );
	}

	/**
	 * Contribute
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_github() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/github.php' );
	}

	/**
	 * Changelog
	 * @since 1.8.2.4
	 */
	public function illdy_welcome_changelog() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/changelog.php' );
	}
}

new illdy_Welcome();
