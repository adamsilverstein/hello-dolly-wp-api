( function( $ ) {
	'use strict';

	var template = _.template( '<p id="dolly"><%- value %></p>' ),
		hello    = new wp.api.collections.Hello();

	hello.fetch().done( function() {

		$( '#wpbody-content' )
			.find( '.wrap' )
			.before(
				template( {
					value: hello.models[ _.random( 0, ( hello.models.length - 1 ) ) ].get( 'line' )
				} )
			);

	} );
} )( jQuery );
