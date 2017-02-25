/**
 * File customizer.js.
 *
 */

 jQuery(document).on( 'wp-plugin-update-success', function( evt, response ){
    location.reload();
});

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

/**
 * WP EDITOR plugin
 */
(function ( $ ) {

    window._wpEditor = {
        init: function( id , content, settings ){
            var _id = '__wp_mce_editor__';
            var _tpl =  $( '#_wp-mce-editor-tpl').html();
            if (  typeof content === "undefined"  ){
                content = '';
            }

            if (  typeof window.tinyMCEPreInit.mceInit[ _id ]  !== "undefined" ) {

                var tmceInit = _.clone( window.tinyMCEPreInit.mceInit[_id] );
                var qtInit = _.clone( window.tinyMCEPreInit.qtInit[_id] );

                tmceInit = $.extend( tmceInit , settings.tinymce );
                qtInit   = $.extend( qtInit , settings.qtag );

                var tpl = _tpl.replace( new RegExp(_id,"g"), id );
                var template =  $( tpl );
                template.find( 'textarea').removeAttr( 'rows').removeAttr( 'cols' );
                $( "#"+id ).replaceWith( template );
                // set content
                $( '#'+id ).val( content );

                $wrap = tinymce.$( '#wp-' + id + '-wrap' );

                tmceInit.body_class = tmceInit.body_class.replace(new RegExp(_id,"g"), id );
                tmceInit.selector   = tmceInit.selector.replace(new RegExp(_id,"g"), id );
                tmceInit.cache_suffix   = '';

                $wrap.removeClass( 'html-active').addClass( 'tmce-active' );

                tmceInit.init_instance_callback = function( editor ){
                    if (  typeof settings === 'object' ) {
                        if ( typeof settings.mod === 'string' && settings.mod === 'html' ){
                            //console.log( settings.mod  );
                            switchEditors.go( id, settings.mod );
                        }
                        // editor.theme.resizeTo('100%', 500);
                        if( typeof settings.init_instance_callback === "function" ) {
                            settings.init_instance_callback( editor );
                        }

                        if (settings.sync_id !== '') {
                            if (typeof settings.sync_id === 'string') {
                                editor.on('keyup change', function (e) {
                                    var html = editor.getContent( { format: 'raw' } );
                                    html = _wpEditor.removep( html );
                                    $('#' + settings.sync_id).val( html ).trigger('change');
                                });
                            } else {
                                editor.on('keyup change', function (e) {
                                    var html = editor.getContent( { format: 'raw' } );
                                    html = _wpEditor.removep( html );
                                    settings.sync_id.val( html ).trigger('change');
                                });
                            }

                            $( 'textarea#'+id ).on( 'keyup change', function(){
                                var v =  $( this).val();
                                if ( typeof settings.sync_id === 'string' ) {
                                    $('#' + settings.sync_id).val( v ).trigger('change');
                                } else {
                                    settings.sync_id.val( v ).trigger('change');
                                }
                            } );

                        }
                    }
                };

                tmceInit.plugins = tmceInit.plugins.replace('fullscreen,', '');
                tinyMCEPreInit.mceInit[ id ] = tmceInit;

                qtInit.id = id;
                tinyMCEPreInit.qtInit[ id ] = qtInit;

                if ( $wrap.hasClass( 'tmce-active' ) || ! tinyMCEPreInit.qtInit.hasOwnProperty( id )  ) {
                    tinymce.init( tmceInit );
                    if ( ! window.wpActiveEditor ) {
                        window.wpActiveEditor = id;
                    }
                }

                if ( typeof quicktags !== 'undefined' ) {

                    /**
                     * Reset quicktags
                     * This is crazy condition
                     * Maybe this is a bug ?
                     * see wp-includes/js/quicktags.js line 252
                     */
                    if( QTags.instances['0'] ) {
                        QTags.instances['0'] =  false;
                    }
                    quicktags( qtInit );
                    if ( ! window.wpActiveEditor ) {
                        window.wpActiveEditor = id;
                    }

                }

            }
        },

        /**
         * Replace paragraphs with double line breaks
         * @see wp-admin/js/editor.js
         */
        removep: function ( html ) {
            return window.switchEditors._wp_Nop( html );
        },

        sync: function(){
            //
        },

        remove: function( id ){
            var content = '';
            var editor = false;
            if ( editor = tinymce.get(id) ) {
                content = editor.getContent( { format: 'raw' } );
                content = _wpEditor.removep( content );
                editor.remove();
            } else {
                content = $( '#'+id ).val();
            }

            if ( $( '#wp-' + id + '-wrap').length > 0 ) {
                window._wpEditorBackUp = window._wpEditorBackUp || {};
                if (  typeof window._wpEditorBackUp[ id ] !== "undefined" ) {
                    $( '#wp-' + id + '-wrap').replaceWith( window._wpEditorBackUp[ id ] );
                }
            }

            $( '#'+id ).val( content );
        }

    };


    $.fn.wp_js_editor = function( options ) {

        // This is the easiest way to have default options.
        if ( options !== 'remove' ) {
            options = $.extend({
                sync_id: "", // sync to another text area
                tinymce: {}, // tinymce setting
                qtag:    {}, // quick tag settings
                mod:    '', // quick tag settings
                init_instance_callback: function(){} // quick tag settings
            }, options );
        } else{
            options =  'remove';
        }

        return this.each( function( ) {
            var edit_area  =  $( this );

            edit_area.uniqueId();
            // Make sure edit area have a id attribute
            var id =  edit_area.attr( 'id' ) || '';
            if ( id === '' ){
                return ;
            }

            if ( 'remove' !== options ) {
                if ( ! options.mod  ){
                    options.mod = edit_area.attr( 'data-editor-mod' ) || '';
                }
                window._wpEditorBackUp = window._wpEditorBackUp || {};
                window._wpEditorBackUp[ id ] =  edit_area;
                window._wpEditor.init( id, edit_area.val(), options );
            } else {
                window._wpEditor.remove( id );
            }

        });

    };

}( jQuery ));

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

	$('#sub-accordion-panel-illdy_frontpage_panel').sortable({
		helper: 'clone',
		items: '> li.control-section:not(#accordion-section-illdy_jumbotron_general)',
		cancel: 'li.ui-sortable-handle.open',
		delay: 150,
		update: function( event, ui ) {

			illdy_sections_order( $('#sub-accordion-panel-illdy_frontpage_panel') );

		},

	});

	// Textarea editor

	function _the_editor( container ){
        var _editor = {
            ready: function( container ) {

                var control = this;
                control.container = container;
                control.container.addClass( 'illdy-editor-added' );
                control.editing_area = $( 'textarea' , control.container );
                if ( control.editing_area.hasClass( 'wp-editor-added' ) ) {
                    return false;
                }

                control.editing_area.uniqueId();
                control.editing_area.addClass('wp-editor-added');
                control.editing_id = control.editing_area.attr( 'id' ) || false;
                if ( ! control.editing_id ) {
                    return false;
                }
                control.editor_id = 'wpe-for-'+control.editing_id;
                control.preview = $( '<div id="preview-'+control.editing_id+'" class="wp-js-editor-preview"></div>');
                control.editing_editor = $( '<div id="wrap-'+control.editing_id+'" class="modal-wp-js-editor"><textarea id="'+control.editor_id+'"></textarea></div>');
                var content = control.editing_area.val();
                // Load default value
                $( 'textarea', control.editing_editor).val( content );
                try {
                    control.preview.html( window.switchEditors._wp_Autop( content ) );
                } catch ( e ) {

                }

                $( 'body' ).on( 'click', '#customize-controls, .customize-section-back', function( e ) {
                    if ( ! $( e.target ).is( control.preview ) ) {
                        /// e.preventDefault(); // Keep this AFTER the key filter above
                        control.editing_editor.removeClass( 'wpe-active' );
                        $( '.wp-js-editor-preview').removeClass( 'wpe-focus');
                    }
                } );

                control._init();

                $( window ) .on( 'resize', function(){
                    control._resize();
                } );

            },

            _init: function(  ){

                var control = this;
                $( 'body .wp-full-overlay').append( control.editing_editor );

                $( 'textarea',  control.editing_editor).attr(  'data-editor-mod', ( control.editing_area.attr( 'data-editor-mod' ) || '' ) ) .wp_js_editor( {
                    sync_id: control.editing_area,
                    init_instance_callback: function( editor ) {
                        var w =  $( '#wp-'+control.editor_id+ '-wrap' );
                        $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor fullscreen-wp-editor"  type="button"><span class="dashicons"></span></button>' );
                        $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor preview-wp-editor"  type="button"><span class="dashicons dashicons-visibility"></span></button>' );
                        $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor close-wp-editor"  type="button"><span class="dashicons dashicons-no-alt"></span></button>' );
                        w.on( 'click', '.close-wp-editor', function( e ) {
                            e.preventDefault();
                            control.editing_editor.removeClass( 'wpe-active' );
                            $( '.wp-js-editor-preview').removeClass( 'wpe-focus');
                        } );
                        $( '.preview-wp-editor', w ).hover( function(){
                            w.closest( '.modal-wp-js-editor').css( { opacity: 0 } );
                        }, function(){
                            w.closest( '.modal-wp-js-editor').css( { opacity: 1 } );
                        } );
                        w.on( 'click', '.fullscreen-wp-editor', function( e ) {
                            e.preventDefault();
                            w.closest( '.modal-wp-js-editor').toggleClass( 'fullscreen' );
                            setTimeout( function(){
                                $( window ).resize();
                            }, 600 );
                        } );
                    }
                } );


                control.editing_area.on( 'change', function() {
                    control.preview.html( window.switchEditors._wp_Autop( $( this).val() ) );
                });

                control.preview.on( 'click', function( e ){
                    $( '.modal-wp-js-editor').removeClass( 'wpe-active' );
                    control.editing_editor.toggleClass( 'wpe-active' );
                    tinyMCE.get( control.editor_id ).focus();
                    control.preview.addClass( 'wpe-focus' );
                    control._resize();
                    return false;
                } );

                control.editing_area.on( 'focus', function( e ){
                    console.log('asdasdsad');
                    $( '.modal-wp-js-editor').removeClass( 'wpe-active' );
                    control.editing_editor.toggleClass( 'wpe-active' );
                    tinyMCE.get( control.editor_id ).focus();
                    control.preview.addClass( 'wpe-focus' );
                    control._resize();
                    return false;
                } );



                control.container.find( '.wp-js-editor').addClass( 'wp-js-editor-active' );
                control.preview.insertBefore( control.editing_area );
                control.container.on( 'click', '.wp-js-editor-preview', function( e ){
                    e.preventDefault();
                } );

            },

            _resize: function(){
                var control = this;
                var w =  $( '#wp-'+control.editor_id+ '-wrap');
                var height = w.innerHeight();
                var tb_h = w.find( '.mce-toolbar-grp' ).eq( 0 ).height();
                tb_h += w.find( '.wp-editor-tools' ).eq( 0 ).height();
                tb_h += 50;
                //var width = $( window ).width();
                var editor = tinymce.get( control.editor_id );
                control.editing_editor.width( '' );
                editor.theme.resizeTo( '100%', height - tb_h );
                w.find( 'textarea.wp-editor-area').height( height - tb_h  );
            }

        };

        _editor.ready( container );

    }

    function _remove_editor( $context ){
        $( 'textarea', $context ).each( function(){
            var id = $(this).attr( 'id' ) || '';
            var editor_id = 'wpe-for-'+id;
            try {
                var editor = tinymce.get( editor_id );
                if ( editor ) {
                    editor.remove();
                }
                $( '#wrap-'+editor_id ).remove();
                $( '#wrap-'+id ).remove();

                if ( typeof tinyMCEPreInit.mceInit[ editor_id ] !== "undefined"  ) {
                    delete  tinyMCEPreInit.mceInit[ editor_id ];
                }

                if ( typeof tinyMCEPreInit.qtInit[ editor_id ] !== "undefined"  ) {
                    delete  tinyMCEPreInit.qtInit[ editor_id ];
                }

            } catch (e) {

            }

        } );
    }

    var _is_init_editors = {};

    $( 'body' ).on( 'click', '#customize-theme-controls .accordion-section', function( e ){
        //e.preventDefault();
        var section = $( this );
        var id = section.attr( 'id' ) || '';
        if ( id ) {
            if ( typeof _is_init_editors[ id ] === "undefined" ) {
                _is_init_editors[ id ] = true;

                setTimeout( function() {
                    if ( $( '.wp-js-editor', section ).length > 0 ) {
                        $( '.wp-js-editor', section ).each( function(){
                            _the_editor( $( this ) );
                        } );
                    }
                }, 10 );

            }
        }
    } );

    if ( _wpCustomizeSettings.autofocus ) {
        if ( _wpCustomizeSettings.autofocus.section ) {
        	console.log('focus');
            var id = "sub-accordion-section-"+_wpCustomizeSettings.autofocus.section ;
            _is_init_editors[ id ] = true;
            var section = $( '#'+id );
            setTimeout( function(){
            	console.log('before check');
                if ( $( '.wp-js-editor', section ).length > 0 ) {
                	console.log('exist');
                    $( '.wp-js-editor', section ).each( function(){
                        _the_editor( $( this ) );
                    } );
                }
            }, 1000 );

        } else if ( _wpCustomizeSettings.autofocus.panel ) {

        }
    }

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
				EpsilonFramework.colorSchemes('.mte-color-scheme');

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