jQuery( document ).ready( function( $ ) {
  var windowWidth = $( window ).width();
  var windowHeight = $( window ).height();
  var documentWidth = $( document ).width();
  var documentHeight = $( document ).height();

  // If is IOS
  function isIsIOS() {
    $.browser.device = ( /iphone|ipad|ipod/i.test( navigator.userAgent.toLowerCase() ) );
    if ( true === $.browser.device ) {
      $( '#counter' ).css( 'background-attachment', 'scroll' );
      $( '#testimonials' ).css( 'background-attachment', 'scroll' );
    }
  }

  // Smooth Scroll Anchors
  function smoothScrollAnchors() {
    $( 'body:not(.single-product) a[href*="#"]:not([href="#"])' ).on( 'click', function() {
      var target;
      if ( location.pathname.replace( /^\//, '' ) === this.pathname.replace( /^\//, '' ) && location.hostname === this.hostname ) {
        target = $( this.hash );
        target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
        if ( target.length ) {
          $( 'html,body' ).animate( {
            scrollTop: target.offset().top - $( '#sticky-wrapper' ).outerHeight( true )
          }, 1000 );
          return false;
        }
      }
    } );
  }

  // Open Responsive Menu
  function openResponsiveMenu() {
    $( '.open-responsive-menu' ).click( function() {
      var top = $( '.top-header' ).outerHeight(),
          height = $( window ).height() - top;

      if ( $( '#header' ).hasClass( 'header-has-sticky-menu' ) ) {
        $( '.responsive-menu' ).css( { 'top': top, 'max-height': height } );
      }

      $( '.responsive-menu' ).toggle( 'slow', function() {
        $( this ).toggleClass( 'active' );
      } );
    } );
  }

  // Add Height To Front Page
  function addHeightToFrontPageProject() {
    var project = $( '#projects .project' );
    var projectWidth = $( project ).width();

    $( project ).css( 'height', projectWidth );
  }

  // Set Color on Front Page Service
  function setColorOnFrontPageService() {
    if ( $( '#services .section-content .service' ).length ) {
      $( '#services .section-content .service' ).each( function() {
        var service = $( this );
        var serviceIcon = $( service ).children( '.service-icon' );
        var serviceTitle = $( service ).children( '.service-title' );
        var dataServiceColor = $( service ).data( 'service-color' );

        $( serviceIcon ).css( 'color', dataServiceColor );
        $( serviceTitle ).css( 'color', dataServiceColor );
      } );
    }
  }

  // Set Color on Front Page Service
  function setColorOnFrontPagePerson() {
    if ( $( '#team .section-content .person' ).length ) {
      $( '#team .section-content .person' ).each( function() {
        var person = $( this );
        var dataPersonColor = $( person ).data( 'person-color' );
        var personPosition = $( person ).children( '.person-content' ).children( '.person-position' );
        var personContentSocial = $( person ).children( '.person-content' ).children( '.person-content-social.clearfix' ).children( 'li' ).children( 'a' );

        $( personPosition ).css( 'color', dataPersonColor );
        $( personContentSocial ).css( { 'border-color': dataPersonColor, 'color': dataPersonColor } );
      } );
    }
  }

  // Align Sub Sub Menu
  function alignSubSubMenu() {
    var subSubMenu;
    if ( $( '#header .top-header .header-navigation ul li.menu-item-has-children' ).length ) {
      subSubMenu = $( '#header .top-header .header-navigation ul li.menu-item-has-children ul' );

      $( subSubMenu ).each( function() {
        if ( ( windowWidth - $( this ).offset().left ) < 200 ) {
          $( this ).css( 'left', '-200px' );
        }
      } );
    }
  }

  // Scroll To Top
  function scrollToTop() {
    var item = $( '.illdy-top' );
    if ( item.length > 0 ) {
      item.click( function( event ) {
        event.preventDefault();
        $( 'html,body' ).animate( {
          scrollTop: 0
        }, 1000 );
      } );

      $( document ).scroll( function() {
        var y = window.scrollY;
        if ( y >= 300 ) {
          item.addClass( 'is-active' );
        } else {
          item.removeClass( 'is-active' );
        }
      } );

    }
  }

  // Called Functions
  $( function() {
    isIsIOS();
    smoothScrollAnchors();
    openResponsiveMenu();
    addHeightToFrontPageProject();
    setColorOnFrontPageService();
    setColorOnFrontPagePerson();
    alignSubSubMenu();
    scrollToTop();
  } );

  // Window Resize
  $( window ).resize( function() {

    // Called Functions
    $( function() {
      addHeightToFrontPageProject();
    } );
  } );
} );
