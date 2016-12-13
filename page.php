<?php
/**
 *	The template for dispalying the page.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<?php get_header(); ?>
<div class="container">
	<div class="row">
		<?php if ( is_active_sidebar( 'page-sidebar' ) ) { ?>
		<div class="col-sm-8">
			<?php } else { ?>
			<div class="col-sm-8 col-sm-offset-2">
				<?php } ?>
			<section id="blog">
				<?php
				if( have_posts() ):
					while( have_posts() ):
						the_post();
						get_template_part( 'template-parts/content', 'page' );
					endwhile;
				endif;
				?>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
		<?php if ( is_active_sidebar( 'page-sidebar' ) ) { ?>
			<div class="col-sm-4">
				<div id="sidebar">
					<?php dynamic_sidebar( 'page-sidebar' ); ?>
				</div>
			</div>
		<?php } ?>
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>