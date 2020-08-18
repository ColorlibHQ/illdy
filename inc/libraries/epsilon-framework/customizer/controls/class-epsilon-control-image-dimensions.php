<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Control_Image_Dimensions
 */
class Epsilon_Control_Image_Dimensions extends WP_Customize_Control {
	/**
	 * Control type
	 *
	 * @var string
	 */
	public $type = 'epsilon-image-dimensions';
	/**
	 * Linked control
	 *
	 * @var string
	 */
	public $linked_control = '';

	/**
	 * Epsilon_Control_Image_Dimensions constructor.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param                      $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$manager->register_control_type( 'Epsilon_Control_Image_Dimensions' );
	}

	/**
	 * Format data so we can access it in JS
	 *
	 * @return array
	 */
	public function json() {
		$json                  = parent::json();
		$json['id']            = $this->id;
		$json['link']          = $this->get_link();
		$json['linkedControl'] = $this->linked_control;
		$json['value']         = $this->get_values();

		return $json;
	}

	/**
	 * Get values
	 */
	public function get_values() {
		$arr = array(
			'width'  => null,
			'height' => null,
			'ratio'  => true,
		);

		$values = json_decode( $this->value(), true );

		if ( $values === null ) {
			return $arr;
		}

		return wp_parse_args( $values, $arr );
	}

	/**
	 * Display the control's content
	 */
	public function content_template() {
		//@formatter:off ?>
		<label class="epsilon-image-dimensions-label">
			<span class="customize-control-title epsilon-button-label">
				{{{ data.label }}}
				<# if( data.description ){ #>
					<i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
						<span class="mte-tooltip">
							{{{ data.description }}}
						</span>
					</i>
				<# } #>
			</span>
		</label>
		<div class="epsilon-controller-image-dimensions-container">
			<div class="col-4">
				<label for="{{ data.id }}-width" class="mini-label"><?php esc_html_e('Width', 'epsilon-framework'); ?></label>
				<input type="text" id="{{ data.id }}-width" data-type="width" value="{{ data.value.width }}"/>
			</div>
			<div class="col-4">
				<label for="{{ data.id }}-height" class="mini-label"><?php esc_html_e('Height', 'epsilon-framework'); ?></label>
				<input type="text" id="{{ data.id }}-height" data-type="height" value="{{ data.value.height }}"/>
			</div>
			<div class="col-4">
				<label for="{{ data.id }}-ratio" class="mini-label"><?php esc_html_e('Ratio', 'epsilon-framework'); ?></label>
				<input type="checkbox" id="{{ data.id }}-ratio" <# if ( data.value.ratio ){ #> checked <# } #>/>
			</div>
		</div>
	<?php //@formatter:on
	}


	/**
	 * Empty, as it should be
	 *
	 */
	public function render_content() {
	}
}
