<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp.timersys.com
 * @since      1.0.0
 *
 * @package    Mailtpl
 * @subpackage Mailtpl/admin
 * @author     wpexperts
 */
class Mailtpl_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	public function email_template() {
		$link = $this->get_customizer_link();
		?>
		<style>
		.emailtemplate .container{
			display: flex;
		}
		.emailtemplate .col-md-6 .boxcustom {
			background-color: white;
			margin-right: 20px;
			padding: 10px;
			border-radius: 4px;
			border: solid #d1d1ff 1px;
			transition: box-shadow 0.6s ease-in-out;
			-webkit-box-shadow: 2px 3px 9px -2px rgb(126 126 126 / 75%);
			-moz-box-shadow: 2px 3px 9px -2px rgb(126 126 126 / 75%);
			box-shadow: 2px 3px 9px -2px rgb(126 126 126 / 75%);
			text-align: center;
		}
		.emailtemplate button {
		    margin-top: 15px;
			width: 97%;
		    height: 45px;
			margin-top: 15px;
		    width: 97%;
		    height: 45px;
		    border-radius: 7px;
		    color: white;
		    font-weight: 600;
		    font-size: 18px;
		    transition: box-shadow 0.6s ease-in-out;
		    -webkit-box-shadow: 7px 7px 4px -4px rgb(122 122 122 / 75%);
		    -moz-box-shadow: 7px 7px 4px -4px rgb(122 122 122 / 75%);
		    box-shadow: 7px 7px 4px -4px rgb(122 122 122 / 75%);
		}
		.emailtemplate button.wordpress-btn {
		    background-color: #0073aa;
			border: solid #6c6c6c 1px;
		}
		.emailtemplate button.woocommerce-btn {
		    background-color: #8053b4;
			border: solid #6c6c6c 1px;
		}
		.boxcustom img {
		    max-width: 100%;
		}
		.emailtemplate h2 {
		    text-align: center;
		    font-weight: 300;
		    font-size: 23px;
		    line-height: 46px;
		    margin-top: 0px;
		}
		.headdingemailtemplate {
			text-align: center;
			margin-top: -10px;
			margin-bottom: 8px;
		}
		.headdingemailtemplate img {
			vertical-align:middle;
			max-width: 78px;
		}
		.emailtemplate .col-md-6:hover .boxcustom {
			transition: box-shadow 0.6s ease-in-out;
			box-shadow: 5px 3px 13px 0px rgb(126 126 126 / 75%);
		}
		.emailtemplate .col-md-6:hover button {
			transition: box-shadow 0.6s ease-in-out;
			box-shadow: 6px 5px 7px -1px rgb(126 126 126 / 75%);
		}
		</style>
		
		<div class="wrap emailtemplate">
			<div class="headdingemailtemplate">
				<h1>
				<img src="<?php echo esc_attr( MAILTPL_WOOMAIL_URL . 'assets/images/icon-128x128.png' ) ?>">
				Email Templates
				</h1>
			</div>
			<div class="container">
				<div class="col-md-6">
					<div class="boxcustom">
						<img src="<?php echo esc_attr( MAILTPL_WOOMAIL_URL . 'assets/images/WooCommerce-wordpress-02.png' ) ?>">
						<h2 style="border-bottom: solid #54b0d1 1px;">WordPress Email Templates</h2>
						<p>Live preview your WordPress emails.</p>
						<p>Customize emails to match your brand colors.</p>
						<p>Customize heading, subtitle, and body text.</p>
						<p>Design and send custom-built emails with WordPress Email Templates.</p>
						<p>Choose your template style, add a logo or some text, change colors, edit footer and start sending nice emails in WordPress.</p>
					</div>
					<a target="_blank" href="<?php echo $link; ?>"> 
						<button class="wordpress-btn">Open WordPress Email Editor</button>
					</a>
				</div>
				<div class="col-md-6">
					<div class="boxcustom">
						<img src="<?php echo esc_attr( MAILTPL_WOOMAIL_URL . 'assets/images/WooCommerce-wordpress-01.png' ) ?>">
						<h2 style="border-bottom: solid #7f54b3 1px;">WooCommerce Email Templates</h2>
						<p>Customize the default transactional emails.</p>
						<p>Live preview your WooCommerce emails.</p>
						<p>Export and import your plugin settings.</p>
						<p>Design and customize WooCommerce's default transactional email templates.</p>
						<p>Use WordPress's native customizer for visual edits and customize the text (including body text) in WooCommerce without editing code.</p>
					</div>
					<a target="_blank" href="customize.php?mailtpl-woomail-customize=1&url=<?php echo urlencode( add_query_arg( array( 'mailtpl-woomail-preview' => '1' ), home_url( '/' ) ) ); ?>" > 
						<button class="woocommerce-btn">Open Woocommerce Email Editor</button>
					</a>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Create the wp-admin menu link
	 */
	public function add_menu_link() { 
	
		add_menu_page(
			esc_html__( 'Email Templates', 'mailtpl-woocommerce-email-composer' ),
			esc_html__( 'Email Templates', 'mailtpl-woocommerce-email-composer' ),
			'manage_woocommerce',
			'email-Template',
			array( $this,'email_template' ),
			'dashicons-email',
			52
		);
	}
	/**
	 * If we are in our template strip everything out and leave it clean
	 * @since 1.0.0
	 */
	public function remove_all_actions(){
		global $wp_scripts, $wp_styles;

		$exceptions = array(
			'mailtpl-js',
			'jquery',
			'query-monitor',
			'mailtpl-front-js',
			'customize-preview',
			'customize-controls',
		);
		
		if ( is_object( $wp_scripts ) && isset( $wp_scripts->queue ) && is_array( $wp_scripts->queue ) ) {
			foreach( $wp_scripts->queue as $handle ){
				if( in_array($handle, $exceptions))
					continue;
				wp_dequeue_script($handle);
			}
		}

		if ( is_object( $wp_styles ) && isset( $wp_styles->queue ) && is_array( $wp_styles->queue ) ) {
			foreach( $wp_styles->queue as $handle ){
				if( in_array($handle, $exceptions) )
					continue;
				wp_dequeue_style($handle);
			}
		}

		// Now remove actions
		$action_exceptions = array(
			'wp_print_footer_scripts',
			'wp_admin_bar_render',
		);

		// No core action in header
		remove_all_actions('wp_header');

		global $wp_filter;
		foreach( $wp_filter['wp_footer'] as $priority => $handle ){
			if( in_array( key($handle), $action_exceptions ) )
				continue;
			unset( $wp_filter['wp_footer'][$priority] );
		}
	}

	/**
	 * Function that handle all the wp pointers logic and enqueue files
	 * @since 1.0.1
	 */
	public function wp_pointers() {

		$screen = get_current_screen();
		$screen_id = $screen->id;

		// Get pointers for this screen
		$pointers = apply_filters( 'mailtpl/admin_pointers-' . $screen_id, array() );

		if ( ! $pointers || ! is_array( $pointers ) )
			return;

		// Get dismissed pointers
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
		$valid_pointers = array();

		// Check pointers and remove dismissed ones.
		foreach ( $pointers as $pointer_id => $pointer ) {

			// Sanity check
			if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
				continue;

			$pointer['pointer_id'] = $pointer_id;

			// Add the pointer to $valid_pointers array
			$valid_pointers['pointers'][] =  $pointer;
		}

		// No valid pointers? Stop here.
		if ( empty( $valid_pointers ) )
			return;

		// Add pointers style to queue.
		wp_enqueue_style( 'wp-pointer' );

		// Add pointers script to queue. Add custom script.
		wp_enqueue_script( 'mailtpl-pointer', MAILTPL_WOOMAIL_URL . '/admin/js/mailtpl-pointer.js', array( 'wp-pointer' ) );

		// Add pointer options to script.
		wp_localize_script( 'mailtpl-pointer', 'mailtpl_pointer', $valid_pointers );
	}

	/**
	 * Register our pointers
	 * @param $pointers Array
	 *
	 * @return mixed
	 */
	function add_wp_pointer( $pointers ) {
		$pointers['mailtpl_welcome'] = array(
			'target' => '#menu-appearance',
			'options' => array(
				'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
					__( 'Email Templates', 'email-templates'),
					__( 'Now you can edit your email template right in the Appearance menu', 'email-templates')
				),
				'position' => array( 'edge' => 'top', 'align' => 'middle' )
			)
		);
		return $pointers;
	}

	/**
	 * Add our template to Easy Digital Downloads
	 * @param $templates
	 */
	function add_edd_template( $templates ) {
		$templates['mailtpl'] = 'Email Template Plugin';
		return $templates;
	}

	/**
	 * We need to hook into edd_email_send_before to change get_template to 'none' before it sends so we don't loose formatting
	 * @return void
	 */
	function edd_get_template() {
		add_filter('edd_email_template', array( $this, 'set_edd_template'));
	}

	/**
	 * We change edd_template as we are using an html template to avoid all the get_template_parts that are taken care now by our plugin
	 * @return string
	 */
	function set_edd_template(){
		return 'none';
	}

	/**
	 * WooCommerce Integration.
	 * We first remove our autoformatting as woocommerce will also add it
	 * Then we remove their template header and footer to use ours
	 * @param $WC_Emails Instace on WC_Emails class
	 */
	function woocommerce_integration( $WC_Emails ) {
		remove_filter( 'mailtpl/email_content', 'wptexturize' );
		remove_filter( 'mailtpl/email_content', 'convert_chars' );
		remove_filter( 'mailtpl/email_content', 'wpautop' );
		remove_action('woocommerce_email_header', array($WC_Emails , 'email_header'));
		//remove_action('woocommerce_email_footer', array($WC_Emails , 'email_footer'));
	}


	function woocommerce_preview_link( $settings ) {
		for( $i = 0; $i < sizeof( $settings ); $i++ ) {
			if( isset( $settings[ $i ]['id'] ) && 'email_template_options' == $settings[ $i ]['id'] ) {
				$settings[ $i ]['desc'] = sprintf(__( 'This section lets you customize the WooCommerce emails. <a href="%s" target="_blank">Click here to preview your email template</a>.', 'woocommerce' ), $this->get_customizer_link() );
			}
		}
		return $settings;
	}

	/**
	 * Simple function to generate link for customizer
	 * @return string
	 */
	private function get_customizer_link() {
		$link = add_query_arg(
			array(
				'url'             => urlencode( site_url( '/?mailtpl_display=true' ) ),
				'return'          => urlencode( admin_url() ),
				'mailtpl_display' => 'true'
			),
			'customize.php'
		);

		return $link;
	}
}
