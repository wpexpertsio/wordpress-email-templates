<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Email Templates
 *
 * @link              https://www.wpexperts.io/
 * @since             2.0
 * @package           Mailtpl
 *
 * @wordpress-plugin
 * Plugin Name:       Email Templates
 * Plugin URI:        http://wordpress.org/plugins/email-templates
 * Description:       Beautify WordPress default emails
 * Version:           1.4
 * Author:            wpexpertsio
 * Author URI:        https://www.wpexperts.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       email-templates
 * Domain Path:       /languages
 */
 
if ( ! class_exists( 'Mailtpl_Woomail_Composer' ) ) {
class Mailtpl_Woomail_Composer {
	/**
	 * Instance Control
	 *
	 * @var null
	 */
	private static $instance = null;
	/**
	 * User Role
	 *
	 * @var null
	 */
	private static $admin_capability = null;
	/**
	 * Overide Var
	 *
	 * @var null
	 */
	private static $overwrite_options = null;

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
	 * Construct
	 */
	public function __construct() {
		global $woo_send;
		$woo_send = true;
		define( 'MAILTPL_VERSION'       , '1.4');
		define( 'MAILTPL_PLUGIN_FILE'   , __FILE__);
		define( 'MAILTPL_PLUGIN_DIR'    , plugin_dir_path(__FILE__) );
		define( 'MAILTPL_WOOMAIL_URL'    , plugin_dir_url(__FILE__) );
		define( 'MAILTPL_PLUGIN_HOOK'   , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );
		define( 'MAILTPL_WOOMAIL_PATH', realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR );
		
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded_woomail' ) );
	}
	/**
	 * Function on plugins loaded
	 */
	 
	
	public function on_plugins_loaded() {
		require plugin_dir_path( __FILE__ ) . 'includes/class-mailtpl.php';
		$plugin = Mailtpl::instance();
		$plugin->run();
	}
	
	public function on_plugins_loaded_woomail() {

		if ( ! mailtpl_woomail_is_woo_active() ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_need_woocommerce' ) );
			return;
		}
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-settings.php'; // Gets all settings.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-customizer.php'; // Gets custom customizer set up.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-import-export.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-range-value-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-mailtpltemplateload-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-mailtplsendemail-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-repeater-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-mailtplinfoblock-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-mailtplimportexport-control.php'; // Adds Customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-customizer-toggle-control.php'; // Adds customizer control.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-preview.php'; // Builds the email preview for customizer.
		require_once MAILTPL_WOOMAIL_PATH . 'includes/class-mailtpl-woomail-woo.php'; // Add settings to woocommerce email settings page.

		add_action( 'init', array( $this, 'on_init' ), 80 );

		// Get translation set up.
		load_plugin_textdomain( 'mailtpl-woocommerce-email-composer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Add link for plugin page.
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugins_page_links' ) );

	}
	/**
	 * Trigger Load on init.
	 */
	public function on_init() {
		// Remove the woocommerce call for email header.
		if ( function_exists( 'WC' ) ) {
			remove_action( 'woocommerce_email_header', array( WC()->mailer(), 'email_header' ) );
			// $remove_schema = Mailtpl_Woomail_Customizer::opt( 'email_schema' );
			// if ( true == $remove_schema ) {
			// 	remove_action( 'woocommerce_email_order_details', array( WC()->structured_data, 'output_email_structured_data' ), 30 ); // This removes structured data from all Emails sent by WooCommerce.
			// }
		}
		
		// Add our custom call for email header.
		add_action( 'woocommerce_email_header', array( $this, 'add_email_header' ), 20, 2 );

		// Use our templates instead of woocommerce.
		add_filter( 'woocommerce_locate_template', array( $this, 'filter_locate_template' ), 10, 3 );

		// Add extra placeholder support for subject and title fields.
		add_filter( 'woocommerce_email_format_string', array( $this, 'add_extra_placeholders' ), 20, 2 );

		// Hook in main text areas for customized emails.
		add_action( 'Mailtpl_Woomailemail_details', array( $this, 'email_main_text_area' ), 10, 4 );

		// Hook in main text areas for customized emails.
		add_action( 'Mailtpl_Woomailemail_text', array( $this, 'email_main_text_area_no_order' ), 10, 1 );
		
		// Hook in footer container.
		add_action( 'Mailtpl_Woomailemail_footer', array( $this, 'email_footer_content' ), 100 );

		// hook in email photo option.
		add_filter( 'woocommerce_email_order_items_args', array( $this, 'add_wc_order_email_args_images' ), 10 );

		// Hook for replacing {year} in email-footer.
		add_filter( 'woocommerce_email_footer_text', array( $this, 'email_footer_replace_year' ) );

		add_filter( 'woocommerce_email_setup_locale', array( $this, 'switch_to_site_locale' ) );

		add_filter( 'woocommerce_email_restore_locale', array( $this, 'restore_to_user_locale' ) );

		//add_filter( 'woocommerce_email_styles', array( $this, 'check_to_add_gmail_hack' ), 50, 2 );

		//require_once MAILTPL_WOOMAIL_PATH . 'includes/class-kwed-cartflows-ca-email.php'; // Add CartFlows, soon.

		// Forces the WordPress to use the correct language file if switched.
		add_action( 'change_locale', array( $this, 'load_plugin_textdomain' ) );

	}
	/**
	 * Adds the filter for email hack if this filter runs.
	 *
	 * @param  string $css   the Email css.
	 * @param  object $email the Email object.
	 * @return string        the Email css.
	 */
	public function check_to_add_gmail_hack( $css, $email = '' ) {
		add_filter( 'woocommerce_mail_content', array( $this, 'add_gmail_hack' ), 50 );
		return $css;
	}
	/**
	 * Adds a bit of css to fix a rendering issue where gmail breaks email templates.
	 *
	 * @param  string $content the Email content.
	 * @return string         Email content with string possibly added on.
	 */
	public function add_gmail_hack( $content ) {
		$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
		if ( true != $responsive_check ) {
			$content = '<style type="text/css">.gm-remove-late{ display:none;}</style>' . $content;
		}
		remove_filter( 'woocommerce_mail_content', array( $this, 'add_gmail_hack' ), 50 );
		return $content;
	}
	/**
	 * Filter callback to replace {year} in email footer
	 *
	 * @param  string $string Email footer text.
	 * @return string         Email footer text with any replacements done.
	 */
	public function email_footer_replace_year( $string ) {
		return str_replace( '{year}', date( 'Y' ), $string );
	}

	/**
	 * Add a notice about woocommerce being needed.
	 *
	 * @param array $args the order detials args.
	 */
	public function add_wc_order_email_args_images( $args ) {
		$product_photo = Mailtpl_Woomail_Customizer::opt( 'order_items_image' );
		$size = Mailtpl_Woomail_Customizer::opt( 'order_items_image_size' );
		if ( 'show' === $product_photo ) {
			$args['show_image'] = true;
			if ( '100x100' === $size ) {
				$args['image_size'] = array( 100, 100 );
			} else if ( '150x150' === $size ) {
				$args['image_size'] = array( 150, 150 );
			} else if ( '40x40' === $size ) {
				$args['image_size'] = array( 40, 40 );
			} else if ( '50x50' === $size ) {
				$args['image_size'] = array( 50, 50 );
			} else if ( 'woocommerce_thumbnail' === $size ) {
				$args['image_size'] = 'woocommerce_thumbnail';
			} else {
				$args['image_size'] = array( 100, 50 );
			}
		}
		return $args;
	}
	/**
	 * Add a notice about woocommerce being needed.
	 */
	public function admin_notice_need_woocommerce() {
		echo '<div class="notice notice-error is-dismissible">';
		echo '<p>' . esc_html__( 'Mailtpl Woocommerce Email Composer requires WooCommerce to be active to work', 'mailtpl-woocommerce-email-composer' ) . '</p>';
		echo '</div>';
	}
	/**
	 * Set up the footer content
	 */
	public function email_footer_content() { 
		$content_width = Mailtpl_Woomail_Customizer::opt( 'content_width' );
		if ( empty( $content_width ) ) {
			$content_width = '600';
		}
		
		$content_width = str_replace( 'px', '', $content_width );
		$social_enable = Mailtpl_Woomail_Customizer::opt( 'footer_social_enable' );
		$social_links  = Mailtpl_Woomail_Customizer::opt( 'footer_social_repeater' );
		$social_links  = json_decode( $social_links );
		?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_footer_container">
			<tr>
				<td valign="top" align="center">
					<table border="0" cellpadding="10" cellspacing="0" width="<?php echo esc_attr( $content_width ); ?>" id="template_footer">
						<tr>
							<td valign="top" id="template_footer_inside">
								<table border="0" cellpadding="10" cellspacing="0" width="100%">
									<?php if ( false != $social_enable && ! empty( $social_links ) && is_array( $social_links ) ) { ?>
										<tr>
											<td valign="top">
												<table id="footersocial" border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<?php
														$items = count( $social_links );
														foreach ( $social_links as $social_link ) {
															?>
															<td valign="middle" style="text-align:center; width:<?php echo esc_attr( round( 100 / $items, 2 ) ); ?>%">
															<a href="<?php echo esc_url( $social_link->link ); ?>" class="ft-social-link" style="display:block; text-decoration: none;">
															<?php
															if ( 'customizer_repeater_image' == $social_link->choice ) {
																echo '<img src="' . esc_attr( $social_link->image_url ) . '" width="24" style="vertical-align: bottom;">';
															} else if ( 'customizer_repeater_icon' == $social_link->choice ) {
																$img_string = str_replace( 'mailtpl-woomail-', '', $social_link->icon_value );
																if ( isset( $social_link->icon_color ) && ! empty( $social_link->icon_color ) ) {
																	$color = $social_link->icon_color;
																} else {
																	$color = 'black';
																}
																echo '<img alt="' . esc_attr( $img_string ) . '" src="' . esc_attr( MAILTPL_WOOMAIL_URL . 'assets/images/' . $color . '/' . $img_string ) . '.png" width="24" style="vertical-align: bottom;">';
															}
															?>
															<span class="ft-social-title"><?php echo esc_html( $social_link->title ); ?></span>
															</a>
															</td>
															<?php
														}
														?>
													</tr>
												</table>
											</td>
										</tr>
									<?php } ?>
									<tr>
										<td valign="top">
											<table border="0" cellpadding="10" cellspacing="0" width="100%">
												<tr>
													<td colspan="2" valign="middle" id="credit">
														<?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php
	}
	/**
	 * Check if WooCommerce settings need to be overwritten and custom styles applied
	 * This is true when plugin is active and at least one custom option is stored in the database
	 *
	 * @access public
	 * @return bool
	 */
	public static function overwrite_options() {

		// Check if any settings were saved.
		if ( null === self::$overwrite_options ) {
			$option = get_option( 'mailtpl_woomail', array() );

			self::$overwrite_options = ! empty( $option );
		}

		// Return result.
		return self::$overwrite_options;
	}

	/**
	 * Hook in main text areas for customized emails
	 *
	 * @param  object  $order   the order object.
	 * @param  boolean $sent_to_admin if sent to admin.
	 * @param  boolean $plain_text if plan text.
	 * @param  object  $email the Email object.
	 * @return void
	 */
	public function email_main_text_area( $order, $sent_to_admin, $plain_text, $email ) {

		// Get Email ID.
		$key = $email->id;
		if ( 'customer_refunded_order' == $key ) {
			if ( $email->partial_refund ) {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body_partial' );
			} else {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body_full' );
			}
		} elseif ( 'customer_partially_refunded_order' == $key ) {
			$body_text = Mailtpl_Woomail_Customizer::opt( 'customer_refunded_order_body_partial' );
		} elseif ( 'customer_invoice' == $key ) {
			if ( $order->has_status( 'pending' ) ) {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body' );
				$btn_switch = Mailtpl_Woomail_Customizer::opt( $key . '_btn_switch' );
				if ( true == $btn_switch ) {
					$pay_link = '<p class="btn-container"><a class="btn" href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'mailtpl-woocommerce-email-composer' ) . '</a></p>';
				} else {
					$pay_link = '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'mailtpl-woocommerce-email-composer' ) . '</a>';
				}
				$body_text = str_replace( '{invoice_pay_link}', $pay_link, $body_text );
			} else {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body_paid' );
			}
		} elseif ( 'customer_renewal_invoice' == $key ) {
			if ( $order->has_status( 'pending' ) ) {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body' );
				$btn_switch = Mailtpl_Woomail_Customizer::opt( $key . '_btn_switch' );
				if ( true == $btn_switch ) {
					$pay_link = '<p class="btn-container"><a class="btn" href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a></p>';
				} else {
					$pay_link = '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a>';
				}
				$body_text = str_replace( '{invoice_pay_link}', $pay_link, $body_text );
			} else {
				$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body_failed' );
				$btn_switch = Mailtpl_Woomail_Customizer::opt( $key . '_btn_switch' );
				if ( true == $btn_switch ) {
					$pay_link = '<p class="btn-container"><a class="btn" href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a></p>';
				} else {
					$pay_link = '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a>';
				}
				$body_text = str_replace( '{invoice_pay_link}', $pay_link, $body_text );
			}
		} elseif ( 'customer_payment_retry' == $key ) {
			$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body' );
			$btn_switch = Mailtpl_Woomail_Customizer::opt( $key . '_btn_switch' );
			if ( true == $btn_switch ) {
				$pay_link = '<p class="btn-container"><a class="btn" href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a></p>';
			} else {
				$pay_link = '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay Now &raquo;', 'mailtpl-woocommerce-email-composer' ) . '</a>';
			}
			$body_text = str_replace( '{invoice_pay_link}', $pay_link, $body_text );
		} else {
			$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body' );
		}
		$body_text = str_replace( '{site_title}', get_bloginfo( 'name', 'display' ), $body_text );
		$body_text = str_replace( '{site_address}', wp_parse_url( home_url(), PHP_URL_HOST ), $body_text );
		$body_text = str_replace( '{site_url}', wp_parse_url( home_url(), PHP_URL_HOST ), $body_text );

		if ( $order ) {
			if ( 0 === ( $user_id = (int) get_post_meta( $order->get_id(), '_customer_user', true ) ) ) {
				$user_id = 'guest';
			}
			// Check for placeholders.
			$body_text = str_replace( '{order_date}', wc_format_datetime( $order->get_date_created() ), $body_text );
			$body_text = str_replace( '{order_number}', $order->get_order_number(), $body_text );
			$body_text = str_replace( '{customer_first_name}', $order->get_billing_first_name(), $body_text );
			$body_text = str_replace( '{customer_last_name}', $order->get_billing_last_name(), $body_text );
			$body_text = str_replace( '{customer_full_name}', $order->get_formatted_billing_full_name(), $body_text );
			$body_text = str_replace( '{customer_company}', $order->get_billing_company(), $body_text );
			$body_text = str_replace( '{customer_email}', $order->get_billing_email(), $body_text );
			$body_text = str_replace( '{customer_username}', self::get_username_from_id( $user_id ), $body_text );
		}

		$body_text = apply_filters( 'mailtpl_woomail_order_body_text', $body_text, $order, $sent_to_admin, $plain_text, $email );

		// auto wrap text.
		$body_text = wpautop( $body_text );

		echo wp_kses_post( $body_text );

	}
	/**
	 * Get username from user id.
	 *
	 * @param string $id the user id.
	 * @access public
	 * @return string
	 */
	public static function get_username_from_id( $id ) {
		if ( empty( $id ) || 'guest' === $id ) {
			return __( 'Guest', 'mailtpl-woocommerce-email-composer' );
		}
		$user = get_user_by( 'id', $id );
		if ( is_object( $user ) ) {
			$username = $user->user_login;
		} else {
			$username = __( 'Guest', 'mailtpl-woocommerce-email-composer' );
		}
		return $username;
	}
	/**
	 * Filter Subtitle for Placeholders
	 *
	 * @param string $subtitle the email subtitle.
	 * @param object $email the email object.
	 * @access public
	 * @return string
	 */
	public static function filter_subtitle( $subtitle, $email ) {
		// Check for placeholders.
		$subtitle = str_replace( '{site_title}', get_bloginfo( 'name', 'display' ), $subtitle );
		$subtitle = str_replace( '{site_address}', wp_parse_url( home_url(), PHP_URL_HOST ), $subtitle );
		$subtitle = str_replace( '{site_url}', wp_parse_url( home_url(), PHP_URL_HOST ), $subtitle );
		if ( is_a( $email->object, 'WP_User' ) ) {
			$first_name = get_user_meta( $email->object->ID, 'billing_first_name', true );
			if ( empty( $first_name ) ) {
				// Fall back to user display name.
				$first_name = $email->object->display_name;
			}

			$last_name = get_user_meta( $email->object->ID, 'billing_last_name', true );
			if ( empty( $last_name ) ) {
				// Fall back to user display name.
				$last_name = $email->object->display_name;
			}

			$full_name = get_user_meta( $email->object->ID, 'formatted_billing_full_name', true );
			if ( empty( $full_name ) ) {
				// Fall back to user display name.
				$full_name = $email->object->display_name;
			}
			$subtitle = str_replace( '{customer_first_name}', $first_name, $subtitle );
			$subtitle = str_replace( '{customer_last_name}', $last_name, $subtitle );
			$subtitle = str_replace( '{customer_full_name}', $full_name, $subtitle );
			$subtitle = str_replace( '{customer_username}', $email->user_login, $subtitle );
			$subtitle = str_replace( '{customer_email}', $email->object->user_email, $subtitle );

		} elseif ( is_a( $email->object, 'WC_Order' ) ) {
			if ( 0 === ( $user_id = (int) get_post_meta( $email->object->get_id(), '_customer_user', true ) ) ) {
				$user_id = 'guest';
			}
			$subtitle = str_replace( '{order_date}', wc_format_datetime( $email->object->get_date_created() ), $subtitle );
			$subtitle = str_replace( '{order_number}', $email->object->get_order_number(), $subtitle );
			$subtitle = str_replace( '{customer_first_name}', $email->object->get_billing_first_name(), $subtitle );
			$subtitle = str_replace( '{customer_last_name}', $email->object->get_billing_last_name(), $subtitle );
			$subtitle = str_replace( '{customer_full_name}', $email->object->get_formatted_billing_full_name(), $subtitle );
			$subtitle = str_replace( '{customer_company}', $email->object->get_billing_company(), $subtitle );
			$subtitle = str_replace( '{customer_email}', $email->object->get_billing_email(), $subtitle );
			$subtitle = str_replace( '{customer_username}', self::get_username_from_id( $user_id ), $subtitle );
		} elseif ( is_a( $email->object, 'WC_Product' ) ) {
			$subtitle = str_replace( '{product_title}', $email->object->get_title(), $subtitle );
		}

		return $subtitle;

	}

	/**
	 * Hook in main text areas for customized emails.
	 *
	 * @param object $email the email object.
	 * @access public
	 * @return void
	 */
	public function email_main_text_area_no_order( $email ) {

		// Get Email ID.
		$key = $email->id;

		$body_text = Mailtpl_Woomail_Customizer::opt( $key . '_body' );
		// Check for placeholders.
		$body_text = str_replace( '{site_title}', get_bloginfo( 'name', 'display' ), $body_text );
		$body_text = str_replace( '{site_address}', wp_parse_url( home_url(), PHP_URL_HOST ), $body_text );
		$body_text = str_replace( '{site_url}', wp_parse_url( home_url(), PHP_URL_HOST ), $body_text );
		if ( is_a( $email->object, 'WP_User' ) ) {

			$first_name = get_user_meta( $email->object->ID, 'billing_first_name', true );
			if ( empty( $first_name ) ) {
				$first_name = get_user_meta( $email->object->ID, 'first_name', true );
				if ( empty( $first_name ) ) {
					// Fall back to user display name.
					$first_name = $email->object->display_name;
				}
			}

			$last_name = get_user_meta( $email->object->ID, 'billing_last_name', true );
			if ( empty( $last_name ) ) {
				$last_name = get_user_meta( $email->object->ID, 'last_name', true );
				if ( empty( $last_name ) ) {
					// Fall back to user display name.
					$last_name = $email->object->display_name;
				}
			}

			$full_name = get_user_meta( $email->object->ID, 'formatted_billing_full_name', true );
			if ( empty( $full_name ) ) {
				// Fall back to user display name.
				$full_name = $email->object->display_name;
			}
			$body_text = str_replace( '{customer_first_name}', $first_name, $body_text );
			$body_text = str_replace( '{customer_last_name}', $last_name, $body_text );
			$body_text = str_replace( '{customer_full_name}', $full_name, $body_text );
			$body_text = str_replace( '{customer_username}', $email->user_login, $body_text );
			$body_text = str_replace( '{customer_email}', $email->object->user_email, $body_text );
		} elseif ( is_a( $email->object, 'WC_Product' ) ) {
			$body_text = str_replace( '{product_title}', $email->object->get_title(), $body_text );
			$body_text = str_replace( '{product_link}', $email->object->get_permalink(), $body_text );
		}

		$body_text = apply_filters( 'mailtpl_woomail_no_order_body_text', $body_text, $email );

		// auto wrap text.
		$body_text = wpautop( $body_text );

		echo wp_kses_post( $body_text );

	}

	/**
	 * Filter through strings to add support for extra placeholders
	 *
	 * @param string $string string of text.
	 * @param object $email  the email object.
	 * @access public
	 * @return string
	 */
	public function add_extra_placeholders( $string, $email ) {

		if ( is_a( $email->object, 'WP_User' ) ) {
			$first_name = get_user_meta( $email->object->ID, 'billing_first_name', true );
			if ( empty( $first_name ) ) {
				$first_name = get_user_meta( $email->object->ID, 'first_name', true );
				if ( empty( $first_name ) ) {
					// Fall back to user display name.
					$first_name = $email->object->display_name;
				}
			}

			$last_name = get_user_meta( $email->object->ID, 'billing_last_name', true );
			if ( empty( $last_name ) ) {
				$last_name = get_user_meta( $email->object->ID, 'last_name', true );
				if ( empty( $last_name ) ) {
					// Fall back to user display name.
					$last_name = $email->object->display_name;
				}
			}

			$full_name = get_user_meta( $email->object->ID, 'formatted_billing_full_name', true );
			if ( empty( $full_name ) ) {
				// Fall back to user display name.
				$full_name = $email->object->display_name;
			}
			$string = str_replace( '{customer_first_name}', $first_name, $string );
			$string = str_replace( '{customer_last_name}', $last_name, $string );
			$string = str_replace( '{customer_full_name}', $full_name, $string );
			$string = str_replace( '{customer_username}', $email->user_login, $string );
			$string = str_replace( '{customer_email}', $email->object->user_email, $string );

		} else if ( is_a( $email->object, 'WC_Order' ) ) {
			if ( 0 === ( $user_id = (int) get_post_meta( $email->object->get_id(), '_customer_user', true ) ) ) {
				$user_id = 'guest';
			}
			$string = str_replace( '{customer_first_name}', $email->object->get_billing_first_name(), $string );
			$string = str_replace( '{customer_last_name}', $email->object->get_billing_last_name(), $string );
			$string = str_replace( '{customer_full_name}', $email->object->get_formatted_billing_full_name(), $string );
			$string = str_replace( '{customer_company}', $email->object->get_billing_company(), $string );
			$string = str_replace( '{customer_email}', $email->object->get_billing_email(), $string );
			$string = str_replace( '{customer_username}', self::get_username_from_id( $user_id ), $string );
		}

		return $string;
	}

	/**
	 * Add submenu under woocommerce for email customizer
	 *
	 * @access public
	 * @return void
	 */

	public function wwp_wholesale_reports_callback() {
	 
	}

	/**
	 * Add submenu under woocommerce for email customizer
	 *
	 * @param array $links plugin links.
	 * @access public
	 * @return array
	 */
	public function plugins_page_links( $links ) {
		$settings_link = '<a href="' . Mailtpl_Woomail_Customizer::get_customizer_url() . '">' . __( 'Open Email Composer', 'mailtpl-woocommerce-email-composer' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Checks to see if we are opening our custom customizer preview
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_own_preview_request() {
		return isset( $_REQUEST['mailtpl-woomail-preview'] ) && '1' === $_REQUEST['mailtpl-woomail-preview'];
	}

	/**
	 * Checks to see if we are opening our custom customizer controls
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_own_customizer_request() {
		return isset( $_REQUEST['mailtpl-woomail-customize'] ) && '1' === $_REQUEST['mailtpl-woomail-customize'];
	}

	/**
	 * Gets the capability setting needed to edit in the email customizer
	 *
	 * @access public
	 * @return string
	 */
	public static function get_admin_capability() {
		// Get capability.
		if ( is_null( self::$admin_capability ) ) {
			self::$admin_capability = apply_filters( 'mailtpl_woomail_capability', 'manage_woocommerce' );
		}

		// Return capability.
		return self::$admin_capability;
	}

	/**
	 * Check if user is authorized to use the email customizer
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_admin() {
		return current_user_can( self::get_admin_capability() );
	}

	/**
	 * Hook in email header with access to the email object
	 *
	 * @param string $email_heading email heading.
	 * @param object $email the email object.
	 * @access public
	 * @return void
	 */
	public function add_email_header( $email_heading, $email = '' ) {
		wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading, 'email' => $email ) );
	}

	/**
	 * Filter in custom email templates with priority to child themes
	 *
	 * @param string $template the email template file.
	 * @param string $template_name name of email template.
	 * @param string $template_path path to email template.
	 * @access public
	 * @return string
	 */
	public function filter_locate_template( $template, $template_name, $template_path ) {
		// Make sure we are working with an email template.
		if ( ! in_array( 'emails', explode( '/', $template_name ) ) ) {
			return $template;
		}
		// clone template.
		$_template = $template;

		// Get the woocommerce template path if empty.
		if ( ! $template_path ) {
			global $woocommerce;
			$template_path = $woocommerce->template_url;
		}

		// Get our template path.
		$plugin_path = MAILTPL_WOOMAIL_PATH . 'templates/woo/';

		// Look within passed path within the theme - this is priority.
		$template = locate_template( array( $template_path . $template_name, $template_name ) );

		// If theme isn't trying to override get the template from this plugin, if it exists.
		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		// else if we still don't have a template use default.
		if ( ! $template ) {
			$template = $_template;
		}
		// Return template.
		return $template;

	}
	/**
	 * Filter in custom email templates with priority to child themes
	 *
	 * @param string $template the email template file.
	 * @param string $template_name name of email template.
	 * @param string $template_path path to email template.
	 * @access public
	 * @return string
	 */
	public function filter_locate_template_language( $template, $template_name, $template_path ) {
		// Make sure we are working with an email template.
		if ( ! in_array( 'emails', explode( '/', $template_name ) ) ) {
			return $template;
		}

		$this->load_plugin_textdomain();
		// Return template.
		return $template;
	}
	/**
	 * Filter when email languages are set, adds in a switch if needed
	 *
	 * @access public
	 * @param bool $switch whether or not it should switch.
	 * @return bool
	 */
	public function switch_to_site_locale( $switch ) {
		if ( $switch ) {
			if ( function_exists( 'switch_to_locale' ) ) {
				add_filter( 'woocommerce_locate_template', array( $this, 'filter_locate_template_language' ), 5, 3 );
			}
		}
		return $switch;
	}
	/**
	 * Load Localisation files.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'mailtpl-woocommerce-email-composer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	/**
	 * Restore the locale to the default locale. Use after finished with setup_locale.
	 *
	 * @param boolean $switch whether or not it should switch.
	 * @return boolean
	 */
	public function restore_to_user_locale( $switch ) {
		if ( $switch ) {
			if ( function_exists( 'restore_previous_locale' ) ) {
				remove_filter( 'woocommerce_locate_template', array( $this, 'filter_locate_template_language' ), 5, 3 );
			}
		}
		return $switch;
	}
}
Mailtpl_Woomail_Composer::get_instance();

/**
 * Checks if WooCommerce is enabled
 */
class Mailtpl_Woomail_Plugin_Check {

	private static $active_plugins;

	public static function init() {

		self::$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}
	}

	public static function active_check_woo() {

		if ( ! self::$active_plugins ) {
			self::init();
		}
		return in_array( 'woocommerce/woocommerce.php', self::$active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', self::$active_plugins );
	}

}
}
/**
 * Checks if WooCommerce is enabled
 */
function mailtpl_woomail_is_woo_active() {
	return Mailtpl_Woomail_Plugin_Check::active_check_woo();
}
 
 


























