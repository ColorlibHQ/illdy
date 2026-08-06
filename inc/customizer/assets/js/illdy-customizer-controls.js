/**
 * Illdy Customizer control behaviour.
 *
 * Uses core's wp.editor API rather than a bundled framework. Values are written back
 * to the Customizer setting unchanged, so what is stored stays exactly what the
 * setting always held.
 */
( function ( $, api ) {
	'use strict';

	/**
	 * Turns a textarea into a TinyMCE / QuickTags editor and keeps the Customizer
	 * setting in sync with it.
	 *
	 * @param {HTMLElement} node The .illdy-text-editor textarea.
	 */
	function initEditor( node ) {
		var $node = $( node ),
			id = node.id,
			settingId = $node.data( 'customize-setting-link' ),
			setting = settingId ? api( settingId ) : null;

		if ( ! id || $node.data( 'illdyEditorReady' ) ) {
			return;
		}
		$node.data( 'illdyEditorReady', true );

		if ( ! window.wp || ! wp.editor || 'function' !== typeof wp.editor.initialize ) {
			return; // core editor unavailable; the plain textarea still works
		}

		function push( value ) {
			if ( setting && setting() !== value ) {
				setting.set( value );
			}
		}

		wp.editor.initialize( id, {
			tinymce: {
				wpautop: true,
				toolbar1: 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo',
				setup: function ( editor ) {
					editor.on( 'change keyup NodeChange SetContent', function () {
						push( editor.getContent() );
					} );
				}
			},
			quicktags: true,
			mediaButtons: false
		} );

		// Text (QuickTags) mode edits the raw textarea directly.
		$node.on( 'change keyup', function () {
			push( $node.val() );
		} );
	}

	function initAll( context ) {
		$( context || document ).find( '.illdy-text-editor' ).each( function () {
			initEditor( this );
		} );
	}

	api.bind( 'ready', function () {
		initAll();

		// Sections render lazily; catch editors that appear when one is expanded.
		api.section.each( function ( section ) {
			section.expanded.bind( function ( isExpanded ) {
				if ( isExpanded ) {
					initAll( section.container );
				}
			} );
		} );
	} );
} )( jQuery, wp.customize );
