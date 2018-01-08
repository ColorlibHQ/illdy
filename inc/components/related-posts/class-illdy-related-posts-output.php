<?php

if ( ! function_exists( 'illdy_call_related_posts' ) ) {

	function illdy_call_related_posts() {
		$display_related_blog_posts = get_theme_mod( 'illdy_enable_related_blog_posts', 1 );

		if ( 1 == $display_related_blog_posts ) {

			// instantiate the class & load everything else
			Illdy_Related_Posts_Output::get_instance();
		}
	}
	add_action( 'wp_loaded', 'illdy_call_related_posts' );
}


if ( ! class_exists( 'Illdy_Related_Posts_Output' ) ) {

	/**
	 * Class Illdy_Related_Posts_Output
	 */
	class Illdy_Related_Posts_Output {

		/**
		 * @var Singleton The reference to *Singleton* instance of this class
		 */
		private static $instance;

		/**
		 *
		 */
		protected function __construct() {
			add_action( 'illdy_single_after_content', array( $this, 'output_related_posts' ), 3 );
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
		 * Render related posts carousel
		 *
		 * @return string                    HTML markup to display related posts
		 **/
		function output_related_posts() {
			global $post;

			$output = '';

			$post_query_args = array(
				'post_type'              => array( 'post' ),
				'category__in'           => wp_get_post_categories( $post->ID ),
				'nopaging'               => false,
				'posts_per_page'         => 3,
				'ignore_sticky_posts'    => true,
				'cache_results'          => true,
				'update_post_meta_cache' => true,
				'update_post_term_cache' => true,
				'post__not_in'           => array( $post->ID ),
				'meta_key'               => '_thumbnail_id',
			);

			$post_query = new WP_Query( $post_query_args );

			if ( $post_query->have_posts() ) {
				$output                 .= '<div class="blog-post-related-articles">';
					$output             .= '<div class="row">';
						$output         .= '<div class="col-sm-12">';
							$output     .= '<div class="related-article-title">';
								$output .= __( 'Related Articles', 'illdy' );
							$output     .= '</div><!--/.related-article-title-->';
						$output         .= '</div><!--/.col-sm-12-->';

				while ( $post_query->have_posts() ) {
					$post_query->the_post();

					$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'illdy-blog-post-related-articles' );

					$output .= '<div class="col-sm-4">';
					$output .= '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '" class="related-post" style="background-image: url(' . ( $post_thumbnail ? esc_url( $post_thumbnail[0] ) : '' ) . ');">';
					$output .= '<span class="related-post-title">' . esc_html( get_the_title() ) . '</span>';
					$output .= '</a><!--/.related-post-->';
					$output .= '</div><!--/.col-sm-4-->';
				}
					$output .= '</div><!--/.row-->';
				$output     .= '</div><!--/.blog-post-related-articles-->';
			}

			wp_reset_postdata();

			echo $output;
		}
	}
}// End if().
