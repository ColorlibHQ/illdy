<?php

$slides = get_theme_mod( 'illdy_jumbotron_slides', false );

if ( ! $slides ) {
	return;
}

$autoplay      = get_theme_mod( 'illdy_jumbotron_slider_autoplay', true );
$navigation    = get_theme_mod( 'illdy_jumbotron_slider_nav', true );
$autoplay_time = get_theme_mod( 'illdy_jumbotron_slider_autoplay_time', 5000 );

?>
<div class="illdy-slider illdy-jumbotron-background owl-carousel" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-autoplay-time="<?php echo esc_attr( $autoplay_time ); ?>">
	<?php

	foreach ( (array) $slides as $slide ) {
		// Repeater rows are arrays; guard in case an older value stored objects.
		$slide = (array) $slide;

		if ( ! empty( $slide['slide_image'] ) ) {
			printf(
				'<div class="illdy-slide" style="background-image:url(%1$s)"><img src="%1$s" alt="" style="display:none"></div>',
				esc_url( $slide['slide_image'] )
			);
		}
	}

	?>
</div>
<?php if ( $navigation ) { ?>
	<div class="illdy-slider-navigation">
		<a href="#" id="prev" class="illdy-navigation-button">
			<i class="fa-solid fa-angle-left" aria-hidden="true"></i>
		</a>
		<a href="#" id="next" class="illdy-navigation-button">
			<i class="fa-solid fa-angle-right" aria-hidden="true"></i>
		</a>
	</div>
<?php } ?>
