<?php
/**
 *	Template Name: Blog
 *
 *	The template for dispalying Custom Page Template: Blog.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-7">
			<section id="blog">
				<?php do_action( 'mtl_above_content_after_header' ); ?>
				<?php
				$wp_query_args = array (
					'post_type'					=> array( 'post' ),
					'ignore_sticky_posts'		=> true,
					'cache_results'				=> true,
					'update_post_meta_cache'	=> true,
					'update_post_term_cache'	=> true
				);

				$wp_query = new WP_Query( $wp_query_args );

				if( $wp_query->have_posts() ):
					while( $wp_query->have_posts() ):
						$wp_query->the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
				else:
					get_template_part( 'template-parts/content', 'none' );
				endif;

				wp_reset_postdata();
				?>
				<?php do_action( 'mtl_after_content_above_footer' ); ?>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
		<?php get_sidebar(); ?>
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>