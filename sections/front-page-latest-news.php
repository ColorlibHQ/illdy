<?php
/**
 *    The template for displaying the latest news section in front page.
 *
 * @package    WordPress
 * @subpackage illdy
 */
?>
<?php

$blog_page_id = get_option( 'page_for_posts' );
$button_url   = '#';
if ( $blog_page_id ) {
	$button_url = get_permalink( $blog_page_id );
}
if ( current_user_can( 'edit_theme_options' ) ) {
	$general_title   = get_theme_mod( 'illdy_latest_news_general_title', __( 'Latest News', 'illdy' ) );
	$general_entry   = get_theme_mod( 'illdy_latest_news_general_entry', __( 'If you are interested in the latest articles in the industry, take a sneak peek at our blog. You have got nothing to loose!', 'illdy' ) );
	$button_text     = get_theme_mod( 'illdy_latest_news_button_text', __( 'See blog', 'illdy' ) );
	$number_of_posts = get_theme_mod( 'illdy_latest_news_number_of_posts', absint( 3 ) );
} else {
	$general_title   = get_theme_mod( 'illdy_latest_news_general_title' );
	$general_entry   = get_theme_mod( 'illdy_latest_news_general_entry' );
	$button_text     = get_theme_mod( 'illdy_latest_news_button_text' );
	$number_of_posts = get_theme_mod( 'illdy_latest_news_number_of_posts', absint( 3 ) );
}

$number_of_words = get_theme_mod( 'illdy_latest_news_words_number', absint( 20 ));

$post_query_args = array(
	'post_type'              => array( 'post' ),
	'nopaging'               => false,
	'posts_per_page'         => absint( $number_of_posts ),
	'ignore_sticky_posts'    => true,
	'cache_results'          => true,
	'update_post_meta_cache' => true,
	'update_post_term_cache' => true,
);

$post_query = new WP_Query( $post_query_args );

if ( $post_query->have_posts() || $general_title != '' || $general_entry != '' || $button_text != '' ) {

	?>

	<section id="latest-news" class="front-page-section">
		<div class="section-header">
			<div class="container">
				<div class="row">
					<?php if ( $general_title ): ?>
						<div class="col-sm-12">
							<h3><?php echo do_shortcode(wp_kses_post( $general_title )); ?></h3>
						</div><!--/.col-sm-12-->
					<?php endif; ?>
					<?php if ( $general_entry ): ?>
						<div class="col-sm-10 col-sm-offset-1">
							<div class="section-description"><?php echo do_shortcode(wp_kses_post( $general_entry )); ?></div>
						</div><!--/.col-sm-10.col-sm-offset-1-->
					<?php endif; ?>
				</div><!--/.row-->
			</div><!--/.container-->
		</div><!--/.section-header-->
		<?php if ( $button_text ): ?>
			<a href="<?php echo esc_url( $button_url ); ?>" title="<?php echo esc_attr( $button_text ); ?>" class="latest-news-button"><i class="fa fa-chevron-circle-right"></i><?php echo esc_html( $button_text ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $post_query->have_posts() ): ?>
			<div class="section-content">
				<div class="container">
					<div class="row blog-carousel">
						<?php $counter = 0; ?>
						<?php while ( $post_query->have_posts() ): ?>
							<?php $post_query->the_post(); ?>
							<?php $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'illdy-front-page-latest-news' ); ?>

							<div class="illdy-blog-post col-md-4 col-sm-6 col-xs-12">
								<div class="post" style="<?php if ( ! $post_thumbnail && !get_theme_mod( 'illdy_disable_random_featured_image' ) ): echo 'padding-top: 40px;'; endif; ?>">
									<?php if ( has_post_thumbnail() ){ ?>
										<div class="post-image" style="background-image: url('<?php echo esc_url( $post_thumbnail[0] ); ?>');"></div>
									<?php }elseif ( get_theme_mod( 'illdy_disable_random_featured_image' ) ) { ?>
										<div class="post-image"  style="background-image: url('<?php echo illdy_get_random_featured_image(); ?>');"></div><!--/.blog-post-image-->
									<?php } ?>
									<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-title"><?php the_title(); ?></a></h5>
									<div class="post-entry">
										<?php echo wp_trim_words( get_the_content(), $number_of_words ); ?>
									</div><!--/.post-entry-->
									<a href="<?php the_permalink(); ?>" title="<?php _e( 'Read more', 'illdy' ); ?>" class="post-button"><i class="fa fa-chevron-circle-right"></i><?php _e( 'Read more', 'illdy' ); ?>
									</a>
								</div><!--/.post-->
							</div><!--/.col-sm-4-->
							<?php $counter ++; ?>
						<?php endwhile; ?>
					</div><!--/.row-->
				</div><!--/.container-->
			</div><!--/.section-content-->
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</section><!--/#latest-news.front-page-section-->

<?php } ?>