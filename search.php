<?php
/**
 *	The template for displaying the search.
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
				<?php do_action( 'illdy_above_content_after_header' ); ?>
				<?php
				if( have_posts() ):
					while( have_posts() ):
						the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
				else:
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
				<?php do_action( 'illdy_after_content_above_footer' ); ?>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
		<?php get_sidebar(); ?>
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>