<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Control_Section_Repeater
 *
 * @since 1.0.0
 */
class Epsilon_Control_Section_Repeater extends WP_Customize_Control {
	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.2.0
	 * @access public
	 * @var    string
	 */
	public $type = 'epsilon-section-repeater';

	/**
	 * @since 1.0.0
	 * @var array
	 */
	public $repeatable_sections = array();

	/**
	 * @since 1.0.0
	 * @var array
	 */
	public $choices = array();

	/**
	 * @since 1.0.0
	 * @var bool
	 */
	public $sortable = true;

	/**
	 * @since 1.2.0
	 * @var int
	 */
	protected $integration_count = 0;
	/**
	 * Icons array
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $icons = array();

	/**
	 * @var null
	 */
	protected $save_as_meta = null;

	/**
	 * Page builder
	 *
	 * @var
	 */
	protected $page_builder = false;

	/**
	 * Selective refresh
	 *
	 * @var bool
	 */
	protected $selective_refresh = false;

	/**
	 * @var null
	 */
	protected $repeater_helper = null;

	/**
	 * Epsilon_Control_Section_Repeater constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		$this->repeater_helper = Epsilon_Section_Repeater_Helper::get_instance( array( 'id' => $id ) );
		parent::__construct( $manager, $id, $args );
		$manager->register_control_type( 'Epsilon_Control_Section_Repeater' );
	}

	/**
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		$json['id']                 = $this->id;
		$json['link']               = $this->get_link();
		$json['choices']            = $this->choices;
		$json['value']              = $this->value();
		$json['sections']           = $this->set_repeatable_sections();
		$json['integrations']       = $this->check_integrations();
		$json['integrations_count'] = $this->integration_count;
		$json['default']            = ( isset( $this->default ) ) ? $this->default : $this->setting->default;
		$json['sortable']           = $this->sortable;
		$json['save_as_meta']       = $this->save_as_meta;
		$json['selective_refresh']  = $this->selective_refresh;

		return $json;
	}

	/**
	 * Enqueues selectize js
	 *
	 * @since  1.3.4
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'minicolors', EPSILON_URI . '/assets/vendors/minicolors/jquery.minicolors.css' );
		wp_enqueue_script( 'minicolors', EPSILON_URI . '/assets/vendors/minicolors/jquery.minicolors.min.js', array( 'jquery' ), '1.2.0', true );
		wp_enqueue_style( 'selectize', EPSILON_URI . '/assets/vendors/selectize/selectize.css' );
		wp_enqueue_script( 'selectize', EPSILON_URI . '/assets/vendors/selectize/selectize.min.js', array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * @since 1.2.0
	 */
	public function check_integrations() {
		$integration = false;
		foreach ( $this->repeatable_sections as $section ) {
			if ( isset( $section['integration'] ) && $section['integration']['status'] && $section['integration']['check'] ) {
				$integration = true;
				$this->integration_count ++;
			}
		}

		return $integration;
	}

	/**
	 * @since 1.0.0
	 */
	public function get_icons() {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$path = $this->icons;
		/**
		 * In case we don`t have path to icons, we load our own library
		 */
		if ( empty( $this->icons ) || ! file_exists( $path ) ) {
			$path = EPSILON_PATH . '/assets/data/icons.json';
		}

		$icons = $wp_filesystem->get_contents( $path );
		$icons = json_decode( $icons );


		/**
		 * In case the json could not be decoded, we return a new stdClass
		 */
		if ( null === $icons ) {
			return new stdClass();
		}

		return $icons;
	}

	/**
	 * @since 1.0.0
	 */
	public function set_repeatable_sections() {
		if ( empty( $this->repeatable_sections ) || ! is_array( $this->repeatable_sections ) ) {
			$this->repeatable_sections = array();
		}
		$sizes = Epsilon_Helper::get_image_sizes();

		foreach ( $this->repeatable_sections as $key => $value ) {
			/**
			 * Adds the new section class
			 */
			$this->repeatable_sections[ $key ]['fields'][ $key . '_section_class' ] = array(
				'label'   => esc_html__( 'Section Class', 'epsilon-framework' ),
				'type'    => 'epsilon-section-class',
				'default' => 'section-' . $key . '-' . mt_rand( 1, mt_getrandmax()),
			);

			foreach ( $value['fields'] as $k => $v ) {
				$this->repeatable_sections[ $key ]['fields'][ $k ]['metaId'] = ! empty( $this->save_as_meta ) ? $this->save_as_meta : '';

				if ( ! isset( $v['default'] ) ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['default'] = '';
				}

				if ( ! isset( $v['label'] ) ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['label'] = '';
				}

				if ( 'epsilon-icon-picker' === $v['type'] ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['icons'] = $this->get_icons();
				}

				if ( 'epsilon-customizer-navigation' === $v['type'] ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['group'] = 'outofit';

					$this->repeatable_sections[ $key ]['fields'][ $k ]['opensDouble'] = false;
				}
				/**
				 * Range Slider defaults
				 */
				if ( 'epsilon-slider' === $v['type'] ) {
					if ( ! isset( $this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] ) ) {
						$this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] = array();
					}

					$default = array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					);

					$this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] = wp_parse_args( $this->repeatable_sections[ $key ]['fields'][ $k ]['choices'], $default );
				}
				/**
				 * Epsilon Button Group defaults
				 */
				if ( 'epsilon-button-group' === $v['type'] ) {
					if ( ! isset( $this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] ) ) {
						$this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] = array();
					}

					$this->repeatable_sections[ $key ]['fields'][ $k ]['groupType'] = $this->repeater_helper->set_group_type( $this->repeatable_sections[ $key ]['fields'][ $k ]['choices'] );
				}

				/**
				 * Epsilon Image
				 */
				if ( 'epsilon-image' === $v['type'] ) {
					if ( ! isset( $this->repeatable_sections[ $key ]['fields'][ $k ]['default'] ) ) {
						$this->repeatable_sections[ $key ]['fields'][ $k ]['default'] = '';
					}

					$this->repeatable_sections[ $key ]['fields'][ $k ]['size']      = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['size'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['size'] : 'full';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['sizeArray'] = $sizes;

					$this->repeatable_sections[ $key ]['fields'][ $k ]['mode'] = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['mode'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['mode'] : 'url';
				}

				/**
				 * Color picker defaults
				 */
				if ( 'epsilon-color-picker' === $v['type'] ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['mode']       = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['mode'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['mode'] : 'hex';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['defaultVal'] = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['defaultVal'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['defaultVal'] : '';
				}

				/**
				 * Epsilon Upsell
				 */
				if ( 'epsilon-upsell' === $v['type'] ) {
					$this->repeatable_sections[ $key ]['fields'][ $k ]['label']              = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['label'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['label'] : __( 'See what\'s in the PRO version', 'epsilon-framework' );
					$this->repeatable_sections[ $key ]['fields'][ $k ]['separator']          = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['separator'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['separator'] : '';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['button_text']        = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['button_text'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['button_text'] : '';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['button_url']         = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['button_url'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['button_url'] : '';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_text'] = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_text'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_text'] : '';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_url']  = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_url'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['second_button_url'] : '';
					$this->repeatable_sections[ $key ]['fields'][ $k ]['options']            = ! empty( $this->repeatable_sections[ $key ]['fields'][ $k ]['options'] ) ? $this->repeatable_sections[ $key ]['fields'][ $k ]['options'] : array();
				}

				$this->repeatable_sections[ $key ]['fields'][ $k ]['id'] = $k;
			} // End foreach().

			if ( ! isset( $this->repeatable_sections[ $key ]['image'] ) ) {
				$this->repeatable_sections[ $key ]['image'] = EPSILON_URI . '/assets/img/ewf-icon-section-default.png';
			}

			if ( ! isset( $this->repeatable_sections[ $key ]['customization'] ) ) {
				$this->repeatable_sections[ $key ]['customization'] = array();
			}

			$this->repeatable_sections[ $key ]['customization'] = wp_parse_args(
				$this->repeatable_sections[ $key ]['customization'],
				array(
					'enabled' => false,
					'styling' => array(),
					'layout'  => array(),
					'colors'  => array(),
				)
			);

			$this->repeatable_sections[ $key ]['customization']['styling'] = $this->repeater_helper->create_styling_fields( $this->repeatable_sections[ $key ]['customization']['styling'], $key );
			$this->repeatable_sections[ $key ]['customization']['layout']  = $this->repeater_helper->create_layout_fields( $this->repeatable_sections[ $key ]['customization']['layout'], $key );
			$this->repeatable_sections[ $key ]['customization']['colors']  = $this->repeater_helper->create_color_fields( $this->repeatable_sections[ $key ]['customization']['colors'], $key );
		} // End foreach().

		return $this->repeatable_sections;
	}

	/**
	 * Empty
	 *
	 * @since 1.0.0
	 */
	public function render_content() {

	}

	/**
	 * Active callback override
	 */
	public function active_callback() {
		if ( ! $this->page_builder ) {
			return true;
		}

		$id = absint( url_to_postid( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
		if ( 0 === $id ) {
			$id = absint( get_option( 'page_on_front', 0 ) );
		}

		if ( absint( $this->save_as_meta ) === $id ) {
			return true;
		}

		return false;
	}

	/**
	 * Control template;
	 */
	public function content_template() {
		//@formatter:off ?>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
				<# if( data.description ){ #>
					<i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
						<span class="mte-tooltip">
							{{{ data.description }}}
						</span>
					</i>
				<# } #>
			</span> </label>
		<ul class="repeater-sections"></ul>
		<# if(!_.isUndefined(data.choices.limit)){ #>
		<?php /* Translators: Section limit */ ?>
		<p class="limit"><?php echo esc_html__( 'Limit: ', 'epsilon-framework' ); ?>
			{{{ data.choices.limit }}} <?php echo esc_html__( 'sections', 'epsilon-framework' ); ?></p>
		<# } #>
		<div class="epsilon-add-section-buttons">
			<input type="hidden" value="" {{{ data.link }}}/>
			<button type="button" class="button epsilon-add-new-section" aria-expanded="false" aria-controls="available-sections">
				<?php esc_html_e( 'Add a Section', 'epsilon-framework' ); ?>
			</button>
		</div>
		<div id="sections-left-{{ data.id }}">
			<div class="available-sections">
				<div class="available-sections-filter">
					<label class="screen-reader-text" for="sections-search-{{ data.id }}"><?php esc_html_e( 'Search sections', 'epsilon-framework' ); ?></label>
					<input type="text" class="sections-search-input" id="sections-search-{{ data.id }}" placeholder="<?php esc_attr_e( 'Search sections &hellip;', 'epsilon-framework' ) ?>" aria-describedby="sections-search-desc"/>
					<div class="search-icon" aria-hidden="true"></div>
					<button type="button" class="clear-results">
						<span class="screen-reader-text"><?php esc_html_e( 'Clear Results', 'epsilon-framework' ); ?></span>
					</button>
					<p class="screen-reader-text" id="sections-search-desc-{{ data.id }}"><?php esc_html_e( 'The search results will be updated as you type.', 'epsilon-framework' ); ?></p>
				</div>
				<div class="available-sections-list">
					<# if ( data.integrations ) { #>
						<nav class="available-sections-tab-nav">
							<a href="#" data-tab="normal" class="available-sections-tab-toggler active"><span class="dashicons dashicons-menu"></span> <?php esc_html_e( 'Sections', 'epsilon-framework' ); ?></a>
							<a href="#" data-tab="integrations" class="available-sections-tab-toggler"><span class="dashicons dashicons-admin-plugins"></span> <?php esc_html_e( 'Integrations', 'epsilon-framework' ); ?> <span class="badge">{{ data.integrations_count }}</span></a>
						</nav>
					<# } #>

					<# if ( data.integrations ) { #>
						<div data-tab-id="normal" class="normal-sections available-sections-tab-content active">
					<# } #>
						<# for (section in data.sections) { #>
						<# var temp = JSON.stringify(data.sections[section].fields); #>
							<# if ( _.isUndefined(data.sections[section].integration) ) { #>
								<div class="epsilon-section" data-id="{{ data.sections[section].id }}" >
									<div class="epsilon-section-image-description">
										<img src="{{ data.sections[section].image }}" />
										<span class="epsilon-section-description">{{ data.sections[section].description }}</span>
									</div>
									<span class="epsilon-section-title">{{ data.sections[section].title }}</span>
									<button class="button button-primary" data-action="add"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
									<button class="button button-info" data-action="info"> <i class="fa fa-question" aria-hidden="true"></i> </button>
									<input type="hidden" value="{{ temp }}" data-customization="{{ data.sections[section].customization.enabled }}"/>
								</div>
							<# } #>
						<# } #>

					<# if ( data.integrations ) { #>
						</div>
						<div data-tab-id="integrations" class="integrations-sections available-sections-tab-content">
							<# for (section in data.sections) { #>
								<# if ( ! _.isUndefined(data.sections[section].integration) ) { #>
									<div class="epsilon-section" data-id="{{ data.sections[section].id }}" >
										<div class="epsilon-section-image-description">
											<img src="{{ data.sections[section].image }}" />
											<span class="epsilon-section-description">{{ data.sections[section].description }}</span>
										</div>
										<span class="epsilon-section-title">{{ data.sections[section].title }}</span>
										<button class="button button-primary" data-action="add"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
										<button class="button button-info" data-action="info"> <i class="fa fa-question" aria-hidden="true"></i> </button>
										<input type="hidden" value="{{ temp }}" data-customization="{{ data.sections[section].customization.enabled }}"/>
									</div>
								<# } #>
							<# } #>
						</div>
					<# } #>
				</div>
			</div>
		</div>
		<?php //@formatter:on
	}
}
