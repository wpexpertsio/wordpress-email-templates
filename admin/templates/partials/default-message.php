<p><?php _e( 'Here you will see the email content that is normally sent in WordPress.', 'email-templates');?></p>
<p><?php _e( 'The email template is responsive an fully customizable. I hope you enjoy it!', 'email-templates');?></p>
<p><?php echo sprintf( __( 'We would like to ask you a little favour. If you are happy with the plugin and can take a minute please <a href="%s" target="_blank">leave a nice review</a> on WordPress. It will be a tremendous help for us!', 'mailtpm' ), 'https://wordpress.org/support/view/plugin-reviews/email-templates?filter=5');?></p>

<h3>Placeholders</h3>
<p><?php _e( 'You can use any of these placeholders in your emails content or templates and they will be automatically replaced', 'email-templates');?></p>
<ul>
	<li>%%BLOG_URL%%</li>
	<li>%%HOME_URL%%</li>
	<li>%%BLOG_NAME%%</li>
	<li>%%BLOG_DESCRIPTION%%</li>
	<li>%%ADMIN_EMAIL%%</li>
	<li>%%DATE%%</li>
	<li>%%TIME%%</li>
	<li>%%USER_EMAIL%% (not on sendgrid)</li>
</ul>