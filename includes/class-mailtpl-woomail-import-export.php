<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}
if ( ! class_exists( 'Mailtpl_Woomail_Import_Export' ) ) {

	class Mailtpl_Woomail_Import_Export {
		/**
		* @var null
		*/
		private static $instance = null;
		private static $woo_core_options = array(
			'woocommerce_email_header_image',
			'woocommerce_email_footer_text',
			'woocommerce_email_body_background_color',
			'woocommerce_email_text_color',
			'woocommerce_email_background_color',
			'woocommerce_new_order_settings[heading]',
			'woocommerce_new_order_settings[subject]',

			'woocommerce_cancelled_order_settings[heading]',
			'woocommerce_customer_processing_order_settings[heading]',
			'woocommerce_customer_completed_order_settings[heading]',
			'woocommerce_customer_refunded_order_settings[heading_full]',
			'woocommerce_customer_refunded_order_settings[heading_partial]',

			'woocommerce_customer_on_hold_order_settings[heading]',
			'woocommerce_customer_invoice_settings[heading]',
			'woocommerce_customer_invoice_settings[heading_paid]',
			'woocommerce_failed_order_settings[heading]',
			'woocommerce_customer_new_account_settings[heading]',
			'woocommerce_customer_note_settings[heading]',
			'woocommerce_customer_reset_password_settings[heading]',

			'woocommerce_cancelled_order_settings[subject]',
			'woocommerce_customer_processing_order_settings[subject]',
			'woocommerce_customer_completed_order_settings[subject]',

			'woocommerce_customer_refunded_order_settings[subject_full]',
			'woocommerce_customer_refunded_order_settings[subject_partial]',

			'woocommerce_customer_on_hold_order_settings[subject]',

			'woocommerce_customer_invoice_settings[subject]',
			'woocommerce_customer_invoice_settings[subject_paid]',

			'woocommerce_failed_order_settings[subject]',
			'woocommerce_customer_new_account_settings[subject]',
			'woocommerce_customer_note_settings[subject]',
			'woocommerce_customer_reset_password_settings[subject]',
		);
		private static $prebuilt_options = array();
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

			// Only proceed if this is own request
			if ( ! Mailtpl_Woomail_Composer::is_own_customizer_request() && ! Mailtpl_Woomail_Composer::is_own_preview_request() ) {
				return;
			}

			add_action( 'customize_register', array( $this, 'import_export_requests' ), 999999 );
			add_action( 'customize_controls_print_scripts', array( $this, 'controls_print_scripts' ) );

		}

		/**
	 	 * Check to see if we need to do an export or import.
	 	 * @param object $wp_customize An instance of WP_Customize_Manager.
		 * @return void
		 */
		static public function import_export_requests( $wp_customize ) {
			// Check if user is allowed to change values
			if ( ! Mailtpl_Woomail_Composer::is_admin()) {
				exit;
			}
			
			if ( isset( $_REQUEST['mailtpl-woomail-export'] ) ) {
				self::export_woomail( $wp_customize );
			}
			if ( isset( $_REQUEST['mailtpl-woomail-import'] ) && isset( $_FILES['mailtpl-woomail-import-file'] ) ) {
				self::import_woomail( $wp_customize );
			}

			if ( isset( $_REQUEST['mailtpl-woomail-import-template'] ) ) {
				self::import_woomail_template( $wp_customize );
			}


		}

		/**
		 * Export woomail settings.
		 *
		 * @access private
		 * @param object $wp_customize An instance of WP_Customize_Manager.
		 * @return void
		 */
		static private function export_woomail( $wp_customize )  {
			if ( ! wp_verify_nonce( $_REQUEST['mailtpl-woomail-export'], 'mailtpl-woomail-exporting' ) ) {
				return;
			}
			
			$template	= 'mailtpl-woomail-Composer';
			$charset	= get_option( 'blog_charset' );
			$data		= array(
							  'template'  => $template,
							  'options'	  => array()
						  );

			// Get options from the Customizer API.
			$settings = $wp_customize->settings();

			foreach ( $settings as $key => $setting ) {
				if ( stristr( $key, 'mailtpl_woomail' ) || in_array( $key, self::$woo_core_options ) ) {
					// to prevent issues we don't want to export the order id.
					if( $key != 'mailtpl_woomail[preview_order_id]' ) {
						$data['options'][ $key ] = $setting->value();
					}
				}
			}


			// Set the download headers.
			header( 'Content-disposition: attachment; filename=mailtpl-woomail-Composer-export.dat' );
			header( 'Content-Type: application/octet-stream; charset=' . $charset );

			// Serialize the export data.
			echo base64_encode( serialize( $data ) );

			// Start the download.
			die();
		}
		/**
		 * Imports uploaded Mailtpl woo email settings
		 *
		 * @access private
		 * @param object $wp_customize An instance of WP_Customize_Manager.
		 * @return void
		 */
		static private function import_woomail( $wp_customize ) {
			// Make sure we have a valid nonce.
			if ( ! wp_verify_nonce( $_REQUEST['mailtpl-woomail-import'], 'mailtpl-woomail-importing' ) ) {
				return;
			}
			// Make sure WordPress upload support is loaded.
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			
			// Load the export/import option class.
			require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-import-option.php';
			
			// Setup global vars.
			global $wp_customize;
			global $mailtpl_woomail_import_error;

			// Setup internal vars.
			$mailtpl_woomail_import_error	 = false;
			$template	 = 'mailtpl-woomail-Composer';
			$overrides   = array( 'test_form' => false, 'test_type' => false, 'mimes' => array('dat' => 'text/plain') );
			$file        = wp_handle_upload( $_FILES['mailtpl-woomail-import-file'], $overrides );

			// Make sure we have an uploaded file.
			if ( isset( $file['error'] ) ) {
				$mailtpl_woomail_import_error = $file['error'];
				return;
			}
			if ( ! file_exists( $file['file'] ) ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! Please try again.', 'mailtpl-woocommerce-email-composer' );
				return;
			}

			// Get the upload data.
			$raw  = file_get_contents( $file['file'] );
			//$data = @unserialize( $raw );
			// $data = self::mb_unserialize( $raw );
			$data = unserialize( base64_decode( $raw ) );
			if ( 'array' != gettype( $data ) || ! isset( $data['template'] ) ) {
				 $data = self::mb_unserialize( $raw );
			}
			// Remove the uploaded file.
			unlink( $file['file'] );

			// Data checks.
			if ( 'array' != gettype( $data ) ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! Please check that you uploaded an email customizer export file.', 'mailtpl-woocommerce-email-composer' );
				return;
			}
			if ( ! isset( $data['template'] ) ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! Please check that you uploaded an email customizer export file.', 'mailtpl-woocommerce-email-composer' );
				return;
			}
			if ( $data['template'] != $template ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! The settings you uploaded are not for the Mailtpl Woomail Composer.', 'mailtpl-woocommerce-email-composer' );
				return;
			}

			// Import custom options.
			if ( isset( $data['options'] ) ) {
				
				foreach ( $data['options'] as $option_key => $option_value ) {
					
					$option = new Mailtpl_Woomail_Import_Option( $wp_customize, $option_key, array(
						'default'		=> '',
						'type'			=> 'option',
						'capability'	=> Mailtpl_Woomail_Composer::get_admin_capability(),
					) );

					$option->import( $option_value );
				}
			}


			// Call the customize_save action.
			do_action( 'customize_save', $wp_customize );

			// Call the customize_save_after action.
			do_action( 'customize_save_after', $wp_customize );

			wp_redirect( Mailtpl_Woomail_Customizer::get_customizer_url() );

			exit;
		}
		/**
		 * Mulit-byte Unserialize
		 *
		 * UTF-8 will screw up a serialized string
		 *
		 * @access private
		 * @param string
		 * @return string
		 */
		static private function mb_unserialize( $string ) {
			$string2 = preg_replace_callback(
				'!s:(\d+):"(.*?)";!s',
				function( $m ){
					$len = strlen($m[2]);
					$result = "s:$len:\"{$m[2]}\";";
					return $result;

				},
			$string );
			return @unserialize( $string2 );
		}

		/**
		 * Imports prebuilt Mailtpl woo email settings
		 *
		 * @access private
		 * @param object $wp_customize An instance of WP_Customize_Manager.
		 * @return void
		 */
		static private function import_woomail_template( $wp_customize ) {
			// Make sure we have a valid nonce.
			if ( ! wp_verify_nonce( $_REQUEST['mailtpl-woomail-import-template'], 'mailtpl-woomail-importing-template' ) ) {
				return;
			}
			// Load the export/import option class.
			require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-import-option.php';
			
			// Setup global vars.
			global $wp_customize;
			global $mailtpl_woomail_import_error;
			
			// Setup internal vars.
			$mailtpl_woomail_import_error	 = false;
			$template	 = 'mailtpl-woomail-Composer';
			$prebuilt    = $_REQUEST['mailtpl-woomail-prebuilt-template'];
			$raw_data 	= self::prebuilt( $prebuilt );
			
			$data = @unserialize( $raw_data );
			
			
			// Data checks.
			if ( 'array' != gettype( $data ) ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! The template you selected is not found.', 'mailtpl-woocommerce-email-composer' );
				return;
			}
			if ( ! isset( $data['template'] ) ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! The template you selected is not valid.', 'mailtpl-woocommerce-email-composer' );
				return;
			}
			if ( $data['template'] != $template ) {
				$mailtpl_woomail_import_error = __( 'Error importing settings! The template you selected is not valid.', 'mailtpl-woocommerce-email-composer' );
				return;
			}
			

			// Import custom options.
			if ( isset( $data['options'] ) ) {
				
				foreach ( $data['options'] as $option_key => $option_value ) {
					
					$option = new Mailtpl_Woomail_Import_Option( $wp_customize, $option_key, array(
						'default'		=> '',
						'type'			=> 'option',
						'capability'	=> Mailtpl_Woomail_Composer::get_admin_capability(),
					) );

					$option->import( $option_value );
				}
			}


			// Call the customize_save action.
			do_action( 'customize_save', $wp_customize );

			// Call the customize_save_after action.
			//do_action( 'customize_save_after', $wp_customize );

			wp_redirect( Mailtpl_Woomail_Customizer::get_customizer_url() );

			exit;
		}
		/**
		 * Prints error scripts for the control.
		 *
		 * @since 0.1
		 * @return void
		 */
		static public function controls_print_scripts() {
			global $mailtpl_woomail_import_error;
			
			if ( $mailtpl_woomail_import_error ) {
				echo '<script> alert("' . $mailtpl_woomail_import_error . '"); </script>';
			}
		}
		/**
		 * Get value for prebuilt
		 *
		 * @access public
		 * @param string $key
		 * @return string
		 */
		public static function prebuilt( $key ) {
			if ( isset( self::$prebuilt_options[$key] ) ) {
				$data = self::$prebuilt_options[$key];
			} else {
				$data = null;
			}

			// Allow developers to override with there templates
			return apply_filters( 'mailtpl_woomail_template_data', $data, $key );
		}
	}
	Mailtpl_Woomail_Import_Export::get_instance();
}