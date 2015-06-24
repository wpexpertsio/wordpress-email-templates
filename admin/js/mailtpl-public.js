(function( $ ) {
        // Update the site footer in real time...
        wp.customize( 'mailtpl_opts[footer]', function( value ) {
            value.bind( function( newval ) {
                $( '#credit' ).html( newval );
            } );
        } );


})( jQuery );
