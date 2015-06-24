<?php

/**
 * All customizer aspects will go in here
 *
 * @link       https://wp.timersys.com
 * @since      1.0.0
 *
 * @package    Mailtpl
 * @subpackage Mailtpl/includes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mailtpl
 * @subpackage Mailtpl/admin
 * @author     Damian Logghe <info@timersys.com>
 */
class Mailtpl_Customizer {

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


	public function register_customize_sections( $wp_customize ){

		$wp_customize->add_panel( 'mailtpl', array(
			'title' => __( 'Email Templates', $this->plugin_name ),
		) );

		$this->template_section( $wp_customize );
		$this->footer_section( $wp_customize );

		do_action('mailtpl/customize_sections', $wp_customize );

	}

	/**
	 * Remover other panels and sections
	 * @param $active
	 * @param $section
	 *
	 * @return bool
	 */
	public function remove_other_sections( $active, $section ) {
		if ( isset( $_GET['mailtpl_display'] ) ) {
			if ( in_array( $section->id, array( 'section_mailtpl_footer', 'section_mailtpl_template' ) ) ) {
				return true;
			}
			return false;
		}
		return true;
	}

	/**
	 * Here we capture the page and show template acordingly
	 * @param $template
	 *
	 * @return string
	 */
	public function capture_customizer_page( $template ){

		if( is_customize_preview() && isset( $_GET['mailtpl_display'] ) && 'true' == $_GET['mailtpl_display'] ){
			return dirname(__FILE__) . "/templates/simple.php";
		}
		return $template;
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'mailtpl-js', plugin_dir_url( dirname(__FILE__) ) . 'admin/js/mailtpl-admin.js', '', $this->version, false );
		wp_localize_script( 'mailtpl-js', 'mailtpl',
			array(
				'focus' => 'mailtpl_template', // id de un control
			)
		);
	}

	/**
	 * Enqueue scripts for preview area
	 * @since 1.0.0
	 */
	public function enqueue_template_scripts(){
		wp_enqueue_script( 'mailtpl-front-js', plugin_dir_url( dirname(__FILE__) ) . 'admin/js/mailtpl-public.js', array(  'jquery', 'customize-preview' ), $this->version, true );
	}

	/**
	 * Template Section
	 * @param $wp_customize instance
	 */
	private function template_section($wp_customize) {

		$wp_customize->add_section( 'section_mailtpl_template', array(
			'title' => __( 'Template', $this->plugin_name ),
			'panel' => 'mailtpl',
		) );
		$wp_customize->add_setting( 'mailtpl_opts[template]', array(
			'type' => 'option',
			'default' => 'simple',
			'transport' => 'postMessage',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => '',
			'sanitize_js_callback' => '',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
			'mailtpl_template', array(
				'label' => __( 'Choose one', $this->plugin_name ),
				'type' => 'select',
				'section' => 'section_mailtpl_template',
				'settings' => 'mailtpl_opts[template]',
				'choices'  => array('simple' => 'Simple Theme')
			)
		) );
	}

	/**
	 * Footer section
	 *
	 * @param $wp_customize instance
	 */
	private function footer_section($wp_customize) {
		$wp_customize->add_section( 'section_mailtpl_footer', array(
			'title' => __( 'Footer', $this->plugin_name ),
			'panel' => 'mailtpl',
		) );
		$wp_customize->add_setting( 'mailtpl_opts[footer]', array(
			'type' => 'option',
			'default' => 'Footer',
			'transport' => 'postMessage',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => '',
			'sanitize_js_callback' => '',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
			'mailtpl_footer', array(
				'label' => __( 'Choose one', $this->plugin_name ),
				'type' => 'test',
				'section' => 'section_mailtpl_footer',
				'settings' => 'mailtpl_opts[footer]',
			)
		) );
	}

}
