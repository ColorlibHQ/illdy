/**
 * File customizer.js.
 *
 */

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
						if ( individualId.search('illdy_person') != -1 || individualId.search('illdy_counter') != -1 || individualId.search('illdy_service') != -1 || individualId.search('illdy_skill') != -1 || individualId.search('illdy_project') != -1 ) {
							$(this).hide();
						} else {
							$(this).show();
						}
					});
					break;
			}
		});
	});
})(jQuery);