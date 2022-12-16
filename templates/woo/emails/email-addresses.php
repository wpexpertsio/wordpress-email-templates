<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
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
 * @version 3.9.0
 */

/** 
 * EDIT NOTES FOR MAILTPL WOOMAIL Composer
 *
 * Add support for responsive email.
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align       = is_rtl() ? 'right' : 'left';
$address          = $order->get_formatted_billing_address();
$shipping         = $order->get_formatted_shipping_address();
$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
if ( true == $responsive_check ) {
	?>
	<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
		<tr>
			<td class="address-container" style="text-align:<?php echo esc_attr( $text_align ); ?>; padding:0; border:0;" valign="top">
				<h2><?php esc_html_e( 'Billing address', 'mailtpl-woocommerce-email-composer' ); ?></h2>

				<address class="address">
					<table cellspacing="0" cellpadding="0" style="width: 100%; padding:0;" border="0">
						<tr>
							<td class="address-td" valign="top">
								<?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'mailtpl-woocommerce-email-composer' ) ); ?>
								<?php
								// Adds in support for plugin.
								if ( ! class_exists( 'APG_Campo_NIF' ) ) {
									if ( $order->get_billing_phone() ) :
										?>
										<br/><?php echo wc_make_phone_clickable( $order->get_billing_phone() ); ?>
									<?php endif; ?>
									<?php if ( $order->get_billing_email() ) : ?>
										<a href="mailto:<?php echo esc_attr( $order->get_billing_email() ); ?>"><?php echo esc_html( $order->get_billing_email() ); ?></a>
										<?php
									endif;
								}
								?>
							</td>
						</tr>
					</table>
				</address>
			</td>
		</tr>
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
			<tr>
				<td class="shipping-address-container" style="text-align:<?php echo esc_attr( $text_align ); ?>;" valign="top">
					<h2><?php esc_html_e( 'Shipping address', 'mailtpl-woocommerce-email-composer' ); ?></h2>

					<address class="address">
						<table cellspacing="0" cellpadding="0" style="width: 100%; padding:0;" border="0">
							<tr>
								<td class="address-td" valign="top">
									<?php echo wp_kses_post( $shipping ); ?>
								</td>
							</tr>
						</table>
					</address>
				</td>
			</tr>
		<?php endif; ?>
	</table>
	<?php
} else {
	?>
	<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
		<tr>
			<td class="address-container" style="text-align:<?php echo esc_attr( $text_align ); ?>; padding:0; border:0;" valign="top" width="50%">
				<h2><?php esc_html_e( 'Billing address', 'mailtpl-woocommerce-email-composer' ); ?></h2>

				<address class="address">
					<table cellspacing="0" cellpadding="0" style="width: 100%; padding:0;" border="0">
						<tr>
							<td class="address-td" valign="top">
							<?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'mailtpl-woocommerce-email-composer' ) ); ?>
							<?php
							// Adds in support for plugin.
							if ( ! class_exists( 'APG_Campo_NIF' ) ) {
								if ( $order->get_billing_phone() ) :
									?>
									<br/><?php echo wc_make_phone_clickable( $order->get_billing_phone() ); ?>
								<?php endif; ?>
								<?php if ( $order->get_billing_email() ) : ?>
									<a href="mailto:<?php echo esc_attr( $order->get_billing_email() ); ?>"><?php echo esc_html( $order->get_billing_email() ); ?></a>
									<?php
								endif;
							}
							?>
							</td>
						</tr>
					</table>
				</address>
			</td>
			<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
				<td class="shipping-address-container" style="text-align:<?php echo esc_attr( $text_align ); ?>; padding:0 0 0 20px;" valign="top" width="50%">
					<h2><?php esc_html_e( 'Shipping address', 'mailtpl-woocommerce-email-composer' ); ?></h2>
					<address class="address">
						<table cellspacing="0" cellpadding="0" style="width: 100%; padding:0;" border="0">
							<tr>
								<td class="address-td" valign="top">
									<?php echo wp_kses_post( $shipping ); ?>
								</td>
							</tr>
						</table>
					</address>
				</td>
			<?php endif; ?>
		</tr>
	</table>
	<?php
}
