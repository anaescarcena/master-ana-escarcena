/**
 * acf-theme-code.js
 *
 * Scripts para el plugin Asdrubal Custom Fields: Theme Code.
 * Compatible con ACF (Free/Pro) y SCF (Secure Custom Fields).
 *
 * Dependencias: wp-i18n, jquery, clipboard.js v2.x
 */

/* global wp, ClipboardJS */

( function ( $ ) {

	'use strict';

	// ── i18n ──────────────────────────────────────────────────────────────────
	const { __ } = wp.i18n;

	const i18nCopyAll = __( 'Copiar todo al portapapeles', 'acf-theme-code' );
	const i18nCode    = __( 'Código', 'acf-theme-code' );

	// ── Tipos de campo sin código generado ────────────────────────────────────
	// Debe coincidir con ACFTC_Core::$ignored_field_types en PHP
	const ignoredFieldTypes = [ 'tab', 'message', 'accordion', 'enhanced_message', 'row', 'page' ];

	// ── DOM ready ─────────────────────────────────────────────────────────────
	$( document ).ready( function () {

		// Evitar que los enlaces # suban al inicio de la página
		$( 'a.acftc-field__copy' ).on( 'click', function ( e ) {
			e.preventDefault();
		} );

		// Botón "Copiar todo" en la cabecera del meta box
		$( '#acftc-meta-box .inside' ).prepend(
			`<a href="#" class="acftc-copy-all acf-js-tooltip" title="${ i18nCopyAll }"></a>`
		);

		// Ocultar el toggle indicator del meta box (no se necesita en este plugin)
		$( '#acftc-meta-box .toggle-indicator' ).hide();

		// ── Añadir enlace "Código" a cada campo en el editor de grupos ─────────
		const $fields = $( '#acf-field-group-fields .acf-field-object' )
			// Excluir campos anidados (sub-campos de repeaters, etc.)
			.filter( function () {
				return $( this ).parentsUntil( '#acf-field-group-fields', '.acf-field-object' ).length === 0;
			} );

		$fields.each( function () {

			const fieldKey  = $( this ).attr( 'data-id' );
			const fieldType = $( this ).attr( 'data-type' );

			if ( ! ignoredFieldTypes.includes( fieldType ) ) {
				$( this ).find( '.row-options' ).eq( 0 ).append(
					`<a class="acftc-scroll__link" href="#acftc-${ fieldKey }">${ i18nCode }</a>`
				);
			}

		} );

		// ── Scroll animado al bloque de código del campo ──────────────────────
		$( document ).on( 'click', 'a.acftc-scroll__link', function ( e ) {

			e.preventDefault();

			const $wpAdminBar     = $( '#wpadminbar' );
			const $acfToolbar     = $( '.acf-admin-toolbar' );
			const $acfHeaderBar   = $( '.acf-headerbar' );
			let scrollOffset      = 44;

			// Localizar la ubicación activa
			let location = $( '#acftc-group-option option:selected' ).val();
			if ( ! location ) {
				location = 'acftc-meta-box .inside';
			}

			const hash   = $( this ).attr( 'href' );
			const $target = $( `#${ location } ${ hash }` );

			if ( ! $target.length ) {
				return;
			}

			const targetOffset = $target.offset().top;

			// Sumar altura de barras fijas/sticky
			[ $wpAdminBar, $acfToolbar, $acfHeaderBar ].forEach( function ( $bar ) {
				if ( $bar.length ) {
					const pos = $bar.css( 'position' );
					if ( pos === 'fixed' || pos === 'sticky' ) {
						scrollOffset += $bar.outerHeight();
					}
				}
			} );

			$( 'html, body' ).animate( {
				scrollTop: targetOffset - scrollOffset,
			}, 600 );

		} );

		// ── Selector de ubicaciones ───────────────────────────────────────────

		// Activar la primera ubicación al cargar
		$( '#acftc-group-0' ).addClass( 'location-wrap--active' );

		// Cambio de ubicación seleccionada
		$( '#acftc-group-option' ).on( 'change', function () {

			const activeId = $( this ).val();

			$( '.location-wrap' )
				.slideUp()
				.removeClass( 'location-wrap--active' );

			$( `#${ activeId }` )
				.slideDown()
				.addClass( 'location-wrap--active' );

		} );

	} ); // document.ready

	// ── Clipboard: copiar campo individual ────────────────────────────────────
	// clipboard.js v2.x usa ClipboardJS (no Clipboard)
	const copyField = new ClipboardJS( '.acftc-field__copy', {
		target: function ( trigger ) {
			return trigger.nextElementSibling;
		},
	} );

	copyField.on( 'success', function ( e ) {
		e.clearSelection();
	} );

	// ── Clipboard: copiar todos los campos de la ubicación activa ─────────────
	const copyAllFields = new ClipboardJS( '.acftc-copy-all', {
		text: function () {
			const $blocks = $( '#acftc-meta-box .location-wrap--active .acftc-field-code pre' );
			return $blocks.text();
		},
	} );

	copyAllFields.on( 'success', function ( e ) {
		e.clearSelection();
	} );

} )( jQuery );