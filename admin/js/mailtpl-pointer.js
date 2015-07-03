jQuery(document).ready( function($) {
    mailtpl_open_pointer(0);
    function mailtpl_open_pointer(i) {
        pointer = mailtpl_pointer.pointers[i];
        options = $.extend( pointer.options, {
            close: function() {
                $.post( ajaxurl, {
                    pointer: pointer.pointer_id,
                    action: 'dismiss-wp-pointer'
                });
            }
        });

        $(pointer.target).pointer( options ).pointer('open');
    }
});