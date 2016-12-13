/**
 *	jQuery Document Ready
 */
jQuery( document ).ready( function($) {
	var windowWidth = $( window ).width();
	var windowHeight = $( window ).height();
	var documentWidth = $( document ).width();
	var documentHeight = $( document ).height();

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
		$('a[href*="#"]:not([href="#"])').on('click', function() {
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
			$( this ).children( 'ul' ).css( 'visibility', 'visible' ).fadeIn();
		}, function() {
			$( this ).children( 'ul' ).css( 'visibility', 'hidden' ).fadeOut();
		});
	}

	// Align Sub Sub Menu
	function alignSubSubMenu() {
		if( $( '#header .top-header .header-navigation ul li.menu-item-has-children' ).length ) {
			var subSubMenu = $( '#header .top-header .header-navigation ul li.menu-item-has-children ul' );

			$( subSubMenu ).each( function() {
				if( ( windowWidth - $( this ).offset()['left'] ) < 250 ) {
					$( this ).css( 'left', '-250px' );
				}
			});
		}
	}

	// WooCommerce Tabs
	function woocommerceTabs() {
		var descriptionTab = $( 'li.description_tab' );
		var descriptionTabLink = $( 'li.description_tab a' );
		var reviewsTab = $( 'li.reviews_tab' );
		var reviewsTabLink = $( 'li.reviews_tab a' );
		var panelDescription = $( '.panel#tab-description' );
		var panelReviews = $( '.panel#tab-reviews' );

		$( descriptionTabLink ).click( function() {
			$( this ).parent().addClass( 'active' );
			$( reviewsTab ).removeClass( 'active' );
			$( panelDescription ).show();
			$( panelReviews ).hide();
		});

		$( reviewsTabLink ).click( function() {
			$( this ).parent().addClass( 'active' );
			$( descriptionTab ).removeClass( 'active' );
			$( panelReviews ).show();
			$( panelDescription ).hide();
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
		alignSubSubMenu();
		woocommerceTabs();
	});

	// Window Resize
	$( window ).resize( function() {
		// Called Functions
		$( function() {
			addHeightToFrontPageProject();
		});
	});
});