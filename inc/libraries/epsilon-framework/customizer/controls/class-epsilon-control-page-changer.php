<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Control_Page_Changer
 */
class Epsilon_Control_Page_Changer extends WP_Customize_Control {
	/**
	 * Control type
	 *
	 * @var string
	 */
	public $type = 'epsilon-page-changer';

	/**
	 * Epsilon_Control_Customizer_Navigation constructor.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$manager->register_control_type( 'Epsilon_Control_Page_Changer' );
	}

	/**
	 * Enqueues selectize js
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'selectize', EPSILON_URI . '/assets/vendors/selectize/selectize.css' );
		wp_enqueue_script( 'selectize', EPSILON_URI . '/assets/vendors/selectize/selectize.min.js', array( 'jquery' ), '1.0.0', true );
	}


	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.2.0
	 * @access public
	 */
	public function json() {
		$json = parent::json();

		$json['id']          = $this->id;
		$json['currentPage'] = $this->get_current_page();
		$json['pages']       = $this->get_pages();

		return $json;
	}

	/**
	 * Gets the current page so we can "select" the value
	 */
	public function get_current_page() {
		$id = absint( url_to_postid( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
		if ( 0 === $id ) {
			$id = absint( get_option( 'page_on_front', 0 ) );
		}

		return $id;
	}

	/**
	 * Returns an array of pages
	 *
	 * @return array
	 */
	public function get_pages() {
		$arr   = array();
		$pages = get_pages( array( 'exclude' => get_option( 'page_for_posts' ) ) );

		foreach ( $pages as $key => $page ) {
			$arr[ $page->ID ] = array(
				'id'    => $page->ID,
				'title' => $page->post_title,
				'link'  => get_permalink( $page->ID ),
			);
		}

		return $arr;
	}

	/**
	 * Empty as it should be
	 *
	 * @since 1.0.0
	 */
	public function render_content() {

	}

	/**
	 * Render the content template
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		//@formatter:off ?>
		<label>
			<span class="customize-control-title">
				<# if( data.label ){ #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>

				<# if( data.description ){ #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</span>
			<select id="{{{ data.id }}}-page-changer">
				<# _.each(data.pages, function(k, v){ #>
					<option <# if( k['id'] == data.currentPage ) { #> selected <# } #> value="{{{ k['link'] }}}">{{{ k['title'] }}}</option>
				<# }) #>
			</select>
		</label>
		<?php //@formatter:on
	}
}
