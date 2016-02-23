<?php
/**
 *	Template part for displaying a message that posts cannot be found.
 *
 *	@package WordPress
 *	@subpackage illdy
 */
?>
<article <?php post_class( 'blog-post' ); ?>>
	<a href="<?php echo esc_url( home_url() ); ?>" title="<?php _e( 'Nothing Found', 'illdy' ); ?>" class="blog-post-title"><?php _e( 'Nothing Found', 'illdy' ); ?></a>
	<div class="blog-post-entry">
		<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'illdy' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	</div><!--/.blog-post-entry-->
</article><!--/#post-<?php the_ID(); ?>.blog-post-->