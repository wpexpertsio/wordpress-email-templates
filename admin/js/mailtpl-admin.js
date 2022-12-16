(function( $ ) {

    $(window).load(function () {
        $('.mailtpl_range').on('input',function(){
            var val = $(this).val();
            $(this).parent().find('.font_value').html(val);
            $(this).val(val);
        });

        if( $('#customize-control-mailtpl_template select').val() != 'boxed' ) {
            $('#customize-control-mailtpl_body_size').hide();
        }
        $('#customize-control-mailtpl_template select').on('change', function () {
            if( $(this).val() == 'boxed' ) {
                $('#customize-control-mailtpl_body_size').fadeIn();
            } else {
                $('#customize-control-mailtpl_body_size').fadeOut();
            }
        });
    });

    $( document ).ready( function() {
        $(document).on('click', '#mailtpl-send_mail', function(e){
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
    } );

})( jQuery );
