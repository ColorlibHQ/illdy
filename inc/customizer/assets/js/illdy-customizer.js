/**
 * File customizer.js.
 *
 */

( function( api ) {

	// Extends our custom "illdy-pro-section" section.
	api.sectionConstructor['illdy-pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );
	// Extends our custom "illdy-pro-section" section.
	api.sectionConstructor['illdy-recomended-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );

 jQuery( document ).ready( function( $ ) {

 	$('.recomended-actions_container').on( 'actions_complete', function( evt,  element ){
 		if ( $(element).next( '.epsilon-recommeded-actions-container' ).length > 0 ) {
 			var nex_actions = $(element).next( '.epsilon-recommeded-actions-container' );
 			var next_index = nex_actions.data('index');
 			$('.control-section-illdy-recomended-section .illdy-actions-count .current-index').text( next_index );
 			$(element).remove();
 		}else{
 			$(element).remove();
 			$('.control-section-illdy-recomended-section .illdy-actions-count').addClass('complete');
 			$('.control-section-illdy-recomended-section .accordion-section-title .section-title').text( $('.control-section-illdy-recomended-section .accordion-section-title .section-title').data('succes') )
 			$('.recomended-actions_container .succes').show();
 		}

 	});

	wp.customize.section.each( function ( section ) {

		var sectionID = '#sub-accordion-section-'+section.id;
		if ( $(sectionID).find('.epsilon-tabs').length > 0 ) {
			var current_tab = $(sectionID).find('.epsilon-tabs a.epsilon-tab.active');
			var current_control = current_tab.parent().parent().parent();
			var current_controlID = current_control.attr('id');
			$(sectionID+' #'+current_controlID).nextAll().hide().addClass('tab-element');
			var fields = current_tab.data('fields');
			$(sectionID).find(fields).show();
			
			$(sectionID).find('.epsilon-tabs a.epsilon-tab').click(function(evt){
				evt.preventDefault();

				var section = $(this).parent().parent().parent().parent();
				var sectionID = section.attr('id');
				section.find('.epsilon-tabs a').removeClass('active');
				$(this).addClass('active');
				var field = $(this).parent().parent().parent();
				var fieldID = field.attr('id');
				$('#'+sectionID+' #'+fieldID).nextAll().hide();
				var fields = $(this).data('fields');
				section.find(fields).show();
			});
		}

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

		$('.epsilon-button').on( 'click', function( evt ){
			evt.preventDefault();
			section = $(this).data('section');
			if ( section ) {
				wp.customize.section( section ).focus();
			}
		});

	});


	// Color Scheme
	var EpsilonFramework = {};
	EpsilonFramework.colorSchemes = function (selector) {
		/**
		 * Set variables
		 */
		var context = $(selector),
				options = context.find('.mte-color-option'),
				input = context.parent().find('.mte-color-scheme-input'),
				json = $.parseJSON(options.first().find('input').val()),
				api = wp.customize,
				colorSettings = [],
				css = {
					action: 'epsilon_generate_css',
					data  : {}
				};

		$.each(json, function (index, value) {
			index = index.replace(/-/g, '_');
			colorSettings.push('epsilon_' + index + '_color');
		});

		function updateCSS() {
			_.each(colorSettings, function (setting) {
				css.data[ setting ] = api(setting)();
			});
			api.previewer.send('update-inline-css', css)
		}

		_.each(colorSettings, function (setting) {
			api(setting, function (setting) {
				setting.bind(updateCSS);
			});
		});

		/**
		 * On clicking a color scheme, update the color pickers
		 */
		$('.mte-color-option').on('click', function () {
			var val = $(this).attr('data-color-id'),
					json = $.parseJSON($(this).find('input').val());

			/**
			 * find the customizer options
			 */
			$.each(json, function (index, value) {
				index = index.replace(/-/g, '_');
				colorSettings.push('epsilon_' + index + '_color');
				/**
				 * Set values
				 */
				wp.customize('epsilon_' + index + '_color').set(value);
			});

			/**
			 * Remove the selected class from siblings
			 */
			$(this).siblings('.mte-color-option').removeClass('selected');
			/**
			 * Make active the current selection
			 */
			$(this).addClass('selected');
			/**
			 * Trigger change
			 */
			input.val(val).change();

			_.each(colorSettings, function (setting) {
				api(setting, function (setting) {
					setting.bind(updateCSS());
				});
			});
		});
	};

	if ( typeof(wp) !== 'undefined' ) {
		if ( typeof(wp.customize) !== 'undefined' ) {
			wp.customize.bind('ready', function () {
				EpsilonFramework.colorSchemes('.mte-color-scheme');
			});
		}
	}
	
})(jQuery);