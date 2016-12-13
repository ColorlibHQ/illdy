<?php
/**
 *    The template for dispalying the bottom header section in blog.
 *
 * @package    WordPress
 * @subpackage illdy
 *             * @TODO: https://developer.wordpress.org/reference/functions/get_the_archive_title/
 */
?>
<div class="bottom-header blog">
	<div class="container">
		<div class="row">
			<?php if ( is_page_template( 'page-templates/blog.php' ) || is_singular() ): ?>
				<div class="col-sm-12">
					<h2><?php the_title(); ?><span class="span-dot">.</span></h2>
				</div><!--/.col-sm-12-->
			<?php else: ?>
				<div class="col-sm-12">
					<?php

					$current_site_title        = get_bloginfo( 'name' );
					$custom_blog_archive_title = get_theme_mod( 'illdy_custom_blog_archive_title', __( 'Blog', 'illdy' ) );

					// check if the current page being displayed is the same one set in Settings -> Reading as the blog page.
					// Only for this page we're employing some custom logic to display a custom title.
					// 1. Custom Page title
					// 2. the_archive_title used as fallback


					if ( ! empty( $custom_blog_archive_title ) ) {
						echo '<h2>' . esc_html( $custom_blog_archive_title ) . '<span class="span-dot">.</span></h2>';
					} else {
						the_archive_title( '<h2>', '<span class="span-dot">.</span></h2>' );
					}

					?>
				</div><!--/.col-sm-12-->
				<div class="col-sm-8 col-sm-offset-2">
					<?php echo '<p>' . get_bloginfo( 'description' ) . '</p>'; ?>
					<?php the_archive_description( '<p>', '</p>' ); ?>
				</div><!--/.col-sm-8.col-sm-offset-2-->
			<?php endif; ?>
		</div><!--/.row-->
	</div><!--/.container-->
</div><!--/.bottom-header.blog-->