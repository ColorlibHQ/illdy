
jQuery( document ).ready( function( $ ) {

  // Each library below is only enqueued on the front page, so feature-detect before
  // calling it. Keeps inner pages error-free when the library is intentionally absent.
  function hasPlugin( name ) {
    return typeof $.fn[ name ] === 'function';
  }

  // Progress Bar
  function illdyProgressBar() {
    if ( ! hasPlugin( 'progressbar' ) ) {
      return;
    }

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
    if ( ! hasPlugin( 'owlCarousel' ) ) {
      return;
    }

    if ( $( '.testimonials-carousel.owl-carousel-enabled .widget_illdy_testimonial' ).length > 1 ) {
      $( '.testimonials-carousel.owl-carousel-enabled' ).owlCarousel( {
        'items': 1,
        'loop': true,
        'dots': true
      } );
    }
  }

  // Counter Number
  var counterStarted = false;

  function counterNumber() {
    if ( counterStarted || ! hasPlugin( 'countTo' ) ) {
      return;
    }

    var counter = $( '#counter' ).find( '.counter-number' );
    if ( counter.length ) {
      // Guarded so the count runs once. It used to restart on every scroll event
      // while the section stayed in view, which visibly reset the number.
      counterStarted = true;
      counter.countTo();
    }
  }

  // Front Page jumbotron Slider
  function illdyJumbotronSlider() {
    if ( ! hasPlugin( 'owlCarousel' ) ) {
      return;
    }

    var illdySlider = $( '.illdy-slider' );
    if ( illdySlider.length > 0 ) {
      illdySlider.owlCarousel( {
        'items': 1,
        'loop': true,
        'dots': false,
        'autoplay': illdySlider.data( 'autoplay' ),
        'autoplayTimeout': illdySlider.data( 'autoplay-time' )
      } );
      if ( $( '.illdy-slider-navigation' ).length > 0 ) {
        $( '.illdy-slider-navigation #prev' ).on( 'click', function( evt ) {
          evt.preventDefault();
          illdySlider.trigger( 'prev.owl.carousel' );
        } );
        $( '.illdy-slider-navigation #next' ).on( 'click', function( evt ) {
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

    if ( ! $( '#counter' ).length || ! hasPlugin( 'visible' ) ) {
      return;
    }

    // Passive + rAF-throttled: the previous handler ran a layout-reading visibility
    // test on every single scroll event.
    var ticking = false;

    function onScroll() {
      if ( ticking ) {
        return;
      }
      ticking = true;
      window.requestAnimationFrame( function() {
        if ( true === $( '#counter' ).visible() ) {
          counterNumber();
          if ( counterStarted ) {
            window.removeEventListener( 'scroll', onScroll );
          }
        }
        ticking = false;
      } );
    }

    window.addEventListener( 'scroll', onScroll, { passive: true } );
    onScroll();
  } );
} );
