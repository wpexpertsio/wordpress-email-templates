<?php

/**
 * All mail functions will go in here
 *
 * @link       https://wp.timersys.com
 * @since      1.0.0
 *
 * @package    Mailtpl
 * @subpackage Mailtpl/includes
 * @author     Damian Logghe <info@timersys.com>
 */
class Mailtpl_Mailer {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 *
	 * @var string  $template Cached version of the template
	 */
	private $template = false;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		$this->opts         = Mailtpl::opts();

	}

	/**
	 * Send html emails instead of text plain
	 * @since 1.0.0
	 * @return string
	 */
	public function set_content_type() {
		return $content_type = 'text/html';
	}

	/**
	 * Modify php mailer body with final email
	 *
	 * @since 1.0.0
	 * @param object $phpmailer
	 */
	function send_email( &$phpmailer ) {
		do_action( 'mailtpl/send_email', $phpmailer, $this );
		$message            =  $this->add_template( apply_filters( 'mailtpl/email_content', $phpmailer->Body ) );
		$user_email = $phpmailer->getToAddresses();
		$phpmailer->AltBody =  $this->replace_placeholders( strip_tags($phpmailer->Body), $user_email );
		$phpmailer->Body    =  $this->replace_placeholders( $message, $user_email );

	}

	/**
	 * Generic Compatibility functions used for Mandrill,Mailgun, etc
	 * @param $message Array
	 *
	 * @return Array
	 */
	public function send_email_generic( $message ) {
		do_action( 'mailtpl/send_email_generic', $message, $this );
		$temp_message       =  $this->add_template( apply_filters( 'mailtpl/email_content', $message['html'] ) );
		$user_email = isset( $message['to'] ) ? $message['to'] : $message;
		$message['html']    =  $this->replace_placeholders( $temp_message, $user_email );
		return $message;
	}

	/**
	 * Sengrid compatibility
	 * @param $message Array
	 *
	 * @return Array
	 */
	public function send_email_sendgrid( $message ) {
		do_action( 'mailtpl/send_email_sendgrid', $message, $this );
		$temp_message       =  $this->add_template( apply_filters( 'mailtpl/email_content', $message ) );
		$message    =  $this->replace_placeholders( $temp_message, '' );

		return $message;
	}

	/**
	 * Postman Compatibility
	 *
	 * @param $args
	 *
	 * @return Array
	 *
	 */
	public function send_email_postman( $args ) {
		if( !class_exists('Postman') )
			return $args;
		do_action( 'mailtpl/send_email_postman', $args, $this );
		$temp_message       =  $this->add_template( apply_filters( 'mailtpl/email_content', $args['message'] ) );
		$user_email = isset( $args['to'] ) ? $args['to'] : $args;
		$args['message']    =  $this->replace_placeholders( $temp_message, $user_email );
		return $args;
	}

	/**
	 * Send a test email to admin email
	 * @since 1.0.0
	 */
	public function send_test_email () {
		ob_start();
		include_once( MAILTPL_PLUGIN_DIR . '/admin/templates/partials/default-message.php');
		$message = ob_get_contents();
		ob_end_clean();
		$subject = __( 'Wp Email Templates', 'email-templates');

		echo wp_mail( get_bloginfo('admin_email'), $subject, $message);

		die();
	}

	/**
	 * Add template to plain mail
	 * @param $email string Mail to be send
	 * @since 1.0.0
	 * @return string
	 */
	private function add_template( $email ) {
		if( $this->template )
			return str_replace( '%%MAILCONTENT%%', $email, $this->template );

		do_action( 'mailtpl/add_template', $email, $this );

		$template_file = apply_filters( 'mailtpl/customizer_template', MAILTPL_PLUGIN_DIR . "/admin/templates/default.php");
		ob_start();
		include_once( $template_file );
		$this->template = ob_get_contents();
		ob_end_clean();
		return str_replace( '%%MAILCONTENT%%', $email, $this->template );
	}

	/**
	 * Replace placeholders
	 *
	 * @param $email string Mail to be send
	 *
	 * @param $user_email string Get destination email
	 * Passed to the filters in case users needs something
	 *
	 * @return string
	 */
	private function replace_placeholders( $email, $user_email = '' ) {

		$to_replace = apply_filters( 'emailtpl/placeholders', array(
			'%%BLOG_URL%%'         => get_option( 'siteurl' ),
			'%%HOME_URL%%'         => get_option( 'home' ),
			'%%BLOG_NAME%%'        => get_option( 'blogname' ),
			'%%BLOG_DESCRIPTION%%' => get_option( 'blogdescription' ),
			'%%ADMIN_EMAIL%%'      => get_option( 'admin_email' ),
			'%%DATE%%'             => date_i18n( get_option( 'date_format' ) ),
			'%%TIME%%'             => date_i18n( get_option( 'time_format' ) ),
			'%%USER_EMAIL%%'       => $user_email
		), $user_email);

		foreach ( $to_replace as $placeholder => $var ) {
			if( is_array($var) ){
				do{
					$var = reset($var);
				} while( is_array($var) );
			}
			$email = str_replace( $placeholder , $var, $email );
		}

		return $email;

	}

	/**
	 * Sets email's From email
	 * @since 1.0.0
	 * @return string
	 */
	public function set_from_email( $email ){
		if( empty( $this->opts['from_email'] ) )
			return $email;
		return $this->opts['from_email'];
	}

	/**
	 * Sets email's From name
	 * @since 1.0.0
	 * @return string
	 */
	public function set_from_name( $name ){
		if( empty( $this->opts['from_name'] ) )
			return $name;
		return $this->opts['from_name'];
	}

	/**
	 * Clear retrieve password message for wrong html tag
	 * @param $message
	 *
	 * @return mixed
	 */
	public function clean_retrieve_password( $message ) {
		return make_clickable( preg_replace( '@<(http[^> ]+)>@', '$1', $message ) );
	}

	/**
	 * This way we fully removed html added by gravity forms. Only possible on versions  2.2.1.5 or above
	 * @since 1.2.2
	 * @return string
	 */
	public function gform_template(){
		return '{message}';
	}
}
