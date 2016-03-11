/**
 *	jQuery Document Ready
 */
jQuery( document ).ready( function($) {
	// Progress Bar
	function illdyProgressBar() {
		if( $( '#about .skill' ).length ) {
				$( '#about .skill' ).each( function() {
				var skill = $( this );
				var skillProgressBar = $( skill ).children( '.skill-top' ).children( '.skill-progress-bar' );
				var dataSkillProgressBarWidth = $( skill ).data( 'skill-progress-bar-width' );
				var dataSkillColor = $( skill ).data( 'skill-color' );
				var skillBottom = $( skill ).children( '.skill-bottom' );

				$( skillProgressBar ).progressbar({
					value: dataSkillProgressBarWidth
				});

				$( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).css( 'background-color', dataSkillColor );
				$( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).append( '<span class="ui-progressbar-value-circle" style="background-color: '+ dataSkillColor +'"></span>' );
				$( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).append( '<span class="ui-progressbar-value-top" style="background-color: '+ dataSkillColor +'"></span>' );
				$( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).children( '.ui-progressbar-value-top' ).text( dataSkillProgressBarWidth + '%' );
				$( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).children( '.ui-progressbar-value-top' ).append( '<span class="ui-progressbar-value-triangle" style="border-top-color: '+ dataSkillColor +'; border-right-color: transparent; border-bottom-color: transparent; border-left-color: transparent;"></span>' );
				$( this ).children( '.skill-bottom' ).css( 'color', dataSkillColor );
			});
		}
	}

	// Testimonials OWL Carousel
	function testimonialsOwlCarousel() {
		if( $( '.testimonials-carousel.owl-carousel-enabled' ).length ) {
			$( '.testimonials-carousel.owl-carousel-enabled' ).owlCarousel({
				'items': 1,
				'loop': true,
				'dots': true
			});
		}
	}

	// Counter Number
	function counterNumber() {
		if( $( '#counter .counter-number' ).length ) {
			$( '#counter .counter-number' ).countTo();
		}
	}

	// Called Functions
	$( function() {
		illdyProgressBar();
		testimonialsOwlCarousel();

		$( window ).scroll( function() {
			var counterVisible = $( '#counter' ).visible();

			if( counterVisible == true ) {
				counterNumber();
			}
		});
	});
});