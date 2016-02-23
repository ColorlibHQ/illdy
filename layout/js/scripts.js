/**
 *	jQuery Document Ready
 */
jQuery( document ).ready( function($) {
	// If is IOS
	function isIsIOS() {
		$.browser.device = (/iphone|ipad|ipod/i.test(navigator.userAgent.toLowerCase()));
		if( $.browser.device == true ) {
			$( '#counter' ).css( 'background-attachment', 'scroll' );
			$( '#testimonials' ).css( 'background-attachment', 'scroll' );
		}
	}

	// Smooth Scroll Anchors
	function smoothScrollAnchors() {
		$('a[href*=#]:not([href=#])').on('click', function() {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});
	}

	// Open Responsive Menu
	function openResponsiveMenu() {
		$( '.open-responsive-menu' ).click( function() {
			$( '.responsive-menu' ).toggle( 'slow', function() {
				$( this ).toggleClass( 'active' );
			});
		});
	}

	// Add Height To Front Page
	function addHeightToFrontPageProject() {
		var project = $( '#projects .project' );
		var projectWidth = $( project ).width();

		$( project ).css( 'height', projectWidth );
	}

	// Set Color on Front Page Service
	function setColorOnFrontPageService() {
		if( $( '#services .section-content .service' ).length ) {
			$( '#services .section-content .service' ).each( function() {
				var service = $( this );
				var serviceIcon = $( service ).children( '.service-icon' );
				var serviceTitle = $( service ).children( '.service-title' );
				var dataServiceColor = $( service ).data( 'service-color' );

				$( serviceIcon ).css( 'color', dataServiceColor );
				$( serviceTitle ).css( 'color', dataServiceColor );
			});
		}
	}

	// Set Color on Front Page Service
	function setColorOnFrontPagePerson() {
		if( $( '#team .section-content .person' ).length ) {
			$( '#team .section-content .person' ).each( function() {
				var person = $( this );
				var dataPersonColor = $( person ).data( 'person-color' );
				var personPosition = $( person ).children( '.person-content' ).children( 'h5' );
				var personContentSocial = $( person ).children( '.person-content' ).children( '.person-content-social.clearfix' ).children( 'li' ).children( 'a' );

				$( personPosition ).css( 'color', dataPersonColor );
				$( personContentSocial ).css( 'background-color', dataPersonColor );
			});
		}
	}

	// Sub Menu
	function subMenu() {
		$( '#header .top-header .header-navigation ul li.menu-item-has-children' ).hover( function() {
			$( this ).children( 'ul' ).show( 'fast' );
		}, function() {
			$( this ).children( 'ul' ).hide( 'fast' );
		});
	}

	// Called Functions
	$( function() {
		isIsIOS();
		smoothScrollAnchors();
		openResponsiveMenu();
		addHeightToFrontPageProject();
		setColorOnFrontPageService();
		setColorOnFrontPagePerson();
		subMenu();
	});

	// Window Resize
	$( window ).resize( function() {
		// Called Functions
		$( function() {
			addHeightToFrontPageProject();
		});
	});
});