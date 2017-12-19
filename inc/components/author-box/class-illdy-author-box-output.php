<?php

if ( ! class_exists( 'Illdy_Author_Box_Output' ) ) {

	/**
	 * Class Illdy_Author_Box_Output
	 */
	class Illdy_Author_Box_Output {

		/**
		 * @var Singleton The reference to *Singleton* instance of this class
		 */
		private static $instance;

		/**
		 *
		 */
		protected function __construct() {
			add_action( 'illdy_single_after_content', array( $this, 'output_author_box' ), 3 );
		}

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Singleton The *Singleton* instance.
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Singleton* instance.
		 *
		 * @return void
		 */
		private function __clone() {
		}

		/**
		 * Private unserialize method to prevent unserializing of the *Singleton*
		 * instance.
		 *
		 * @return void
		 */
		private function __wakeup() {
		}

		/**
		 * Simple function that renders the Author Box Mark-up HTML code
		 *
		 * @return string
		 */
		function output_author_box() {
			$output = '';

			$output     .= '<div class="blog-post-author clearfix">';
				$output .= get_avatar( get_the_author_meta( 'user_email' ), 98 );
				$output .= '<h4>' . esc_html( get_the_author() ) . '</h4>';
				$output .= ( get_the_author_meta( 'description' ) ) ? '<div>' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</div>' : '';
			$output     .= '</div><!--/.blog-post-author.clearfix-->';

			echo $output;
		}
	}
}// End if().

if ( ! function_exists( 'illdy_call_author_box_class' ) ) {
	/**
	 *
	 * Gets called only if the "display social media options" option is checked
	 * in the back-end
	 *
	 * @since   1.0.0
	 *
	 */
	function illdy_call_author_box_class() {
		$display_author_box = get_theme_mod( 'illdy_enable_author_box_blog_posts', 1 );

		if ( 1 == $display_author_box ) {
			// instantiate the class & load everything else
			Illdy_Author_Box_Output::get_instance();
		}
	}
	add_action( 'wp_loaded', 'illdy_call_author_box_class' );
}
