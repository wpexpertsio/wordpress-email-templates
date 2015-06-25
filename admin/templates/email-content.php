<?php
if( is_customize_preview() ) {
?>
<p><?php _e( 'Here you will see the email content that is normally sent in WordPress.', 'mailtpl');?></p>
<p><?php _e( 'The email template is responsive an fully customizable. I hope you enjoy it!', 'mailtpl');?></p>
<p><?php echo sprintf( __( 'We would like to ask you a little favour. If you are happy with the plugin and can take a minute please <a href="%s" target="_blank">leave a nice review</a> on WordPress. It will be a tremendous help for us!', 'mailtpm' ), 'https://wordpress.org/support/view/plugin-reviews/popups?filter=5');?></p><?php
} else {
	echo '%%MAILCONTENT%%';
}