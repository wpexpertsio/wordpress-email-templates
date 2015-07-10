(function( $ ) {


        wp.customize( 'mailtpl_opts[body_bg]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#body' ).css( 'background-color', newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[header_logo]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length ) {
                    $( '#logo a' ).html( '<img src="'+newval+'" alt="logo"/>' );
                } else {
                    $( '#logo a' ).html( '' );
                }
            } );
        } );
        wp.customize( 'mailtpl_opts[header_logo_text]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#logo a' ).text( newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[header_aligment]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#logo' ).css( 'text-align', newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[header_bg]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#template_header' ).css( 'background-color', newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[header_text_color]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#logo' ).css( 'color', newval );
            } );
        } );

        wp.customize( 'mailtpl_opts[footer_aligment]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#credit' ).css( 'text-align', newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[footer_bg]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#template_footer' ).css( 'background-color', newval );
            } );
        } );
        wp.customize( 'mailtpl_opts[footer_text_color]', function( value ) {
            value.bind( function( newval ) {
                if( newval.length )
                    $( '#credit' ).css( 'color', newval );
            } );
        } );


        wp.customize( 'mailtpl_opts[footer_text]', function( value ) {
            value.bind( function( newval ) {
                $( '#credit' ).html( newval );
            } );
        } );

        wp.customize( 'mailtpl_opts[footer_powered_by]', function( value ) {
            value.bind( function( newval ) {
                if( newval == 'off' ) {
                    $( '#powered' ).hide();
                } else {
                    $( '#powered' ).show();
                }
            } );
        } );


})( jQuery );
