<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Notify_System
 */
class Epsilon_Section_Navigation_Menu {
	/**
	 * @var string
	 */
	public $option = '';
	/**
	 * @var mixed|string|void
	 */
	public $id = '';
	/**
	 * @var array
	 */
	public $sections = array();

	/**
	 * Epsilon_Section_Navigation_Menu constructor.
	 */
	public function __construct( $option = '' ) {
		$this->id       = get_option( 'page_on_front' );
		$this->option   = $option . $this->id;
		$this->sections = $this->get_fp_sections();

		if ( empty( $this->sections ) ) {
			return;
		}

		add_action( 'admin_head-nav-menus.php', array( $this, 'add_section_metabox' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_menu_item' ), 10, 3 );
	}

	/**
	 *
	 */
	public function add_section_metabox() {
		add_meta_box(
			'epsilon-page-sections',
			__( 'Front Page Sections', 'epsilon-framework' ),
			array( $this, 'metabox_callback' ),
			'nav-menus',
			'side',
			'default'
		);
	}

	/**
	 *
	 */
	public function metabox_callback() {
		global $_nav_menu_placeholder, $nav_menu_selected_id;
		$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : - 1;

		if ( empty( $this->sections ) ) {
			return;
		}
		//@formatter:off
		?>
		<div class="customlinkdiv" id="epsilon-section-navigation-menu">
			<input type="hidden"
			       value="custom"
			       name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-type]"/>
			<p id="menu-item-url-wrap" class="wp-clearfix">
				<label class="howto"
				       for="custom-menu-item-url">
					<?php esc_html_e( 'Section', 'epsilon-framework' ); ?>
				</label>
				<select id="epsilon-section-id"
				        name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-url]"
				        type="text"
				        class="code menu-item-textbox">
					<option value="0"><?php esc_html_e( 'Select a Section', 'epsilon-framework' ); ?></option>
					<?php foreach ( $this->sections as $k => $v ) { ?>
						<option value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v['label'] ); ?></option>
					<?php } ?>
				</select>
			</p>
			<p id="menu-item-name-wrap" class="wp-clearfix">
				<label class="howto"
				       for="custom-menu-item-name">
					<?php esc_html_e( 'Label', 'epsilon-framework' ); ?>
				</label>
				<input id="epsilon-section-label"
				       name="menu-item[<?php echo esc_attr( $_nav_menu_placeholder ); ?>][menu-item-title]"
				       type="text"
				       class="regular-text menu-item-textbox"/>
			</p>
			<p>
				<?php esc_html_e('Only sections that have an ID are selectable, please edit section id\'s to see all the sections!', 'epsilon-framework');?>
			</p>
			<p class="button-controls wp-clearfix">
			<span class="add-to-menu">
				<input type="submit" <?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?>
				       class="button submit-add-to-menu right"
				       value="<?php esc_attr_e( 'Add to Menu', 'epsilon-framework' ); ?>"
				       name="add-epsilon-section-menu-item"
				       id="submit-epsilon-section"/>
				<span class="spinner"></span>
			</span>
			</p>

		</div><!-- /.customlinkdiv -->
		<?php
		//@formatter:on
	}

	/**
	 * Updates menu item
	 */
	public function update_menu_item() {
		if ( ! empty( $_POST['menu-item'] ) && count( $_POST['menu-item'] ) == 1 ) {
			if ( isset( $_POST['menu-item']['-1'] ) ) {
				$menu_item = $_POST['menu-item']['-1'];
				if ( isset( $menu_item['menu-item-extra'] ) && 'epsilon-section' == $menu_item['menu-item-extra'] ) {
					update_post_meta( $menu_item_db_id, '_menu_item_extra', 'epsilon-section' );
				}
				if ( isset( $menu_item['menu-item-widget'] ) ) {
					update_post_meta( $menu_item_db_id, '_menu_item_widget', sanitize_text_field( $menu_item['menu-item-widget'] ) );
				}
			}
		}
	}

	/**
	 * @returns array
	 */
	public function get_fp_sections() {
		$arr = array();

		if ( is_customize_preview() ) {
			return $arr;
		}

		$fp = Epsilon_Page_Generator::get_instance( $this->option, $this->id );

		if ( ! $fp->sections ) {
			return $arr;
		}

		foreach ( $fp->sections as $index => $values ) {
			if ( empty( $values[ $values['type'] . '_section_unique_id' ] ) ) {
				continue;
			}
			$arr[ $values[ $values['type'] . '_section_unique_id' ] ] = array(
				'index'  => $index,
				'type'   => $values['type'],
				'label'  => ucwords( $values['type'] ),
				'unique' => $values[ $values['type'] . '_section_unique_id' ],
			);
		}

		return $arr;
	}
}
