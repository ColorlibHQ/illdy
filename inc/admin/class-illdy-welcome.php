<?php
/**
 * The "About Illdy" admin screen.
 *
 * Replaces the Epsilon welcome screen. Same purpose — get someone from a fresh install
 * to a finished site — but built from core admin markup and core's own plugin installer
 * rather than a vendored framework, and without the parts that had no business being
 * there: the PRO licence form, the dismissable "required actions" checklist that wrote
 * its own state to the options table, and the notice that nagged on every admin page.
 *
 * Tabs are extensible. Illdy Companion adds the demo importer through
 * `illdy_welcome_tabs` + `illdy_welcome_tab_{id}` instead of handing this screen a blob
 * of HTML to print, which is how the old one worked.
 *
 * @package WordPress
 * @subpackage illdy
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Illdy_Welcome' ) ) {

	class Illdy_Welcome {

		/**
		 * Menu slug. Deliberately the one the old welcome screen used, so existing
		 * bookmarks and the links in Colorlib's documentation still resolve.
		 */
		const SLUG = 'illdy-welcome';

		/**
		 * Capability to view the screen.
		 */
		const CAP = 'edit_theme_options';

		/**
		 * Plugins suggested on the Recommended Plugins tab.
		 *
		 * Every one is a free wordpress.org plugin, installed through core's own
		 * installer. Illdy Companion is listed first because the front page sections
		 * depend on its widgets.
		 *
		 * @return array Slug => reason it is suggested.
		 */
		public static function recommended_plugins() {
			$plugins = array(
				'illdy-companion'                  => __( 'Adds the widgets that build the Illdy front page, and the demo content importer. The theme needs it to look like the demo.', 'illdy' ),
				'kali-forms'                       => __( 'Contact forms for the front page contact section, built by the same team.', 'illdy' ),
				'colorlib-login-customizer'        => __( 'Restyle the WordPress login screen to match your site.', 'illdy' ),
				'colorlib-coming-soon-maintenance' => __( 'Put up a coming soon or maintenance page while you build.', 'illdy' ),
				'simple-custom-post-order'         => __( 'Reorder posts, pages and projects by dragging them.', 'illdy' ),
				'fancybox-for-wordpress'           => __( 'Lightbox for images in posts and the portfolio.', 'illdy' ),
			);

			/**
			 * Filters the plugins suggested on the About Illdy screen.
			 *
			 * @param array $plugins Slug => description.
			 */
			return apply_filters( 'illdy_recommended_plugins', $plugins );
		}

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * The admin-page hook suffix, for scoping asset loading.
		 *
		 * @return string
		 */
		public static function hook_suffix() {
			return 'appearance_page_' . self::SLUG;
		}

		/**
		 * URL of the screen, optionally of one tab.
		 *
		 * @param string $tab Tab id.
		 *
		 * @return string
		 */
		public static function url( $tab = '' ) {
			$args = array( 'page' => self::SLUG );

			if ( '' !== $tab ) {
				$args['tab'] = $tab;
			}

			return add_query_arg( $args, self_admin_url( 'themes.php' ) );
		}

		/**
		 * Registers the screen under Appearance.
		 */
		public function register_page() {
			add_theme_page(
				/* translators: %s: theme name. */
				sprintf( __( 'About %s', 'illdy' ), 'Illdy' ),
				/* translators: %s: theme name. */
				sprintf( __( 'About %s', 'illdy' ), 'Illdy' ),
				self::CAP,
				self::SLUG,
				array( $this, 'render' )
			);
		}

		/**
		 * The tabs, in display order.
		 *
		 * @return array Tab id => label.
		 */
		public function tabs() {
			$tabs = array(
				'getting-started' => __( 'Getting Started', 'illdy' ),
				'plugins'         => __( 'Recommended Plugins', 'illdy' ),
				'support'         => __( 'Support', 'illdy' ),
			);

			/**
			 * Filters the About Illdy tabs.
			 *
			 * A tab with no matching render method here fires
			 * `illdy_welcome_tab_{id}` instead, which is how Illdy Companion adds
			 * the demo importer.
			 *
			 * @param array $tabs Tab id => label.
			 */
			$tabs = apply_filters( 'illdy_welcome_tabs', $tabs );

			return is_array( $tabs ) ? $tabs : array();
		}

		/**
		 * The requested tab, validated against the registered ones.
		 *
		 * @return string
		 */
		public function current_tab() {
			$tabs = $this->tabs();

			if ( empty( $tabs ) ) {
				return '';
			}

			$requested = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			/*
			 * The old screen required a file named after the tab and passed the request
			 * value straight to require_once, so an unknown tab was a fatal error on an
			 * empty path. Anything unrecognised now falls back to the first tab.
			 */
			if ( '' !== $requested && isset( $tabs[ $requested ] ) ) {
				return $requested;
			}

			return (string) key( $tabs );
		}

		/**
		 * Loads styles, and core's plugin installer on the tab that needs it.
		 *
		 * @param string $hook_suffix Current admin page.
		 */
		public function enqueue( $hook_suffix ) {
			if ( self::hook_suffix() !== $hook_suffix ) {
				return;
			}

			wp_enqueue_style(
				'illdy-welcome',
				get_template_directory_uri() . '/inc/admin/css/illdy-welcome.css',
				array(),
				ILLDY_VERSION
			);

			if ( 'plugins' !== $this->current_tab() ) {
				return;
			}

			/*
			 * The plugin cards below use core's markup, so core's own scripts drive the
			 * Install / Activate buttons over AJAX. Nothing theme-specific is involved,
			 * which means no nonce or capability handling of this theme's own.
			 */
			wp_enqueue_style( 'plugin-install' );
			wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
			add_thickbox();
		}

		/**
		 * Renders the screen.
		 */
		public function render() {
			if ( ! current_user_can( self::CAP ) ) {
				wp_die( esc_html__( 'You do not have permission to view this page.', 'illdy' ) );
			}

			$theme   = wp_get_theme( get_template() );
			$tabs    = $this->tabs();
			$current = $this->current_tab();
			?>
			<div class="wrap illdy-welcome">

				<h1 class="illdy-welcome__title">
					<?php
					/* translators: %s: theme name. */
					printf( esc_html__( 'Welcome to %s', 'illdy' ), esc_html( $theme->get( 'Name' ) ) );
					?>
					<span class="illdy-welcome__version"><?php echo esc_html( $theme->get( 'Version' ) ); ?></span>
				</h1>

				<p class="illdy-welcome__intro">
					<?php esc_html_e( 'Illdy is a one-page WordPress theme with a front page you build from widgets. Everything below is optional — the three steps on this tab are the fastest route to a site that looks like the demo.', 'illdy' ); ?>
				</p>

				<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'illdy' ); ?>">
					<?php foreach ( $tabs as $illdy_tab_id => $illdy_tab_label ) : ?>
						<a href="<?php echo esc_url( self::url( $illdy_tab_id ) ); ?>"
							class="nav-tab<?php echo ( $illdy_tab_id === $current ) ? ' nav-tab-active' : ''; ?>"
							<?php echo ( $illdy_tab_id === $current ) ? ' aria-current="page"' : ''; ?>>
							<?php echo esc_html( $illdy_tab_label ); ?>
						</a>
					<?php endforeach; ?>
				</nav>

				<div class="illdy-welcome__body">
					<?php
					switch ( $current ) {
						case 'getting-started':
							$this->tab_getting_started();
							break;

						case 'plugins':
							$this->tab_plugins();
							break;

						case 'support':
							$this->tab_support();
							break;

						default:
							/**
							 * Renders a tab added through `illdy_welcome_tabs`.
							 *
							 * @param string $current Tab id.
							 */
							do_action( 'illdy_welcome_tab_' . $current, $current );
							break;
					}
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * A link that opens in a new tab, with a trailing external-link icon.
		 *
		 * Centralised so the icon spacing and the screen-reader hint stay identical
		 * everywhere; the icon is aligned by flex on .illdy-external-link rather than by
		 * vertical-align, which cannot centre an inline-block against the button's
		 * line-height.
		 *
		 * @param string $url     Destination.
		 * @param string $label   Visible text.
		 * @param string $classes Classes for the anchor.
		 */
		private function external_link( $url, $label, $classes = 'button' ) {
			printf(
				'<a class="%1$s illdy-external-link" href="%2$s" target="_blank" rel="noopener noreferrer">%3$s<span class="dashicons dashicons-external" aria-hidden="true"></span><span class="screen-reader-text">%4$s</span></a>',
				esc_attr( $classes ),
				esc_url( $url ),
				esc_html( $label ),
				esc_html__( '(opens in a new tab)', 'illdy' )
			);
		}

		/**
		 * Tab: Getting Started.
		 */
		private function tab_getting_started() {
			$companion_active = Illdy_Plugin_State::is_active( 'illdy-companion' );
			$has_import_tab   = array_key_exists( 'import', $this->tabs() );
			$static_front     = ( 'page' === get_option( 'show_on_front' ) );
			?>
			<div class="illdy-steps">

				<div class="illdy-step<?php echo $companion_active ? ' is-done' : ''; ?>">
					<h3>
						<span class="illdy-step__num" aria-hidden="true">1</span>
						<?php esc_html_e( 'Install Illdy Companion', 'illdy' ); ?>
						<?php if ( $companion_active ) : ?>
							<span class="illdy-step__badge"><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e( 'Done', 'illdy' ); ?></span>
						<?php endif; ?>
					</h3>
					<p><?php esc_html_e( 'The front page sections — About, Projects, Services, Team, Counter, Testimonials — are built from widgets that this free plugin provides. Without it those sections show placeholder content.', 'illdy' ); ?></p>
					<p>
						<?php if ( $companion_active ) : ?>
							<a href="<?php echo esc_url( self::url( 'plugins' ) ); ?>"><?php esc_html_e( 'See the other recommended plugins', 'illdy' ); ?></a>
						<?php else : ?>
							<a class="button button-primary" href="<?php echo esc_url( self::url( 'plugins' ) ); ?>"><?php esc_html_e( 'Install Illdy Companion', 'illdy' ); ?></a>
						<?php endif; ?>
					</p>
				</div>

				<div class="illdy-step<?php echo $static_front ? ' is-done' : ''; ?>">
					<h3>
						<span class="illdy-step__num" aria-hidden="true">2</span>
						<?php esc_html_e( 'Import the demo content', 'illdy' ); ?>
						<?php if ( $static_front ) : ?>
							<span class="illdy-step__badge"><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e( 'Front page set', 'illdy' ); ?></span>
						<?php endif; ?>
					</h3>
					<p><?php esc_html_e( 'Sets up the front page the way the demo looks: creates the Front Page and Blog pages, fills in the Customizer settings and adds the front page widgets. Optional — you can build everything by hand instead.', 'illdy' ); ?></p>
					<p>
						<?php if ( $has_import_tab ) : ?>
							<a class="button" href="<?php echo esc_url( self::url( 'import' ) ); ?>"><?php esc_html_e( 'Go to the importer', 'illdy' ); ?></a>
						<?php else : ?>
							<em><?php esc_html_e( 'Available once Illdy Companion is active.', 'illdy' ); ?></em>
						<?php endif; ?>
					</p>
				</div>

				<div class="illdy-step">
					<h3>
						<span class="illdy-step__num" aria-hidden="true">3</span>
						<?php esc_html_e( 'Make it yours', 'illdy' ); ?>
					</h3>
					<p><?php esc_html_e( 'Colours, fonts, the header image or video, and the order of the front page sections are all in the Customizer. Drag the sections in Front Page Sections to reorder them.', 'illdy' ); ?></p>
					<p>
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Open the Customizer', 'illdy' ); ?></a>
						<a class="button" href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Manage widgets', 'illdy' ); ?></a>
					</p>
				</div>
			</div>

			<div class="illdy-callout">
				<h3><?php esc_html_e( 'Read the documentation', 'illdy' ); ?></h3>
				<p><?php esc_html_e( 'Illdy works differently from most themes: the front page is a stack of widget areas rather than a page you edit. The documentation covers how each section is put together.', 'illdy' ); ?></p>
				<p>
					<?php $this->external_link( 'https://colorlib.com/wp/support/illdy/', __( 'Illdy documentation', 'illdy' ) ); ?>
				</p>
			</div>
			<?php
		}

		/**
		 * Tab: Recommended Plugins.
		 */
		private function tab_plugins() {
			$plugins = self::recommended_plugins();
			?>
			<p class="illdy-tab-intro">
				<?php esc_html_e( 'All free, all from the WordPress.org plugin directory, and all optional except the first. They install here without leaving this page.', 'illdy' ); ?>
			</p>

			<?php if ( ! current_user_can( 'install_plugins' ) ) : ?>
				<div class="notice notice-info inline">
					<p><?php esc_html_e( 'Your account cannot install plugins, so these are listed for reference only.', 'illdy' ); ?></p>
				</div>
			<?php endif; ?>

			<div id="plugin-filter" class="illdy-plugin-cards">
				<?php
				foreach ( $plugins as $illdy_slug => $illdy_reason ) {
					$this->render_plugin_card( $illdy_slug, $illdy_reason );
				}
				?>
			</div>
			<?php
		}

		/**
		 * One plugin card, in the shape core's plugin browser uses.
		 *
		 * The class names and data attributes matter: wp.updates binds Install / Activate
		 * to them, so the buttons behave exactly as they do under Plugins → Add New.
		 *
		 * @param string $slug   Plugin directory slug.
		 * @param string $reason Why Illdy suggests it.
		 */
		private function render_plugin_card( $slug, $reason ) {
			$info   = Illdy_Plugin_State::info( $slug );
			$action = Illdy_Plugin_State::action( $slug );
			$icon   = Illdy_Plugin_State::icon( $info );

			$name    = is_object( $info ) && ! empty( $info->name ) ? $info->name : $slug;
			$author  = is_object( $info ) && ! empty( $info->author ) ? $info->author : '';
			$version = is_object( $info ) && ! empty( $info->version ) ? $info->version : '';
			$details = add_query_arg(
				array(
					'tab'       => 'plugin-information',
					'plugin'    => $slug,
					'TB_iframe' => 'true',
					'width'     => 772,
					'height'    => 550,
				),
				self_admin_url( 'plugin-install.php' )
			);
			?>
			<div class="plugin-card plugin-card-<?php echo esc_attr( $slug ); ?> illdy-plugin-card">
				<div class="illdy-plugin-card__head">
					<?php if ( '' !== $icon ) : ?>
						<img class="illdy-plugin-card__icon" src="<?php echo esc_url( $icon ); ?>" alt="" width="64" height="64">
					<?php else : ?>
						<span class="illdy-plugin-card__icon illdy-plugin-card__icon--fallback dashicons dashicons-admin-plugins" aria-hidden="true"></span>
					<?php endif; ?>

					<div class="illdy-plugin-card__heading">
						<h3><?php echo esc_html( $name ); ?></h3>
						<?php if ( '' !== $author || '' !== $version ) : ?>
							<p class="illdy-plugin-card__meta">
								<?php if ( '' !== $version ) : ?>
									<?php
									/* translators: %s: plugin version number. */
									printf( esc_html__( 'Version %s', 'illdy' ), esc_html( $version ) );
									?>
								<?php endif; ?>
								<?php if ( '' !== $author && '' !== $version ) : ?><span aria-hidden="true"> · </span><?php endif; ?>
								<?php echo wp_kses( $author, array( 'a' => array( 'href' => array(), 'title' => array() ) ) ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<p class="illdy-plugin-card__desc"><?php echo esc_html( $reason ); ?></p>

				<div class="illdy-plugin-card__actions">
					<?php if ( $action['enabled'] ) : ?>
						<a class="<?php echo esc_attr( $action['class'] ); ?>"
							href="<?php echo esc_url( $action['url'] ); ?>"
							data-slug="<?php echo esc_attr( $slug ); ?>"
							data-name="<?php echo esc_attr( $name ); ?>"
							aria-label="<?php echo esc_attr( sprintf( '%1$s %2$s', $action['label'], $name ) ); ?>">
							<?php echo esc_html( $action['label'] ); ?>
						</a>
					<?php else : ?>
						<button type="button" class="<?php echo esc_attr( $action['class'] ); ?>" disabled>
							<?php echo esc_html( $action['label'] ); ?>
						</button>
					<?php endif; ?>

					<?php if ( is_object( $info ) && current_user_can( 'install_plugins' ) ) : ?>
						<a href="<?php echo esc_url( $details ); ?>" class="thickbox open-plugin-details-modal illdy-plugin-card__details"
							aria-label="<?php echo esc_attr( sprintf( /* translators: %s: plugin name. */ __( 'More information about %s', 'illdy' ), $name ) ); ?>">
							<?php esc_html_e( 'More details', 'illdy' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		/**
		 * Tab: Support.
		 */
		private function tab_support() {
			$cards = array(
				array(
					'icon'  => 'dashicons-book-alt',
					'title' => __( 'Documentation', 'illdy' ),
					'text'  => __( 'How the front page sections work, what each Customizer option does, and how to set up the theme from scratch.', 'illdy' ),
					'label' => __( 'Read the docs', 'illdy' ),
					'url'   => 'https://colorlib.com/wp/support/illdy/',
				),
				array(
					'icon'  => 'dashicons-sos',
					'title' => __( 'Support forum', 'illdy' ),
					'text'  => __( 'Free support for Illdy on WordPress.org. Search first — most questions have already been answered there.', 'illdy' ),
					'label' => __( 'Ask a question', 'illdy' ),
					'url'   => 'https://wordpress.org/support/theme/illdy/',
				),
				array(
					'icon'  => 'dashicons-star-filled',
					'title' => __( 'Leave a review', 'illdy' ),
					'text'  => __( 'Illdy is free and always has been. A review on WordPress.org is the most useful thing you can do in return.', 'illdy' ),
					'label' => __( 'Rate Illdy', 'illdy' ),
					'url'   => 'https://wordpress.org/support/theme/illdy/reviews/#new-post',
				),
				array(
					'icon'  => 'dashicons-editor-code',
					'title' => __( 'Report a bug', 'illdy' ),
					'text'  => __( 'Found something broken, or want to suggest a change? The theme is developed in the open on GitHub.', 'illdy' ),
					'label' => __( 'Open an issue', 'illdy' ),
					'url'   => 'https://github.com/ColorlibHQ/illdy/issues',
				),
			);
			?>
			<div class="illdy-support-cards">
				<?php foreach ( $cards as $illdy_card ) : ?>
					<div class="illdy-support-card">
						<h3>
							<span class="dashicons <?php echo esc_attr( $illdy_card['icon'] ); ?>" aria-hidden="true"></span>
							<?php echo esc_html( $illdy_card['title'] ); ?>
						</h3>
						<p><?php echo esc_html( $illdy_card['text'] ); ?></p>
						<p>
							<?php $this->external_link( $illdy_card['url'], $illdy_card['label'] ); ?>
						</p>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="illdy-callout">
				<h3><?php esc_html_e( 'Before you ask', 'illdy' ); ?></h3>
				<p><?php esc_html_e( 'Two things account for most support questions: the front page is built from widgets rather than page content, and the front page sections only appear when Settings → Reading is set to a static page. Both are covered in step 1 and 2 of Getting Started.', 'illdy' ); ?></p>
				<p><a href="<?php echo esc_url( self::url( 'getting-started' ) ); ?>"><?php esc_html_e( 'Back to Getting Started', 'illdy' ); ?></a></p>
			</div>
			<?php
		}
	}

	new Illdy_Welcome();
}
