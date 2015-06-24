(function( $ ) {

    $(window).load(function () {
        if ( ! _.isUndefined( mailtpl ) ) {
            wp.customize.control( mailtpl.focus ).focus();
        }

    });

})( jQuery );
