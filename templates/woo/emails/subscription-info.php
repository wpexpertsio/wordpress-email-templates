<?php
/**
 * Subscription information template
 *
 * @author  wpexperts
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * EDIT NOTES FOR MAILTPL WOOMAIL Composer
 * ADDED: Separator spans.
 * ADDED: Responsive layout.
 */
$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
$text_align       = is_rtl() ? 'right' : 'left';

if ( ! empty( $subscriptions ) ) :
	if ( true == $responsive_check ) {
		?>
		<div style="clear:both; height:1px;"></div>
		<h2><?php esc_html_e( 'Subscription Information:', 'mailtpl-woocommerce-email-composer' ); ?></h2>
		<div style="padding-bottom: 20px;">
			<?php foreach ( $subscriptions as $subscription ) : ?>
				<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; margin-bottom: 20px;" border="1">
					<tbody>
						<tr>
							<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
								<p style="margin-bottom: 0"><strong><?php esc_html_e( 'Subscription', 'mailtpl-woocommerce-email-composer' ); ?></strong></p>
								<p style="margin-bottom: 0"><a href="<?php echo esc_url( ( $is_admin_email ) ? wcs_get_edit_post_link( $subscription->get_id() ) : $subscription->get_view_order_url() ); ?>"><?php echo sprintf( esc_html_x( '#%s', 'subscription number in email table. (eg: #106)', 'mailtpl-woocommerce-email-composer' ), esc_html( $subscription->get_order_number() ) ); ?></a></p>
							</td>
							<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
								<p style="margin-bottom: 0"><strong><?php echo esc_html_x( 'Price', 'table heading', 'mailtpl-woocommerce-email-composer' ); ?></strong></p>
								<p style="margin-bottom: 0"><?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?></p>
							</td>
						</tr>
						<tr>
							<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
								<p style="margin-bottom: 0"><strong><?php echo esc_html_x( 'Start Date', 'table heading', 'mailtpl-woocommerce-email-composer' ); ?></strong></p>
								<p style="margin-bottom: 0"><?php echo esc_html( date_i18n( wc_date_format(), $subscription->get_time( 'date_created', 'site' ) ) ); ?></p>
							</td>
							<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
								<p style="margin-bottom: 0"><strong><?php echo esc_html_x( 'End Date', 'table heading', 'mailtpl-woocommerce-email-composer' ); ?></strong></p>
								<p style="margin-bottom: 0"><?php echo esc_html( ( 0 < $subscription->get_time( 'end' ) ) ? date_i18n( wc_date_format(), $subscription->get_time( 'end', 'site' ) ) : _x( 'When Cancelled', 'Used as end date for an indefinite subscription', 'mailtpl-woocommerce-email-composer' ) ); ?></p>
							</td>
						</tr>
					</tbody>
				</table>
			<?php endforeach; ?>
		</div>
	<?php } else { ?>
		<div style="clear:both; height:1px;"></div>
		<h2><?php esc_html_e( 'Subscription Information:', 'mailtpl-woocommerce-email-composer' ); ?></h2>
		<div class="email-spacing-wrap" style="margin-bottom: 40px;">
			<table class="td" cellspacing="0" cellpadding="6" style="width: 100%;" border="1">
				<thead>
					<tr>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Subscription', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo esc_html_x( 'Start Date', 'table heading',  'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo esc_html_x( 'End Date', 'table heading',  'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo esc_html_x( 'Price',  'table heading', 'mailtpl-woocommerce-email-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $subscriptions as $subscription ) : ?>
					<tr>
						<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><a href="<?php echo esc_url( ( $is_admin_email ) ? wcs_get_edit_post_link( $subscription->get_id() ) : $subscription->get_view_order_url() ); ?>"><?php echo sprintf( esc_html_x( '#%s', 'subscription number in email table. (eg: #106)', 'mailtpl-woocommerce-email-composer' ), esc_html( $subscription->get_order_number() ) ); ?></a></td>
						<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo esc_html( date_i18n( wc_date_format(), $subscription->get_time( 'date_created', 'site' ) ) ); ?></td>
						<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo esc_html( ( 0 < $subscription->get_time( 'end' ) ) ? date_i18n( wc_date_format(), $subscription->get_time( 'end', 'site' ) ) : _x( 'When Cancelled', 'Used as end date for an indefinite subscription', 'mailtpl-woocommerce-email-composer' ) ); ?></td>
						<td class="td" scope="row" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $subscription->get_formatted_order_total() ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
<?php endif; ?>
