<?php
/**
 *  Template name: Left Sidebar
 *
 *  The template for displaying Custom Page Template: Left Sidebar.
 *
 *  @package WordPress
 *  @subpackage illdy
 */
?>
<?php get_header(); ?>
<div class="container">
	<div class="row">
		<?php get_sidebar(); ?>
		<div class="col-sm-7">
			<section id="blog">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'page' );
					endwhile;
				endif;
				?>
			</section><!--/#blog-->
		</div><!--/.col-sm-7-->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>
