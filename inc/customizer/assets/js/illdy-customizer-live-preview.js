/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	/* Company text logo */
	wp.customize( 'illdy_text_logo', function( value ) {
		value.bind( function( newval ) {
			if( wp.customize._value.illdy_img_logo() == '' ) {
				$( '#header .top-header .header-logo' ).html( newval );
			}
		} );
	} );

	/* Company image logo */
	wp.customize( 'illdy_img_logo', function( value ) {
		value.bind( function( newval ) {
			if( newval !== '' ) {
				$( '#header .top-header .header-logo' ).empty();
				$( '#header .top-header .header-logo' ).prepend( '<img src="" alt="'+ wp.customize._value.illdy_text_logo +'" title="'+ wp.customize._value.illdy_text_logo +'" />' );
				$( '#header .top-header .header-logo img' ).attr( 'src', newval );
			} else {
				$( '#header .top-header .header-logo' ).text( wp.customize._value.illdy_text_logo() );
			}
		} );
	} );

	/* Facebook URL */
	wp.customize( 'illdy_contact_bar_facebook_url', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-social a[title="Facebook"]' ).attr( 'href', newval );
		} );
	} );

	/* Twitter URL */
	wp.customize( 'illdy_contact_bar_twitter_url', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-social a[title="Twitter"]' ).attr( 'href', newval );
		} );
	} );

	/* LinkedIn URL */
	wp.customize( 'illdy_contact_bar_linkedin_url', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-social a[title="LinkedIn"]' ).attr( 'href', newval );
		} );
	} );

	/* email */
	wp.customize( 'illdy_email', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-right span a' ).attr( 'href', 'mailto: ' + newval );
			$( '#contact-us .section-content .contact-us-box .box-right span a' ).attr( 'title', newval );
			$( '#contact-us .section-content .contact-us-box .box-right span a' ).text( newval );
		} );
	} );

	/* phone number */
	wp.customize( 'illdy_phone', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-right span[data-customizer="contact-us-phone"]' ).attr( 'href', 'tel:' + newval );
			$( '#contact-us .section-content .contact-us-box .box-right span[data-customizer="contact-us-phone"]' ).attr( 'title', newval );
			$( '#contact-us .section-content .contact-us-box .box-right span[data-customizer="contact-us-phone"]' ).text( 'Phone: ' + newval );
		} );
	} );

	// Address 1
	wp.customize( 'illdy_address1', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-right span[data-customizer="contact-us-address-1"]' ).html( newval );
		} );
	} );

	// Address 1
	wp.customize( 'illdy_address2', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-right span[data-customizer="contact-us-address-2"]' ).html( newval );
		} );
	} );

	/* Footer Image Logo */
	wp.customize( 'illdy_img_footer_logo', function( value ) {
		value.bind( function( newval ) {
			if( newval !== '' ) {
				$( '#footer .footer-logo img' ).removeClass( 'customizer-display-none' );
			} else {
				$( '#footer .footer-logo img' ).addClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Footer Copyright */
	wp.customize( 'illdy_footer_copyright', function( value ) {
		value.bind( function( newval ) {
			$( '#footer .bottom-copyright' ).html( newval );
		} );
	} );

	// Display theme copyright in the footer?
	wp.customize( 'illdy_general_footer_display_copyright', function( value ) {
		value.bind( function( newval ) {
			if( newval == true ) {
				$( '#footer .copyright span[data-customizer="copyright-credit"]' ).removeClass( 'customizer-display-none' );
			} else if( newval == false ) {
				$( '#footer .copyright span[data-customizer="copyright-credit"]' ).addClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Posted on on single blog posts */
	wp.customize( 'illdy_enable_post_posted_on_blog_posts', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .blog-post-meta' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .blog-post-meta' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Post Tags on single blog posts */
	wp.customize( 'illdy_enable_post_tags_blog_posts', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .blog-post-tags' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .blog-post-tags' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Post Comments on single blog posts */
	wp.customize( 'illdy_enable_post_comments_blog_posts', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .blog-post-meta .post-meta-comments' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .blog-post-meta .post-meta-comments' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );


	/* Author Info Box on single blog posts */
	wp.customize( 'illdy_enable_author_box_blog_posts', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .blog-post-author' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .blog-post-author' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Facebook visibility */
	wp.customize( 'illdy_facebook_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="facebook"]' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="facebook"]' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Twitter visibility */
	wp.customize( 'illdy_twitter_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="twitter"]' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="twitter"]' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* LinkedIN visibility */
	wp.customize( 'illdy_linkein_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="linkedin"]' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( 'body.single #blog .blog-post .social-links-list li[data-customizer="linkedin"]' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Current header */
	wp.customize( 'header_image', function( value ) {
		value.bind( function( newval ) {
			if( newval == 'remove-header' ) {
				$( '#header.header-blog' ).removeAttr( 'style' );
			} else if( newval == 'random-uploaded-image' ) {
				// $( '#header.header-blog' ).removeAttr( 'style' );
			} else if( newval == 'random-default-image' ) {
				// $( '#header.header-blog' ).removeAttr( 'style' );
			} else {
				$( '#header.header-blog' ).css( 'background-image', 'url('+ newval +')' );
			}
		} );
	} );

	// Image
	// wp.customize( 'illdy_jumbotron_general_image', function( value ) {
	// 	value.bind( function( newval ) {
	// 		if( newval == '' ) {
	// 			$( '#header.header-front-page' ).removeAttr( 'style' );
	// 		} else {
	// 			$( '#header.header-front-page' ).css( 'background-image', 'url('+ newval +')' );
	// 		}
	// 	} );
	// } );

	// First word from title
	wp.customize( 'illdy_jumbotron_general_first_row_from_title', function( value ) {
		value.bind( function( newval ) {
			if( newval == '' ) {
				$( '#header .bottom-header span.span-dot.first-span-dot' ).addClass( 'customizer-display-none' );
			} else {
				$( '#header .bottom-header span.span-dot.first-span-dot' ).removeClass( 'customizer-display-none' );
			}

			$( '#header .bottom-header h2 span[data-customizer="first-row-from-title"]' ).html( newval );
		} );
	} );

	// Second word from title
	wp.customize( 'illdy_jumbotron_general_second_row_from_title', function( value ) {
		value.bind( function( newval ) {
			if( newval == '' ) {
				$( '#header .bottom-header span.span-dot.second-span-dot' ).addClass( 'customizer-display-none' );
			} else {
				$( '#header .bottom-header span.span-dot.second-span-dot' ).removeClass( 'customizer-display-none' );
			}

			$( '#header .bottom-header h2 span[data-customizer="second-row-from-title"]' ).html( newval );
		} );
	} );

	// Third word from title
	wp.customize( 'illdy_jumbotron_general_third_row_from_title', function( value ) {
		value.bind( function( newval ) {
			$( '#header .bottom-header h2 span[data-customizer="third-row-from-title"]' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_jumbotron_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#header .bottom-header p' ).html( newval );
		} );
	} );

	// First button text
	wp.customize( 'illdy_jumbotron_general_first_button_title', function( value ) {
		value.bind( function( newval ) {
			if ( newval == false ) {
				$( '#header .bottom-header .header-button-one' ).hide();
			}
			if ( newval != '' ) {
				$( '#header .bottom-header .header-button-one' ).show();
			}
			$( '#header .bottom-header .header-button-one' ).html( newval );
		} );
	} );

	// First button URL
	wp.customize( 'illdy_jumbotron_general_first_button_url', function( value ) {
		value.bind( function( newval ) {
			$( '#header .bottom-header .header-button-one' ).attr( 'href', newval );
		} );
	} );

	// Second button text
	wp.customize( 'illdy_jumbotron_general_second_button_title', function( value ) {
		value.bind( function( newval ) {
			if ( newval == false ) {
				$( '#header .bottom-header .header-button-two' ).hide();
			}
			if ( newval != '' ) {
				$( '#header .bottom-header .header-button-two' ).show();
			}
			$( '#header .bottom-header .header-button-two' ).html( newval );
		} );
	} );

	// Second button URL
	wp.customize( 'illdy_jumbotron_general_second_button_url', function( value ) {
		value.bind( function( newval ) {
			$( '#header .bottom-header .header-button-two' ).attr( 'href', newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_about_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#about' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#about' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_about_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#about.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_about_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#about.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_projects_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#projects' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#projects' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_projects_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#projects.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_projects_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#projects.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_testimonials_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#testimonials' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#testimonials' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_testimonials_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#testimonials.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Background Image
	wp.customize( 'illdy_testimonials_general_background_image', function( value ) {
		value.bind( function( newval ) {
			if( newval == '' ) {
				$( '#testimonials' ).removeAttr( 'style' );
			} else {
				$( '#testimonials' ).css( 'background-image', 'url('+ newval +')' );
			}
		} );
	} );

	// Show this section
	wp.customize( 'illdy_services_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#services' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#services' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_services_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#services.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_services_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#services.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_latest_news_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#latest-news' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#latest-news' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_latest_news_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#latest-news.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_latest_news_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#latest-news.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Button Text
	wp.customize( 'illdy_latest_news_button_text', function( value ) {
		value.bind( function( newval ) {
			$( '#latest-news .latest-news-button' ).html( '<i class="fa fa-chevron-circle-right"></i>' + newval );
		} );
	} );

	// Button URL
	wp.customize( 'illdy_latest_news_button_url', function( value ) {
		value.bind( function( newval ) {
			$( '#latest-news .latest-news-button' ).attr( 'href', newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_counter_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#counter' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#counter' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Type of Background
	wp.customize( 'illdy_counter_background_type', function( value ) {
		value.bind( function( newval ) {
			if( newval == 'image' ) {
				$( '#counter' ).css( 'background-image', 'url('+ wp.customize._value.illdy_counter_background_image() +')' );
			} else if( newval == 'color' ) {
				$( '#counter' ).css( 'background-image', '' );
				$( '#counter' ).css( 'background-color', 'color:' + wp.customize._value.illdy_counter_background_color() );
			}
		} );
	} );

	// Image
	wp.customize( 'illdy_counter_background_image', function( value ) {
		value.bind( function( newval ) {
			if( newval == '' ) {
				$( '#counter' ).css( 'background-image', '' );
			} else {
				$( '#counter' ).css( 'background-image', 'url('+ newval +')' );
			}
		} );
	} );

	// Color
	wp.customize( 'illdy_counter_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '#counter' ).css( 'background-color', newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_team_general_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#team' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#team' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_team_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#team.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_team_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#team.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Show this section
	wp.customize( 'illdy_contact_us_show', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#contact-us' ).addClass( 'customizer-display-none' );
			} else if( newval == true ) {
				$( '#contact-us' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Title
	wp.customize( 'illdy_contact_us_general_title', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us.front-page-section .section-header h3' ).html( newval );
		} );
	} );

	// Entry
	wp.customize( 'illdy_contact_us_general_entry', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us.front-page-section .section-header p' ).html( newval );
		} );
	} );

	// Address Title
	wp.customize( 'illdy_contact_us_general_address_title', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-left[data-customizer="box-left-address-title"]' ).html( newval );
		} );
	} );

	// Customer Support Title
	wp.customize( 'illdy_contact_us_general_customer_support_title', function( value ) {
		value.bind( function( newval ) {
			$( '#contact-us .section-content .contact-us-box .box-left[data-customizer="box-left-customer-support-title"]' ).html( newval );
		} );
	} );

	// Color scheme
	wp.customize.bind('preview-ready', function () {
		wp.customize.preview.bind('update-inline-css', function (object) {

			var data = {
				'action': object.action,
				'args'  : object.data,
				'id'    : object.id
			};

			jQuery.ajax({
				dataType: 'json',
				type    : 'POST',
				url     : WPUrls.ajaxurl,
				data    : data,
				complete: function (json) {
					var sufix = object.action + object.id;
					var style = $('#illdy-main-inline-css');

					if ( !style.length ) {
						style = $('head').append('<style type="text/css" id="illdy-main-inline-css" />').find('#illdy-main-inline-css');
					}

					style.html(json.responseText);
				}
			});
		});

		wp.customize.preview.bind('update-section-css', function (object) {
			var illdy_templates = {};
			var template = '#illdy-'+object.illdy_section+'-section';
			var h_t = Handlebars.compile($(template).text());
			var html = h_t(object.values);
			var style = $('#illdy-'+object.illdy_section+'-section-css');
			if ( !style.length ) {
				style = $('head').append('<style type="text/css" id="illdy-'+object.illdy_section+'-section-css" />').find('#illdy-'+object.illdy_section+'-section-css');
			}
			
			style.html(html);
		});

	});

	$(document).ready(function(){
		wp.customize.selectiveRefresh.bind('widget-updated', function (placement) {
			$('.parallax-window').parallax();
		});
	});

} )( jQuery );