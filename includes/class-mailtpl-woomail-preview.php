<?php
/**
 * Customizer Setup for preview.
 *
 * @package Mailtpl WooCommerce Email Composer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Setup
 * Heavily borrowed from rightpress Decorator
 */
if ( ! class_exists( 'Mailtpl_Woomail_Preview' ) ) {
	/**
	 * Customizer Preview Setup
	 */
	class Mailtpl_Woomail_Preview {
		// WooCommerce email classes.
		public static $current_order            = null;
		public static $current_product_title    = null;
		public static $current_recipients       = null;
		public static $current_member           = null;
		public static $email_types_class_names  = array(
			'new_order'                         => 'WC_Email_New_Order',
			'cancelled_order'                   => 'WC_Email_Cancelled_Order',
			'customer_processing_order'         => 'WC_Email_Customer_Processing_Order',
			'customer_completed_order'          => 'WC_Email_Customer_Completed_Order',
			'customer_refunded_order'           => 'WC_Email_Customer_Refunded_Order',
			'customer_on_hold_order'            => 'WC_Email_Customer_On_Hold_Order',
			'customer_invoice'                  => 'WC_Email_Customer_Invoice',
			'failed_order'                      => 'WC_Email_Failed_Order',
			'customer_new_account'              => 'WC_Email_Customer_New_Account',
			'customer_note'                     => 'WC_Email_Customer_Note',
			'customer_reset_password'           => 'WC_Email_Customer_Reset_Password',
			// WooCommerce Subscriptions Plugin.
			'new_renewal_order'                 => 'WCS_Email_New_Renewal_Order',
			'customer_processing_renewal_order' => 'WCS_Email_Processing_Renewal_Order',
			'customer_completed_renewal_order'  => 'WCS_Email_Completed_Renewal_Order',
			'customer_completed_switch_order'   => 'WCS_Email_Completed_Switch_Order',
			'customer_renewal_invoice'          => 'WCS_Email_Customer_Renewal_Invoice',
			'customer_payment_retry'            => 'WCS_Email_Customer_Payment_Retry',
			'admin_payment_retry'               => 'WCS_Email_Payment_Retry',
			'cancelled_subscription'            => 'WCS_Email_Cancelled_Subscription',
			// Woocommerce Memberships.
			'WC_Memberships_User_Membership_Note_Email'             => 'WC_Memberships_User_Membership_Note_Email',
			'WC_Memberships_User_Membership_Ending_Soon_Email'      => 'WC_Memberships_User_Membership_Ending_Soon_Email',
			'WC_Memberships_User_Membership_Ended_Email'            => 'WC_Memberships_User_Membership_Ended_Email',
			'WC_Memberships_User_Membership_Renewal_Reminder_Email' => 'WC_Memberships_User_Membership_Renewal_Reminder_Email',
			'WC_Memberships_User_Membership_Activated_Email'        => 'WC_Memberships_User_Membership_Activated_Email',
			// Waitlist Plugin.
			'woocommerce_waitlist_mailout'      => 'Pie_WCWL_Waitlist_Mailout',
			// WC Marketplace.
			'vendor_new_account'                => 'WC_Email_Vendor_New_Account',
			'admin_new_vendor'                  => 'WC_Email_Admin_New_Vendor_Account',
			'approved_vendor_new_account'       => 'WC_Email_Approved_New_Vendor_Account',
			'rejected_vendor_new_account'       => 'WC_Email_Rejected_New_Vendor_Account',
			'vendor_new_order'                  => 'WC_Email_Vendor_New_Order',
			'notify_shipped'                    => 'WC_Email_Notify_Shipped',
			'admin_new_vendor_product'          => 'WC_Email_Vendor_New_Product_Added',
			'admin_added_new_product_to_vendor' => 'WC_Email_Admin_Added_New_Product_to_Vendor',
			'vendor_commissions_transaction'    => 'WC_Email_Vendor_Commission_Transactions',
			'vendor_direct_bank'                => 'WC_Email_Vendor_Direct_Bank',
			'admin_widthdrawal_request'         => 'WC_Email_Admin_Widthdrawal_Request',
			'vendor_orders_stats_report'        => 'WC_Email_Vendor_Orders_Stats_Report',
			'vendor_contact_widget_email'       => 'WC_Email_Vendor_Contact_Widget',
			// Germanized Emails.
			'customer_ekomi'                     => 'WC_GZD_Email_Customer_Ekomi',
			'customer_new_account_activation'    => 'WC_GZD_Email_Customer_New_Account_Activation',
			'customer_paid_for_order'            => 'WC_GZD_Email_Customer_Paid_For_Order',
			'customer_revocation'                => 'WC_GZD_Email_Customer_Revocation',
			'customer_sepa_direct_debit_mandate' => 'WC_GZD_Email_Customer_SEPA_Direct_Debit_Mandate',
			'customer_trusted_shops'             => 'WC_GZD_Email_Customer_Trusted_Shops',
			// stripe Emails
			'failed_preorder_sca_authentication'      => 'WC_Stripe_Email_Failed_Preorder_Authentication',
			'failed_renewal_authentication'      => 'WC_Stripe_Email_Failed_Renewal_Authentication',
			'failed_authentication_requested'      => 'WC_Stripe_Email_Failed_Authentication_Retry',
			'cartflows_ca_email_templates' => 'KWED_Cartflows_CA_Email',
			// Subscriptio Email Types.
			// 'customer_subscription_new_order'	     => 'Subscriptio_Email_Customer_Subscription_New_Order',
			// 'customer_subscription_processing_order' => 'Subscriptio_Email_Customer_Subscription_Processing_Order',
			// 'customer_subscription_completed_order'  => 'Subscriptio_Email_Customer_Subscription_Completed_Order',
			// 'customer_subscription_paused'           => 'Subscriptio_Email_Customer_Subscription_Paused',
			// 'customer_subscription_resumed'          => 'Subscriptio_Email_Customer_Subscription_Resumed',
			// 'customer_subscription_suspended'        => 'Subscriptio_Email_Customer_Subscription_Suspended',
			// 'customer_subscription_payment_overdue'	 => 'Subscriptio_Email_Customer_Subscription_Payment_Overdue',
			// 'customer_subscription_payment_reminder' => 'Subscriptio_Email_Customer_Subscription_Payment_Reminder',
			// 'customer_subscription_expired'          => 'Subscriptio_Email_Customer_Subscription_Expired',
			// 'customer_subscription_cancelled'        => 'Subscriptio_Email_Customer_Subscription_Cancelled',
		);
		public static $email_types_order_status = array(
			'new_order'                         => 'processing',
			'cancelled_order'                   => 'cancelled',
			'customer_processing_order'         => 'processing',
			'customer_completed_order'          => 'completed',
			'customer_refunded_order'           => 'refunded',
			'customer_on_hold_order'            => 'on-hold',
			'customer_invoice'                  => 'processing',
			'failed_order'                      => 'failed',
			'customer_new_account'              => null,
			'customer_note'                     => 'processing',
			'customer_reset_password'           => null,
			// WooCommerce Subscriptions Plugin.
			'new_renewal_order'                 => 'processing',
			'customer_processing_renewal_order' => 'processing',
			'customer_completed_renewal_order'  => 'completed',
			'customer_completed_switch_order'   => 'completed',
			'customer_renewal_invoice'          => 'failed',
			'customer_payment_retry'            => 'pending',
			'admin_payment_retry'            => 'pending',
			'cancelled_subscription'            => 'cancelled',
			// Woocommerce Memberships.
			'WC_Memberships_User_Membership_Note_Email'             => 'completed',
			'WC_Memberships_User_Membership_Ending_Soon_Email'      => 'completed',
			'WC_Memberships_User_Membership_Ended_Email'            => 'on-hold',
			'WC_Memberships_User_Membership_Renewal_Reminder_Email' => 'completed',
			'WC_Memberships_User_Membership_Activated_Email'        => 'completed',
			// Waitlist Plugin
			'woocommerce_waitlist_mailout'      => null,
			// WC Marketplace
			'vendor_new_account'                => null,
			'admin_new_vendor'                  => null,
			'approved_vendor_new_account'       => null,
			'rejected_vendor_new_account'       => null,
			'vendor_new_order'                  => 'processing',
			'notify_shipped'                    => 'completed',
			'admin_new_vendor_product'          => null,
			'admin_added_new_product_to_vendor' => null,
			'vendor_commissions_transaction'    => null,
			'vendor_direct_bank'                => null,
			'admin_widthdrawal_request'         => null,
			'vendor_orders_stats_report'        => null,
			'vendor_contact_widget_email'       => null,
			// Woo Advanced Shipment Tracking
			'customer_delivered_order' => 'completed',
				// Germanized Emails.
			'customer_ekomi'                     => 'completed',
			'customer_new_account_activation'    => null,
			'customer_paid_for_order'            => 'completed',
			'customer_revocation'                => null,
			'customer_sepa_direct_debit_mandate' => 'completed',
			'customer_trusted_shops'             => 'completed',
			// Stripe
			'failed_preorder_sca_authentication'      => 'failed',
			'failed_renewal_authentication'      => 'failed',
			'failed_authentication_requested'      => 'failed',
			// Subscriptio Email Types
			// 'customer_subscription_new_order'	     => 'processing',
			// 'customer_subscription_processing_order' => 'processing',
			// 'customer_subscription_completed_order'  => 'completed',
			// 'customer_subscription_paused'           => 'on-hold',
			// 'customer_subscription_resumed'          => 'completed',
			// 'customer_subscription_suspended'        => 'on-hold',
			// 'customer_subscription_payment_overdue'	 => 'on-hold',
			// 'customer_subscription_payment_reminder' => 'completed',
			// 'customer_subscription_expired'          => 'failed',
			// 'customer_subscription_cancelled'        => 'cancelled',
		);
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
			// Set up preview.
			add_action( 'parse_request', array( $this, 'set_up_preview' ) );
		}

		/**
		 * Set up preview
		 *
		 * @access public
		 * @return void
		 */
		public function set_up_preview() {
			// Make sure this is own preview request.
			if ( ! Mailtpl_Woomail_Composer::is_own_preview_request() ) {
				return;
			}
			// Load main view.
			include MAILTPL_WOOMAIL_PATH . 'preview.php';

			// Do not load any further elements.
			exit;
		}

		/**
		 * Get the email order status
		 *
		 * @param string $email_template the template string name.
		 */
		public static function get_email_order_status( $email_template ) {
			$order_status = apply_filters( 'mailtpl_woomail_email_type_order_status_array', self::$email_types_order_status );
			if ( isset( $order_status[ $email_template ] ) ) {
				return $order_status[ $email_template ];
			} else {
				return 'processing';
			}
		}
		/**
		 * Get the email class name
		 *
		 * @param string $email_template the email template slug.
		 */
		public static function get_email_class_name( $email_template ) {
			$class_names = apply_filters( 'mailtpl_woomail_email_type_class_name_array', self::$email_types_class_names );
			// if ( class_exists( 'WC_GZDP_Email_Customer_Invoice_Simple' ) ) {
			// 	$class_names['customer_invoice'] = 'WC_GZDP_Email_Customer_Invoice_Simple';
			// }
			if ( isset( $class_names[ $email_template ] ) ) {
				return $class_names[ $email_template ];
			} else {
				return false;
			}
		}
		/**
		 * Get the email content
		 *
		 */
		public static function get_preview_email( $send_email = false, $email_addresses = null ) {
			// Load WooCommerce emails.

			$wc_emails      = WC_Emails::instance();
			
			$emails         = $wc_emails->get_emails();
			$email_template = Mailtpl_Woomail_Customizer::opt( 'email_type' );
			$preview_id     = Mailtpl_Woomail_Customizer::opt( 'preview_order_id' );
			
			if ( strlen( $email_template ) > 29 && 'cartflows_ca_email_templates_' === substr( $email_template, 29 ) ) {
				$email_template = 'cartflows_ca_email_templates';
			}
			$email_type     = self::get_email_class_name( $email_template );
			if ( false === $email_type ) {
				return false;
			}
			$order_status = self::get_email_order_status( $email_template );
			//$order_status = self::$email_types_order_status[$email_template];

			if ( 'customer_invoice' == $email_template ) {
				$invoice_paid = Mailtpl_Woomail_Customizer::opt( 'customer_invoice_switch' );
				if ( ! $invoice_paid ) {
					$order_status = 'pending';
				}
			}
			if ( 'customer_refunded_order' == $email_template ) {
				$partial_preview = Mailtpl_Woomail_Customizer::opt( 'customer_refunded_order_switch' );
				if ( ! $partial_preview ) {
					$partial_status = true;
				} else {
					$partial_status = false;
				}
			}
			// Reference email.
			if ( isset( $emails[ $email_type ] ) && is_object( $emails[ $email_type ] ) ) {
				$email = $emails[ $email_type ];
			};

			// Get an order
			$order               = self::get_wc_order_for_preview( $order_status, $preview_id );
			self::$current_order = $order;

			if ( is_object( $order ) ) {
				// Get user ID from order, if guest get current user ID.
				if ( 0 === ( $user_id = (int) get_post_meta( $order->get_id(), '_customer_user', true ) ) ) {
					$user_id = get_current_user_id();
				}
			} else {
				$user_id = get_current_user_id();
			}
			// Get user object
			$user = get_user_by( 'id', $user_id );
			self::$current_product_title = 'Product Title Example';
			if ( 'woocommerce_waitlist_mailout' == $email_template ) {

				$product_id = -1;
				if ( is_object( $order ) ) {
					$items = $order->get_items();
					foreach ( $items as $item ) {
						$product_id = $item['product_id'];
						if ( null !== get_post( $product_id ) ) {
							break;
						}
					}
				}

				if ( null === get_post( $product_id ) ) {

					$args           = array(
						'posts_per_page' => 1,
						'orderby'        => 'date',
						'post_type'      => 'product',
						'post_status'    => 'publish',
					);
					$products_array = get_posts( $args );

					if ( isset( $products_array[0]->ID ) ) {
						$product_id = $products_array[0]->ID;
					}
				}
			}
			if ( isset( $email ) ) {
				// Make sure gateways are running in case the email needs to input content from them.
				WC()->payment_gateways();
				// Make sure shipping is running in case the email needs to input content from it.
				WC()->shipping();
				switch ( $email_template ) {
					/**
					 * WooCommerce (default transactional mails).
					 */
					case 'new_order':
					case 'cancelled_order':
					case 'customer_processing_order':
					case 'customer_completed_order':
					case 'customer_on_hold_order':
					case 'failed_renewal_authentication':
					case 'failed_preorder_sca_authentication':
					case 'failed_order':
						$email->object               = $order;
						if ( is_object( $order ) ) {
							$email->find['order-date']   = '{order_date}';
							$email->find['order-number'] = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					case 'customer_invoice':
						$email->object = $order;
						if ( is_object( $order ) ) {
							$email->invoice = ( function_exists( 'wc_gzdp_get_order_last_invoice' ) ? wc_gzdp_get_order_last_invoice( $order ) : null );
							$email->find['order-date']   = '{order_date}';
							$email->find['order-number'] = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					case 'customer_refunded_order':
						$email->object               = $order;
						$email->partial_refund       = $partial_status;
						if ( is_object( $order ) ) {
							$email->find['order-date']   = '{order_date}';
							$email->find['order-number'] = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					case 'customer_new_account':
						$email->object             = $user;
						$email->user_pass          = '{user_pass}';
						$email->user_login         = stripslashes( $email->object->user_login );
						$email->user_email         = stripslashes( $email->object->user_email );
						$email->recipient          = $email->user_email;
						$email->password_generated = true;
						break;
					case 'customer_note':
						$email->object                  = $order;
						$email->customer_note           = __( 'Hello! This is an example note', 'mailtpl-woocommerce-email-composer' );
						if ( is_object( $order ) ) {
							$email->find['order-date']      = '{order_date}';
							$email->find['order-number']    = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					case 'customer_reset_password':
						$email->object     = $user;
						$email->user_id    = $user_id;
						$email->user_login = $user->user_login;
						$email->user_email = stripslashes( $email->object->user_email );
						$email->reset_key  = '{{reset-key}}';
						$email->recipient  = stripslashes( $email->object->user_email );
						break;
					/**
					 * Woo Advanced Shipment Tracking.
					 */
					case 'customer_delivered_order':
						$email->object               = $order;
						if ( is_object( $order ) ) {
							$email->find['order-date']   = '{order_date}';
							$email->find['order-number'] = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					/**
					 * WooCommerce Subscriptions Plugin (from WooCommerce).
					 */
					case 'new_renewal_order':
					case 'new_switch_order':
					case 'customer_processing_renewal_order':
					case 'customer_completed_renewal_order':
					case 'customer_renewal_invoice':
						$email->object                  = $order;
						if ( is_object( $order ) ) {
							$email->find['order-date']      = '{order_date}';
							$email->find['order-number']    = '{order_number}';
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						break;
					case 'customer_completed_switch_order':
						$email->object                  = $order;
						$email->find['order-date']      = '{order_date}';
						$email->find['order-number']    = '{order_number}';
						$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
						$email->replace['order-number'] = $email->object->get_order_number();
						// Other properties
						$email->recipient = $email->object->get_billing_email();
						$subscriptions = false;
						if ( ! empty( $preview_id ) && 'mockup' != $preview_id ) {
							if ( function_exists( 'wcs_get_subscriptions_for_switch_order' ) ) {
								$subscriptions = wcs_get_subscriptions_for_switch_order( $preview_id );
							}
						}
						if ( $subscriptions ) {
							$email->subscriptions = $subscriptions;
						} else {
							$email->subscriptions = array();
						}
						break;
					case 'cancelled_subscription':
						$subscription = false;
						if ( ! empty( $preview_id ) && 'mockup' != $preview_id ) {
							if ( function_exists( 'wcs_get_subscriptions_for_order' ) ) {
								$subscriptions_ids = wcs_get_subscriptions_for_order( $preview_id );
								// We get the related subscription for this order.
								if ( $subscriptions_ids ) {
									foreach ( $subscriptions_ids as $subscription_id => $subscription_obj ) {
										if ( $subscription_obj->order->id == $preview_id ) {
											$subscription = $subscription_obj;
											break; // Stop the loop).
										}
									}
								}
							}
						}
						if ( $subscription ) {
							$email->object = $subscription;
						} else {
							$email->object = 'subscription';
						}
						break;
					case 'customer_payment_retry':
						$email->object                  = $order;
						$email->find['order-date']      = '{order_date}';
						$email->find['order-number']    = '{order_number}';
						$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
						$email->replace['order-number'] = $email->object->get_order_number();
						// Other properties.
						$email->recipient = $email->object->get_billing_email();
						if ( ! empty( $preview_id ) && 'mockup' != $preview_id ) {
							if ( WCS_Retry_Manager::is_retry_enabled() ) {
								$retry = WCS_Retry_Manager::store()->get_last_retry_for_order( $preview_id );
								if ( ! empty( $retry ) && is_object( $retry ) ) {
									$email->retry                 = $retry;
									$email->find['retry_time']    = '{retry_time}';
									$email->replace['retry_time'] = wcs_get_human_time_diff( $email->retry->get_time() );
								} else {
									$email->object = 'retry';
								}
							} else {
								$email->object = 'retry';
							}
						} else {
							$email->object = 'retry';
						}
						break;
					case 'admin_payment_retry':
						$email->object                  = $order;
						$email->find['order-date']      = '{order_date}';
						$email->find['order-number']    = '{order_number}';
						$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
						$email->replace['order-number'] = $email->object->get_order_number();
						// Other properties.
						if ( ! empty( $preview_id ) && 'mockup' != $preview_id ) {
							if ( WCS_Retry_Manager::is_retry_enabled() ) {
								$retry = WCS_Retry_Manager::store()->get_last_retry_for_order( $preview_id );
								if ( ! empty( $retry ) && is_object( $retry ) ) {
									$email->retry                 = $retry;
									$email->find['retry_time']    = '{retry_time}';
									$email->replace['retry_time'] = wcs_get_human_time_diff( $email->retry->get_time() );
								} else {
									$email->object = 'retry';
								}
							} else {
								$email->object = 'retry';
							}
						} else {
							$email->object = 'retry';
						}
						break;
					/**
					 * WooCommerce Membership.
					 */
					case 'WC_Memberships_User_Membership_Note_Email':
					case 'WC_Memberships_User_Membership_Ending_Soon_Email':
					case 'WC_Memberships_User_Membership_Ended_Email':
					case 'WC_Memberships_User_Membership_Renewal_Reminder_Email':
					case 'WC_Memberships_User_Membership_Activated_Email':
						if ( function_exists( 'wc_memberships_get_user_membership' ) ) {
							$memberships = wc_memberships_get_user_active_memberships( $user_id );

							if ( ! empty( $memberships ) ) {
								$user_membership = $memberships[0];
								self::$current_member = $user_membership;
								$email->object = $user_membership;
								$email_id = strtolower( $email_template );
								$email_body = $email->object->get_plan()->get_email_content( $email_template );
								$member_body = (string) apply_filters( "{$email_id}_email_body", $email->format_string( $email_body ), $email->object );

								if ( empty( $member_body ) || ! is_string( $member_body ) || '' === trim( $member_body ) ) {
									$member_body = $email->get_default_body();
								}

								// convert relative URLs to absolute for links href and images src attributes
								$domain  = get_home_url();
								$replace = array();
								$replace['/href="(?!https?:\/\/)(?!data:)(?!#)/'] = 'href="' . $domain;
								$replace['/src="(?!https?:\/\/)(?!data:)(?!#)/']  = 'src="'  . $domain;

								$member_body = preg_replace( array_keys( $replace ), array_values( $replace ), $member_body );

								$membership_plan = $user_membership->get_plan();

								// get member data
								$member            = get_user_by( 'id', $user_membership->get_user_id() );
								$member_name       = ! empty( $member->display_name ) ? $member->display_name : '';
								$member_first_name = ! empty( $member->first_name )   ? $member->first_name   : $member_name;
								$member_last_name  = ! empty( $member->last_name )    ? $member->last_name    : '';
								$member_full_name  = $member_first_name && $member_last_name ? $member_first_name . ' ' . $member->last_name : $member_name;

								// membership expiry date
								$expiration_date_timestamp = $user_membership->get_local_end_date( 'timestamp' );

								// placeholders
								$email_merge_tags = array(
									'member_name'                 => $member_name,
									'member_first_name'           => $member_first_name,
									'member_last_name'            => $member_last_name,
									'member_full_name'            => $member_full_name,
									'membership_plan'             => $membership_plan ? $membership_plan->get_name() : '',
									'membership_expiration_date'  => date_i18n( wc_date_format(), $expiration_date_timestamp ),
									'membership_expiry_time_diff' => human_time_diff( current_time( 'timestamp', true ), $expiration_date_timestamp ),
									'membership_view_url'         => esc_url( $user_membership->get_view_membership_url() ),
									'membership_renewal_url'      => esc_url( $user_membership->get_renew_membership_url() ),
								);
								foreach ( $email_merge_tags as $find => $replace ) {
									$email->find[$find]      = '{' . $find . '}';
									$email->replace[$find]   = $replace;
									$member_body = str_replace( '{' . $find . '}', $replace, $member_body );
								}
							} else {
								$email->object = 'member';
							}
						} else {
							$email->object = false;
						}
						break;
					/**
					 * WC MarketPlace
					 */
					case 'vendor_new_order':
						if ( is_object( $order ) ) {
							$order_id = $order->get_id();
							if ( function_exists( 'get_vendor_from_an_order' ) ) {
								if ( 1 === $order_id ) {
									$email->object = 'vendor';
								} else {
									$vendors = get_vendor_from_an_order( $order_id );

									if ( $vendors ) {
										$vendor = $vendors[0];

										$vendor_obj = get_wcmp_vendor_by_term( $vendor );
										$vendor_email = $vendor_obj->user_data->user_email;
										$vendor_id = $vendor_obj->id;

										if ( $order_id && $vendor_email ) {
											$email->object = $email->order = $order;
											$email->find[] = '{order_date}';
											$email->replace[] = wc_format_datetime( $email->object->get_date_created() );

											$email->find[] = '{order_number}';
											$email->replace[] = $email->object->get_order_number();
											$email->vendor_email = $vendor_email;
											$email->vendor_id = $vendor_id;
											$email->recipient = $vendor_email;
										}
									} else {
										$email->object = 'vendor';
									}
								}
							} else {
								$email->object = false;
							}
						} else {
							$email->object = false;
						}
						break;
					// /**
					//  * Subscriptio
					//  */
					// case 'customer_subscription_new_order':
					// case 'customer_subscription_processing_order':
					// case 'customer_subscription_completed_order':
					// case 'customer_subscription_paused':
					// case 'customer_subscription_resumed':
					// case 'customer_subscription_suspended':
					// case 'customer_subscription_payment_overdue':
					// case 'customer_subscription_payment_reminder':
					// case 'customer_subscription_expired':
					// case 'customer_subscription_cancelled':
					// 	$email->object                  = $order;
					// 	$email->find['order-date']      = '{order_date}';
					// 	$email->find['order-number']    = '{order_number}';
					// 	$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
					// 	$email->replace['order-number'] = $email->object->get_order_number();
					// 	// Other properties.
					// 	$email->recipient = $email->object->get_billing_email();
					// 	break;
					/**
					 * WooCommerce Wait-list Plugin (from WooCommerce).
					 */
					case 'woocommerce_waitlist_mailout':
						$email->object               = wc_get_product( $product_id );
						$email->find[]               = '{product_title}';
						$email->replace[]            = $email->object->get_title();
						self::$current_product_title = $email->object->get_title();
						break;
					case 'failed_authentication_requested':
						$email->object               = $order;
						$email->find['order-date']   = '{order_date}';
						$email->find['order-number'] = '{order_number}';
						if ( is_object( $order ) ) {
							$email->replace['order-date']   = wc_format_datetime( $email->object->get_date_created() );
							$email->replace['order-number'] = $email->object->get_order_number();
							// Other properties
							$email->recipient = $email->object->get_billing_email();
						}
						if ( ! empty( $preview_id ) && 'mockup' != $preview_id ) {
							if ( class_exists( 'WCS_Retry_Manager' ) && WCS_Retry_Manager::is_retry_enabled() ) {
								$retry = WCS_Retry_Manager::store()->get_last_retry_for_order( $preview_id );
								if ( ! empty( $retry ) && is_object( $retry ) ) {
									$email->retry                 = $retry;
									$email->find['retry_time']    = '{retry_time}';
									$email->replace['retry_time'] = wcs_get_human_time_diff( $email->retry->get_time() );
								} else {
									$email->object = 'retry';
								}
							} else {
								$email->object = 'retry';
							}
						} else {
							$email->object = 'retry';
						}
						break;
					/**
					 * Everything else.
					 */
					default:
						$email->object = $order;
						// Allow unnamed emails preview to be filtered by plugin
						$email = apply_filters( 'Mailtpl_Woomail_Preview_email_object', $email );
						break;
				}

				if ( true === $send_email && ! empty( $email_addresses ) ) {

					self::$current_recipients = $email_addresses;

					add_filter( 'woocommerce_email_recipient_' . $email->id, array( 'Mailtpl_Woomail_Preview', 'change_recipient' ), 99 );
					$email->setup_locale();

					if ( $email->get_recipient() ) {
						$content = $email->send( $email->get_recipient(), $email->get_subject(), $email->get_content(), $email->get_headers(), $email->get_attachments() );
					}
					$email->restore_locale();

					remove_filter( 'woocommerce_email_recipient_' . $email->id, array( 'Mailtpl_Woomail_Preview', 'change_recipient' ), 99 );

				} else {
					if ( false == $email->object ) {
						$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'This email type can not be previewed please try a different order or email type.', 'mailtpl-woocommerce-email-composer' ) . '</div>';
					} else if ( 'subscription' == $email->object ) {
						$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'This email type requires that an order containing a subscription be selected as the preview order.', 'mailtpl-woocommerce-email-composer' ) . '</div>';
					} else if ( 'retry' == $email->object ) {
						$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'To generate a preview of this email type you must choose an order containing a subscription which has also failed to auto renew as the preview order in the settings.', 'mailtpl-woocommerce-email-composer' ) . '</div>';
					} else if ( 'vendor' == $email->object ) {
						$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'This email type requires that an order containing a vendor purchase be selected as the preview order.', 'mailtpl-woocommerce-email-composer' ) . '</div>';
					} else if ( 'member' == $email->object ) {
						$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'This email type requires that an order containing a user who has an active membership be selected as the preview order.', 'mailtpl-woocommerce-email-composer' ) . '</div>';
					} else if ( 'WC_Memberships_User_Membership_Ending_Soon_Email' === $email_template || 'WC_Memberships_User_Membership_Renewal_Reminder_Email' === $email_template || 'WC_Memberships_User_Membership_Activated_Email' === $email_template || 'WC_Memberships_User_Membership_Ended_Email' === $email_template ) {
						$args = array(
							'user_membership' => $email->object,
							'email'           => $email,
							'email_heading'   => $email->get_heading(),
							'email_body'      => $member_body,
							'sent_to_admin'   => false,
						);
						ob_start();

						wc_get_template( $email->template_html, $args );

						$content = ob_get_clean();
						$content = $email->style_inline( $content );
						$content = apply_filters( 'woocommerce_mail_content', $content );

						if ( 'plain' === $email->email_type ) {
							$content = '<div style="padding: 35px 40px; background-color: white;">' . str_replace( "\n", '<br/>', $content ) . '</div>';
						}
					} else {
						// Get email content and apply styles.
						$content = $email->get_content();
						$content = $email->style_inline( $content );
						$content = apply_filters( 'woocommerce_mail_content', $content );

						if ( 'plain' === $email->email_type ) {
							$content = '<div style="padding: 35px 40px; background-color: white;">' . str_replace( "\n", '<br/>', $content ) . '</div>';
						}
					}
				}
			} else {
				$content = false;
			}
			
			return $content;
		}

		/**
		 * Change Recipient to a custom one.
		 *
		 * @access public
		 * @return string
		 */
		public static function change_recipient( $recipient ) {

			if ( ! empty( self::$current_recipients ) ) {
				$recipient = self::$current_recipients;
			} else {
				// Don't send if not set
				$recipient = '';
			}
			return $recipient;
		}
		/**
		 * Print preview email 
		 *
		 * @access public
		 * @return void
		 */
		public static function print_preview_email() {

			$content = self::get_preview_email();
			if ( false == $content ) {
				echo __( 'An error occurred trying to load this email type. Make sure this email type is enabled or please try another type.', 'mailtpl-woocommerce-email-composer' );
			} elseif ( ! empty( $content ) ) {
				// Print email content
				
				echo $content;
				// Print live preview scripts in footer
				add_action( 'wp_footer', array( 'Mailtpl_Woomail_Preview', 'print_live_preview_scripts' ), 99 );
			}
		}

		/**
		 * Send preview email
		 *
		 * @access public
		 * @return void
		 */
		public static function send_preview_email() {
			$content = self::get_preview_email();
			if ( ! empty( $content ) ) {
				// Print email content
				echo $content;
			}
		}

		/**
		 * Get WooCommerce order for preview
		 *
		 * @access public
		 * @param string $order_status
		 * @return object
		 */
		public static function get_wc_order_for_preview( $order_status = null, $order_id = null ) {
			if ( ! empty( $order_id ) && 'mockup' != $order_id ) {
				return wc_get_order( $order_id );
			} else {
				// Use mockup order

				// Instantiate order object
				$order = new WC_Order();

				// Other order properties
				$order->set_props( array(
					'id'                 => 1,
					'status'             => ( null === $order_status ? 'processing' : $order_status ),
					'billing_first_name' => 'Sherlock',
					'billing_last_name'  => 'Holmes',
					'billing_company'    => 'Detectives Ltd.',
					'billing_address_1'  => '221B Baker Street',
					'billing_city'       => 'London',
					'billing_postcode'   => 'NW1 6XE',
					'billing_country'    => 'GB',
					'billing_email'      => 'support@wpexperts.io',
					'billing_phone'      => '02123123123',
					'date_created'       => date( 'Y-m-d H:i:s' ),
					'total'              => 24.90,
				) );

				// Item #1
				$order_item = new WC_Order_Item_Product();
				$order_item->set_props( array(
					'name'     => 'A Study in Scarlet',
					'subtotal' => '9.95',
					'sku'      => 'kwd_ex_1',
				) );
				$order->add_item( $order_item );

				// Item #2
				$order_item = new WC_Order_Item_Product();
				$order_item->set_props( array(
					'name'     => 'The Hound of the Baskervilles',
					'subtotal' => '14.95',
					'sku'      => 'kwd_ex_2',
				) );
				$order->add_item( $order_item );

				// Return mockup order
				return $order;
			}

		}

		/**
		* Print live preview scripts
		*
		* @access public
		* @return void
		*/
		public static function print_live_preview_scripts() {
		
			$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
			// Open container
			$scripts = '<script type="text/javascript" id="mailtpl-woomail-wp-customize-js">jQuery(document).ready(function() {';

			// Font family mapping
			$scripts .= 'var font_family_mapping = ' . json_encode( Mailtpl_Woomail_Settings::$font_family_mapping ) . ';';

			// Get information from email to use in placeholders.
			$scripts .= 'var pl_site_title = "' . get_bloginfo( 'name', 'display' ) . '";';
			$scripts .= 'var pl_site_address = "' . wp_parse_url( home_url(), PHP_URL_HOST ) . '";';
			$scripts .= 'var pl_year = "' . date( 'Y' ) . '";';
			if ( is_object( self::$current_order ) ) {
				$scripts .= 'var pl_order_date = "' . wc_format_datetime( self::$current_order->get_date_created() ) . '";';
				$scripts .= 'var pl_order_number = "' . self::$current_order->get_order_number() . '";';
				$scripts .= 'var pl_customer_first_name = "' . self::$current_order->get_billing_first_name() . '";';
				$scripts .= 'var pl_customer_last_name = "' . self::$current_order->get_billing_last_name() . '";';
				$scripts .= 'var pl_customer_full_name = "' . self::$current_order->get_formatted_billing_full_name() . '";';
				if ( 0 === ( $user_id = (int) get_post_meta( self::$current_order->get_id(), '_customer_user', true ) ) ) {
					$user_id = get_current_user_id();
				}
				$scripts .= 'var pl_customer_username = "' . Mailtpl_Woomail_Composer::get_username_from_id( $user_id ) . '";';
			}
			$scripts .= 'var pl_member_plan = "' . ( is_object( self::$current_member ) ? self::$current_member->get_plan()->get_name() : 'Membership Plan Name' ) . '";';
			$scripts .= 'var pl_product_title = "' . self::$current_product_title . '";';
			// Function to handle special cases.
			$scripts .= "function prepare(value, key, selector) {
					if (key === 'border_radius' && selector === '#template_header') {
						value = value.replace('!important', '').trim();
						value = value + ' ' + value + ' 0 0 !important';
					} else if (key === 'footer_padding' && selector === '#template_footer #credit') {
						value = '0 ' + value + ' ' + value + ' ' + value;
					}  else if (key === 'footer_content_text' && value !== '') {
						value = '<p>' + value + '</p>';
					} else if (key === 'shadow') {
						value = '0 ' + (value > 0 ? 1 : 0) + 'px ' + (value * 4) + 'px ' + value + 'px rgba(0,0,0,0.1) !important';
					} else if (key.match(/font_family$/)) {
						value = typeof font_family_mapping[value] !== 'undefined' ? font_family_mapping[value] : value;
					} else if (key === 'woocommerce_email_header_image') {
						value = '<p style=\"margin-top:0; margin-bottom:0;\"><img src=\"' + value + '\" style=\"border: none; display: inline; font-weight: bold; height: auto; line-height: 100%; outline: none; text-decoration: none; text-transform: capitalize;\" /></p>';
					} else if (value && value.includes('{site_title}') ) {
						value = value.replace('{site_title}', pl_site_title);
						if (value && value.includes('{year}') ) {
							value = value.replace('{year}', pl_year);
						}
					} else if (value && value.includes('{site_address}') ) {
						value = value.replace('{site_address}', pl_site_address);
					} else if (value && value.includes('{order_date}') ) {
						value = value.replace('{order_date}', pl_order_date);
					} else if (value && value.includes('{order_number}') ) {
						value = value.replace('{order_number}', pl_order_number);
					} else if (value && value.includes('{customer_first_name}') ) {
						value = value.replace('{customer_first_name}', pl_customer_first_name);
					} else if (value && value.includes('{customer_username}') ) {
						value = value.replace('{customer_username}', pl_customer_username);
					} else if (value && value.includes('{customer_last_name}') ) {
						value = value.replace('{customer_last_name}', pl_customer_last_name);
					} else if (value && value.includes('{customer_full_name}') ) {
						value = value.replace('{customer_full_name}', pl_customer_full_name);
					} else if (value && value.includes('{product_title}') ) {
						value = value.replace('{product_title}', pl_product_title);
					} else if (value && value.includes('{year}') ) {
						value = value.replace('{year}', pl_year);
					} else if (value && value.includes('{membership_plan}') ) {
						value = value.replace('{membership_plan}', pl_member_plan);
					}

					return value;
				}";
			// Get CSS suffixes
			$scripts .= 'var suffixes = ' . json_encode( Mailtpl_Woomail_Customizer::get_css_suffix() ) . ';';

			// Go through Mailtpl woomail settings
			foreach ( Mailtpl_Woomail_Settings::get_settings() as $setting_key => $setting ) {

				// No live method
				if ( ! isset( $setting['live_method'] ) ) {
					continue;
				}

				// Iterate over selectors
				if ( in_array( $setting['live_method'], array( 'css', 'property' ) ) && ! empty( $setting['selectors'] ) ) {
					foreach ( $setting['selectors'] as $selector => $properties ) {

						// Iterate over properties
						foreach ( $properties as $property ) {

							// CSS value change
							if ( ! isset( $setting['live_method'] ) || $setting['live_method'] === 'css' ) {
								if ( $responsive_check && 'content_width'== $setting_key ) {
									$property = 'max-width';
									if ( '#template_container' !== $selector && '#template_footer' !== $selector ) {
										continue;
									}
								}
								if ( ! $responsive_check && 'content_inner_width' == $setting_key ) {
									continue;
								}
								$scripts .= "wp.customize('mailtpl_woomail[$setting_key]', function(value) {
								value.bind(function(newval) {
								newval = newval + (typeof suffixes['$setting_key'] !== 'undefined' ? suffixes['$setting_key'] : '');
								newval = prepare(newval, '$setting_key', '$selector');
								jQuery('$selector').css('$property', '').attr('style', function(i, s) { return (s||'') + '$property: ' + newval + ';' });
								});
								});";
							}

							// DOM object property
							if ( $setting['live_method'] === 'property' ) {
								$scripts .= "wp.customize('mailtpl_woomail[$setting_key]', function(value) {
								value.bind(function(newval) {
								newval = newval + (typeof suffixes['$setting_key'] !== 'undefined' ? suffixes['$setting_key'] : '');
								newval = prepare(newval, '$setting_key', '$selector');
								jQuery('$selector').prop('$property', newval);
								});
								});";
							}
						}
					}
				}

				// HTML Replace
				if ( $setting['live_method'] === 'replace' && ! empty( $setting[ 'selectors' ] ) ) {
					foreach ( $setting['selectors'] as $selector ) {
						$original = json_encode( $setting['original'] );
						$scripts .= "wp.customize('mailtpl_woomail[$setting_key]', function(value) {
						value.bind(function(newval) {
						newval = (newval !== '' ? newval : $original);
						newval = prepare(newval, '$setting_key', '$selector');
						jQuery('$selector').html(newval);
						});
						});";
					}
				}
			}
			// Go through woo settings
			foreach ( Mailtpl_Woomail_Settings::get_woo_settings() as $setting_key => $setting ) {

				// No live method
				if ( ! isset( $setting['live_method'] ) ) {
					continue;
				}

				// Iterate over selectors
				if ( in_array( $setting['live_method'], array( 'css', 'property' ) ) && ! empty( $setting['selectors'] ) ) {
					foreach ( $setting['selectors'] as $selector => $properties ) {

						// Iterate over properties
						foreach ( $properties as $property ) {

							// CSS value change.
							if ( ! isset( $setting['live_method'] ) || $setting['live_method'] === 'css' ) {
								$scripts .= "wp.customize('$setting_key', function(value) {
								value.bind(function(newval) {
								newval = newval + (typeof suffixes['$setting_key'] !== 'undefined' ? suffixes['$setting_key'] : '');
								newval = prepare(newval, '$setting_key', '$selector');
								jQuery('$selector').css('$property', '').attr('style', function(i, s) { return (s||'') + '$property: ' + newval + ';' });
								});
								});";
							}

							// DOM object property.
							if ( 'property' === $setting['live_method'] ) {
								$scripts .= "wp.customize('$setting_key', function(value) {
								value.bind(function(newval) {
								newval = newval + (typeof suffixes['$setting_key'] !== 'undefined' ? suffixes['$setting_key'] : '');
								newval = prepare(newval, '$setting_key', '$selector');
								jQuery('$selector').prop('$property', newval);
								});
								});";
							}
						}
					}
				}
				// HTML Replace.
				if ( 'replace' === $setting['live_method'] && ! empty( $setting['selectors'] ) ) {
					foreach ( $setting['selectors'] as $selector ) {
						$original = ( isset( $setting['input_attrs'] ) && isset( $setting['input_attrs']['placeholder'] ) && ! empty( $setting['input_attrs']['placeholder'] ) ? json_encode( $setting['input_attrs']['placeholder'] ) : '"Placeholder Text"' );
						$scripts .= "wp.customize('$setting_key', function(value) {
						value.bind(function(newval) {
						newval = (newval !== '' ? newval : $original);
						";

						if ( 'woocommerce_customer_invoice_settings[heading_paid]' === $setting_key || 'woocommerce_customer_invoice_settings[heading]' === $setting_key ) {
							$scripts .= "var mailtpl_woomail_selector;";
							if ( 'woocommerce_customer_invoice_settings[heading_paid]' === $setting_key ) {
								$scripts .= "mailtpl_woomail_selector = 'mailtpl-woomail-paid-heading';
								if ( wp.customize( 'mailtpl_woomail[customer_invoice_switch]' )() ) {
								jQuery( '$selector' ).addClass( mailtpl_woomail_selector );
								jQuery( '$selector' ).removeClass( 'mailtpl-woomail-unpaid-heading' );
								} else {
								jQuery( '$selector' ).removeClass( mailtpl_woomail_selector );
								}
								newval = prepare(newval, '$setting_key', '.' + mailtpl_woomail_selector )
								jQuery( '.' + mailtpl_woomail_selector ).html( newval )
								});});";
							} else {
								$scripts .= "mailtpl_woomail_selector = 'mailtpl-woomail-unpaid-heading';
								if ( ! wp.customize( 'mailtpl_woomail[customer_invoice_switch]' )() ) {
								jQuery( '$selector' ).addClass( mailtpl_woomail_selector );
								jQuery( '$selector' ).removeClass( 'mailtpl-woomail-paid-heading' );
								} else {
								jQuery( '$selector' ).removeClass( mailtpl_woomail_selector );
								}
								newval = prepare(newval, '$setting_key', '.' + mailtpl_woomail_selector )
								jQuery( '.' + mailtpl_woomail_selector ).html( newval )
								});});";
							}

						} else {
							$scripts .= "newval = prepare(newval, '$setting_key', '$selector');
							jQuery('$selector').html(newval);
							});
							});";
						}
					}
				}
			}

//            exit( '<pre id="syed_ali_ahmed_debugger">' . print_r( Mailtpl_Woomail_Settings::get_woo_settings(), true ) . '</pre>' );
			// Close container and return.
			echo $scripts . '});</script>';
		}

	}

	Mailtpl_Woomail_Preview::get_instance();

}
