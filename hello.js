( function( $ ) {
	'use strict';

	var loadPromise,
		template = _.template( '<p id="dolly"><%- value %></p>' ),
		hello    = new wp.api.collections.Hello();

	loadPromise = hello.fetch();

	loadPromise.done( function() {

		$( '#wpbody-content' )
		.find( '.wrap' )
		.before( template( {
			value: hello.models[ _.random( 0, ( hello.models.length - 1 ) ) ].get( 'line' )
		} ) );

	} );
} )( jQuery );
