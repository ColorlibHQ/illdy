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
			<?php if ( is_404() ) { ?>
				<h1><?php _e( 'Page not found', 'illdy' ) ?></h1>			 
			<?php }elseif ( is_page_template( 'page-templates/blog.php' ) || is_singular() ){ ?>
				<div class="col-sm-12">
					<?php

						$title = get_the_title();
						echo '<h1>' . esc_html( $title ) . '</h1>';

					?>
				</div><!--/.col-sm-12-->
			<?php }elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$title = get_the_title(woocommerce_get_page_id( 'shop' ));
				echo '<h1>' . esc_html( $title ) . '</h1>';
			}else{ ?>
				<div class="col-sm-12">
					<?php

					$custom_blog_archive_title        = get_bloginfo( 'name' );

					// check if the current page being displayed is the same one set in Settings -> Reading as the blog page.
					// Only for this page we're employing some custom logic to display a custom title.
					// 1. Custom Page title
					// 2. the_archive_title used as fallback


					if ( ! empty( $custom_blog_archive_title ) && is_home() ) {
						echo '<h2>' . esc_html( $custom_blog_archive_title ) . '</h2>';
					} else {
						$archive_title = get_the_archive_title();
						echo '<h2>' . esc_html( $archive_title ) . '</h2>';
					}

					?>
				</div><!--/.col-sm-12-->
				<div class="col-sm-8 col-sm-offset-2">
					<?php if ( is_home() ){ ?>
						<?php echo '<p>' . get_bloginfo( 'description' ) . '</p>'; ?>
					<?php }else{ ?>
						<?php the_archive_description( '<p>', '</p>' ); ?>
					<?php } ?>
				</div><!--/.col-sm-8.col-sm-offset-2-->
			<?php } ?>
		</div><!--/.row-->
	</div><!--/.container-->
</div><!--/.bottom-header.blog-->