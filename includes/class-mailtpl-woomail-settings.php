<?php
/**
 * Customizer Mail Settings
 *
 * @package Mailtpl WooCommerce Email Composer
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Mailtpl_Woomail_Settings' ) ) {
	/**
	 * Customizer Settings
	 */
	class Mailtpl_Woomail_Settings {
		/**
		 * The panels for customizer.
		 *
		 * @var null
		 */
		private static $panels = null;

		/**
		 * The sections for customizer.
		 *
		 * @var null
		 */
		private static $sections = null;

		/**
		 * The settings for customizer.
		 *
		 * @var null
		 */
		private static $settings = null;

		/**
		 * The woo settings copy for customizer.
		 *
		 * @var null
		 */
		private static $woo_copy_settings = null;

		/**
		 * The woo settings for customizer.
		 *
		 * @var null
		 */
		private static $woo_settings = null;

		/**
		 * The default values for customizer.
		 *
		 * @var null
		 */
		private static $default_values = null;

		/**
		 * The order ids.
		 *
		 * @var null
		 */
		private static $order_ids = null;

		/**
		 * The emails types.
		 *
		 * @var null
		 */
		private static $email_types = null;

		/**
		 * The available text edit email types.
		 *
		 * @var null
		 */
		private static $customized_email_types = null;

		/**
		 * The available font options.
		 *
		 * @var array
		 */
		public static $font_family_mapping = array(
			'helvetica'   => '"Helvetica Neue", Helvetica, Roboto, Arial, sans-serif',
			'arial'       => 'Arial, Helvetica, sans-serif',
			'arial_black' => '"Arial Black", Gadget, sans-serif',
			'courier'     => '"Courier New", Courier, monospace',
			'impact'      => 'Impact, Charcoal, sans-serif',
			'lucida'      => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
			'palatino'    => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
			'georgia'     => 'Georgia, serif',
		);

		/**
		 * Get our prebuilt tempaltes.
		 *
		 * @var array
		 */
		public static $prebuilt_templates_mapping = array(
			'kt_full'   => 'assets/images/kt_full_template.jpg',
			'kt_skinny' => 'assets/images/kt_skinny_template.jpg',
			'kt_flat'   => 'assets/images/kt_flat_template.jpg',
		);
		/**
		 * Get our customizer panels
		 *
		 * @access public
		 * @return array
		 */
		public static function get_panels() {
			// Define panels.
			if ( is_null( self::$panels ) ) {
				self::$panels = array(
					// Header.
					'header' => array(
						'title'    => __( 'Header', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 20,
					),

					// Content.
					'content' => array(
						'title'    => __( 'Content', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 30,
					),

					// Footer.
					'footer' => array(
						'title'    => __( 'Footer', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 40,
					),

				);
			}

			// Return panels.
			return self::$panels;
		}

		/**
		 * Get our Customizer sections
		 *
		 * @access public
		 * @return array
		 */
		public static function get_sections() {
			// Define sections.
			if ( is_null( self::$sections ) ) {
				self::$sections = array(
					// Text and Type.
					'mtype' => array(
						'title'    => __( 'Email Type and Text', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 10,
					),
					// Container.
					'container' => array(
						'title'    => __( 'Container', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 15,
					),

					// Header Style.
					'header_style' => array(
						'title'    => __( 'Header Style', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'header',
						'priority' => 20,
					),

					// Header Image.
					'header_image' => array(
						'title'    => __( 'Header Image', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'header',
						'priority' => 20,
					),

					// Heading.
					'heading' => array(
						'title'    => __( 'Heading', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'header',
						'priority' => 30,
					),

					// Footer Style.
					'footer_style' => array(
						'title'    => __( 'Footer Style', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'footer',
						'priority' => 40,
					),
					// Footer social.
					'footer_social' => array(
						'title'    => __( 'Footer Social', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'footer',
						'priority' => 50,
					),
					// Footer Content.
					'footer_content' => array(
						'title'    => __( 'Footer Credit Content', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'footer',
						'priority' => 60,
					),
					// Content Container.
					'content_container' => array(
						'title'    => __( 'Content Container', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 5,
					),
					// Heading Style.
					'headings_style' => array(
						'title'    => __( 'Content Headings Style', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 8,
					),
					// Text Style.
					'text_style' => array(
						'title'    => __( 'Content Text Style', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 10,
					),
					// Items Table.
					'items_table' => array(
						'title'    => __( 'Order Items', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 10,
					),
					// Items Table.
					'addresses' => array(
						'title'    => __( 'Addresses', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 10,
					),
					// Text input.
					'text_input' => array(
						'title'    => __( 'Text Copy', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 5,
					),
					// Button Styles.
					'btn_styles' => array(
						'title'    => __( 'Button Styles', 'mailtpl-woocommerce-email-composer' ),
						'panel'    => 'content',
						'priority' => 10,
					),
					// Custom Styles.
					'custom_styles' => array(
						'title'    => __( 'Custom Styles', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 80,
					),
					// Import_export.
					'import_export' => array(
						'title'    => __( 'Import Export', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 90,
					),
					// Send Email.
					'send_email' => array(
						'title'    => __( 'Send Preview Email', 'mailtpl-woocommerce-email-composer' ),
						'priority' => 100,
					),
				);
			}
			// Return sections.
			return self::$sections;
		}

		/**
		 * Get woocommerce settings that the plugin will allow editing of
		 *
		 * @access public
		 * @return array
		 */
		public static function get_woo_settings() {

			if ( is_null( self::$woo_settings ) ) {
				$base_options = array();

				// Email header image.
				$base_options['woocommerce_email_header_image'] = array(
					'title'        => __( 'Header Image', 'mailtpl-woocommerce-email-composer' ),
					'control_type' => 'image',
					'section'      => 'header_image',
					'default'      => self::get_default_value( 'header_image' ),
					'original'     => '',
					'priority'     => 5,
					'transport'    => 'refresh',
					'selectors'    => array(
						'#template_header_image img',
					),
				);
				// Email background color.
				$base_options['woocommerce_email_background_color'] = array(
					'title'        => __( 'Container Background color', 'mailtpl-woocommerce-email-composer' ),
					'section'      => 'container',
					'control_type' => 'color',
					'priority'     => 5,
					'default'      => self::get_default_value( 'body_background_color' ),
					'live_method'  => 'css',
					'selectors'    => array(
						'body'     => array( 'background-color' ),
						'#wrapper' => array( 'background-color' ),
					),
				);
				// Email text color.
				$base_options['woocommerce_email_text_color'] = array(
					'title'        => __( 'Content Text color', 'mailtpl-woocommerce-email-composer' ),
					'section'      => 'text_style',
					'control_type' => 'color',
					'default'      => self::get_default_value( 'text_color' ),
					'live_method'  => 'css',
					'selectors'    => array(
						'#body_content_inner' => array( 'color' ),
						'.td'                 => array( 'color' ),
						'.text'               => array( 'color' ),
						'address'             => array( 'color' ),
					),
				);
				// Email body background color.
				$base_options['woocommerce_email_body_background_color'] = array(
					'title'         => __( 'Content Background color', 'mailtpl-woocommerce-email-composer' ),
					'section'       => 'content_container',
					'control_type'  => 'color',
					'priority'      => 5,
					'default'       => self::get_default_value( 'background_color' ),
					'live_method'   => 'css',
					'selectors'     => array(
						'#body_content' => array( 'background-color' ),
						'#template_container' => array( 'background-color' ),
						'h2 .separator-bubble' => array( 'background-color' ),
					),
				);
				// Footer Content Footer text.
				$base_options['woocommerce_email_footer_text'] = array(
					'title'       => __( 'Footer text', 'mailtpl-woocommerce-email-composer' ),
					'type'        => 'textarea',
					'section'     => 'footer_content',
					'default'     => self::get_default_value( 'footer_content_text' ),
					'original'    => '',
					'live_method' => 'replace',
					'selectors'   => array(
						'#template_footer #credit',
					),
				);
				$email_text = array();
				foreach ( self::get_email_types() as $key => $value ) {
					// Email recipients Text.
					if ( 'cancelled_order' == $key || 'new_order' == $key || 'failed_order' == $key ) {
						$email_text[ 'woocommerce_' . $key . '_settings[recipient]' ] = array(
							'title'         => __( 'Recipient(s)', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'text',
							'section'       => 'mtype',
							'priority'      => 5,
							'default'       => '',
							'description'   => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to %s.', 'mailtpl-woocommerce-email-composer' ), '<code>' . esc_attr( get_option( 'admin_email' ) ) . '</code>' ),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					}
					if ( 'customer_refunded_order' == $key ) {
						// Email Subject.
						$email_text[ 'woocommerce_' . $key . '_settings[subject_full]' ] = array(
							'title'         => __( 'Full refund subject', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'text',
							'section'       => 'mtype',
							'priority'      => 5,
							'default'       => '',
							'input_attrs' => array(
								'placeholder' => self::get_default_value( $key . '_subject_full' ),
							),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Subject.
						$email_text[ 'woocommerce_' . $key . '_settings[subject_partial]' ] = array(
							'title'         => __( 'Partial refund subject', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'text',
							'section'       => 'mtype',
							'priority'      => 5,
							'default'       => '',
							'input_attrs' => array(
								'placeholder' => self::get_default_value( $key . '_subject_partial' ),
							),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Header Text.
						$email_text[ 'woocommerce_' . $key . '_settings[heading_full]' ] = array(
							'title'           => __( 'Full refund Heading Text', 'mailtpl-woocommerce-email-composer' ),
							'type'            => 'text',
							'section'         => 'mtype',
							'priority'        => 5,
							'default'         => '',
							'input_attrs'     => array(
								'placeholder' => self::get_default_value( $key . '_heading_full' ),
							),
							'live_method'   => 'replace',
							'selectors'     => array(
								'#header_wrapper h1',
							),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Header Text.
						$email_text[ 'woocommerce_' . $key . '_settings[heading_partial]' ] = array(
							'title'           => __( 'Partial refund Heading Text', 'mailtpl-woocommerce-email-composer' ),
							'type'            => 'text',
							'section'         => 'mtype',
							'priority'        => 5,
							'default'         => '',
							'input_attrs'     => array(
								'placeholder' => self::get_default_value( $key . '_heading_partial' ),
							),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						if ( version_compare( WC_VERSION, '3.7', '>' ) ) {
							$email_text[ 'woocommerce_' . $key . '_settings[additional_content]' ] = array(
								'title'         => __( 'Additional content', 'mailtpl-woocommerce-email-composer' ),
								'type'          => 'textarea',
								'section'       => 'mtype',
								'priority'      => 20,
								'default'       => '',
								'input_attrs' => array(
									'placeholder' => self::get_default_value( $key . '_additional_content' ),
								),
								'transport'     => 'refresh',
								'active_callback' => array(
									'id' => 'email_type',
									'compare' => '==',
									'value' => $key,
								),
							);
						}
					} else {
						// Email Subject.
						$email_text[ 'woocommerce_' . $key . '_settings[subject]' ] = array(
							'title'           => __( 'Subject Text', 'mailtpl-woocommerce-email-composer' ),
							'type'            => 'text',
							'section'         => 'mtype',
							'priority'        => 5,
							'default'         => '',
							'input_attrs'     => array(
								'placeholder' => self::get_default_value( $key . '_subject' ),
							),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						if ( 'customer_invoice' == $key ) {
							$email_text[ 'woocommerce_' . $key . '_settings[subject_paid]' ] = array(
								'title'         => __( 'Subject (paid) Text', 'mailtpl-woocommerce-email-composer' ),
								'type'          => 'text',
								'section'       => 'mtype',
								'priority'      => 5,
								'default'       => '',
								'input_attrs' => array(
									'placeholder' => self::get_default_value( $key . '_subject_paid' ),
								),
								'active_callback' => array(
									'id' => 'email_type',
									'compare' => '==',
									'value' => $key,
								),
							);
						}
						// Email Header Text.
						$email_text[ 'woocommerce_' . $key . '_settings[heading]' ] = array(
							'title'         => __( 'Heading Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'text',
							'section'       => 'mtype',
							'priority'      => 5,
							'default'       => '',
							'input_attrs'   => array(
								'placeholder' => self::get_default_value( $key . '_heading' ),
							),
							'live_method'   => 'replace',
							'selectors'     => array( '#header_wrapper h1' ),
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						if ( 'customer_invoice' == $key ) {
							$email_text[ 'woocommerce_' . $key . '_settings[heading_paid]' ] = array(
								'title'         => __( 'Heading (paid) Text', 'mailtpl-woocommerce-email-composer' ),
								'type'          => 'text',
								'section'       => 'mtype',
								'priority'      => 5,
								'default'       => '',
								'input_attrs' => array(
									'placeholder' => self::get_default_value( $key . '_heading_paid' ),
								),
								'active_callback' => array(
									'id' => 'email_type',
									'compare' => '==',
									'value' => $key,
								),
								'live_method' => 'replace',
								'selectors' => array( '#header_wrapper h1' ),
							);
						}
						if ( version_compare( WC_VERSION, '3.7', '>' ) ) {
							$email_text[ 'woocommerce_' . $key . '_settings[additional_content]' ] = array(
								'title'         => __( 'Additional content', 'mailtpl-woocommerce-email-composer' ),
								'type'          => 'textarea',
								'section'       => 'mtype',
								'priority'      => 20,
								'default'       => '',
								'input_attrs' => array(
									'placeholder' => self::get_default_value( $key . '_additional_content' ),
								),
								'transport'     => 'refresh',
								'active_callback' => array(
									'id' => 'email_type',
									'compare' => '==',
									'value' => $key,
								),
							);
						}
					}
				}
				self::$woo_settings = array_merge( $base_options, $email_text );
			}
			return self::$woo_settings;
		}

		/**
		 * Get our extra settings
		 *
		 * @access public
		 * @return array
		 */
		public static function get_settings() {
			// Define settings
			if ( is_null( self::$settings ) ) {
				// Main Base options.
				$mainoptions = array(
					// Email template
					'email_load_template' => array(
						'title'         => __( 'Template_load', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'template',
						'control_type'  => 'mailtpltemplateload',
						'choices'       => self::get_email_templates(),
						'default'       => 'kt_full',
						'transport'     => 'refresh',
					),
					// Preview Order Id.
					'preview_order_id' => array(
						'title'         => __( 'Preview Order', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'mtype',
						'type'          => 'select',
						'priority'      => 1,
						'choices'       => self::get_order_ids(),
						'default'       => self::get_default_value( 'preview_order_id' ),
						'transport'     => 'refresh',
					),
					// Email Type.
					'email_type' => array(
						'title'         => __( 'Email Type', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'mtype',
						'type'          => 'select',
						'priority'      => 2,
						'choices'       => self::get_email_types(),
						'default'       => self::get_default_value( 'email_type' ),
						'transport'     => 'refresh',
					),
					// Placeholder Info.
					'email_text_info' => array(
						'title'         => __( 'Available placeholders', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'mtype',
						'control_type'  => 'kwdinfoblock',
						'priority'      => 50,
						'description'   => '<code>{site_title}, {order_date}, {order_number}, {customer_first_name}, {customer_last_name}, {customer_full_name}, {customer_username}, {customer_email}</code>',
					),
					// // Placeholder Info.
					// 'email_schema' => array(
					// 	'title'         => __( 'Disable Email Schema', 'mailtpl-woocommerce-email-composer' ),
					// 	'section'       => 'mtype',
					// 	'control_type'    => 'toggleswitch',
					// 	'default'         => self::get_default_value( 'email_schema' ),
					// 	'priority'      => 60,
					// 	'description'   => __( 'Some inboxes seem to have trouble with woocommerce default schema code added.', 'mailtpl-woocommerce-email-composer' ),
					// ),
				);
				$extra_email_text = array();

				// Get the Extra Text area settings.
				foreach ( self::get_customized_email_types() as $key => $value ) {
					// Email Subtitle Text
					$extra_email_text[ $key . '_subtitle' ] = array(
						'title'         => __( 'Subtitle Text', 'mailtpl-woocommerce-email-composer' ),
						'type'          => 'text',
						'section'       => 'mtype',
						'default'       => '',
						'original'      => '',
						'live_method'   => 'replace',
						'selectors'     => array(
							'#header_wrapper .subtitle',
						),
						'active_callback' => array(
							'id' => 'email_type',
							'compare' => '==',
							'value' => $key,
						),
					);
					if ( 'customer_new_account' == $key ) {
						$extra_email_text[ $key . '_account_section' ] = array(
							'title'           => __( 'Show account section', 'mailtpl-woocommerce-email-composer' ),
							'control_type'    => 'toggleswitch',
							'section'         => 'mtype',
							'transport'       => 'refresh',
							'default'         => self::get_default_value( $key . '_account_section' ),
							'original'        => '',
							'priority'        => 3,
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						$extra_email_text[ $key . '_btn_switch' ] = array(
							'title'         => __( 'Switch account link to button', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_btn_switch' ),
							'original'      => '',
							'priority'      => 3,
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					}
					if ( 'customer_refunded_order' == $key ) {
						// Email preview switch
						$extra_email_text[ $key . '_switch' ] = array(
							'title'         => __( 'Switch off for Partial Refund Preview', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_switch' ),
							'original'      => '',
							'priority'      => 3,
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body_full' ] = array(
							'title'         => __( 'Body Full Refund Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body_full' ),
							'original'      => '',
							'transport'     => 'refresh',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body_partial' ] = array(
							'title'         => __( 'Body Partial Refund Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body_partial' ),
							'original'      => '',
							'transport'     => 'refresh',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else if ( 'customer_invoice' == $key ) {
						// Email preview switch
						$extra_email_text[ $key . '_switch' ] = array(
							'title'         => __( 'Switch off for unpaid preview', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_switch' ),
							'original'      => '',
							'priority'      => 3,
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email preview switch.
						$extra_email_text[ $key . '_btn_switch' ] = array(
							'title'         => __( 'Make "Pay for this Order" a button', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_btn_switch' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body_paid' ] = array(
							'title'         => __( 'Body Invoice Paid Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body_paid' ),
							'original'      => '',
							'transport'     => 'refresh',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body' ] = array(
							'title'         => __( 'Body Invoice Pending Payment Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else if ( 'customer_payment_retry' == $key ) {
						// Override content.
						$extra_email_text[ $key . '_override' ] = array(
							'title'         => __( 'Override Static Email Content with Custom Body Text?', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_override' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Button Switch.
						$extra_email_text[ $key . '_btn_switch' ] = array(
							'title'         => __( 'Make "Pay now" a button', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_btn_switch' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text.
						$extra_email_text[ $key . '_body' ] = array(
							'title'         => __( 'Body Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else if ( 'admin_payment_retry' == $key ) {
						// Override content.
						$extra_email_text[ $key . '_override' ] = array(
							'title'         => __( 'Override Static Email Content with Custom Body Text?', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_override' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text.
						$extra_email_text[ $key . '_body' ] = array(
							'title'         => __( 'Body Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else if ( 'customer_renewal_invoice' == $key ) {
						// Button Switch.
						$extra_email_text[ $key . '_btn_switch' ] = array(
							'title'         => __( 'Make "Pay Now" a button', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_btn_switch' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body_failed' ] = array(
							'title'         => __( 'Body Invoice Failed Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body_failed' ),
							'original'      => '',
							'transport'     => 'refresh',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body' ] = array(
							'title'         => __( 'Body Invoice Pending Payment Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else if ( 'customer_reset_password' == $key ) {
						// Email preview switch.
						$extra_email_text[ $key . '_btn_switch' ] = array(
							'title'         => __( 'Make "reset your password" a button', 'mailtpl-woocommerce-email-composer' ),
							'control_type'  => 'toggleswitch',
							'section'       => 'mtype',
							'transport'     => 'refresh',
							'default'       => self::get_default_value( $key . '_switch' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
						// Email Body Text
						$extra_email_text[ $key . '_body' ] = array(
							'title'         => __( 'Body Text', 'mailtpl-woocommerce-email-composer' ),
							'type'          => 'textarea',
							'section'       => 'mtype',
							'default'       => self::get_default_value( $key . '_body' ),
							'original'      => '',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					} else {
						// Email Body Text.
						$extra_email_text[ $key . '_body' ] = array(
							'title'           => __( 'Body Text', 'mailtpl-woocommerce-email-composer' ),
							'type'            => 'textarea',
							'section'         => 'mtype',
							'default'         => self::get_default_value( $key . '_body' ),
							'original'        => '',
							'transport'       => 'refresh',
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					}
					if ( 'woocommerce_waitlist_mailout' == $key ) {
						$extra_email_text[ $key . '_hide_content' ] = array(
							'title'           => __( 'Remove Normal Content Output', 'mailtpl-woocommerce-email-composer' ),
							'control_type'    => 'toggleswitch',
							'section'         => 'mtype',
							'transport'       => 'refresh',
							'default'         => self::get_default_value( $key . '_hide_content' ),
							'original'        => '',
							'priority'        => 3,
							'active_callback' => array(
								'id'      => 'email_type',
								'compare' => '==',
								'value'   => $key,
							),
						);
					}
				}
				$main = array(
					/*
					CONTAINER STUFF */
					   // Email width.
					   'content_width' => array(
						   'title'         => __( 'Content Width', 'mailtpl-woocommerce-email-composer' ),
						   'control_type'  => 'rangevalue',
						   'section'       => 'container',
						   'default'       => self::get_default_value( 'content_width' ),
						   'live_method'   => 'css',
						   'selectors'     => array(
							   '#template_container'       => array( 'width' ),
							   '#template_header'          => array( 'width' ),
							   '#template_header_image'   => array( 'width' ),
							   '#template_body'            => array( 'width' ),
							   '#template_footer'          => array( 'width' ),
						   ),
						   'input_attrs' => array(
							   'step'  => 2,
							   'min'   => 350,
							   'max'   => 1500,
						   ),
					   ),
					'responsive_mode' => array(
						'title'         => __( 'Enable Fluid Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'toggleswitch',
						'section'       => 'container',
						'transport'     => 'refresh',
						'default'       => self::get_default_value( 'responsive_mode' ),
					),
					'content_inner_width' => array(
						'title'         => __( 'Content Inner Max Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => self::get_default_value( 'content_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_container #template_header'          => array( 'max-width' ),
							'#template_container #template_header_image'   => array( 'max-width' ),
							'#template_container #template_body'            => array( 'max-width' ),
							'#template_container #template_footer'          => array( 'max-width' ),
						),
						'input_attrs' => array(
							'step'  => 2,
							'min'   => 350,
							'max'   => 1500,
						),
						'active_callback' => array(
							'id' => 'responsive_mode',
							'compare' => '==',
							'value' => true,
						),
					),
					// Border radius
					'border_radius' => array(
						'title'         => __( 'Border radius', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => self::get_default_value( 'border_radius' ),
						'live_method'   => 'css',
						'description'   => __( 'Warning: most desktop email clients do not yet support this.', 'mailtpl-woocommerce-email-composer' ),
						'selectors'     => array(
							'#template_container'   => array( 'border-radius' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 100,
						),
					),
					// Border Width.
					'border_width' => array(
						'title'         => __( 'Border Top Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => self::get_default_value( 'border_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container'   => array( 'border-top-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 20,
						),
					),
					// Border Width.
					'border_width_right' => array(
						'title'         => __( 'Border Right Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => str_replace( 'px', '', Mailtpl_Woomail_Customizer::opt( 'border_width' ) ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container' => array( 'border-right-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 20,
						),
					),
					// Border Width.
					'border_width_bottom' => array(
						'title'         => __( 'Border Bottom Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => str_replace( 'px', '', Mailtpl_Woomail_Customizer::opt( 'border_width' ) ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container' => array( 'border-bottom-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 20,
						),
					),
					// Border Width.
					'border_width_left' => array(
						'title'         => __( 'Border Left Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => str_replace( 'px', '', Mailtpl_Woomail_Customizer::opt( 'border_width' ) ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container' => array( 'border-left-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 20,
						),
					),
					// Border Color.
					'border_color' => array(
						'title'         => __( 'Border color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'container',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'border_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container'         => array( 'border-color' ),
						),
					),
					// Shadow
					'shadow' => array(
						'title'         => __( 'Shadow', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'description'   => __( 'Warning: most email clients do not yet support this.', 'mailtpl-woocommerce-email-composer' ),
						'default'       => self::get_default_value( 'shadow' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'body #template_container' => array( 'box-shadow' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 20,
						),
					),
					// Email Top Padding
					'email_padding' => array(
						'title'         => __( 'Container Top Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => self::get_default_value( 'email_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#wrapper' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 250,
						),
					),
					// Email Top Padding
					'email_padding_bottom' => array(
						'title'         => __( 'Container Botom Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'container',
						'default'       => self::get_default_value( 'email_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#wrapper' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 250,
						),
					),
					/**
					 * HEADER IMAGE OPTIONS
					 */
					'header_image_link' => array(
						'title'         => __( 'Make Image link to website?', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'toggleswitch',
						'section'       => 'header_image',
						'transport'     => 'refresh',
						'default'       => self::get_default_value( 'header_image_link' ),
					),
					// Header Image Width.
					'header_image_placement' => array(
						'title'         => __( 'Header Image Placement', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_image',
						'default'       => self::get_default_value( 'header_image_placement' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'outside'       => __( 'Outside Body Container', 'mailtpl-woocommerce-email-composer' ),
							'inside'        => __( 'Inside Body Container', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// Image Align.
					'header_image_align' => array(
						'title'         => __( 'Image Align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_image',
						'default'       => self::get_default_value( 'header_image_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_image_aligns(),
						'selectors'     => array(
							'#template_header_image_table td' => array( 'text-align' ),
						),
					),
					// Image Maxwidth
					'header_image_maxwidth' => array(
						'title'         => __( 'Image Max Width', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_image',
						'default'       => self::get_default_value( 'header_image_maxwidth' ),
						'live_method'   => 'css',
						'control_type'  => 'rangevalue',
						'selectors'     => array(
							'#template_header_image img' => array( 'width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 1200,
						),
					),
					'header_image_background_color' => array(
						'title'         => __( 'Background color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_image',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'header_image_background_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header_image_container' => array( 'background-color' ),
						),
					),
					// Header Padding top/bottom.
					'header_image_padding_top_bottom' => array(
						'title'         => __( 'Padding top/bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'header_image',
						'default'       => self::get_default_value( 'header_image_padding_top_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header_image_table td' => array( 'padding-top', 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Header background color.
					'header_background_color' => array(
						'title'         => __( 'Background color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'header_background_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header' => array( 'background-color' ),
						),
					),
					// Header Text align
					'header_text_align' => array(
						'title'         => __( 'Text align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'header_style',
						'default'       => self::get_default_value( 'header_text_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_text_aligns(),
						'selectors'     => array(
							'#header_wrapper h1' => array( 'text-align' ),
							'#header_wrapper' => array( 'text-align' ),
						),
					),

					// Header Padding top/bottom.
					'header_padding_top' => array(
						'title'         => __( 'Padding Top', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'header_style',
						'default'       => self::get_default_value( 'header_padding_top_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#header_wrapper' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Header Padding top/bottom
					'header_padding_bottom' => array(
						'title'         => __( 'Padding Bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'header_style',
						'default'       => self::get_default_value( 'header_padding_top_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#header_wrapper' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),

					// Header Padding left/right
					'header_padding_left_right' => array(
						'title'         => __( 'Padding left/right', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'header_style',
						'default'       => self::get_default_value( 'header_padding_left_right' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#header_wrapper' => array( 'padding-left', 'padding-right' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Heading Font size
					'heading_font_size' => array(
						'title'         => __( 'Heading Font size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'heading_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header h1' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 75,
						),
					),
					// heading Line Height
					'heading_line_height' => array(
						'title'         => __( 'Heading Line Height', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'heading_line_height' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header h1' => array( 'line-height' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 125,
						),
					),
					// Heading Font family
					'heading_font_family' => array(
						'title'         => __( 'Heading Font family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'default'       => self::get_default_value( 'heading_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_header h1' => array( 'font-family' ),
						),
					),
					// Heading Font style
					'heading_font_style' => array(
						'title'         => __( 'Heading Font Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'default'       => self::get_default_value( 'heading_font_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'italic'        => __( 'Italic', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#template_header h1' => array( 'font-style' ),
						),
					),
					// Heading Font weight
					'heading_font_weight' => array(
						'title'         => __( 'Heading Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'heading_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header h1'   => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// Heading Color
					'heading_color' => array(
						'title'         => __( 'Heading Text color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'heading_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header'      => array( 'color' ),
							'#template_header h1'   => array( 'color' ),
						),
					),
					// Subtitle Info
					'subtitle_fontt_info' => array(
						'title'         => __( 'Subtitle Settings', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'control_type'  => 'kwdinfoblock',
						'description'   => '',
					),
					// Subtitle placement
					'subtitle_placement' => array(
						'title'         => __( 'Subtitle Placement', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_placement' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'below'         => __( 'Below Heading', 'mailtpl-woocommerce-email-composer' ),
							'above'         => __( 'Above Heading', 'mailtpl-woocommerce-email-composer' ),
						),
					),

					// Subtitle Font size
					'subtitle_font_size' => array(
						'title'         => __( 'Subtitle Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header .subtitle' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 75,
						),
					),
					// Subtitle Line Height
					'subtitle_line_height' => array(
						'title'         => __( 'Subtitle Line Height', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_line_height' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header .subtitle' => array( 'line-height' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 125,
						),
					),
					// Subtitle Font family.
					'subtitle_font_family' => array(
						'title'         => __( 'Subtitle Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_header .subtitle' => array( 'font-family' ),
						),
					),
					// Subtitle Font style
					'subtitle_font_style' => array(
						'title'         => __( 'Subtitle Font Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_font_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'italic'        => __( 'Italic', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#template_header .subtitle' => array( 'font-style' ),
						),
					),

					// Subtitle Font weight
					'subtitle_font_weight' => array(
						'title'         => __( 'Subtitle Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'heading',
						'default'       => self::get_default_value( 'subtitle_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header .subtitle'   => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),

					// Subtitle Color
					'subtitle_color' => array(
						'title'         => __( 'Subtitle Text color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'heading',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'subtitle_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_header .subtitle'   => array( 'color' ),
						),
					),

					// Content padding top
					'content_padding_top' => array(
						'title'         => __( 'Padding Top', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'content_container',
						'default'       => self::get_default_value( 'content_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Content padding
					'content_padding_bottom' => array(
						'title'         => __( 'Padding Bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'content_container',
						'default'       => self::get_default_value( 'content_padding_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Content padding
					'content_padding' => array(
						'title'         => __( 'Padding Left/Right', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'content_container',
						'default'       => self::get_default_value( 'content_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content > table > tbody > tr > td' => array( 'padding-left', 'padding-right' ),
							'#body_content > table > tr > td' => array( 'padding-left', 'padding-right' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// TEXT STYLE
					// Font size
					'font_size' => array(
						'title'         => __( 'Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'text_style',
						'default'       => self::get_default_value( 'font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner'   => array( 'font-size' ),
							'img'                   => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 8,
							'max'   => 30,
						),
					),
					// Line Height
					'line_height' => array(
						'title'         => __( 'Line Height', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'text_style',
						'default'       => self::get_default_value( 'line_height' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner'   => array( 'line-height' ),
							'img'                   => array( 'line-height' ),
						),
						'input_attrs' => array(
							'step' => 1,
							'min'  => 10,
							'max'  => 90,
						),
					),
					// Font family
					'font_family' => array(
						'title'       => __( 'Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'     => 'text_style',
						'default'     => self::get_default_value( 'font_family' ),
						'live_method' => 'css',
						'type'        => 'select',
						'choices'     => self::get_font_families(),
						'selectors'   => array(
							'#body_content_inner'     => array( 'font-family' ),
							'#body_content_inner .td' => array( 'font-family' ),
							'.text'                   => array( 'font-family' ),
						),
					),
					// Font weight.
					'font_weight' => array(
						'title'         => __( 'Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'text_style',
						'default'       => self::get_default_value( 'font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner'   => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// Link color.
					'link_color' => array(
						'title'         => __( 'Link Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'text_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'link_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a'     => array( 'color' ),
							'.link' => array( 'color' ),
							'.btn'  => array( 'background-color' ),
						),
					),
					// H2 TEXT STYLE.
					// Font size.
					'h2_font_size' => array(
						'title'         => __( 'H2 Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 8,
							'max'   => 50,
						),
					),
					// h2 Line Height.
					'h2_line_height' => array(
						'title'         => __( 'H2 Line Height', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_line_height' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'line-height' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 90,
						),
					),
					// h2 padding top.
					'h2_padding_top' => array(
						'title'         => __( 'H2 Padding Top', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_padding_top' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 60,
						),
					),
					// h2 padding bottom.
					'h2_padding_bottom' => array(
						'title'         => __( 'H2 Padding Bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_padding_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 60,
						),
					),
					// h2 margin top.
					'h2_margin_top' => array(
						'title'         => __( 'H2 Margin Top', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_margin_top' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'margin-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 60,
						),
					),
					// h2 margin bottom.
					'h2_margin_bottom' => array(
						'title'         => __( 'H2 Margin Bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_margin_bottom' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'margin-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 60,
						),
					),
					// h2 Font family.
					'h2_font_family' => array(
						'title'         => __( 'H2 Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_body h2'   => array( 'font-family' ),
							'#template_body h2 a'   => array( 'font-family' ),
						),
					),
					// h2 Font style.
					'h2_font_style' => array(
						'title'         => __( 'H2 Font Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_font_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'italic'        => __( 'Italic', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#template_body h2' => array( 'font-style' ),
							'#template_body h2 a' => array( 'font-style' ),
						),
					),
					// h2 Font weight.
					'h2_font_weight' => array(
						'title'         => __( 'H2 Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'   => array( 'font-weight' ),
							'#template_body h2 a'   => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// h2 text transform.
					'h2_text_transform' => array(
						'title'         => __( 'H2 Text Transform', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_text_transform' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'none'          => __( 'None', 'mailtpl-woocommerce-email-composer' ),
							'uppercase'     => __( 'Uppercase', 'mailtpl-woocommerce-email-composer' ),
							'lowercase'     => __( 'Lowercase', 'mailtpl-woocommerce-email-composer' ),
							'capitalize'    => __( 'Capitalize', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#template_body h2' => array( 'text-transform' ),
						),
					),
					// H2 color.
					'h2_color' => array(
						'title'         => __( 'H2 Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'h2_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h2'    => array( 'color' ),
							'#template_body h2 a'    => array( 'color' ),
						),
					),
					// h2 text align.
					'h2_text_align' => array(
						'title'         => __( 'H2 Text Align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_text_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_text_aligns(),
						'selectors'     => array(
							'#template_body h2' => array( 'text-align' ),
						),
					),
					// h2 style.
					'h2_style' => array(
						'title'         => __( 'H2 Separator', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_style' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'none'          => __( 'None', 'mailtpl-woocommerce-email-composer' ),
							'below'         => __( 'Separator below', 'mailtpl-woocommerce-email-composer' ),
							'above'         => __( 'Separator above', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// separator height.
					'h2_separator_height' => array(
						'title'         => __( 'H2 Separator height', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'control_type'  => 'rangevalue',
						'default'       => self::get_default_value( 'h2_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 30,
						),
						'selectors'     => array(
							'.title-style-below #template_body h2' => array( 'border-bottom-width' ),
							'.title-style-above #template_body h2' => array( 'border-top-width' ),
						),
					),
					// h2 style
					'h2_separator_style' => array(
						'title'         => __( 'H2 Separator Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'solid'     => __( 'Solid', 'mailtpl-woocommerce-email-composer' ),
							'double'    => __( 'Double', 'mailtpl-woocommerce-email-composer' ),
							'groove'    => __( 'Groove', 'mailtpl-woocommerce-email-composer' ),
							'dotted'    => __( 'Dotted', 'mailtpl-woocommerce-email-composer' ),
							'dashed'    => __( 'Dashed', 'mailtpl-woocommerce-email-composer' ),
							'ridge'     => __( 'Ridge', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'.title-style-below #template_body h2' => array( 'border-bottom-style' ),
							'.title-style-above #template_body h2' => array( 'border-top-style' ),
						),
					),
					// separator color
					'h2_separator_color' => array(
						'title'         => __( 'H2 Separator Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'h2_separator_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'.title-style-below #template_body h2' => array( 'border-bottom-color' ),
							'.title-style-above #template_body h2' => array( 'border-top-color' ),
						),
					),
					// H3 TEXT STYLE
					// h3 Info
					'h3_font_info' => array(
						'title'         => __( 'H3 Settings', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'control_type'  => 'kwdinfoblock',
						'description'   => '',
					),
					// Font size
					'h3_font_size' => array(
						'title'         => __( 'H3 Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h3_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h3' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 8,
							'max'   => 30,
						),
					),
					// h3 Line Height.
					'h3_line_height' => array(
						'title'         => __( 'H3 Line Height', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_line_height' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h3'   => array( 'line-height' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 10,
							'max'   => 90,
						),
					),
					// h3 Font family.
					'h3_font_family' => array(
						'title'         => __( 'H3 Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h2_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_body h3'   => array( 'font-family' ),
						),
					),
					// h3 Font style.
					'h3_font_style' => array(
						'title'         => __( 'H3 Font Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h3_font_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'italic'        => __( 'Italic', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#template_body h3' => array( 'font-style' ),
						),
					),
					// h3 Font weight.
					'h3_font_weight' => array(
						'title'         => __( 'H3 Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'headings_style',
						'default'       => self::get_default_value( 'h3_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h3'   => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// H3 color.
					'h3_color' => array(
						'title'         => __( 'H3 Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'headings_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'h3_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_body h3'    => array( 'color' ),
						),
					),
					// Order ITEMS.
					'order_items_style' => array(
						'title'         => __( 'Order Table Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'order_items_style' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'light'         => __( 'Light', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// Order ITEMS Image.
					'order_items_image' => array(
						'title'         => __( 'Product Image Option', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'order_items_image' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Do not show', 'mailtpl-woocommerce-email-composer' ),
							'show'      => __( 'Show', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// Order ITEMS Image size.
					'order_items_image_size' => array(
						'title'         => __( 'Product Image Size', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'order_items_image_size' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'40x40'                 => __( '40x40', 'mailtpl-woocommerce-email-composer' ),
							'50x50'                 => __( '50x50', 'mailtpl-woocommerce-email-composer' ),
							'100x50'                => __( '100x50', 'mailtpl-woocommerce-email-composer' ),
							'100x100'               => __( '100x100', 'mailtpl-woocommerce-email-composer' ),
							'150x150'               => __( '150x150', 'mailtpl-woocommerce-email-composer' ),
							'woocommerce_thumbnail' => __( 'Woocommerce Thumbnail', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// Items table Background color.
					'items_table_background_color' => array(
						'title'         => __( 'Order Table Background color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'items_table_background_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner table.td' => array( 'background-color' ),
						),
					),
					// Items table Background color.
					'items_table_background_odd_color' => array(
						'title'         => __( 'Order Table Background Odd Row Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'items_table_background_odd_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner table.td tbody tr:nth-child(even)' => array( 'background-color' ),
							'#body_content_inner table.td thead tr' => array( 'background-color' ),
							'#body_content_inner table.td tfoot tr:nth-child(odd)' => array( 'background-color' ),
						),
					),

					// Items table Padding.
					'items_table_padding' => array(
						'title'         => __( 'Padding Top and Bottom', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'items_table_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'.order-items-normal #body_content_inner table.td th' => array( 'padding-top', 'padding-bottom' ),
							'.order-items-normal #body_content_inner table.td td' => array( 'padding-top', 'padding-bottom' ),
							'.order-items-light #body_content_inner table.td th' => array( 'padding-top', 'padding-bottom' ),
							'.order-items-light #body_content_inner table.td td' => array( 'padding-top', 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 50,
						),
					),
					// Items table Padding Left and Right.
					'items_table_padding_left_right' => array(
						'title'         => __( 'Padding Left and Right', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'items_table',
						'default'       => str_replace( 'px', '', Mailtpl_Woomail_Customizer::opt( 'items_table_padding' ) ),
						'live_method'   => 'css',
						'selectors'     => array(
							'.order-items-normal #body_content_inner table.td th' => array( 'padding-left', 'padding-right' ),
							'.order-items-normal #body_content_inner table.td td' => array( 'padding-left', 'padding-right' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 50,
						),
					),

					// Items table Border width
					'items_table_border_width' => array(
						'title'         => __( 'Border Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'items_table_border_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'.order-items-normal #body_content_inner .td'    => array( 'border-width' ),
							'.order-items-light #body_content_inner table.td .td'    => array( 'border-bottom-width' ),
							'.order-items-light #body_content_inner table.td'    => array( 'border-top-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 10,
						),
					),

					// Items table Border color
					'items_table_border_color' => array(
						'title'         => __( 'Border Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'items_table_border_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .td'   => array( 'border-color' ),
						),
					),
					// tems table border style
					'items_table_border_style' => array(
						'title'         => __( 'Border Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'items_table_border_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'solid'     => __( 'Solid', 'mailtpl-woocommerce-email-composer' ),
							'double'    => __( 'Double', 'mailtpl-woocommerce-email-composer' ),
							'groove'    => __( 'Groove', 'mailtpl-woocommerce-email-composer' ),
							'dotted'    => __( 'Dotted', 'mailtpl-woocommerce-email-composer' ),
							'dashed'    => __( 'Dashed', 'mailtpl-woocommerce-email-composer' ),
							'ridge'     => __( 'Ridge', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'.order-items-normal #body_content_inner .td' => array( 'border-style' ),
							'.order-items-light #body_content_inner table.td .td' => array( 'border-bottom-style' ),
							'.order-items-light #body_content_inner table.td' => array( 'border-top-style' ),
						),
					),
					// Order ITEMS
					'order_heading_style' => array(
						'title'         => __( 'Order Table Heading Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'items_table',
						'default'       => self::get_default_value( 'order_heading_style' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'normal'        => __( 'Normal', 'mailtpl-woocommerce-email-composer' ),
							'split'         => __( 'Split', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					'notes_outside_table' => array(
						'title'         => __( 'Enable Order Notes to be moved below table.', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'toggleswitch',
						'section'       => 'items_table',
						'transport'     => 'refresh',
						'default'       => self::get_default_value( 'notes_outside_table' ),
						'active_callback' => array(
							'id' => 'responsive_mode',
							'compare' => '==',
							'value' => false,
						),
					),
					// addresses Background color
					'addresses_background_color' => array(
						'title'         => __( 'Address Box Background color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'addresses',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'addresses_background_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .address-td' => array( 'background-color' ),
						),
					),
					// addresses Padding
					'addresses_padding' => array(
						'title'         => __( 'Address Box Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'addresses',
						'default'       => self::get_default_value( 'addresses_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .address-td'    => array( 'padding' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 100,
						),
					),
					// addresses Border width
					'addresses_border_width' => array(
						'title'         => __( 'Address Box Border Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'addresses',
						'default'       => self::get_default_value( 'addresses_border_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .address-td'    => array( 'border-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 10,
						),
					),
					// addresses Border color
					'addresses_border_color' => array(
						'title'         => __( 'Address Box Border Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'addresses',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'addresses_border_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .address-td'   => array( 'border-color' ),
						),
					),
					// h2 style
					'addresses_border_style' => array(
						'title'         => __( 'Address Box Border Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'addresses',
						'default'       => self::get_default_value( 'addresses_border_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'solid'     => __( 'Solid', 'mailtpl-woocommerce-email-composer' ),
							'double'    => __( 'Double', 'mailtpl-woocommerce-email-composer' ),
							'groove'    => __( 'Groove', 'mailtpl-woocommerce-email-composer' ),
							'dotted'    => __( 'Dotted', 'mailtpl-woocommerce-email-composer' ),
							'dashed'    => __( 'Dashed', 'mailtpl-woocommerce-email-composer' ),
							'ridge'     => __( 'Ridge', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#body_content_inner .address-td' => array( 'border-style' ),
						),
					),
					// addresses color
					'addresses_text_color' => array(
						'title'         => __( 'Address Box Text Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'addresses',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'addresses_text_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#body_content_inner .address-td'    => array( 'color' ),
						),
					),
					// addresses text align
					'addresses_text_align' => array(
						'title'         => __( 'Address Box Text Align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'addresses',
						'default'       => self::get_default_value( 'addresses_text_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_text_aligns(),
						'selectors'     => array(
							'#body_content_inner .address-td' => array( 'text-align' ),
						),
					),
					// Footer Background Width
					'footer_background_placement' => array(
						'title'         => __( 'Footer Background Placement', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_style',
						'default'       => self::get_default_value( 'footer_background_placement' ),
						'transport'     => 'refresh',
						'type'          => 'select',
						'choices'       => array(
							'inside'        => __( 'Inside Body Container', 'mailtpl-woocommerce-email-composer' ),
							'outside'       => __( 'Outside Body Container', 'mailtpl-woocommerce-email-composer' ),
						),
					),
					// Footer Background Color
					'footer_background_color' => array(
						'title'         => __( 'Footer Background Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_style',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'footer_background_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer_container' => array( 'background-color' ),
							'.gmail-app-fix' => array( 'background-color' ),
						),
					),
					// Footer Top Padding
					'footer_top_padding' => array(
						'title'         => __( 'Top Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_style',
						'default'       => self::get_default_value( 'footer_top_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #template_footer_inside' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Footer Bottom Padding
					'footer_bottom_padding' => array(
						'title'         => __( 'Bottom Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_style',
						'default'       => self::get_default_value( 'footer_bottom_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #template_footer_inside' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Footer left and right Padding
					'footer_left_right_padding' => array(
						'title'         => __( 'Left/Right Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_style',
						'default'       => self::get_default_value( 'footer_left_right_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #template_footer_inside' => array( 'padding-left', 'padding-right' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					'footer_social_enable' => array(
						'title'         => __( 'Enable Social Section', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'toggleswitch',
						'section'       => 'footer_social',
						'transport'     => 'refresh',
						'default'       => self::get_default_value( 'footer_social_enable' ),
					),
					// Footer social repeater
					'footer_social_repeater' => array(
						'title'         => __( 'Footer Social Options', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'repeater',
						'transport'     => 'refresh',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'social_options' ),
						'customizer_repeater_image_control' => true,
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_icon_color' => true,
						'customizer_repeater_title_control' => true,
						'customizer_repeater_link_control' => true,
						'santitize_callback'    => 'customizer_repeater_sanitize',
					),
					// Footer Social Title Color
					'footer_social_title_color' => array(
						'title'         => __( 'Footer Social Title Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_title_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer a.ft-social-link' => array( 'color' ),
						),
						'control_type'  => 'color',
					),
					// Footer Social Title Font size
					'footer_social_title_size' => array(
						'title'         => __( 'Footer Social Title Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_title_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer .ft-social-title' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 8,
							'max'   => 30,
						),
					),
					// Footer Social Title Font family
					'footer_social_title_font_family' => array(
						'title'         => __( 'Footer Social Title Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_title_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_footer a.ft-social-link' => array( 'font-family' ),
						),
					),
					// Footer Social Title Font weight
					'footer_social_title_font_weight' => array(
						'title'         => __( 'Footer Social Title Font Weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_title_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer .ft-social-title' => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// Footer Social Top Padding
					'footer_social_top_padding' => array(
						'title'         => __( 'Top Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_top_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #footersocial td' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Footer Social Bottom Padding
					'footer_social_bottom_padding' => array(
						'title'         => __( 'Bottom Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_bottom_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #footersocial td' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Footer Social Bottom Border width
					'footer_social_border_width' => array(
						'title'         => __( 'Footer Social Bottom Border Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_border_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#footersocial'    => array( 'border-bottom-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 10,
						),
					),
					// Footer Social Bottom Bordercolor
					'footer_social_border_color' => array(
						'title'         => __( 'Footer Social Bottom Border Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_social',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'footer_social_border_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#footersocial'   => array( 'border-bottom-color' ),
						),
					),
					// Footer Social Bottom Border style
					'footer_social_border_style' => array(
						'title'         => __( 'Footer Social Bottom Border Style', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_social',
						'default'       => self::get_default_value( 'footer_social_border_style' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => array(
							'solid'     => __( 'Solid', 'mailtpl-woocommerce-email-composer' ),
							'double'    => __( 'Double', 'mailtpl-woocommerce-email-composer' ),
							'groove'    => __( 'Groove', 'mailtpl-woocommerce-email-composer' ),
							'dotted'    => __( 'Dotted', 'mailtpl-woocommerce-email-composer' ),
							'dashed'    => __( 'Dashed', 'mailtpl-woocommerce-email-composer' ),
							'ridge'     => __( 'Ridge', 'mailtpl-woocommerce-email-composer' ),
						),
						'selectors'     => array(
							'#footersocial' => array( 'border-bottom-style' ),
						),
					),
					// Footer Text align
					'footer_text_align' => array(
						'title'         => __( 'Text Align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_text_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_text_aligns(),
						'selectors'     => array(
							'#template_footer #credit' => array( 'text-align' ),
						),
					),

					// Footer Font size
					'footer_font_size' => array(
						'title'         => __( 'Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_font_size' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #credit' => array( 'font-size' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 8,
							'max'   => 30,
						),
					),
					// Footer Font family
					'footer_font_family' => array(
						'title'         => __( 'Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'#template_footer #credit' => array( 'font-family' ),
						),
					),

					// Footer Font weight
					'footer_font_weight' => array(
						'title'         => __( 'Font weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #credit' => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),

					// Footer Color
					'footer_color' => array(
						'title'         => __( 'Text Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'footer_content',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'footer_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #credit' => array( 'color' ),
							'#template_footer #credit p' => array( 'color' ),
							'#template_footer #credit a' => array( 'color' ),
						),
					),
					// Footer credit Top Padding
					'footer_credit_top_padding' => array(
						'title'         => __( 'Top Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_credit_top_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #credit' => array( 'padding-top' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Footer credit Bottom Padding
					'footer_credit_bottom_padding' => array(
						'title'         => __( 'Bottom Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'footer_content',
						'default'       => self::get_default_value( 'footer_credit_bottom_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'#template_footer #credit' => array( 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Button Color.
					'btn_color' => array(
						'title'        => __( 'Button Text Color', 'mailtpl-woocommerce-email-composer' ),
						'section'      => 'btn_styles',
						'default'      => self::get_default_value( 'btn_color' ),
						'live_method'  => 'css',
						'selectors'    => array(
							'a.btn' => array( 'color' ),
						),
						'control_type' => 'color',
					),
					// Button Text Size.
					'btn_size' => array(
						'title'        => __( 'Button Font Size', 'mailtpl-woocommerce-email-composer' ),
						'control_type' => 'rangevalue',
						'section'      => 'btn_styles',
						'default'      => self::get_default_value( 'btn_size' ),
						'live_method'  => 'css',
						'selectors'    => array(
							'a.btn' => array( 'font-size' ),
						),
						'input_attrs'  => array(
							'step' => 1,
							'min'  => 8,
							'max'  => 30,
						),
					),
					// Button Font Family
					'btn_font_family' => array(
						'title'         => __( 'Button Font Family', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_font_family' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_font_families(),
						'selectors'     => array(
							'a.btn' => array( 'font-family' ),
						),
					),
					// Button Font weight.
					'btn_font_weight' => array(
						'title'         => __( 'Button Font Weight', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_font_weight' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a.btn' => array( 'font-weight' ),
						),
						'input_attrs' => array(
							'step'  => 100,
							'min'   => 100,
							'max'   => 900,
						),
					),
					// Button Background Color.
					'btn_bg_color' => array(
						'title'        => __( 'Button Background Color', 'mailtpl-woocommerce-email-composer' ),
						'section'      => 'btn_styles',
						'default'      => self::get_default_value( 'btn_bg_color' ),
						'live_method'  => 'css',
						'selectors'    => array(
							'a.btn' => array( 'background' ),
						),
						'control_type' => 'color',
					),
					// Button Top and bottom Padding.
					'btn_top_bottom_padding' => array(
						'title'         => __( 'Top and Bottom Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_top_bottom_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a.btn' => array( 'padding-top', 'padding-bottom' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Button Left and Right Padding.
					'btn_left_right_padding' => array(
						'title'         => __( 'Left and Right Padding', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_left_right_padding' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a.btn' => array( 'padding-left', 'padding-right' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 150,
						),
					),
					// Button Border Width.
					'btn_border_width' => array(
						'title'         => __( 'Button Border Width', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_border_width' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a.btn'    => array( 'border-width' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 10,
						),
					),
					// Border radius
					'btn_border_radius' => array(
						'title'         => __( 'Border radius', 'mailtpl-woocommerce-email-composer' ),
						'control_type'  => 'rangevalue',
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_border_radius' ),
						'live_method'   => 'css',
						'description'   => __( 'Warning: most desktop email clients do not yet support this.', 'mailtpl-woocommerce-email-composer' ),
						'selectors'     => array(
							'a.btn'   => array( 'border-radius' ),
						),
						'input_attrs' => array(
							'step'  => 1,
							'min'   => 0,
							'max'   => 100,
						),
					),
					// Button Bordercolor
					'btn_border_color' => array(
						'title'         => __( 'Button Border Color', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'btn_styles',
						'control_type'  => 'color',
						'default'       => self::get_default_value( 'btn_border_color' ),
						'live_method'   => 'css',
						'selectors'     => array(
							'a.btn'   => array( 'border-color' ),
						),
					),
					// Button Text align
					'btn_text_align' => array(
						'title'         => __( 'Button Align', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'btn_styles',
						'default'       => self::get_default_value( 'btn_text_align' ),
						'live_method'   => 'css',
						'type'          => 'select',
						'choices'       => self::get_text_aligns(),
						'selectors'     => array(
							'#body_content_inner .btn-container' => array( 'text-align' ),
						),
					),
					'custom_css' => array(
						'title'       => __( 'Custom CSS', 'mailtpl-woocommerce-email-composer' ),
						'section'     => 'custom_styles',
						'default'     => '',
						'type'        => 'textarea',
						'live_method' => 'replace',
						'original'    => '',
						'selectors'   => array(
							'style#Mailtpl_Woomailcustom_css',
						),
					),
					'import_export' => array(
						'title'         => __( 'Import Export', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'import_export',
						'default'       => '',
						'control_type'  => 'kwdimportexport',
					),
					'email_recipient' => array(
						'title'         => __( 'Preview Email Recipient', 'mailtpl-woocommerce-email-composer' ),
						'description'   => __( 'Enter recipients (comma separated) for preview emails', 'mailtpl-woocommerce-email-composer' ),
						'section'       => 'send_email',
						'default'       => self::get_default_value( 'email_recipient' ),
						'control_type'  => 'kwdsendemail',
					),
				);
				$mainoptions = array_merge( $mainoptions, $main );
				self::$settings = array_merge( $extra_email_text, $mainoptions );

			}

			// Return settings
			return self::$settings;
		}
		/**
		 * Get default values
		 *
		 * @access public
		 * @return array
		 */
		public static function get_default_values() {
			// Define default values
			if ( is_null( self::$default_values ) ) {
				$default_values = array(
					'preview_order_id'                                              => 'mockup',
					'email_type'                                                    => 'new_order',
					'email_templates'                                               => 'default',
					'body_background_color'                                         => '#fdfdfd',
					'border_radius'                                                 => '3',
					'border_width'                                                  => '1',
					'border_color'                                                  => '#dedede',
					'responsive_mode'                                               => false,
					'shadow'                                                        => '1',
					'content_width'                                                 => '600',
					'email_padding'                                                 => '70',
					'background_color'                                              => '#ffffff',
					'header_image_maxwidth'                                         => '300',
					'header_image_align'                                            => 'center',
					'header_image_background_color'                                 => 'transparent',
					'header_image_padding_top_bottom'                               => '0',
					'header_image_placement'                                        => 'outside',
					'woocommerce_waitlist_mailout_body'                             => __( 'Hi There,', 'mailtpl-woocommerce-email-composer' ),
					'woocommerce_waitlist_mailout_heading'                          => __( '{product_title} is now back in stock at {site_title}', 'mailtpl-woocommerce-email-composer' ),
					'woocommerce_waitlist_mailout_subject'                          => __( 'A product you are waiting for is back in stock', 'mailtpl-woocommerce-email-composer' ),
					'new_renewal_order_heading'                                     => __( 'New customer order', 'mailtpl-woocommerce-email-composer' ),
					'new_renewal_order_subject'                                     => __( '[{site_title}] New customer order ({order_number}) - {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'new_renewal_order_body'                                        => __( 'You have received a subscription renewal order from {customer_full_name}. Their order is as follows:', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_renewal_order_heading'                     => __( 'Thank you for your order', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_renewal_order_subject'                     => __( 'Your {site_title} order receipt from {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_renewal_order_body'                        => __( 'Your subscription renewal order has been received and is now being processed. Your order details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_renewal_order_heading'                      => __( 'Your order is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_renewal_order_subject'                      => __( 'Your {site_title} order from {order_date} is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_renewal_order_body'                         => __( 'Hi there. Your subscription renewal order with {site_title} has been completed. Your order details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_switch_order_heading'                       => __( 'Your order is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_switch_order_subject'                       => __( 'Your {site_title} order from {order_date} is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_switch_order_body'                          => __( 'Hi there. You have successfully changed your subscription items on {site_title}. Your new order and subscription details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_renewal_invoice_heading'                              => __( 'Invoice for order {order_number}', 'mailtpl-woocommerce-email-composer' ),
					'customer_renewal_invoice_subject'                              => __( 'Invoice for order {order_number}', 'mailtpl-woocommerce-email-composer' ),
					'customer_renewal_invoice_body'                                 => __( 'An invoice has been created for you to renew your subscription with {site_title}. To pay for this invoice please use the following link: {invoice_pay_link}', 'mailtpl-woocommerce-email-composer' ),
					'customer_renewal_invoice_btn_switch'                           => false,
					'customer_renewal_invoice_body_failed'                          => __( 'The automatic payment to renew your subscription with {site_title} has failed. To reactivate the subscription, please login and pay for the renewal from your account page: {invoice_pay_link}', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_subscription_heading'                                => __( 'Subscription Cancelled', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_subscription_subject'                                => __( '[{site_title}] Subscription Cancelled', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_subscription_body'                                   => __( 'A subscription belonging to {customer_full_name} has been cancelled. Their subscription\'s details are as follows:', 'mailtpl-woocommerce-email-composer' ),
					'customer_payment_retry_heading'                                => __( 'Automatic payment failed for order {order_number}', 'mailtpl-woocommerce-email-composer' ),
					'customer_payment_retry_subject'                                => __( 'Automatic payment failed for {order_number}, we will retry {retry_time}', 'mailtpl-woocommerce-email-composer' ),
					'customer_payment_retry_body'                                   => '',
					'customer_payment_retry_override'                               => false,
					'customer_payment_retry_btn_switch'                             => false,
					'admin_payment_retry_heading'                                   => __( 'Automatic renewal payment failed', 'mailtpl-woocommerce-email-composer' ),
					'admin_payment_retry_subject'                                   => __( '[{site_title}] Automatic payment failed for {order_number}, retry scheduled to run {retry_time}', 'mailtpl-woocommerce-email-composer' ),
					'admin_payment_retry_body'                                      => '',
					'admin_payment_retry_override'                                  => false,
					'new_order_heading'                                             => __( 'New customer order', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_order_heading'                                       => __( 'Cancelled order', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order_heading'                             => __( 'Thank you for your order', 'mailtpl-woocommerce-email-composer' ),
					'new_order_additional_content'                                  => __( 'Congratulations on the sale!', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order_additional_content'                  => __( 'Thanks for using {site_address}!', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order_additional_content'                   => __( 'Thanks for shopping with us.', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_additional_content'                    => __( 'We hope to see you again soon.', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order_additional_content'                     => __( 'We look forward to fulfilling your order soon.', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account_additional_content'                       => __( 'We look forward to seeing you soon.', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password_additional_content'                    => __( 'Thanks for reading.', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order_heading'                              => __( 'Your order is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_heading_full'                          => __( 'Order {order_number} details', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_heading_partial'                       => __( 'Your order has been partially refunded', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order_heading'                                => __( 'Thank you for your order', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_heading'                                      => __( 'Invoice for order {order_number}', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_heading_paid'                                 => __( 'Your order details', 'mailtpl-woocommerce-email-composer' ),
					'failed_order_heading'                                          => __( 'Failed order', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account_heading'                                  => __( 'Welcome to {site_title}', 'mailtpl-woocommerce-email-composer' ),
					'customer_note_heading'                                         => __( 'A note has been added to your order', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password_heading'                               => __( 'Password reset instructions', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password_btn_switch'                            => false,
					'new_order_subject'                                             => __( '[{site_title}] New customer order ({order_number}) - {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_order_subject'                                       => __( '[{site_title}] Cancelled order ({order_number})', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order_subject'                             => __( 'Your {site_title} order receipt from {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order_subject'                              => __( 'Your {site_title} order from {order_date} is complete', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_subject_full'                          => __( 'Your {site_title} order from {order_date} has been refunded', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_subject_partial'                       => __( 'Your {site_title} order from {order_date} has been partially refunded', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order_subject'                                => __( 'Your {site_title} order receipt from {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_subject'                                      => __( 'Invoice for order {order_number}', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_subject_paid'                                 => __( 'Your {site_title} order from {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'failed_order_subject'                                          => __( '[{site_title}] Failed order ({order_number})', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account_subject'                                  => __( 'Your account on {site_title}', 'mailtpl-woocommerce-email-composer' ),
					'customer_note_subject'                                         => __( 'Note added to your {site_title} order from {order_date}', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password_subject'                               => __( 'Password reset for {site_title}', 'mailtpl-woocommerce-email-composer' ),
					'new_order_body'                                                => __( 'You have received an order from {customer_full_name}. The order is as follows:', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_order_body'                                          => __( 'The order {order_number} from {customer_full_name} has been cancelled. The order was as follows:', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order_body'                                => __( 'Your order has been received and is now being processed. Your order details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order_body'                                 => __( 'Hi there. Your recent order on {site_title} has been completed. Your order details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_switch'                                => true,
					'customer_refunded_order_body_full'                             => __( 'Hi there. Your order on {site_title} has been refunded.', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order_body_partial'                          => __( 'Hi there. Your order on {site_title} has been partially refunded.', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order_body'                                   => __( 'Your order is on-hold until we confirm payment has been received. Your order details are shown below for your reference:', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_switch'                                       => true,
					'customer_invoice_btn_switch'                                   => false,
					'customer_invoice_body'                                         => __( 'An order has been created for you on {site_title}. {invoice_pay_link}', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice_body_paid'                                    => '',
					'failed_order_body'                                             => __( 'Payment for order {order_number} from {customer_full_name} has failed. The order was as follows:', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account_btn_switch'                               => false,
					'customer_new_account_account_section'                          => true,
					'customer_new_account_body'                                     => __( 'Thanks for creating an account on {site_title}. Your username is {customer_username}', 'mailtpl-woocommerce-email-composer' ),
					'customer_note_body'                                            => __( 'Hello, a note has just been added to your order:', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password_body'                                  => __(
						'Someone requested that the password be reset for the following account:

Username: {customer_username}

If this was a mistake, just ignore this email and nothing will happen.

To reset your password, visit the following address:',
						'mailtpl-woocommerce-email-composer'
					),
					'WC_Memberships_User_Membership_Ended_Email_heading'            => __( 'Renew your {membership_plan}', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Ended_Email_subject'            => __( 'Your {site_title} membership has expired', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Activated_Email_heading'        => __( 'You can now access {membership_plan}', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Activated_Email_subject'        => __( 'Your {site_title} membership is now active!', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Ending_Soon_Email_heading'      => __( 'An update about your {membership_plan}', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Ending_Soon_Email_subject'      => __( 'Your {site_title} membership ends soon!', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Note_Email_heading'             => __( 'A note has been added about your membership', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Note_Email_subject'             => __( 'Note added to your {site_title} membership', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Renewal_Reminder_Email_heading' => __( 'You can renew your {membership_plan}', 'mailtpl-woocommerce-email-composer' ),
					'WC_Memberships_User_Membership_Renewal_Reminder_Email_subject' => __( 'Renew your {site_title} membership!', 'mailtpl-woocommerce-email-composer' ),
					'customer_delivered_order_heading'                              => __( 'Thanks for shopping with us', 'mailtpl-woocommerce-email-composer' ),
					'customer_delivered_order_subject'                              => __( 'Your {site_title} order is now delivered', 'mailtpl-woocommerce-email-composer' ),
					'customer_delivered_order_body'                                 => __(
						'Hi {customer_full_name}
						Your {site_title} order has been marked delivered on our side.',
						'mailtpl-woocommerce-email-composer'
					),
					'header_background_color'                                       => get_option( 'woocommerce_email_base_color' ),
					'header_text_align'                                             => 'left',
					'header_padding_top_bottom'                                     => '36',
					'header_padding_left_right'                                     => '48',
					'heading_font_size'                                             => '30',
					'heading_line_height'                                           => '40',
					'heading_font_family'                                           => 'helvetica',
					'heading_font_style'                                            => 'normal',
					'heading_color'                                                 => '#ffffff',
					'heading_font_weight'                                           => '300',
					'subtitle_placement'                                            => 'below',
					'subtitle_font_size'                                            => '18',
					'subtitle_line_height'                                          => '24',
					'subtitle_font_family'                                          => 'helvetica',
					'subtitle_font_style'                                           => 'normal',
					'subtitle_color'                                                => '#ffffff',
					'subtitle_font_weight'                                          => '300',
					'content_padding'                                               => '48',
					'content_padding_bottom'                                        => '0',
					'text_color'                                                    => '#737373',
					'font_family'                                                   => 'helvetica',
					'font_size'                                                     => '14',
					'line_height'                                                   => '24',
					'font_weight'                                                   => '400',
					'link_color'                                                    => get_option( 'woocommerce_email_base_color' ),
					'h2_font_size'                                                  => '18',
					'h2_line_height'                                                => '26',
					'h2_font_family'                                                => 'helvetica',
					'h3_font_style'                                                 => 'normal',
					'h2_color'                                                      => get_option( 'woocommerce_email_base_color' ),
					'h2_font_weight'                                                => '700',
					'h2_margin_bottom'                                              => '18',
					'h2_padding_top'                                                => '0',
					'h2_margin_top'                                                 => '0',
					'h2_padding_bottom'                                             => '0',
					'h2_text_transform'                                             => 'none',
					'h2_separator_color'                                            => get_option( 'woocommerce_email_base_color' ),
					'h2_separator_height'                                           => '1',
					'h2_separator_style'                                            => 'solid',
					'h3_font_size'                                                  => '16',
					'h3_line_height'                                                => '20',
					'h3_font_family'                                                => 'helvetica',
					'h3_font_style'                                                 => 'normal',
					'h3_color'                                                      => '#787878',
					'h3_font_weight'                                                => '500',
					'btn_border_width'                                              => '0',
					'btn_border_radius'                                             => '4',
					'btn_border_color'                                              => '#dedede',
					'btn_font_family'                                               => 'helvetica',
					'btn_color'                                                     => '#ffffff',
					'btn_font_weight'                                               => '600',
					'btn_left_right_padding'                                        => '8',
					'btn_top_bottom_padding'                                        => '10',
					'btn_size'                                                      => '16',
					'order_items_style'                                             => 'normal',
					'order_items_image'                                             => 'normal',
					'order_items_image_size'                                        => '100x50',
					'items_table_border_width'                                      => '1',
					'items_table_border_color'                                      => '#e4e4e4',
					'items_table_border_style'                                      => 'solid',
					'items_table_background_color'                                  => '',
					'items_table_background_odd_color'                              => '',
					'items_table_padding'                                           => '12',
					'order_heading_style'                                           => 'normal',
					'notes_outside_table'                                           => false,
					'addresses_padding'                                             => '12',
					'addresses_border_width'                                        => '1',
					'addresses_border_color'                                        => '#e5e5e5',
					'addresses_border_style'                                        => 'solid',
					'addresses_background_color'                                    => '',
					'addresses_text_color'                                          => '#8f8f8f',
					'addresses_text_align'                                          => 'left',
					'footer_background_placement'                                   => 'inside',
					'footer_background_color'                                       => '',
					'footer_top_padding'                                            => '0',
					'footer_bottom_padding'                                         => '48',
					'footer_left_right_padding'                                     => '48',
					'footer_social_enable'                                          => true,
					'footer_social_title_color'                                     => '#000000',
					'footer_social_title_font_family'                               => 'helvetica',
					'footer_social_title_font_size'                                 => '18',
					'footer_social_title_font_weight'                               => '400',
					'footer_social_top_padding'                                     => '0',
					'footer_social_bottom_padding'                                  => '0',
					'footer_social_border_width'                                    => '0',
					'footer_social_border_color'                                    => '#dddddd',
					'footer_social_border_style'                                    => 'solid',
					'footer_text_align'                                             => 'center',
					'footer_font_size'                                              => '12',
					'footer_font_family'                                            => 'helvetica',
					'footer_color'                                                  => '#555555',
					'footer_font_weight'                                            => '400',
					'footer_credit_bottom_padding'                                  => '0',
					'footer_credit_top_padding'                                     => '0',
					'items_table_border_width'                                      => '1',
					'items_table_border_color'                                      => '#e4e4e4',
					'footer_content_text'                                           => get_option( 'woocommerce_email_footer_text', '' ),
					'email_recipient'                                               => get_option( 'admin_email' ),
					'customer_ekomi_heading'                                        => _x( 'Please rate your Order', 'ekomi', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account_activation_heading'                       => __( 'Account activation {site_title}', 'mailtpl-woocommerce-email-composer' ),
					'customer_paid_for_order_heading'                               => __( 'Payment received', 'mailtpl-woocommerce-email-composer' ),
					'customer_revocation_heading'                                   => __( 'Your revocation', 'mailtpl-woocommerce-email-composer' ),
					'customer_sepa_direct_debit_mandate'                            => __( 'SEPA Direct Debit Mandate', 'mailtpl-woocommerce-email-composer' ),
					'customer_trusted_shops'                                        => _x( 'Please rate your Order', 'trusted-shops', 'mailtpl-woocommerce-email-composer' ),
					'woocommerce_waitlist_mailout_hide_content'                     => false,
					'header_image_link'                                             => true,
					'email_schema'                                                  => false,
				);
				self::$default_values = apply_filters( 'mailtpl_woomail_email_settings_default_values', $default_values );
			}

			// Return default values.
			return self::$default_values;
		}

		/**
		 * Get default values
		 *
		 * @access public
		 * @param string $key the setting key.
		 * @return string
		 */
		public static function get_default_value( $key ) {
			// Get default values.
			$default_values = self::get_default_values();

			// Check if such key exists and return default value.
			return isset( $default_values[ $key ] ) ? $default_values[ $key ] : '';
		}

		/**
		 * Get border styles
		 *
		 * @access public
		 * @return array
		 */
		public static function get_border_styles() {
			return array(
				'none'   => __( 'none', 'mailtpl-woocommerce-email-composer' ),
				'hidden' => __( 'hidden', 'mailtpl-woocommerce-email-composer' ),
				'dotted' => __( 'dotted', 'mailtpl-woocommerce-email-composer' ),
				'dashed' => __( 'dashed', 'mailtpl-woocommerce-email-composer' ),
				'solid'  => __( 'solid', 'mailtpl-woocommerce-email-composer' ),
				'double' => __( 'double', 'mailtpl-woocommerce-email-composer' ),
				'groove' => __( 'groove', 'mailtpl-woocommerce-email-composer' ),
				'ridge'  => __( 'ridge', 'mailtpl-woocommerce-email-composer' ),
				'inset'  => __( 'inset', 'mailtpl-woocommerce-email-composer' ),
				'outset' => __( 'outset', 'mailtpl-woocommerce-email-composer' ),
			);
		}

		/**
		 * Get text align options
		 *
		 * @access public
		 * @return array
		 */
		public static function get_text_aligns() {
			return array(
				'left'    => __( 'Left', 'mailtpl-woocommerce-email-composer' ),
				'center'  => __( 'Center', 'mailtpl-woocommerce-email-composer' ),
				'right'   => __( 'Right', 'mailtpl-woocommerce-email-composer' ),
				'justify' => __( 'Justify', 'mailtpl-woocommerce-email-composer' ),
			);
		}
		/**
		 * Get image align options
		 *
		 * @access public
		 * @return array
		 */
		public static function get_image_aligns() {
			return array(
				'left'   => __( 'Left', 'mailtpl-woocommerce-email-composer' ),
				'center' => __( 'Center', 'mailtpl-woocommerce-email-composer' ),
				'right'  => __( 'Right', 'mailtpl-woocommerce-email-composer' ),
			);
		}
		/**
		 * Get Order Ids
		 *
		 * @access public
		 * @return array
		 */
		public static function get_order_ids() {
			if ( is_null( self::$order_ids ) ) {
				$order_array           = array();
				$order_array['mockup'] = __( 'Mockup Order', 'mailtpl-woocommerce-email-composer' );
				$orders = new WP_Query(
					array(
						'post_type'      => 'shop_order',
						'post_status'    => array_keys( wc_get_order_statuses() ),
						'posts_per_page' => 20,
					)
				);
				if ( $orders->posts ) {
					foreach ( $orders->posts as $order ) {
						// Get order object.
						$order_object = new WC_Order( $order->ID );
						$order_array[ $order_object->get_id() ] = $order_object->get_id() . ' - ' . $order_object->get_billing_first_name() . ' ' . $order_object->get_billing_last_name();
					}
				}
				self::$order_ids = $order_array;
			}
			return self::$order_ids;
		}
		/**
		 * Get font families
		 *
		 * @access public
		 * @return array
		 */
		public static function get_font_families() {
			return apply_filters( 'mailtpl_woomail_email_font_families', self::$font_family_mapping );
		}

		/**
		 * Get Email Types
		 *
		 * @access public
		 * @return array
		 */
		public static function get_email_types() {
			if ( is_null( self::$email_types ) ) {
				$types = array(
					'new_order'                 => __( 'New Order', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_order'           => __( 'Cancelled Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order' => __( 'Customer Processing Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order'  => __( 'Customer Completed Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order'   => __( 'Customer Refunded Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order'    => __( 'Customer On Hold Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice'          => __( 'Customer Invoice', 'mailtpl-woocommerce-email-composer' ),
					'failed_order'              => __( 'Failed Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account'      => __( 'Customer New Account', 'mailtpl-woocommerce-email-composer' ),
					'customer_note'             => __( 'Customer Note', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password'   => __( 'Customer Reset Password', 'mailtpl-woocommerce-email-composer' ),
				);
				if ( class_exists( 'WC_Subscriptions' ) ) {
					$types = array_merge( $types, array(
						'new_renewal_order'                 => __( 'New Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_processing_renewal_order' => __( 'Customer Processing Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_completed_renewal_order'  => __( 'Customer Completed Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_completed_switch_order'   => __( 'Customer Completed Switch Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_renewal_invoice'          => __( 'Customer Renewal Invoice', 'mailtpl-woocommerce-email-composer' ),
						'cancelled_subscription'            => __( 'Cancelled Subscription', 'mailtpl-woocommerce-email-composer' ),
						'customer_payment_retry'            => __( 'Customer Payment Retry', 'mailtpl-woocommerce-email-composer' ),
						'admin_payment_retry'               => __( 'Payment Retry', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WC_Memberships' ) ) {
					$types = array_merge( $types, array(
						'WC_Memberships_User_Membership_Note_Email'             => __( 'User Membership Note', 'mailtpl-woocommerce-email-composer' ),
						'WC_Memberships_User_Membership_Ending_Soon_Email'      => __( 'User Membership Ending Soon', 'mailtpl-woocommerce-email-composer' ),
						'WC_Memberships_User_Membership_Ended_Email'            => __( 'User Membership Ended', 'mailtpl-woocommerce-email-composer' ),
						'WC_Memberships_User_Membership_Renewal_Reminder_Email' => __( 'User Membership Renewal Reminder', 'mailtpl-woocommerce-email-composer' ),
						'WC_Memberships_User_Membership_Activated_Email'        => __( 'User Membership Activated', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WCMp' ) ) {
					$types = array_merge( $types, array(
						'vendor_new_account'                => __( 'New Vendor Account', 'mailtpl-woocommerce-email-composer' ),
						'admin_new_vendor'                  => __( 'Admin New Vendor Account', 'mailtpl-woocommerce-email-composer' ),
						'approved_vendor_new_account'       => __( 'Approved Vendor Account', 'mailtpl-woocommerce-email-composer' ),
						'rejected_vendor_new_account'       => __( 'Rejected Vendor Account', 'mailtpl-woocommerce-email-composer' ),
						'vendor_new_order'                  => __( 'Vendor New order', 'mailtpl-woocommerce-email-composer' ),
						'notify_shipped'                    => __( 'Notify as Shipped.', 'mailtpl-woocommerce-email-composer' ),
						'admin_new_vendor_product'          => __( 'New Vendor Product', 'mailtpl-woocommerce-email-composer' ),
						'admin_added_new_product_to_vendor' => __( 'New Vendor Product By Admin', 'mailtpl-woocommerce-email-composer' ),
						'vendor_commissions_transaction'    => __( 'Transactions (for Vendor)', 'mailtpl-woocommerce-email-composer' ),
						'vendor_direct_bank'                => __( 'Commission Paid (for Vendor) by BAC', 'mailtpl-woocommerce-email-composer' ),
						'admin_widthdrawal_request'         => __( 'Withdrawal request to Admin from Vendor by BAC', 'mailtpl-woocommerce-email-composer' ),
						'vendor_orders_stats_report'        => __( 'Vendor orders stats report', 'mailtpl-woocommerce-email-composer' ),
						'vendor_contact_widget_email'       => __( 'Vendor Contact Email', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WooCommerce_Germanized' ) ) {
					$types = array_merge( $types, array(
						'customer_ekomi'                  => __( 'eKomi Review Reminder', 'mailtpl-woocommerce-email-composer' ),
						'customer_new_account_activation' => __( 'New account activation', 'mailtpl-woocommerce-email-composer' ),
						'customer_paid_for_order'         => __( 'Paid for order', 'mailtpl-woocommerce-email-composer' ),
						'customer_revocation'             => __( 'Revocation', 'mailtpl-woocommerce-email-composer' ),
						'customer_trusted_shops'          => __( 'Trusted Shops Review Reminder', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WooCommerce_Waitlist_Plugin' ) ) {
					$types = array_merge( $types, array(
						'woocommerce_waitlist_mailout' => __( 'Waitlist Mailout', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WC_Stripe' ) ) {
					$types = array_merge( $types, array(
						'failed_renewal_authentication'       => __( 'Failed Subscription Renewal SCA Authentication', 'mailtpl-woocommerce-email-composer' ),
						'failed_preorder_sca_authentication'  => __( 'Pre-order Payment Action Needed', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WC_Stripe' ) && class_exists( 'WC_Subscriptions' ) ) {
					$types = array_merge( $types, array(
						'failed_authentication_requested'     => __( 'Payment Authentication Requested Email', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				// if ( class_exists( 'Cartflows_Ca_Email_Templates' ) ) {
				// 	$email_tmpl = Cartflows_Ca_Email_Templates::get_instance();
				// 	$templates  = $email_tmpl->fetch_all_active_templates();
				// 	if ( ! empty( $templates ) ) {
				// 		$emails = array();
				// 		foreach ( $templates as $key => $value ) {
				// 			$emails['cartflows_ca_email_templates_' . $value->id] = 'CA: ' . $value->template_name;
				// 		}
				// 		$types = array_merge( $types, $emails );
				// 	}
				// }
				self::$email_types = apply_filters( 'mailtpl_woomail_email_types', $types );
			}

			return self::$email_types;
		}

		/**
		 * Get Email Types
		 *
		 * @access public
		 * @return array
		 */
		public static function get_customized_email_types() {
			if ( is_null( self::$customized_email_types ) ) {
				$types = array(
					'new_order'                 => __( 'New Order', 'mailtpl-woocommerce-email-composer' ),
					'cancelled_order'           => __( 'Cancelled Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_processing_order' => __( 'Customer Processing Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_completed_order'  => __( 'Customer Completed Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_refunded_order'   => __( 'Customer Refunded Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_on_hold_order'    => __( 'Customer On Hold Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_invoice'          => __( 'Customer Invoice', 'mailtpl-woocommerce-email-composer' ),
					'failed_order'              => __( 'Failed Order', 'mailtpl-woocommerce-email-composer' ),
					'customer_new_account'      => __( 'Customer New Account', 'mailtpl-woocommerce-email-composer' ),
					'customer_note'             => __( 'Customer Note', 'mailtpl-woocommerce-email-composer' ),
					'customer_reset_password'   => __( 'Customer Reset Password', 'mailtpl-woocommerce-email-composer' ),
				);
				if ( class_exists( 'WC_Subscriptions' ) ) {
					$types = array_merge( $types, array(
						'new_renewal_order'                 => __( 'New Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_processing_renewal_order' => __( 'Customer Processing Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_completed_renewal_order'  => __( 'Customer Completed Renewal Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_completed_switch_order'   => __( 'Customer Completed Switch Order', 'mailtpl-woocommerce-email-composer' ),
						'customer_renewal_invoice'          => __( 'Customer Renewal Invoice', 'mailtpl-woocommerce-email-composer' ),
						'cancelled_subscription'            => __( 'Cancelled Subscription', 'mailtpl-woocommerce-email-composer' ),
						'customer_payment_retry'            => __( 'Customer Payment Retry', 'mailtpl-woocommerce-email-composer' ),
						'admin_payment_retry'               => __( 'Payment Retry', 'mailtpl-woocommerce-email-composer' ),
					) );
				}
				if ( class_exists( 'WooCommerce_Waitlist_Plugin' ) ) {
					$types = array_merge( $types, array(
						'woocommerce_waitlist_mailout' => __( 'Waitlist Mailout', 'mailtpl-woocommerce-email-composer' ),
					) );
				}

				self::$customized_email_types = apply_filters( 'mailtpl_woomail_customized_email_types', $types );
			}

			return self::$customized_email_types;
		}

		/**
		 * Get Email Templates
		 *
		 * @access public
		 * @return array
		 */
		public static function get_email_templates() {
			return apply_filters( 'mailtpl_woomail_prebuilt_email_templates_settings', self::$prebuilt_templates_mapping );
		}
	}
}
