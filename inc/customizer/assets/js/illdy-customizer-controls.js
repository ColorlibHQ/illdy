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

	/**
	 * Colour scheme palettes.
	 *
	 * Selecting a palette stores its id on the control's own setting and pushes the
	 * palette's colours into the individual epsilon_*_color settings, which is what
	 * the previous control did and what the front end reads.
	 */
	function initColorSchemes() {
		$( document ).on( 'change', '.illdy-color-schemes input[type="radio"]', function () {
			var $input = $( this ),
				colors;

			$input.closest( '.illdy-color-schemes' )
				.find( '.illdy-color-scheme' ).removeClass( 'is-selected' );
			$input.closest( '.illdy-color-scheme' ).addClass( 'is-selected' );

			try {
				colors = JSON.parse( $input.attr( 'data-colors' ) || '{}' );
			} catch ( e ) {
				return;
			}

			$.each( colors, function ( settingId, hex ) {
				var setting = api( settingId );
				if ( setting ) {
					setting.set( hex );
				}
			} );
		} );
	}

	/**
	 * Repeater rows.
	 *
	 * The hidden input carries the whole value as JSON and is what the Customizer
	 * setting is linked to, so the stored shape stays
	 * [ { field: value, … }, … ] exactly as the front end expects.
	 */
	function serialiseRepeater( $wrap ) {
		var fields = [],
			rows = [];

		try {
			fields = JSON.parse( $wrap.attr( 'data-fields' ) || '[]' );
		} catch ( e ) {
			return;
		}

		$wrap.find( '.illdy-repeater-rows > .illdy-repeater-row' ).each( function () {
			var $row = $( this ),
				row = {};

			$.each( fields, function ( i, name ) {
				row[ name ] = $row.find( '.illdy-repeater-field[data-field="' + name + '"] .illdy-repeater-input' ).val() || '';
			} );
			rows.push( row );
		} );

		var $input = $wrap.find( '.illdy-repeater-value' ),
			settingId = $input.data( 'customize-setting-link' ),
			setting = settingId ? api( settingId ) : null;

		$input.val( JSON.stringify( rows ) );
		if ( setting ) {
			setting.set( rows );
		}
	}

	function initRepeaters() {
		$( document )
			.on( 'click', '.illdy-repeater-add', function ( e ) {
				e.preventDefault();
				var $wrap = $( this ).closest( '.illdy-repeater' ),
					tpl = $wrap.find( '.illdy-repeater-template' ).html(),
					index = $wrap.find( '.illdy-repeater-row' ).length;

				$wrap.find( '.illdy-repeater-rows' ).append(
					$( tpl.replace( /__i__/g, String( index ) ) )
				);
				serialiseRepeater( $wrap );
			} )
			.on( 'click', '.illdy-repeater-remove', function ( e ) {
				e.preventDefault();
				var $wrap = $( this ).closest( '.illdy-repeater' );
				$( this ).closest( '.illdy-repeater-row' ).remove();
				serialiseRepeater( $wrap );
			} )
			.on( 'change keyup', '.illdy-repeater-input', function () {
				var $field = $( this ).closest( '.illdy-repeater-field' ),
					val = $( this ).val();
				$field.find( '.illdy-repeater-image-preview' )
					.html( val ? $( '<img>' ).attr( { src: val, alt: '' } ) : '' );
				serialiseRepeater( $( this ).closest( '.illdy-repeater' ) );
			} )
			.on( 'click', '.illdy-repeater-select', function ( e ) {
				e.preventDefault();
				var $field = $( this ).closest( '.illdy-repeater-field' ),
					frame = wp.media( {
						title: wp.media.view.l10n.addMedia,
						library: { type: 'image' },
						multiple: false
					} );

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					$field.find( '.illdy-repeater-input' ).val( attachment.url ).trigger( 'change' );
				} );

				frame.open();
			} );

		// Keep rows reorderable, which is what the old control offered.
		if ( $.fn.sortable ) {
			$( '.illdy-repeater-rows' ).sortable( {
				handle: '.illdy-repeater-row-header',
				update: function () {
					serialiseRepeater( $( this ).closest( '.illdy-repeater' ) );
				}
			} );
		}
	}

	api.bind( 'ready', function () {
		initAll();
		initColorSchemes();
		initRepeaters();

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
