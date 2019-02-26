( function( $ ) {
	'use strict';

	var $doc = $( document );

	$doc.ready( function( $ ) {

		function sortServices() {
			$( '.wpex-social-widget-services-list' ).each( function() {
				var id = $( this ).attr( 'id' ),
					$el = $( '#'+ id );
				$el.sortable( {
					placeholder : "placeholder",
					opacity     : 0.6,
					update      : function( event, ui ) {
						if ( wp.customize !== undefined ) {
							var $input = $el.find( 'input.ui-sortable-handle' );
							$input.trigger( 'change' );
						}
					}
				} );
			} );
		}
		
		sortServices();

		// Customizer support
		if ( wp.customize !== undefined ) {
			$doc.on( 'widget-updated', sortServices );
			$doc.on( 'widget-added', sortServices );
		}

	} );

} ) ( jQuery );