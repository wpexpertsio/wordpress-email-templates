<?php
/**
 * Customer renewal invoice email
 *
 * @author  wpexperts
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * NOTES ABOUT TEMPLATE EDIT FOR MAILTPL WOOMAIL Composer, 
 * 1. add hook 'Mailtpl_Woomailemail_details' to pull in main text
 * 2. Remove static main text area.
 */

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php 

/**
 * @hooked Mailtpl_Woomail_Composer::email_main_text_area
 */
do_action( 'Mailtpl_Woomailemail_details', $order, $sent_to_admin, $plain_text, $email );

?>

<?php do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( isset( $additional_content ) && ! empty( $additional_content ) ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
?>
