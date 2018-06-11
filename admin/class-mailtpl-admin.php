<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp.timersys.com
 * @since      1.0.0
 *
 * @package    Mailtpl
 * @subpackage Mailtpl/admin
 * @author     Damian Logghe <info@timersys.com>
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


	/**
	 * Create the wp-admin menu link
	 */
	public function add_menu_link() {
		$link = $this->get_customizer_link();
		add_submenu_page( 'themes.php', 'Email Templates', 'Email Templates', apply_filters( 'mailtpl/roles', 'edit_theme_options'), $link , null );

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
		wp_enqueue_script( 'mailtpl-pointer', MAILTPL_PLUGIN_URL . '/admin/js/mailtpl-pointer.js', array( 'wp-pointer' ) );

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
		remove_action('woocommerce_email_footer', array($WC_Emails , 'email_footer'));
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
