/**
 * File customizer.js.
 *
 */

//  jQuery(document).on( 'wp-plugin-update-success', function( evt, response ){
//     location.reload();
// });

( function( api ) {
    var sections = [ 'illdy_jumbotron_general', 'illdy_panel_about', 'illdy_panel_projects', 'illdy_testimonials_general', 'illdy_panel_services', 'illdy_latest_news_general', 'illdy_counter_general', 'illdy_panel_team', 'illdy_contact_us', 'illdy_full_width' ];

    // Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
    jQuery.each( sections, function ( index, section ){
        api.section( section, function( section ) {
            section.expanded.bind( function( isExpanding ) {

                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                api.previewer.send( 'section-highlight', { expanded: isExpanding, section: section.id });
            } );
        } );
    });
    

} )( wp.customize );

jQuery( document ).ready( function( $ ) {

 	function illdy_sections_order( container ){
 		var sections = $('#sub-accordion-panel-illdy_frontpage_panel').sortable('toArray');
 		var s_ordered = [];
 		$.each(sections, function( index, s_id ) {
 			s_id = s_id.replace( "accordion-section-", "");
 			s_ordered.push(s_id);
		});

 		$.ajax({
			url: IlldyCustomizer.ajax_url,
			type: 'post',
			dataType: 'html',
			data: {
				'action': 'illdy_order_sections',
				'sections': s_ordered,
			}
		})
		.done( function( data ) {
			wp.customize.previewer.refresh();
		});
 	}

 	$('.recomended-actions_container').on( 'actions_complete', function( evt,  element ){
 		if ( $(element).next( '.epsilon-recommeded-actions-container' ).length > 0 ) {
 			var nex_actions = $(element).next( '.epsilon-recommeded-actions-container' );
 			var next_index = nex_actions.data('index');
 			$('.control-section-illdy-recomended-section .illdy-actions-count .current-index').text( next_index );
 			$(element).remove();
 		}else{
 			$(element).remove();
 			$('.control-section-illdy-recomended-section .illdy-actions-count').remove();
 			$('.control-section-illdy-recomended-section .accordion-section-title .section-title').text( $('.control-section-illdy-recomended-section .accordion-section-title .section-title').data('succes') )
 			$('.recomended-actions_container .succes').show();
 		}

 	});

	

	$('#sub-accordion-panel-illdy_frontpage_panel').sortable({
		helper: 'clone',
		items: '> li.control-section:not(#accordion-section-illdy_jumbotron_general)',
		cancel: 'li.ui-sortable-handle.open',
		delay: 150,
		update: function( event, ui ) {

			illdy_sections_order( $('#sub-accordion-panel-illdy_frontpage_panel') );

		},

	});

});

(function ($) {
	jQuery(document).ready(function ($) {

		/**
		 * Bind an event for the add new widget
		 */
		$('.add-new-widget').on('click', function (event) {
			/**
			 * Define variables used in the script
			 * @type {any}
			 */
			var parent = $(this).parent(),
					id = parent.attr('id'),
					search = $('#widgets-search'),
					widgetList = $('#available-widgets-list').find('.widget-tpl');

			/**
			 * Reset the widget display state
			 */
			$.each(widgetList, function ($k, $v) {
				$(this).show();
			});

			/**
			 * Initiate a switch for the sidebars
			 */
			switch ( id ) {
					/**
					 * When we're in the homepage sections, show only specific widgets
					 */
				case 'customize-control-sidebars_widgets-front-page-about-sidebar':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_skill') == -1 ) {
							$(this).hide();
							search.attr('disabled', true);
						}
					});
					break;
				case 'customize-control-sidebars_widgets-front-page-projects-sidebar':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_project') == -1 ) {
							$(this).hide();
							search.attr('disabled', true);
						}
					});
					break;
				case 'customize-control-sidebars_widgets-front-page-services-sidebar':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_service') == -1 ) {
							$(this).hide();
							search.attr('disabled', true);
						}
					});
					break;
				case 'customize-control-sidebars_widgets-front-page-counter-sidebar':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_counter') == -1 ) {
							$(this).hide();
							search.attr('disabled', true);
						}
					});
					break;
				case 'customize-control-sidebars_widgets-front-page-team-sidebar':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_person') == -1 ) {
							$(this).hide();
							search.attr('disabled', true);
						}
					});
					break;
					/**
					 * By default, hide those 2 specific widgets
					 */
				default:
					$.each(widgetList, function ($k, $v) {
						search.removeAttr('disabled');
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('illdy_person') != -1 || individualId.search('illdy_counter') != -1 || individualId.search('illdy_service') != -1 || individualId.search('illdy_skill') != -1 || individualId.search('illdy_project') != -1 || individualId.search('illdy_recent_posts') != -1 ) {
							$(this).hide();
						} else {
							$(this).show();
						}
					});
					break;
			}
		});

		

	});

    // Sections css
    var sections = {

        'jumbotron' : [ 
            'illdy_jumbotron_general_image', 
            'illdy_jumbotron_general_color', 
            'illdy_jumbotron_first_button_background', 
            'illdy_jumbotron_second_button_background',
            'illdy_jumbotron_second_button_background_hover',
            'illdy_jumbotron_title_color',
            'illdy_jumbotron_points_color',
            'illdy_jumbotron_descriptions_color',
            'illdy_jumbotron_first_button_color',
            'illdy_jumbotron_right_button_color',
            'illdy_jumbotron_background_size',
            'illdy_jumbotron_background_repeat',
            'illdy_jumbotron_background_attachment',
            'illdy_jumbotron_background_position_y',
            'illdy_jumbotron_background_position_x'
            ],
        'latestnews' : [
            'illdy_latest_news_title_color',
            'illdy_latest_news_descriptions_color',
            'illdy_latest_news_general_color',
            'illdy_latest_news_button_background',
            'illdy_latest_news_button_background_hover',
            'illdy_latest_news_button_color',
            'illdy_latest_news_post_bakground_color',
            'illdy_latest_news_post_text_color',
            'illdy_latest_news_post_text_hover_color',
            'illdy_latest_news_post_content_color',
            'illdy_latest_news_post_button_color',
            'illdy_latest_news_post_button_hover_color',
            'illdy_latest_news_general_image',
            'illdy_latest_news_background_size',
            'illdy_latest_news_background_repeat',
            'illdy_latest_news_background_attachment',
            'illdy_latest_news_background_position_y',
            'illdy_latest_news_background_position_x'
        ],
        'fullwidth' : [
            'illdy_full_width_title_color',
            'illdy_full_width_descriptions_color',
            'illdy_full_width_general_color',
            'illdy_full_width_full_text',
            'illdy_full_width_general_image',
            'illdy_full_width_background_size',
            'illdy_full_width_background_repeat',
            'illdy_full_width_background_attachment',
            'illdy_full_width_background_position_y',
            'illdy_full_width_background_position_x'
        ],
        'about' : [
            'illdy_about_title_color',
            'illdy_about_descriptions_color',
            'illdy_about_general_color',
            'illdy_about_general_image',
            'illdy_about_background_size',
            'illdy_about_background_repeat',
            'illdy_about_background_attachment',
            'illdy_about_background_position_y',
            'illdy_about_background_position_x'
        ],
        'projects' : [
            'illdy_projects_title_color',
            'illdy_projects_descriptions_color',
            'illdy_projects_general_color',
            'illdy_projects_general_image',
            'illdy_projects_background_size',
            'illdy_projects_background_repeat',
            'illdy_projects_background_attachment',
            'illdy_projects_background_position_y',
            'illdy_projects_background_position_x'
        ],
        'services' : [
            'illdy_services_title_color',
            'illdy_services_descriptions_color',
            'illdy_services_general_color',
            'illdy_services_general_image',
            'illdy_services_background_size',
            'illdy_services_background_repeat',
            'illdy_services_background_attachment',
            'illdy_services_background_position_y',
            'illdy_services_background_position_x'
        ],
        'testimonials' : [
            'illdy_testimonials_title_color',
            'illdy_testimonials_general_color',
            'illdy_testimonials_general_background_image',
            'illdy_testimonials_background_size',
            'illdy_testimonials_background_repeat',
            'illdy_testimonials_background_attachment',
            'illdy_testimonials_author_text_color',
            'illdy_testimonials_text_color',
            'illdy_testimonials_container_background_color',
            'illdy_testimonials_dots_color',
            'illdy_testimonials_background_position_y',
            'illdy_testimonials_background_position_x'
        ],
        'team' : [
            'illdy_team_title_color',
            'illdy_team_descriptions_color',
            'illdy_team_general_color',
            'illdy_team_general_image',
            'illdy_team_background_size',
            'illdy_team_background_repeat',
            'illdy_team_background_attachment',
            'illdy_team_background_position_y',
            'illdy_team_background_position_x'
        ],

    };

    function illdy_hexToRgbA(hex,opacity){
        var c;
        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
            c= hex.substring(1).split('');
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c= '0x'+c.join('');
            return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+opacity+')';
        }
        throw new Error('Bad Hex');
    }

    function update_jumbotron_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'jumbotron',
            'values' : {}
        };

         _.each( sections.jumbotron, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        if ( liveObj.values.illdy_jumbotron_first_button_background !== undefined ) {
            var color = liveObj.values.illdy_jumbotron_first_button_background;
            liveObj.values.illdy_jumbotron_first_button_background = illdy_hexToRgbA( color, '.2' );
            liveObj.values.illdy_jumbotron_first_button_background_hover = illdy_hexToRgbA( color, '.1' );
            liveObj.values.illdy_jumbotron_first_border_color = illdy_hexToRgbA( color, '1' );
        }

        wp.customize.previewer.send('update-section-css', liveObj);

    }

    function update_latestnews_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'latestnews',
            'values' : {}
        };

         _.each( sections.latestnews, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_fullwidth_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'fullwidth',
            'values' : {}
        };

         _.each( sections.fullwidth, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });
        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_about_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'about',
            'values' : {}
        };

         _.each( sections.about, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_projects_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'projects',
            'values' : {}
        };

         _.each( sections.projects, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_services_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'services',
            'values' : {}
        };

         _.each( sections.services, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_team_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'team',
            'values' : {}
        };

         _.each( sections.team, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }

    function update_testimonials_css(){
        var liveObj = {
            'action' : 'illdy_generate_section_css',
            'illdy_section' : 'testimonials',
            'values' : {}
        };

         _.each( sections.testimonials, function( setting ){
            liveObj.values[setting] = wp.customize(setting)();
        });

        wp.customize.previewer.send('update-section-css', liveObj);
    }


	if ( typeof(wp) !== 'undefined' ) {
		if ( typeof(wp.customize) !== 'undefined' ) {
			wp.customize.bind('ready', function () {
                _.each( sections, function( settings, section_ID  ){
                    _.each( settings, function( setting ){
                        wp.customize(setting, function (setting) {
                            if ( section_ID == 'jumbotron' ) {
                                setting.bind(update_jumbotron_css);
                            }else if ( section_ID == 'latestnews' ) {
                                setting.bind(update_latestnews_css);
                            }else if ( section_ID == 'fullwidth' ) {
                                setting.bind(update_fullwidth_css);
                            }else if ( section_ID == 'about' ) {
                                setting.bind(update_about_css);
                            }else if ( section_ID == 'projects' ) {
                                setting.bind(update_projects_css);
                            }else if ( section_ID == 'services' ) {
                                setting.bind(update_services_css);
                            }else if ( section_ID == 'testimonials' ) {
                                setting.bind(update_testimonials_css);
                            }else if ( section_ID == 'team' ) {
                                setting.bind(update_team_css);
                            }
                            
                        });
                    });
                });

			});
		}
	}
	
})(jQuery);

jQuery(document).ready(function(){

    jQuery(".illdy-dismiss-required-action").click(function () {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type: "GET",
            data: { action: 'illdy_dismiss_required_action', id: id, todo: action },
            dataType: "html",
            url: IlldyCustomizer.ajax_url,
            beforeSend: function (data, settings) {
                jQuery('#' + id).parent().append('<div id="temp_load" style="text-align:center"><img src="' + IlldyCustomizer.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                var container = jQuery('#' + data).parent().parent();
                var index = container.next().data('index');
                jQuery('.illdy-actions-count .current-index').text(index);
                container.slideToggle().remove();
                if ( jQuery('.recomended-actions_container > .epsilon-required-actions').length == 0 ) {
                    
                    jQuery('#accordion-section-illdy-recomended-section .illdy-actions-count').remove();

                    if ( jQuery('.recomended-actions_container > .epsilon-recommended-plugins').length == 0 ) {
                        jQuery('.recomended-actions_container .succes').removeClass('hide');
                        jQuery('#accordion-section-illdy-recomended-section .section-title').text(jQuery('#accordion-section-illdy-recomended-section .section-title').data('social'));
                    }else{
                        jQuery('#accordion-section-illdy-recomended-section .section-title').text(jQuery('#accordion-section-illdy-recomended-section .section-title').data('plugin_text'));
                    }
                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    jQuery(".illdy-recommended-plugin-button").click(function () {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');
        jQuery.ajax({
            type: "GET",
            data: { action: 'illdy_dismiss_recommended_plugins', id: id, todo: action },
            dataType: "html",
            url: IlldyCustomizer.ajax_url,
            beforeSend: function (data, settings) {
                jQuery('#' + id).parent().append('<div id="temp_load" style="text-align:center"><img src="' + IlldyCustomizer.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                var container = jQuery('#' + data).parent().parent();
                var index = container.next().data('index');
                jQuery('.illdy-actions-count .current-index').text(index);
                container.slideToggle().remove();

                if ( jQuery('.recomended-actions_container > .epsilon-recommended-plugins').length == 0 ) {
                    jQuery('.recomended-actions_container .succes').removeClass('hide');
                    jQuery('#accordion-section-illdy-recomended-section .section-title').text(jQuery('#accordion-section-illdy-recomended-section .section-title').data('social'));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });
});

(function( wp, $ ){

    if ( ! wp || ! wp.customize ) { return; }

    var api = wp.customize;
    api.EpsilonTabs = [];

    api.section( 'illdy_404', function( section ) {
        section.expanded.bind( function( isExpanding ) {
            var newURL = IlldyCustomizer.site_url + '/ihopethisisa404page';
            if ( isExpanding ) {
                if ( ! $.inArray( newURL, api.previewer.allowedUrls ) ) {
                    api.previewer.allowedUrls.push( newURL );
                }
                wp.customize.previewer.previewUrl.set( newURL );
            }else{
                wp.customize.previewer.previewUrl.set( IlldyCustomizer.site_url );
            }

        } );
    } );

    api.EpsilonNavigateButton = api.Control.extend({

        ready: function () {
            var control = this;
            control.container.find( 'a.epsilon-button' ).click( function( evt ){
                var newSection = $(this).data('section'),
                    oldSection = control.params.section;
                evt.preventDefault();
                if ( undefined !== newSection ) {
                    api.IlldyNavigateTo = oldSection;
                    api.section( newSection ).focus();
                }
            });
        }

    });

    api.EpsilonTab = api.Control.extend({

        ready: function () {
            var control = this;
            control.container.find( 'a.epsilon-tab' ).click( function( evt ){
                var tab = $(this).data( 'tab' );
                evt.preventDefault();
                control.container.find( 'a.epsilon-tab' ).removeClass( 'active' );
                $(this).addClass( 'active' );
                control.toggleActiveControls( tab );
            });

            api.EpsilonTabs.push( control.id );
        },

        toggleActiveControls: function( tab ){
            var control = this,
                currentFields = control.params.buttons[ tab ].fields;
            _.each(  control.params.fields, function( id ){
                var tabControl = api.control( id );
                if ( undefined !== tabControl ) {
                    tabControl.container.addClass( 'tab-element' );
                    if ( tabControl.active() && $.inArray( id, currentFields ) >= 0 ) {
                        tabControl.toggle( true );
                    }else{
                        tabControl.toggle( false );
                    }
                }
            });
        }

    });

    api.NewSidebarSection = api.Widgets.SidebarSection.extend({

        attachEvents: function () {
            var meta, content, section = this;

            if ( section.container.hasClass( 'cannot-expand' ) ) {
                return;
            }

            // Expand/Collapse accordion sections on click.
            section.container.find( '.accordion-section-title' ).on( 'click keydown', function( event ) {
                if ( api.utils.isKeydownButNotEnterEvent( event ) ) {
                    return;
                }
                event.preventDefault(); // Keep this AFTER the key filter above

                if ( section.expanded() ) {
                    section.collapse();
                } else {
                    section.expand();
                }
            });

            section.container.find( '.customize-section-back' ).on( 'click keydown', function( event ) {
                if ( api.utils.isKeydownButNotEnterEvent( event ) ) {
                    return;
                }
                event.preventDefault(); // Keep this AFTER the key filter above
                if ( section.expanded() ) {
                    if ( api.IlldyNavigateTo ) {
                        api.section( api.IlldyNavigateTo ).expand();
                        api.IlldyNavigateTo = false;
                    }else{
                        section.collapse();
                    }
                } else {
                    section.expand();
                }
            });

            // This is very similar to what is found for api.Panel.attachEvents().
            section.container.find( '.customize-section-title .customize-help-toggle' ).on( 'click', function() {

                meta = section.container.find( '.section-meta' );
                if ( meta.hasClass( 'cannot-expand' ) ) {
                    return;
                }
                content = meta.find( '.customize-section-description:first' );
                content.toggleClass( 'open' );
                content.slideToggle();
                content.attr( 'aria-expanded', function ( i, attr ) {
                    return 'true' === attr ? 'false' : 'true';
                });
            });
        },

    });

    // Extend epsilon button constructor
    $.extend( api.controlConstructor, {
        'epsilon-button': api.EpsilonNavigateButton,
        'epsilon-tab': api.EpsilonTab,
    });

    $.extend( api.sectionConstructor, {
        sidebar: api.NewSidebarSection
    });

    api.bind( 'ready', function(){
        _.each( api.EpsilonTabs, function( epsilonTab ){
            var control = api.control( epsilonTab );
            control.toggleActiveControls( 0 );
        });
    });

})( window.wp, jQuery );
