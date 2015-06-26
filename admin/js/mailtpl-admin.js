(function( $ ) {

    $(window).load(function () {
        if ( ! _.isUndefined( mailtpl ) ) {
            wp.customize.control( mailtpl.focus ).focus();
        }

        $('#mailtpl-send_mail').on('click', function(e){
            e.preventDefault();
            $('#mailtpl-spinner').fadeIn();
            $.ajax({
                url     : ajaxurl,
                data    : { action: 'mailtpl_send_email' }
            }).done(function(data) {
                $('#mailtpl-spinner').fadeOut();
                $('#mailtpl-success').fadeIn().delay(3000).fadeOut();
            });
        });
    });

})( jQuery );
