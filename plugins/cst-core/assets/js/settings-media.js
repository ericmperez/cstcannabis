/* global jQuery, wp, cstSettingsMedia */
/**
 * CST Settings — media uploader buttons.
 *
 * Wires the "Subir / Tomar foto" buttons rendered by render_media_field()
 * to the WordPress media library. The library handles phone camera capture
 * natively (the OS upload picker exposes camera + photo album).
 */
( function ( $ ) {
    'use strict';

    var t = ( window.cstSettingsMedia || {} );

    function frame( cb ) {
        var f = wp.media( {
            title    : t.pickTitle  || 'Select image',
            button   : { text: t.pickButton || 'Use this image' },
            library  : { type: 'image' },
            multiple : false
        } );
        f.on( 'select', function () {
            var att = f.state().get( 'selection' ).first().toJSON();
            cb( att );
        } );
        f.open();
    }

    $( document ).on( 'click', '.cst-media-field__pick', function ( e ) {
        e.preventDefault();
        var $field   = $( this ).closest( '.cst-media-field' );
        var $input   = $field.find( 'input[type=hidden]' );
        var $preview = $field.find( '.cst-media-field__preview' );
        var $remove  = $field.find( '.cst-media-field__remove' );

        frame( function ( att ) {
            $input.val( att.id );
            var url = ( att.sizes && att.sizes.medium && att.sizes.medium.url ) || att.url;
            $preview.html(
                '<img src="' + url + '" style="max-width:240px;max-height:120px;background:#f6f7f7;border:1px solid #c3c4c7;padding:6px;border-radius:4px;display:block;" />'
            );
            $remove.show();
        } );
    } );

    $( document ).on( 'click', '.cst-media-field__remove', function ( e ) {
        e.preventDefault();
        var $field   = $( this ).closest( '.cst-media-field' );
        $field.find( 'input[type=hidden]' ).val( 0 );
        $field.find( '.cst-media-field__preview' ).html(
            '<span class="description">' + ( t.noneLabel || 'No image selected' ) + '</span>'
        );
        $( this ).hide();
    } );
} )( jQuery );
