<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization and all hooks
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mailtpl
 * @subpackage Mailtpl/includes
 * @author     Damian Logghe <info@timersys.com>
 */
class Mailtpl {


	public $customizer;
	public $admin;
	public $mailer;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mailtpl_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Plugin Instance
	 * @since 1.0.0
	 * @var The Mailtpl plugin instance
	 */
	protected static $_instance = null;

	/**
	 * Main Mailtpl Instance
	 *
	 * Ensures only one instance of Mailtpl is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Mailtpl()
	 * @return Mailtpl - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wsi' ), '2.1' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wsi' ), '2.1' );
	}

	/**
	 * Auto-load in-accessible properties on demand.
	 * @param mixed $key
	 * @since 1.0.0
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( in_array( $key, array( 'payment_gateways', 'shipping', 'mailer', 'checkout' ) ) ) {
			return $this->$key();
		}
	}

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'mailtpl';
		$this->version = MAILTPL_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_hooks();
		do_action('mailtpl/init');
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once MAILTPL_PLUGIN_DIR . '/includes/class-mailtpl-loader.php';
		require_once MAILTPL_PLUGIN_DIR . '/includes/class-mailtpl-i18n.php';
		require_once MAILTPL_PLUGIN_DIR . '/includes/class-mailtpl-customizer.php';
		require_once MAILTPL_PLUGIN_DIR . '/includes/class-mailtpl-mailer.php';
		require_once MAILTPL_PLUGIN_DIR . '/admin/class-mailtpl-admin.php';

		$this->loader = new Mailtpl_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mailtpl_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mailtpl_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {

		$this->admin       = new Mailtpl_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->customizer  = new Mailtpl_Customizer( $this->get_plugin_name(), $this->get_version() );
		$this->mailer      = new Mailtpl_Mailer( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $this->admin, 'add_menu_link' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'wp_pointers', 1000 );
		$this->loader->add_action( 'mailtpl/admin_pointers-plugins', $this->admin, 'add_wp_pointer' );
		$this->loader->add_action( 'mailtpl/admin_pointers-dashboard', $this->admin, 'add_wp_pointer' );

		$this->loader->add_filter( 'edd_email_templates', $this->admin, 'add_edd_template' );
		$this->loader->add_action( 'edd_email_send_before', $this->admin, 'edd_get_template' );
		$this->loader->add_action( 'woocommerce_email', $this->admin, 'woocommerce_integration' );
		$this->loader->add_filter( 'woocommerce_email_settings', $this->admin, 'woocommerce_preview_link' );

		// only show in customizer if being acceded by our menu link
		if( defined( 'DOING_AJAX' ) || ( isset( $_GET['mailtpl_display'] ) && 'true' == $_GET['mailtpl_display'] ) ) {
			$this->loader->add_action( 'customize_register', $this->customizer, 'register_customize_sections' );
			$this->loader->add_action( 'customize_section_active', $this->customizer, 'remove_other_sections', 10, 2 );
			$this->loader->add_action( 'customize_panel_active', $this->customizer, 'remove_other_panels', 10, 2 );
			$this->loader->add_action( 'template_include', $this->customizer, 'capture_customizer_page', 999 );
		}

		$this->loader->add_filter( 'wp_mail', $this->mailer, 'send_email', 100 );
		$this->loader->add_action( 'wp_ajax_mailtpl_send_email', $this->mailer, 'send_test_email' );
		$this->loader->add_action( 'wp_mail_content_type', $this->mailer, 'set_content_type', 100 );
		$this->loader->add_action( 'wp_mail_from_name', $this->mailer, 'set_from_name' );
		$this->loader->add_action( 'wp_mail_from', $this->mailer, 'set_from_email');

		$this->loader->add_filter( 'mailtpl/email_content', $this->mailer, 'clean_retrieve_password' );

		$this->loader->add_filter('gform_html_message_template_pre_send_email',$this->mailer, 'gform_template');

		if( isset( $_GET['mailtpl_display'] ) ) {
			$this->loader->add_action( 'customize_controls_enqueue_scripts', $this->customizer, 'enqueue_scripts' );
			$this->loader->add_action( 'customize_preview_init', $this->customizer, 'enqueue_template_scripts', 99 );

			$this->loader->add_action( 'init', $this->admin, 'remove_all_actions', 999 );
		}
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mailtpl_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Load plugin options with defaults
	 * @return array
	 */
	public static function opts() {
		$defaults = self::defaults();
		return apply_filters( 'mailtpl/opts', wp_parse_args(get_option( 'mailtpl_opts', $defaults), $defaults ));
	}

	/**
	 * Default values of plugin
	 * @return array
	 */
	public static function defaults() {
		return apply_filters( 'mailtpl/defaults_opts', array(
			'from_name'         => get_bloginfo('name'),
			'from_email'        => get_bloginfo('admin_email'),
			'template'          => 'boxed',
			'body_bg'           => '#e3e3e3',
			'body_size'         => '680',
			'footer_text'       => '&copy;'.date('Y').' ' .get_bloginfo('name'),
			'footer_aligment'   => 'center',
			'footer_bg'         => '#eee',
			'footer_text_size'  => '12',
			'footer_text_color' => '#777',
			'footer_powered_by' => 'off',
			'header_aligment'   => 'center',
			'header_bg'         => '#454545',
			'header_text_size'  => '30',
			'header_text_color' => '#f1f1f1',
			'email_body_bg'     => '#fafafa',
			'body_text_size'    => '14',
			'body_text_color'   => '#888',
			'body_href_color'   => '#4ca6cf',
			'custom_css'        => '',
		));
	}
}
