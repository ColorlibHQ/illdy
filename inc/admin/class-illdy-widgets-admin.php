<?php
/**
 * Points people at the Customizer for front page editing.
 *
 * Illdy's front page is a stack of widget areas, which makes the Widgets screen a
 * confusing place to build it: the areas are listed out of order, named for sections
 * rather than for what they look like, and nothing on screen shows the result. The
 * Customizer has a Front Page Sections panel that puts them in render order, previews
 * every change live, and lets the sections be reordered by dragging.
 *
 * So the Widgets screen keeps working — it is core UI and removing it would be worse
 * than the problem — but it now says where the better tool is.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Widgets_Admin' ) ) {

	class Illdy_Widgets_Admin {

		/**
		 * Customizer panel holding the front page sections.
		 */
		const PANEL = 'illdy_frontpage_panel';

		public function __construct() {
			add_action( 'admin_notices', array( $this, 'customizer_pointer' ) );
		}

		/**
		 * Deep link into the Front Page Sections panel.
		 *
		 * @return string
		 */
		public static function panel_url() {
			return add_query_arg(
				array(
					'autofocus' => array( 'panel' => self::PANEL ),
					'return'    => rawurlencode( admin_url( 'widgets.php' ) ),
				),
				admin_url( 'customize.php' )
			);
		}

		/**
		 * Shows the pointer on the Widgets screen only.
		 */
		public function customizer_pointer() {
			$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

			if ( ! $screen || 'widgets' !== $screen->id ) {
				return;
			}

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}
			?>
			<div class="notice notice-info">
				<p>
					<strong><?php esc_html_e( 'Building the Illdy front page?', 'illdy' ); ?></strong>
					<?php esc_html_e( 'The front page sections are the widget areas below, but the Customizer shows them in the order they render, previews every change live, and lets you drag the sections to reorder them.', 'illdy' ); ?>
				</p>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( self::panel_url() ); ?>">
						<?php esc_html_e( 'Edit front page sections', 'illdy' ); ?>
					</a>
				</p>
			</div>
			<?php
		}
	}

	new Illdy_Widgets_Admin();
}
