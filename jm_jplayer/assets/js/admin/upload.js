;( function( $ ) {

	'use strict';

/*-----------------------------------------------------------------------------------*/
/*	Uploader
/*-----------------------------------------------------------------------------------*/

	$( '.wolf_jplayer_upload_img_button' ).click( function( e ) {
		e.preventDefault();
		var $el = $( this ).parent(),
			uploader = wp.media( {
				title : 'Choose an image',
				library : { type : 'image'},
				multiple : false
			} )
			.on( 'select', function() {
				var selection = uploader.state().get( 'selection' ),
					attachment = selection.first().toJSON();
				console.log(attachment.url);
				$( 'input', $el ).val( attachment.url );
				$( 'img', $el ).attr( 'src', attachment.url ).show();
			} )
			.open();
	} );

	$( '.wolf_jplayer_upload_button' ).click( function( e ) {
		e.preventDefault();
		var $el = $( this ).parent(),
			uploader = wp.media( {
				title : 'Choose a song',
				library : { type : 'audio'},
				multiple : false
			} )
		.on( 'select', function() {
			var selection = uploader.state().get( 'selection' ),
				attachment = selection.first().toJSON();
			//console.log(attachment);
			$( 'input', $el ).val( attachment.url );
			$( 'img', $el ).attr( 'src', attachment.url ).show();
		} )
		.open();
	} );

/*-----------------------------------------------------------------------------------*/
/*	Reset Image preview in theme options
/*-----------------------------------------------------------------------------------*/

	$( '.wolf_jplayer_reset' ).click( function() {
		
		$( this ).parent().find( 'input' ).val( '' );
		$( this ).parent().find( '.wolf_jplayer_img_preview' ).hide();
		return false;

	} );
	
} )( jQuery );