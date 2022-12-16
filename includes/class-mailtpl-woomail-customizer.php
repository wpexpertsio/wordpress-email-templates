<?php
/**
 * Customizer class.
 *
 * @package Mailtpl WooCommerce Email Composer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Setup
 *  Heavily borrowed from rightpress Decorator
 */
if ( ! class_exists( 'Mailtpl_Woomail_Customizer' ) ) {

	class Mailtpl_Woomail_Customizer {
		// Properties
		private static $panels_added    = array();
		private static $sections_added  = array();
		private static $css_suffixes    = null;
		public static $customizer_url  = null;

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Instance Control
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Add support for third party emails.
			add_action( 'init', array( $this, 'add_third_party_emails' ), 5 );

			// Add settings.
			add_action( 'customize_register', array( $this, 'add_settings' ) );

			// Maybe add custom styles to default WooCommerce styles.
			add_filter( 'woocommerce_email_styles', array( $this, 'maybe_add_custom_styles' ), 99 );

			// Ajax handler.
			add_action( 'wp_ajax_mailtpl_woomail_reset', array( $this, 'ajax_reset' ) );

			// Ajax handler.
			add_action( 'wp_ajax_mailtpl_woomail_send_email', array( $this, 'ajax_send_email' ) );

			// Only proceed if this is own request.
			if ( ! Mailtpl_Woomail_Composer::is_own_customizer_request() && ! Mailtpl_Woomail_Composer::is_own_preview_request() ) {
				return;
			}

			// Add controls, sections and panels.
			add_action( 'customize_register', array( $this, 'add_controls' ) );

			// Add user capability.
			add_filter( 'user_has_cap', array( $this, 'add_customize_capability' ), 99 );

			// Remove unrelated components.
			add_filter( 'customize_loaded_components', array( $this, 'remove_unrelated_components' ), 99, 2 );

			// Remove unrelated sections.
			add_filter( 'customize_section_active', array( $this, 'remove_unrelated_sections' ), 99, 2 );

			// Remove unrelated controls.
			add_filter( 'customize_control_active', array( $this, 'remove_unrelated_controls' ), 99, 2 );

			// Enqueue Customizer scripts.
			add_filter( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_scripts' ) );

			// Changes the publish text to save.
			add_filter( 'gettext', array( $this, 'change_publish_button' ), 10, 2 );

			// This filters in woocommerce edits that are not saved while the preview refreshes.
			add_action( 'init', array( $this, 'get_customizer_options_override_ready' ) );

			// WP-Multilang.
			add_filter( 'wpm_customizer_url', array( $this, 'force_fix_wp_multilang' ), 10 );

			// Unhook divi front end.
			add_action( 'woomail_footer', array( $this, 'unhook_divi' ), 10 );

			// Unhook LifterLMS front end.
			add_action( 'woomail_footer', array( $this, 'unhook_lifter' ), 10 );

			// Unhook Flatsome js.
			add_action( 'customize_preview_init', array( $this, 'unhook_flatsome' ), 50 );

		}
		/**
		 * Add Emails into the previewer.
		 */
		public function add_third_party_emails() {
			/**
				Looking for Structure that looks like this:
				array(
					'email_type' => 'email_example_slug',
					'email_name' => 'Email Example',
					'email_class' => 'Custom_WC_Email_Extend',
					'email_heading' => __( 'Placeholder for Heading', 'plugin' ),
				);
			*/
			$add_email_previews = apply_filters( 'mailtpl_woocommerce_email_previews', array() );
			if ( ! empty( $add_email_previews ) && is_array( $add_email_previews ) ) {
				foreach ( $add_email_previews as $email_item ) {
					if ( isset( $email_item['email_type'] ) && ! empty( $email_item['email_type'] ) && isset( $email_item['email_name'] ) && ! empty( $email_item['email_name'] ) ) {
						add_filter(
							'mailtpl_woomail_email_types',
							function( $types ) use ( $email_item ) {
								$types[ $email_item['email_type'] ] = $email_item['email_name'];
								return $types;
							}
						);
					}
					if ( isset( $email_item['email_type'] ) && ! empty( $email_item['email_type'] ) && isset( $email_item['email_class'] ) && ! empty( $email_item['email_class'] ) ) {
						add_filter(
							'mailtpl_woomail_email_type_class_name_array',
							function( $types ) use ( $email_item ) {
								$types[ $email_item['email_type'] ] = $email_item['email_class'];
								return $types;
							}
						);
					}
					if ( isset( $email_item['email_type'] ) && ! empty( $email_item['email_type'] ) && isset( $email_item['email_heading'] ) && ! empty( $email_item['email_heading'] ) ) {
						add_filter(
							'mailtpl_woomail_email_settings_default_values',
							function( $placeholders ) use ( $email_item ) {
								$placeholders[ $email_item['email_type'] . '_heading' ] = $email_item['email_heading'];
								return $placeholders;
							}
						);
					}
				}
			}
		}

		/*
		 * Unhook Divi front end.
		 *
		 * @param string $url the customizer url.
		 */
		public function force_fix_wp_multilang( $url ) {
			return add_query_arg( array( 'mailtpl-woomail-preview' => '1' ), home_url( '/' ) );
		}
		/*
		 * Unhook flatsome front end.
		 */
		public function unhook_flatsome() {
			// Unhook flatsome issue.
			wp_dequeue_style( 'flatsome-customizer-preview' );
			wp_dequeue_script( 'flatsome-customizer-frontend-js' );
		}
		/*
		 * Unhook lifter front end.
		 */
		public function unhook_lifter() {
			// Unhook LLMs issue.
			wp_dequeue_script( 'llms' );
		}
		/*
		 * Unhook Divi front end.
		 */
		public function unhook_divi() {
			// Divi Theme issue.
			remove_action( 'wp_footer', 'et_builder_get_modules_js_data' );
			remove_action( 'et_customizer_footer_preview', 'et_load_social_icons' );
		}
		public function get_customizer_options_override_ready() {
			foreach ( Mailtpl_Woomail_Settings::get_email_types() as $key => $value ) {
				add_filter( 'option_woocommerce_' . $key . '_settings', array( $this, 'customizer_woo_options_override' ), 99, 2 );
			}
		}
		public function customizer_woo_options_override( $value = array(), $option = '' ) {
			if ( isset( $_POST['customized'] ) ) {
				$post_values = json_decode( stripslashes_deep( $_POST['customized'] ), true );
				if ( isset( $_POST['customized'] ) && ! empty( $post_values ) ) {
					if ( is_array( $post_values ) ) {
						foreach ( $post_values as $key => $current_value ) {
							if ( strpos( $key, $option ) !== false ) {
								$subkey = str_replace( $option, '', $key );
								$subkey = str_replace( '[', '', rtrim( $subkey, ']' ) );
								$value[ $subkey ] = $current_value;
							}
						}
					}
				}
			}
			return $value;
		}

		public function change_publish_button( $translation, $text ) {

			if ( $text == 'Publish' ) {
				return __( 'Save', 'mailtpl-woocommerce-email-composer' );
			} else if ( $text == 'Published' ) {
				return __( 'Saved', 'mailtpl-woocommerce-email-composer' );
			}

			return $translation;
		}

		/**
		 * Add customizer capability
		 *
		 * @access public
		 * @param array $capabilities
		 * @return array
		 */
		public function add_customize_capability( $capabilities ) {
			// Remove filter (circular reference)
			remove_filter( 'user_has_cap', array( $this, 'add_customize_capability' ), 99 );

			// Add customize capability for admin user if this is own customizer request
			if ( Mailtpl_Woomail_Composer::is_admin() && Mailtpl_Woomail_Composer::is_own_customizer_request() ) {
				$capabilities['customize'] = true;
			}

			// Add filter
			add_filter( 'user_has_cap', array( $this, 'add_customize_capability' ), 99 );

			// Return capabilities
			return $capabilities;
		}

		/**
		 * Get Customizer URL
		 */
		public static function get_customizer_url() {
			if ( is_null( self::$customizer_url ) ) {
				self::$customizer_url = add_query_arg(
					array(
						'mailtpl-woomail-customize' => '1',
						'url'                  => urlencode( add_query_arg( array( 'mailtpl-woomail-preview' => '1' ), home_url( '/' ) ) ),
						'return'               => urlencode( Mailtpl_Woomail_Woo::get_email_settings_page_url() ),
					),
					admin_url( 'customize.php' )
				);
			}

			return self::$customizer_url;
		}

		/**
		 * Change site name for customizer
		 *
		 * @access public
		 * @param string $name
		 * @return string
		 */
		public function change_site_name( $name ) {
			return __( 'WooCommerce Emails', 'mailtpl-woocommerce-email-composer' );
		}

		/**
		 * Remove unrelated components
		 *
		 * @access public
		 * @param array  $components
		 * @param object $wp_customize
		 * @return array
		 */
		public function remove_unrelated_components( $components, $wp_customize ) {
			// Iterate over components
			foreach ( $components as $component_key => $component ) {

				// Check if current component is own component
				if ( ! self::is_own_component( $component ) ) {
					unset( $components[ $component_key ] );
				}
			}

			// Return remaining components
			return $components;
		}

		/**
		 * Remove unrelated sections
		 *
		 * @access public
		 * @param bool   $active
		 * @param object $section
		 * @return bool
		 */
		public function remove_unrelated_sections( $active, $section ) {
			// Check if current section is own section
			if ( ! self::is_own_section( $section->id ) ) {
				return false;
			}

			// We can override $active completely since this runs only on own Customizer requests
			return true;
		}

		/**
		 * Remove unrelated controls
		 *
		 * @access public
		 * @param bool   $active
		 * @param object $control
		 * @return bool
		 */
		public function remove_unrelated_controls( $active, $control ) {
			// Check if current control belongs to own section
			if ( ! self::is_own_section( $control->section ) ) {
				return false;
			}

			// We can override $active completely since this runs only on own Customizer requests
			return $active;
		}

		/**
		 * Check if current component is own component
		 *
		 * @access public
		 * @param string $component
		 * @return bool
		 */
		public static function is_own_component( $component ) {
			return false;
		}

		/**
		 * Check if current section is own section
		 *
		 * @access public
		 * @param string $key
		 * @return bool
		 */
		public static function is_own_section( $key ) {
			// Iterate over own sections
			foreach ( Mailtpl_Woomail_Settings::get_sections() as $section_key => $section ) {
				if ( $key === 'mailtpl_woomail_' . $section_key ) {
					return true;
				}
			}

			// Section not found
			return false;
		}

		/**
		 * Enqueue Customizer scripts
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_customizer_scripts() {
			// Enqueue Customizer script
			wp_enqueue_style( 'mailtpl-woomail-customizer-styles', MAILTPL_WOOMAIL_URL . '/assets/css/customizer-styles.css', MAILTPL_VERSION );
			wp_enqueue_script( 'mailtpl-woomail-customizer-scripts', MAILTPL_WOOMAIL_URL . '/assets/js/customizer-scripts.js', array( 'jquery', 'customize-controls' ), MAILTPL_VERSION, true );

			// Send variables to Javascript
			wp_localize_script(
				'mailtpl-woomail-customizer-scripts',
				'mailtpl_woomail',
				array(
					'ajax_url'             => admin_url( 'admin-ajax.php' ),
					'customizer_url'       => self::get_customizer_url(),
					'responsive_mode'       => self::opt( 'responsive_mode' ),
					'labels'                => array(
						'reset'                 => __( 'Reset', 'mailtpl-woocommerce-email-composer' ),
						'customtitle'           => __( 'Woocommerce Emails', 'mailtpl-woocommerce-email-composer' ),
						'send_confirmation'     => __( 'Are you sure you want to send an email?', 'mailtpl-woocommerce-email-composer' ),
						'sent'                  => __( 'Email Sent!', 'mailtpl-woocommerce-email-composer' ),
						'failed'                => __( 'Email failed, make sure you have a working email server for your site.', 'mailtpl-woocommerce-email-composer' ),
						'reset_confirmation'    => __( 'Are you sure you want to reset all changes made to your WooCommerce emails?', 'mailtpl-woocommerce-email-composer' ),
					),
				)
			);
			// Localize
			wp_localize_script(
				'mailtpl-woomail-customizer-scripts',
				'KWMDIEl10n',
				array(
					'emptyImport'   => __( 'Please choose a file to import.', 'customizer-export-import' ),
					'confrim_override'  => __( 'WARNING: This will override all of your current settings. Are you sure you want to do that? We suggest geting an export of your current settings incase you want to revert back.', 'customizer-export-import' ),
				)
			);

			// Config
			wp_localize_script(
				'mailtpl-woomail-customizer-scripts',
				'KWMDIEConfig',
				array(
					'customizerURL'   => admin_url( 'customize.php?mailtpl-woomail-customize=1&url=' . urlencode( add_query_arg( array( 'mailtpl-woomail-preview' => '1' ), site_url( '/' ) ) ) ),
					'exportNonce'     => wp_create_nonce( 'mailtpl-woomail-exporting' ),
				)
			);
		}

		/**
		 * Add settings
		 *
		 * @access public
		 * @param object $wp_customize
		 * @return void
		 */
		public function add_settings( $wp_customize ) {
			// Iterate over settings
			foreach ( Mailtpl_Woomail_Settings::get_settings() as $setting_key => $setting ) {

				// Add setting
				$wp_customize->add_setting(
					'mailtpl_woomail[' . $setting_key . ']',
					array(
						'type'          => 'option',
						'transport'     => isset( $setting['transport'] ) ? $setting['transport'] : 'postMessage',
						'capability'    => Mailtpl_Woomail_Composer::get_admin_capability(),
						'default'       => isset( $setting['default'] ) ? $setting['default'] : '',
						'sanitize_callback' => isset( $settings['sanitize_callback'] ) ? array(
							'WP_Customize_' . $setting['control_type'] . 'Control',
							$settings['sanitize_callback'],
						) : '',
					)
				);
			}
			// Iterate over settings
			foreach ( Mailtpl_Woomail_Settings::get_woo_settings() as $setting_key => $setting ) {
				 // Add setting
				$wp_customize->add_setting(
					$setting_key,
					array(
						'type'          => 'option',
						'transport'     => isset( $setting['transport'] ) ? $setting['transport'] : 'postMessage',
						'capability'    => Mailtpl_Woomail_Composer::get_admin_capability(),
						'default'       => isset( $setting['default'] ) ? $setting['default'] : '',
					)
				);
			}
		}

		/**
		 * Add controls, sections and panels
		 *
		 * @access public
		 * @param object $wp_customize
		 * @return void
		 */
		public function add_controls( $wp_customize ) {
			// Iterate over settings
			foreach ( Mailtpl_Woomail_Settings::get_settings() as $setting_key => $setting ) {

				// Maybe add section
				self::maybe_add_section( $wp_customize, $setting );

				// Maybe add panel
				self::maybe_add_panel( $wp_customize, $setting );

				// Get control class name (none, color, upload, image)
				$control_class = isset( $setting['control_type'] ) ? ucfirst( $setting['control_type'] ) . '_' : '';
				$control_class = 'WP_Customize_' . $control_class . 'Control';
				// Control configuration
				$control_config = array(
					'label'             => $setting['title'],
					'settings'          => 'mailtpl_woomail[' . $setting_key . ']',
					'capability'        => Mailtpl_Woomail_Composer::get_admin_capability(),
					'priority'          => isset( $setting['priority'] ) ? $setting['priority'] : 10,
					'active_callback'   => ( isset( $setting['active_callback'] ) ) ? array(
						'Mailtpl_Woomail_Customizer',
						'active_callback',
					) : '__return_true',
				);

				// Description
				if ( ! empty( $setting['description'] ) ) {
					$control_config['description'] = $setting['description'];
				}

				// Add control to section
				if ( ! empty( $setting['section'] ) ) {
					$control_config['section'] = 'mailtpl_woomail_' . $setting['section'];
				}

				// Add control to panel
				if ( ! empty( $setting['panel'] ) ) {
					$control_config['panel'] = 'mailtpl_woomail_' . $setting['panel'];
				}

				// Add custom field type
				if ( ! empty( $setting['type'] ) ) {
					$control_config['type'] = $setting['type'];
				}

				// Add select field options
				if ( ! empty( $setting['choices'] ) ) {
					$control_config['choices'] = $setting['choices'];
				}
				// Input attributese
				if ( ! empty( $setting['input_attrs'] ) ) {
					$control_config['input_attrs'] = $setting['input_attrs'];
				}
				// Add repeater controls:
				if ( ! empty( $setting['customizer_repeater_image_control'] ) ) {
					$control_config['customizer_repeater_image_control'] = $setting['customizer_repeater_image_control'];
				}
				if ( ! empty( $setting['customizer_repeater_icon_control'] ) ) {
					$control_config['customizer_repeater_icon_control'] = $setting['customizer_repeater_icon_control'];
				}
				if ( ! empty( $setting['customizer_repeater_icon_color'] ) ) {
					$control_config['customizer_repeater_icon_color'] = $setting['customizer_repeater_icon_color'];
				}
				if ( ! empty( $setting['customizer_repeater_title_control'] ) ) {
					$control_config['customizer_repeater_title_control'] = $setting['customizer_repeater_title_control'];
				}
				if ( ! empty( $setting['customizer_repeater_link_control'] ) ) {
					$control_config['customizer_repeater_link_control'] = $setting['customizer_repeater_link_control'];
				}
				// Add control
				$wp_customize->add_control( new $control_class( $wp_customize, 'mailtpl_woomail_' . $setting_key, $control_config ) );
			}
			// Iterate over settings
			foreach ( Mailtpl_Woomail_Settings::get_woo_settings() as $setting_key => $setting ) {

				// Maybe add section
				self::maybe_add_section( $wp_customize, $setting );

				// Maybe add panel
				self::maybe_add_panel( $wp_customize, $setting );

				// Get control class name (none, color, upload, image)
				$control_class = isset( $setting['control_type'] ) ? ucfirst( $setting['control_type'] ) . '_' : '';
				$control_class = 'WP_Customize_' . $control_class . 'Control';

				// Control configuration
				$control_config = array(
					'label'             => $setting['title'],
					'settings'          => $setting_key,
					'capability'        => Mailtpl_Woomail_Composer::get_admin_capability(),
					'priority'          => isset( $setting['priority'] ) ? $setting['priority'] : 10,
					'active_callback'   => ( isset( $setting['active_callback'] ) ) ? array(
						'Mailtpl_Woomail_Customizer',
						'active_woo_callback',
					) : '__return_true',
				);

				// Description
				if ( ! empty( $setting['description'] ) ) {
					$control_config['description'] = $setting['description'];
				}

				// Add control to section
				if ( ! empty( $setting['section'] ) ) {
					$control_config['section'] = 'mailtpl_woomail_' . $setting['section'];
				}

				// Add control to panel
				if ( ! empty( $setting['panel'] ) ) {
					$control_config['panel'] = 'mailtpl_woomail_' . $setting['panel'];
				}
				// Add custom field type
				if ( ! empty( $setting['type'] ) ) {
					$control_config['type'] = $setting['type'];
				}
				// Add custom field type
				if ( ! empty( $setting['label'] ) ) {
					$control_config['label'] = $setting['label'];
				}

				// Add select field options
				if ( ! empty( $setting['choices'] ) ) {
					$control_config['choices'] = $setting['choices'];
				}
				// Input attributese
				if ( ! empty( $setting['input_attrs'] ) ) {
					$control_config['input_attrs'] = $setting['input_attrs'];
				}
				// Add control
				$wp_customize->add_control( new $control_class( $wp_customize, $setting_key, $control_config ) );
			}
		}
		public static function active_callback( $object ) {
			if ( ! isset( $object->setting->id ) ) {
				return true;
			}
			$opt_name       = explode( '[', $object->setting->id );
			$opt_name       = $opt_name[0];
			$id = str_replace( $opt_name . '[', '', str_replace( ']', '', $object->setting->id ) );

			$settings = Mailtpl_Woomail_Settings::get_settings();

			if ( ! isset( $settings[ $id ] ) ) {
				return true;
			}
			$field_id = $settings[ $id ]['active_callback']['id'];
			$compare = $settings[ $id ]['active_callback']['compare'];
			$value = $settings[ $id ]['active_callback']['value'];
			$field_value = self::opt( $field_id );
			switch ( $compare ) {
				case '==':
				case '=':
				case 'equals':
				case 'equal':
					$show = ( $field_value == $value ) ? true : false;
					break;

				case '!=':
				case 'not equal':
					$show = ( $field_value != $value ) ? true : false;
					break;
			}
			return $show;
		}
		public static function active_woo_callback( $object ) {
			if ( ! isset( $object->setting->id ) ) {
				return true;
			}
			$id = $object->setting->id;

			$settings = Mailtpl_Woomail_Settings::get_woo_settings();

			if ( ! isset( $settings[ $id ] ) ) {
				return true;
			}
			$field_id = $settings[ $id ]['active_callback']['id'];
			$compare = $settings[ $id ]['active_callback']['compare'];
			$value = $settings[ $id ]['active_callback']['value'];
			$field_value = self::opt( $field_id );
			switch ( $compare ) {
				case '==':
				case '=':
				case 'equals':
				case 'equal':
					$show = ( $field_value == $value ) ? true : false;
					break;

				case '!=':
				case 'not equal':
					$show = ( $field_value != $value ) ? true : false;
					break;
			}
			return $show;
		}
		/**
		 * Maybe add section
		 *
		 * @access public
		 * @param object $wp_customize
		 * @param array  $child
		 * @return void
		 */
		public static function maybe_add_section( $wp_customize, $child ) {
			// Get sections
			$sections = Mailtpl_Woomail_Settings::get_sections();

			// Check if section is set and exists
			if ( ! empty( $child['section'] ) && isset( $sections[ $child['section'] ] ) ) {

				// Reference current section key
				$section_key = $child['section'];

				// Check if section was not added yet
				if ( ! in_array( $section_key, self::$sections_added, true ) ) {

					// Reference current section
					$section = $sections[ $section_key ];

					// Section config
					$section_config = array(
						'title'     => $section['title'],
						'priority'  => ( isset( $section['priority'] ) ? $section['priority'] : 10 ),
					);

					// Description
					if ( ! empty( $section['description'] ) ) {
						$section_config['description'] = $section['description'];
					}

					// Maybe add panel
					self::maybe_add_panel( $wp_customize, $section );

					// Maybe add section to panel
					if ( ! empty( $section['panel'] ) ) {
						$section_config['panel'] = 'mailtpl_woomail_' . $section['panel'];
					}

					// Register section
					$wp_customize->add_section( 'mailtpl_woomail_' . $section_key, $section_config );

					// Track which sections were added
					self::$sections_added[] = $section_key;
				}
			}
		}

		/**
		 * Maybe add panel
		 *
		 * @access public
		 * @param object $wp_customize
		 * @param array  $child
		 * @return void
		 */
		public static function maybe_add_panel( $wp_customize, $child ) {
			// Get panels
			$panels = Mailtpl_Woomail_Settings::get_panels();
			// Check if panel is set and exists
			if ( ! empty( $child['panel'] ) && isset( $panels[ $child['panel'] ] ) ) {

				// Reference current panel key
				$panel_key = $child['panel'];

				// Check if panel was not added yet
				if ( ! in_array( $panel_key, self::$panels_added, true ) ) {

					// Reference current panel
					$panel = $panels[ $panel_key ];

					// Panel config
					$panel_config = array(
						'title'         => $panel['title'],
						'priority'      => ( isset( $panel['priority'] ) ? $panel['priority'] : 10 ),
						'capability'    => Mailtpl_Woomail_Composer::get_admin_capability(),
					);

					// Panel description
					if ( ! empty( $panel['description'] ) ) {
						$panel_config['description'] = $panel['description'];
					}

					// Register panel
					$wp_customize->add_panel( 'mailtpl_woomail_' . $panel_key, $panel_config );

					// Track which panels were added
					self::$panels_added[] = $panel_key;
				}
			}
		}

		/**
		 * Get styles string
		 *
		 * @access public
		 * @param bool $add_custom_css
		 * @return string
		 */
		public static function get_styles_string( $add_custom_css = true ) {
			$styles_array     = array();
			$styles           = '';
			$responsive_check = self::opt( 'responsive_mode' );

			// Iterate over settings.
			foreach ( Mailtpl_Woomail_Settings::get_settings() as $setting_key => $setting ) {

				// Only add CSS properties.
				if ( isset( $setting['live_method'] ) && $setting['live_method'] === 'css' ) {

					// Iterate over selectors.
					foreach ( $setting['selectors'] as $selector => $properties ) {

						// Iterate over properties.
						foreach ( $properties as $property ) {
							// Add value to styles array.
							if ( $responsive_check && 'content_width' == $setting_key ) {
								$property = 'max-width';
								if ( '#template_container' !== $selector && '#template_footer' !== $selector ) {
									continue;
								}
							}
							if ( ! $responsive_check && 'content_width' == $setting_key ) {
								continue;
							}
							if ( 'border_width' == $setting_key ) {
								if ( '' === self::get_stored_value( 'border_width_right' ) ) {
									$property = 'border-width';
								} else if ( '0' === self::get_stored_value( 'border_width' ) ) {
										$property = 'border-top';
								}
							}
							if ( 'border_width_right' == $setting_key && '0' === self::get_stored_value( 'border_width_right' ) ) {
									$property = 'border-right';
							}
							if ( 'border_width_left' == $setting_key && '0' === self::get_stored_value( 'border_width_left' ) ) {
									$property = 'border-left';
							}
							if ( 'border_width_bottom' == $setting_key && '0' === self::get_stored_value( 'border_width_bottom' ) ) {
									$property = 'border-bottom';
							}

							if ( 'items_table_padding' == $setting_key && ( '.order-items-normal #body_content_inner table.td th' === $selector || '.order-items-normal #body_content_inner table.td td' === $selector ) ) {
								if ( '' === self::get_stored_value( 'items_table_padding_left_right' ) ) {
									$property = 'padding';
								}
							}
							if ( ! $responsive_check && 'content_inner_width' == $setting_key ) {
								continue;
							}
							$styles_array[ $selector ][ $property ] = self::opt( $setting_key, $selector );
						}
					}
				}
			}

			// Join property names with values.
			foreach ( $styles_array as $selector => $properties ) {

				// Open selector.
				$styles .= $selector . '{';

				foreach ( $properties as $property_key => $property_value ) {

					// Add property.
					$styles .= $property_key . ':' . $property_value . ';';
				}

				// Close selector.
				$styles .= '}';
			}

			// Add custom CSS
			if ( $add_custom_css ) {
				$styles .= self::opt( 'custom_css' );
			}

			// Return styles string
			return $styles;
		}

		/**
		 * Get value for use in templates
		 *
		 * @access public
		 * @param string $key
		 * @param string $selector
		 * @return string
		 */
		public static function opt( $key, $selector = null ) {
			// Get raw value
			$stored_value = self::get_stored_value( $key, Mailtpl_Woomail_Settings::get_default_value( $key ) );

			// Prepare value
			$value = self::prepare( $key, $stored_value, $selector );

			// Allow developers to override.
			return apply_filters( 'mailtpl_woomail_option_value', $value, $key, $selector, $stored_value );
		}

		/**
		 * Get value stored in database
		 *
		 * @access public
		 * @param string $key the setting key.
		 * @param string $default the setting defaut.
		 * @return string
		 */
		public static function get_stored_value( $key, $default = '' ) {
			// Get all stored values.
			$stored = (array) get_option( 'mailtpl_woomail', array() );

			// Check if value exists in stored values array.
			if ( ! empty( $stored ) && isset( $stored[ $key ] ) ) {
				return $stored[ $key ];
			}

			// Stored value not found, use default value.
			return $default;
		}
		/**
		 * Prepare value for use in HTML
		 *
		 * @access public
		 * @param string $key
		 * @param string $value
		 * @param string $selector
		 * @return string
		 */
		public static function prepare( $key, $value, $selector = null ) {
			// Append CSS suffix to value
			$value .= self::get_css_suffix( $key );

			// Special case for shadow
			if ( $key === 'shadow' ) {
				$value = '0 ' . ( $value > 0 ? 1 : 0 ) . 'px ' . ( $value * 4 ) . 'px ' . $value . 'px rgba(0,0,0,0.1) !important';
			}

			// Special case for border width 0.
			if ( $key === 'border_width_right' && '0px' === $value ) {
				$background = get_option( 'woocommerce_email_background_color' );
				$value = '0px solid ' . $background . ' !important';
			}
			if ( $key === 'border_width_left' && '0px' === $value ) {
				$background = get_option( 'woocommerce_email_background_color' );
				$value = '0px solid ' . $background . ' !important';
			}
			if ( $key === 'border_width_bottom' && '0px' === $value ) {
				$background = get_option( 'woocommerce_email_background_color' );
				$value = '0px solid ' . $background . ' !important';
			}
			if ( $key === 'border_width' && '0px' === $value ) {
				$background = get_option( 'woocommerce_email_background_color' );
				$value = '0px solid ' . $background . ' !important';
			}

			// Font family
			if ( substr( $key, -11 ) === 'font_family' ) {
				$value = isset( Mailtpl_Woomail_Settings::$font_family_mapping[ $value ] ) ? Mailtpl_Woomail_Settings::$font_family_mapping[ $value ] : $value;
			}

			// Return prepared value
			return $value;
		}

		/**
		 * Get CSS suffix by key or all CSS suffixes
		 *
		 * @access public
		 * @param string $key
		 * @return mixed
		 */
		public static function get_css_suffix( $key = null ) {
			// Define CSS suffixes.
			if ( null === self::$css_suffixes ) {
				self::$css_suffixes = array(
					'email_padding'          => 'px',
					'email_padding_bottom'   => 'px',
					'content_padding_top'    => 'px',
					'content_padding_bottom' => 'px',
					'content_padding'        => 'px',

					'content_width'       => 'px',
					'content_inner_width' => 'px',
					'border_width'        => 'px',
					'border_width_right'  => 'px',
					'border_width_bottom' => 'px',
					'border_width_left'   => 'px',
					'border_radius'       => 'px !important',

					'btn_border_width'        => 'px',
					'btn_size'                => 'px',
					'btn_left_right_padding'  => 'px',
					'btn_top_bottom_padding'  => 'px',
					'btn_border_radius'       => 'px',

					'header_image_maxwidth'           => 'px',
					'header_image_padding_top_bottom' => 'px',

					'header_padding_top'                => 'px',
					'header_padding_bottom'             => 'px',
					'header_padding_left_right'         => 'px',
					'heading_font_size'                 => 'px',
					'heading_line_height'               => 'px',
					'subtitle_font_size'                => 'px',
					'subtitle_line_height'              => 'px',

					'font_size'                         => 'px',
					'line_height'                       => 'px',

					'h2_font_size'                      => 'px',
					'h2_line_height'                    => 'px',
					'h2_separator_height'               => 'px',
					'h2_padding_top'                    => 'px',
					'h2_margin_bottom'                  => 'px',
					'h2_padding_bottom'                 => 'px',
					'h2_margin_top'                     => 'px',
					'h3_font_size'                      => 'px',
					'h3_line_height'                    => 'px',

					'addresses_border_width' => 'px',
					'addresses_padding'      => 'px',

					'footer_top_padding'                => 'px',
					'footer_bottom_padding'             => 'px',
					'footer_left_right_padding'         => 'px',
					'footer_font_size'                  => 'px',
					'footer_social_title_size'          => 'px',
					'footer_social_top_padding'         => 'px',
					'footer_social_bottom_padding'      => 'px',
					'footer_social_border_width'        => 'px',

					'footer_credit_top_padding'         => 'px',
					'footer_credit_bottom_padding'      => 'px',

					'items_table_border_width'      => 'px',
					'items_table_separator_width'   => 'px',
					'items_table_padding'           => 'px',
					'items_table_padding_left_right'           => 'px',
				);
			}

			// Return single suffix
			if ( isset( $key ) ) {
				return isset( self::$css_suffixes[ $key ] ) ? self::$css_suffixes[ $key ] : '';
			}
			// Return all suffixes for use in Javascript
			else {
				return self::$css_suffixes;
			}
		}

		/**
		 * Reset to default values via Ajax request
		 *
		 * @access public
		 * @return void
		 */
		public function ajax_send_email() {
			// Check request
			if ( empty( $_REQUEST['wp_customize'] ) || $_REQUEST['wp_customize'] !== 'on' || empty( $_REQUEST['action'] ) || $_REQUEST['action'] !== 'mailtpl_woomail_send_email' || empty( $_REQUEST['recipients'] ) ) {
				exit;
			}

			// Check if user is allowed to send email
			if ( ! Mailtpl_Woomail_Composer::is_admin() ) {
				exit;
			}
			
			$recipients = wc_clean( $_REQUEST['recipients'] );
			$content = Mailtpl_Woomail_Preview::get_preview_email( true, $recipients );
			echo $content;
		}


		/**
		 * Reset to default values via Ajax request
		 *
		 * @access public
		 * @return void
		 */
		public function ajax_reset() {
			// Check request
			if ( empty( $_REQUEST['wp_customize'] ) || $_REQUEST['wp_customize'] !== 'on' || empty( $_REQUEST['action'] ) || $_REQUEST['action'] !== 'mailtpl_woomail_reset' ) {
				exit;
			}

			// Check if user is allowed to reset values
			if ( ! Mailtpl_Woomail_Composer::is_admin() ) {
				exit;
			}
			global $wp_customize;

			// Reset to default values
			self::reset( $wp_customize );

			exit;
		}

		/**
		 * Reset to default values
		 *
		 * @access private
		 * @return void
		 */
		public static function reset( $wp_customize ) {
			update_option( 'mailtpl_woomail', array() );
			// Load the export/import option class.
			require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-import-option.php';
			// Run through the woocommerce settings we are overriding.
			foreach ( Mailtpl_Woomail_Settings::get_woo_settings() as $setting_key => $setting ) {
				$option = new Mailtpl_Woomail_Import_Option(
					$wp_customize,
					$setting_key,
					array(
						'default'       => '',
						'type'          => 'option',
						'capability'    => Mailtpl_Woomail_Composer::get_admin_capability(),
					)
				);
				if ( 'woocommerce_email_footer_text' == $setting_key ) {
					$option->import( '{site_title}' );
				} else if ( 'woocommerce_email_body_background_color' == $setting_key ) {
					$option->import( '#ffffff' );
				} else if ( 'woocommerce_email_background_color' == $setting_key ) {
					$option->import( '#f7f7f7' );
				} else if ( 'woocommerce_email_text_color' == $setting_key ) {
					$option->import( '#3c3c3c' );
				} else {
					$option->import( '' );
				}
			}
		}

		/**
		 * Maybe add custom styles to default WooCommerce styles
		 *
		 * @access public
		 * @param  string $styles
		 * @return string
		 */
		public function maybe_add_custom_styles( $styles ) {
			// Check if custom styles need to be applied.
			if ( Mailtpl_Woomail_Composer::overwrite_options() ) {

				// Add custom styles.
				$styles .= self::get_styles_string();

				// Static styles.
				$styles .= self::get_static_styles();

			} else if ( Mailtpl_Woomail_Composer::is_own_preview_request() ) {
				// Otherwise apply some fixes for Customizer Preview.
				$styles .= 'body { background-color: ' . get_option( 'woocommerce_email_background_color' ) . '; }';
				$styles .= self::get_static_styles();
			}

			// Return styles.
			return $styles;
		}

		/**
		 * Get static styles
		 *
		 * @access public
		 * @return string
		 */
		public static function get_static_styles() {
			return '.order-items-light table.td .td {
	border: 0;
}
.order-items-light table.td {
	border: 0;
}
.order-items-light tr th.td {
	font-weight:bold;
}
.order-items-light tr .td {
	text-align:center !important;
}
.order-items-light tr .td:first-child, .order-items-light .order-info-split-table td:first-child {
	padding-' . ( is_rtl() ? 'right' : 'left' ) . ': 0 !important;
	text-align: ' . ( is_rtl() ? 'right' : 'left' ) . ' !important;
}
.order-items-light tr .td:last-child, .order-items-light .order-info-split-table td:last-child{
	padding-' . ( is_rtl() ? 'left' : 'right' ) . ': 0 !important;
	text-align:' . ( is_rtl() ? 'left' : 'right' ) . ' !important;
}
.title-style-behind  #template_container h2 {
	border-top:0 !important;
	border-bottom:0 !important;
}
.title-style-above #template_container h2 {
	border-bottom:0 !important;
}
.title-style-below #template_container h2 {
	border-top:0 !important;
}';
		}

	}

	Mailtpl_Woomail_Customizer::get_instance();

}
