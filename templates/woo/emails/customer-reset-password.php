<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version 4.0.0
 */

/**
 * NOTES ABOUT TEMPLATE EDIT FOR MAILTPL WOOMAIL Composer, 
 * 1. add hook 'Mailtpl_Woomailemail_details' to pull in main text
 * 2. Remove static main text area.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$button_check = Mailtpl_Woomail_Customizer::opt( 'customer_reset_password_btn_switch' );

do_action( 'woocommerce_email_header', $email_heading, $email ); 

/**
 * @hooked Mailtpl_Woomail_Composer::email_main_text_area_no_order
 */
do_action( 'Mailtpl_Woomailemail_text', $email ); 

if ( true == $button_check ) {
	echo '<p class="btn-container"><a href="' . esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ) . '" class="btn">' . esc_html__( 'Reset Password', 'mailtpl-woocommerce-email-composer' ) . '</a></p>';
} else {
	?>
	<p>
		<a class="link" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">
				<?php esc_html_e( 'Click here to reset your password', 'mailtpl-woocommerce-email-composer' ); ?></a>
	</p>
	<?php
}
?>
<p></p>
<?php
/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
?>
