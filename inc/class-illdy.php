<?php


class Illdy {

	public $recommended_plugins = array(
		'kiwi-social-share'         => array(
			'recommended' => true,
		),
		'contact-form-7'            => array(
			'recommended' => false,
		),
		'simple-custom-post-order'  => array(
			'recommended' => false,
		),
		'fancybox-for-wordpress'    => array(
			'recommended' => false,
		),
	);

	public $recommended_actions;

	public $theme_slug = 'illdy';

	function __construct() {

		$this->recommended_actions = apply_filters( 'illdy_required_actions', array(
			array(
				'id'          => 'illdy-req-ac-install-illdy-companion',
				'title'       => MT_Notify_System::create_plugin_title( __( 'Illdy Companion', 'illdy' ), 'illdy-companion' ),
				'description' => __( 'It is highly recommended that you install the Illdy Companion.', 'illdy' ),
				'check'       => MT_Notify_System::check_plugin_update( 'illdy-companion' ),
				'type'        => 'plugin',
				'plugin_slug' => 'illdy-companion',
			),
			array(
				'id'          => 'illdy-req-ac-install-contact-form-7',
				'title'       => MT_Notify_System::create_plugin_requirement_title( __( 'Install: Contact Form 7', 'illdy' ), __( 'Activate: Contact Form 7', 'illdy' ), 'contact-form-7' ),
				'description' => __( 'It is highly recommended that you install the Contact Form 7.', 'illdy' ),
				'check'       => MT_Notify_System::has_import_plugin( 'contact-form-7' ),
				'type'        => 'plugin',
				'plugin_slug' => 'contact-form-7',
			),
		) );

		$this->init_epsilon();
		$this->init_welcome_screen();

		add_action( 'customize_register', array( $this, 'init_customizer' ) );

	}

	public function init_epsilon() {
		new Epsilon_Framework();
		$this->init_color_scheme();
	}

	public function init_color_scheme() {

		$handler = 'illdy-style';
		$args = array(
			'fields' => array(
				'epsilon_accent_color' => array(
					'label'       => __( 'Accent Color', 'illdy' ),
					'description' => __( 'The main color used in Illdy.', 'illdy' ),
					'default'     => '#f1d204',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_secondary_accent_color' => array(
					'label'       => __( 'Secondary Accent Color', 'illdy' ),
					'description' => __( 'The secondary color used in Illdy.', 'illdy' ),
					'default'     => '#f18b6d',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_text_color' => array(
					'label'       => __( 'Text Color', 'illdy' ),
					'description' => __( 'The color used for headings.', 'illdy' ),
					'default'     => '#545454',
					'section'     => 'colors',
					'hover-state' => false,
				),

				'epsilon_contrast_color' => array(
					'label'       => __( 'Contrast Color', 'illdy' ),
					'description' => __( 'The color used for paragraphs.', 'illdy' ),
					'default'     => '#8c9597',
					'section'     => 'colors',
					'hover-state' => false,
				),
				'epsilon_hover_color' => array(
					'label'       => __( 'Hover Color', 'illdy' ),
					'description' => __( 'The color used for hover on elements.', 'illdy' ),
					'default'     => '#6a4d8a',
					'section'     => 'colors',
					'hover-state' => false,
				),
			),
			'css' => Epsilon_Color_Scheme::load_css_overrides( get_template_directory() . '/layout/css/style-overrides.css' ),
		);
		Epsilon_Color_Scheme::get_instance( $handler, $args );

	}

	public function init_customizer( $wp_customize ) {
		$current_theme = wp_get_theme();
		$wp_customize->add_section( new Epsilon_Section_Recommended_Actions( $wp_customize, 'epsilon_recomended_section', array(
			'title'                        => esc_html__( 'Recomended Actions', 'illdy' ),
			'social_text'                  => esc_html( $current_theme->get( 'Author' ) ) . esc_html__( ' is social :', 'illdy' ),
			'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'illdy' ),
			'actions'                      => $this->recommended_actions,
			'plugins'                      => $this->recommended_plugins,
			'theme_specific_option'        => $this->theme_slug . '_show_required_actions',
			'theme_specific_plugin_option' => $this->theme_slug . '_show_required_plugins',
			'facebook'                     => 'https://www.facebook.com/colorlib',
			'twitter'                      => 'https://twitter.com/colorlib',
			'wp_review'                    => true,
			'priority'                     => 0,
		) ) );

	}

	public function init_welcome_screen() {

		Epsilon_Welcome_Screen::get_instance(
			$config = array(
				'theme-name'  => 'Illdy',
				'theme-slug'  => 'illdy',
				'actions'     => $this->recommended_actions,
				'plugins'     => $this->recommended_plugins,
			)
		);

	}

}

new Illdy();
