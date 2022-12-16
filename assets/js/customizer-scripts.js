/*
 * Customizer Scripts
 * Need to rewrite and clean up this file.
 */

jQuery(document).ready(function() {

    /**
     * Change description
     */
    jQuery('#customize-info .customize-panel-description').html(mailtpl_woomail.labels.description);
    jQuery('#customize-info .panel-title.site-title').html(mailtpl_woomail.labels.customtitle);
    // Add reset button
    jQuery('#customize-header-actions input#save').after('<input type="submit" name="mailtpl_woomail_reset" id="mailtpl_woomail_reset" class="button button-secondary" value="' + mailtpl_woomail.labels.reset + '" style="float: right; margin-left: 8px; margin-top: 0px;">');

    // Handle reset button click
    jQuery('#customize-header-actions #mailtpl_woomail_reset').click(function(e) {

        // Prevent form submit
        e.preventDefault();

        // Display confirmation prompt
        var confirmation = confirm(mailtpl_woomail.labels.reset_confirmation);

        // Check user input
        if ( ! confirmation ) {
            return;
        }

        // Disable reset button
        jQuery(this).prop('disabled', true);

        // Populate request data object
        var data = {
            wp_customize:   'on',
            action:         'mailtpl_woomail_reset',
        };

        // Send request to server
        jQuery.post(mailtpl_woomail.ajax_url, data, function() {
            wp.customize.state('saved').set(true);
            window.location.replace(mailtpl_woomail.customizer_url);
        });
    });
    wp.customize.state('saved').bind( 'change', function() {
    	if( wp.customize.state( 'saved' ).get() ) {
    		jQuery('input[name=mailtpl-woomail-send-email]').prop('disabled', false);
    	} else {
    		jQuery('input[name=mailtpl-woomail-send-email]').prop('disabled', true);
    	}
    });

    // Handle send email button click
    jQuery('input[name=mailtpl-woomail-send-email]').click(function(e) {

        // Prevent form submit
        e.preventDefault();

        // Get recipients
        var recipients = jQuery('input#_customize-input-mailtpl_woomail_email_recipient').val();
		// Display confirmation prompt
		var confirmation = confirm(mailtpl_woomail.labels.send_confirmation);

		// Check user input
		if ( ! confirmation ) {
		    return;
		}

		// Disable send button
		jQuery(this).prop('disabled', true);

		// Populate request data object
		var data = {
			wp_customize:   'on',
			action:         'mailtpl_woomail_send_email',
			recipients:     recipients,
		};
		// Send request to server
		jQuery.post(mailtpl_woomail.ajax_url, data, function( result ) {
			 if ( result != 0 ) {
		    	alert( mailtpl_woomail.labels.sent );
		    } else {
		    	alert( mailtpl_woomail.labels.failed );
		    }
		    jQuery(this).prop('disabled', false);
		});
    });

     jQuery( '.image-radio-select label' ).on( 'click', function(e) {
    	var new_val = jQuery(this).attr('data-image-value');
    	jQuery('#mailtpl-woomail-prebuilt-template').val(new_val);
    	jQuery('.image-radio-select label.mailtplactive').each( function () {
    		jQuery(this).removeClass("mailtplactive");
    	});
    	jQuery(this).addClass("mailtplactive");
    });

    // Handle mobile button click
    function custom_size_mobile() {
    	// get email width.
    	var email_width = parseInt( jQuery('#customize-control-mailtpl_woomail_content_width .range-slider__range').val() );
    	var ratio = 380/email_width;
    	var framescale = 100/ratio;
    	var framescale = framescale/100;
    	jQuery('#customize-preview iframe').width(email_width+'px');
    	jQuery('#customize-preview iframe').css({
				'-webkit-transform' : 'scale(' + ratio + ')',
				'-moz-transform'    : 'scale(' + ratio + ')',
				'-ms-transform'     : 'scale(' + ratio + ')',
				'-o-transform'      : 'scale(' + ratio + ')',
				'transform'         : 'scale(' + ratio + ')'
		});
    }
	jQuery('#customize-footer-actions .preview-mobile').click(function(e) {
		if ( mailtpl_woomail.responsive_mode ) {
			jQuery('#customize-preview iframe').width('100%');
			jQuery('#customize-preview iframe').css({
					'-webkit-transform' : 'scale(1)',
					'-moz-transform'    : 'scale(1)',
					'-ms-transform'     : 'scale(1)',
					'-o-transform'      : 'scale(1)',
					'transform'         : 'scale(1)'
			});
		} else {
			custom_size_mobile();
		}
	});

	jQuery('#customize-footer-actions .preview-desktop').click(function(e) {
		jQuery('#customize-preview iframe').width('100%');
		jQuery('#customize-preview iframe').css({
				'-webkit-transform' : 'scale(1)',
				'-moz-transform'    : 'scale(1)',
				'-ms-transform'     : 'scale(1)',
				'-o-transform'      : 'scale(1)',
				'transform'         : 'scale(1)'
		});
	});
	jQuery('#customize-footer-actions .preview-tablet').click(function(e) {
		jQuery('#customize-preview iframe').width('100%');
		jQuery('#customize-preview iframe').css({
				'-webkit-transform' : 'scale(1)',
				'-moz-transform'    : 'scale(1)',
				'-ms-transform'     : 'scale(1)',
				'-o-transform'      : 'scale(1)',
				'transform'         : 'scale(1)'
		});
	});

});

( function( $ ) {
	
	var KWMDIE = {
	
		init: function() {
			$( 'input[name=mailtpl-woomail-export-button]' ).on( 'click', KWMDIE._export );
			$( 'input[name=mailtpl-woomail-import-button]' ).on( 'click', KWMDIE._import );
		},
	
		_export: function() {
			window.location.href = KWMDIEConfig.customizerURL + '&mailtpl-woomail-export=' + KWMDIEConfig.exportNonce;
		},
	
		_import: function() {

			// Display confirmation prompt
			var confirmation = confirm(KWMDIEl10n.confrim_override);

			// Check user input
			if ( ! confirmation ) {
				return;
			}

			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="mailtpl-woomail-form" method="POST" enctype="multipart/form-data"></form>' ),
				controls	= $( '.mailtpl-woomail-import-controls' ),
				file		= $( 'input[name=mailtpl-woomail-import-file]' ),
				message		= $( '.mailtpl-woomail-uploading' );
			
			if ( '' == file.val() ) {
				alert( KWMDIEl10n.emptyImport );
			} else {
				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();
			}
		}
	};
	
	$( KWMDIE.init );
	
})( jQuery );

( function( $ ) {
	
	var KWMDTL = {
	
		init: function() {
			$( 'input[name=mailtpl-woomail-template-button]' ).on( 'click', KWMDTL._import_template );
		},
		_import_template: function() {

			// Display confirmation prompt
			var confirmation = confirm(KWMDIEl10n.confrim_override);

			// Check user input
			if ( ! confirmation ) {
				return;
			}
			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="mailtpl-woomail-template-form" method="POST" enctype="multipart/form-data"></form>' ),
				controls	= $( '.mailtpl-template-woomail-load-controls' ),
				message		= $( '.mailtpl-woomail-loading' );
			
				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();
		}
	};
	
	$( KWMDTL.init );
	
})( jQuery );
