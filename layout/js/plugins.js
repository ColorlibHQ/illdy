
jQuery( document ).ready( function( $ ) {

  // Progress Bar
  function illdyProgressBar() {
    if ( $( '#about .skill' ).length ) {
      $( '#about .skill' ).each( function() {
        var skill = $( this );
        var skillProgressBar = $( skill ).children( '.skill-top' ).children( '.skill-progress-bar' );
        var dataSkillProgressBarWidth = $( skill ).data( 'skill-progress-bar-width' );
        var dataSkillColor = $( skill ).data( 'skill-color' );

        $( skillProgressBar ).progressbar( {
          value: dataSkillProgressBarWidth
        } );

        $( this ).children( '.skill-top' ).children( '.skill-progress-bar' ).children( '.ui-progressbar-value' ).css( 'background-color', dataSkillColor );
        $( this ).
            children( '.skill-top' ).
            children( '.skill-progress-bar' ).
            children( '.ui-progressbar-value' ).
            append( '<span class="ui-progressbar-value-circle" style="background-color: ' + dataSkillColor + '"></span>' );
        $( this ).
            children( '.skill-top' ).
            children( '.skill-progress-bar' ).
            children( '.ui-progressbar-value' ).
            append( '<span class="ui-progressbar-value-top" style="background-color: ' + dataSkillColor + '"></span>' );
        $( this ).
            children( '.skill-top' ).
            children( '.skill-progress-bar' ).
            children( '.ui-progressbar-value' ).
            children( '.ui-progressbar-value-top' ).
            text( dataSkillProgressBarWidth + '%' );
        $( this ).
            children( '.skill-top' ).
            children( '.skill-progress-bar' ).
            children( '.ui-progressbar-value' ).
            children( '.ui-progressbar-value-top' ).
            append( '<span class="ui-progressbar-value-triangle" style="border-top-color: ' + dataSkillColor +
                '; border-right-color: transparent; border-bottom-color: transparent; border-left-color: transparent;"></span>' );
        $( this ).children( '.skill-bottom' ).css( 'color', dataSkillColor );
      } );
    }
  }

  // Testimonials OWL Carousel
  function testimonialsOwlCarousel() {
    if ( $( '.testimonials-carousel.owl-carousel-enabled .widget_illdy_testimonial' ).length > 1 ) {
      $( '.testimonials-carousel.owl-carousel-enabled' ).owlCarousel( {
        'items': 1,
        'loop': true,
        'dots': true
      } );
    }
  }

  // Counter Number
  function counterNumber() {
    var counter = $( '#counter' ).find( '.counter-number' );
    if ( counter.length ) {
      counter.countTo();
    }
  }

  // Front Page jumbotron Slider
  function illdyJumbotronSlider() {
    var illdySlider = jQuery( '.illdy-slider' );
    if ( illdySlider.length > 0 ) {
      illdySlider.owlCarousel( {
        'items': 1,
        'loop': true,
        'dots': false,
        'autoplay': illdySlider.data( 'autoplay' ),
        'autoplayTimeout': illdySlider.data( 'autoplay-time' )
      } );
      if ( jQuery( '.illdy-slider-navigation' ).length > 0 ) {
        jQuery( '.illdy-slider-navigation #prev' ).click( function( evt ) {
          evt.preventDefault();
          illdySlider.trigger( 'prev.owl.carousel' );
        } );
        jQuery( '.illdy-slider-navigation #next' ).click( function( evt ) {
          evt.preventDefault();
          illdySlider.trigger( 'next.owl.carousel' );
        } );
      }
    }

  }

  // Called Functions
  $( function() {
    illdyProgressBar();
    testimonialsOwlCarousel();
    illdyJumbotronSlider();

    $( window ).scroll( function() {
      var counterVisible = $( '#counter' ).visible();

      if ( true === counterVisible ) {
        counterNumber();
      }
    } );
  } );
} );
