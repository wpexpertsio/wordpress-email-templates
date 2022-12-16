<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

/*
 * EDIT NOTES FOR MAILTPL WOOMAIL Composer
 *
 * ADDED: option to split up order heading.
 * Because woocommerce subscriptions and woocommerce core share the same file name (WHY!!!) this file is long with included logic for subscriptions.
 * ADDED: responsive mode so table is only two columns.
 */

defined( 'ABSPATH' ) || exit;

$text_align       = is_rtl() ? 'right' : 'left';
$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
$zebra_check      = Mailtpl_Woomail_Customizer::opt( 'items_table_background_odd_color' );
$note_check       = Mailtpl_Woomail_Customizer::opt( 'notes_outside_table' );

if ( isset( $order_type ) && 'subscription' === $order_type && class_exists( 'WC_Subscriptions_Email' ) ) {
	do_action( 'woocommerce_email_before_subscription_table', $order, $sent_to_admin, $plain_text, $email );
	if ( 'cancelled_subscription' != $email->id ) {
		echo '<h3>';

		$link_element_url = ( $sent_to_admin ) ? wcs_get_edit_post_link( wcs_get_objects_property( $order, 'id' ) ) : $order->get_view_order_url();
			// translators: $1-$3: opening and closing <a> tags $2: subscription's order number.
			printf( esc_html_x( 'Subscription %1$s#%2$s%3$s', 'Used in email notification', 'mailtpl-woocommerce-email-composer' ), '<a href="' . esc_url( $link_element_url ) . '">', esc_html( $order->get_order_number() ), '</a>' );
		echo '</h3>';
	}
	if ( true == $responsive_check ) {
		?>
		<div class="email-spacing-wrap" style="margin-bottom: 40px;">
			<table class="td" cellspacing="0" cellpadding="6" width="100%" style="width: 100%;" border="1">
				<thead>
					<tr>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'mailtpl-woocommerce-email-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php echo wp_kses_post( WC_Subscriptions_Email::email_order_items_table( $order, $order_items_table_args ) ); ?>
					<?php
					if ( empty( $zebra_check ) ) {
						?>
						</tbody>
						<tfoot>
						<?php
					}
					$item_totals = $order->get_order_item_totals();

					if ( $item_totals ) {
						$i = 0;
						foreach ( $item_totals as $total ) {
							$i++;
							?>
							<tr>
								<th class="td tlabel-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" scope="row" colspan="1" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td class="td tvalue-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['value'] ); ?></td>
							</tr>
							<?php
						}
					}
					if ( empty( $zebra_check ) ) {
						?>
						</tfoot>
						<?php
					} else {
						?>
						</tbody>
						<?php
					}
					?>
			</table>
		</div>

		<?php
	} else {
		?>
		<div class="email-spacing-wrap" style="margin-bottom: 40px;">
			<table class="td" cellspacing="0" cellpadding="6" width="100%" style="width: 100%;" border="1">
				<thead>
					<tr>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'mailtpl-woocommerce-email-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php echo wp_kses_post( WC_Subscriptions_Email::email_order_items_table( $order, $order_items_table_args ) ); ?>
					<?php
					if ( empty( $zebra_check ) ) {
						?>
						</tbody>
						<tfoot>
						<?php
					}
					$item_totals = $order->get_order_item_totals();

					if ( $item_totals ) {
						$i = 0;
						foreach ( $item_totals as $total ) {
							$i++;
							?>
							<tr>
								<th class="td tlabel-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td class="td tvalue-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['value'] ); ?></td>
							</tr>
							<?php
						}
					}
					if ( empty( $zebra_check ) ) {
						?>
						</tfoot>
						<?php
					} else {
						?>
						</tbody>
						<?php
					}
					?>
			</table>
		</div>
		<?php
	}
	do_action( 'woocommerce_email_after_subscription_table', $order, $sent_to_admin, $plain_text, $email );

} else {

	do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email );
	?>
	<div style="clear:both; height:1px;"></div>
	<?php
	$order_head_style = Mailtpl_Woomail_Customizer::opt( 'order_heading_style' );
	if ( empty( $order_head_style ) ) {
		$order_head_style = 'normal';
	}
	if ( 'split' == $order_head_style ) {
		?>
		<h2>
			<?php
			echo __( 'Order Details', 'mailtpl-woocommerce-email-composer' );
			?>
		</h2>
		<table class="order-info-split-table" cellspacing="0" cellpadding="0" width="100%" border="0">
			<tr>
				<td align="left" valign="middle">
					<h3 style="text-align: left;">
					<?php
					if ( $sent_to_admin ) {
						$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
						$after  = '</a>';
					} else {
						$before = '';
						$after  = '';
					}
					/* translators: %s: Order ID. */
					echo wp_kses_post( $before . sprintf( __( 'Order number: %s', 'mailtpl-woocommerce-email-composer' ) . $after, $order->get_order_number() ) );
					?>
					</h3>
				</td>
				<td align="right" valign="middle">
					<h3 style="text-align: right;">
						<?php
						echo wp_kses_post( sprintf(  __( 'Order date:', 'mailtpl-woocommerce-email-composer' ) . ' <time datetime="%s">%s</time>', $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
						?>
					</h3>
				</td>
			</tr>
		</table>
		<?php
	} else {
		?>
		<h2>
			<?php
			if ( $sent_to_admin ) {
				$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
				$after  = '</a>';
			} else {
				$before = '';
				$after  = '';
			}
			/* translators: %s: Order ID. */
			echo wp_kses_post( $before . sprintf( __( 'Order #%s', 'mailtpl-woocommerce-email-composer' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
			?>
		</h2>
	<?php } ?>

	<?php
	if ( true == $responsive_check ) {
		?>
		<div class="email-spacing-wrap" style="margin-bottom: 40px;">
			<table class="td" cellspacing="0" cellpadding="6" width="100%" style="width: 100%;" border="1">
				<thead>
					<tr>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'mailtpl-woocommerce-email-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						$order,
						array(
							'show_sku'      => $sent_to_admin,
							'show_image'    => false,
							'image_size'    => array( 32, 32 ),
							'plain_text'    => $plain_text,
							'sent_to_admin' => $sent_to_admin,
						)
					);
					if ( empty( $zebra_check ) ) {
						?>
						</tbody>
						<tfoot>
						<?php
					}
					$item_totals = $order->get_order_item_totals();

					if ( $item_totals ) {
						$i = 0;
						foreach ( $item_totals as $total ) {
							$i++;
							?>
							<tr>
								<th class="td tlabel-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" scope="row" colspan="1" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td class="td tvalue-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['value'] ); ?></td>
							</tr>
							<?php
						}
					}
					if ( empty( $zebra_check ) ) {
						?>
						</tfoot>
						<?php
					} else {
						?>
						</tbody>
						<?php
					}
					?>
			</table>
		</div>
		<?php
		if ( $order->get_customer_note() ) {
			?>
			<div class="email-spacing-wrap" style="margin-bottom: 40px;">
				<h2>
				<?php echo esc_html__( 'Order Note', 'mailtpl-woocommerce-email-composer' ); ?>
				</h2>
				<p class="note-content"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></p>
			</div>
			<?php
		}
		?>
	<?php } else { ?>
		<div class="email-spacing-wrap" style="margin-bottom: 40px;">
			<table class="td" cellspacing="0" cellpadding="6" width="100%" style="width: 100%;" border="1">
				<thead>
					<tr>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'mailtpl-woocommerce-email-composer' ); ?></th>
						<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'mailtpl-woocommerce-email-composer' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						$order,
						array(
							'show_sku'      => $sent_to_admin,
							'show_image'    => false,
							'image_size'    => array( 32, 32 ),
							'plain_text'    => $plain_text,
							'sent_to_admin' => $sent_to_admin,
						)
					);
					if ( empty( $zebra_check ) ) {
						?>
						</tbody>
						<tfoot>
						<?php
					}
					$item_totals = $order->get_order_item_totals();

					if ( $item_totals ) {
						$i = 0;
						foreach ( $item_totals as $total ) {
							$i++;
							?>
							<tr>
								<th class="td tlabel-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['label'] ); ?></th>
								<td class="td tvalue-<?php echo esc_attr( preg_replace( '/[^a-z]/', '', strtolower( $total['label'] ) ) ); ?>" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( $total['value'] ); ?></td>
							</tr>
							<?php
						}
					}
					if ( false == $note_check && $order->get_customer_note() ) {
						?>
						<tr>
							<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'mailtpl-woocommerce-email-composer' ); ?></th>
							<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
						</tr>
						<?php
					}
					if ( empty( $zebra_check ) ) {
						?>
						</tfoot>
						<?php
					} else {
						?>
						</tbody>
						<?php
					}
					?>
			</table>
		</div>
		<?php
		if ( true == $note_check && $order->get_customer_note() ) {
			?>
			<div class="email-spacing-wrap" style="margin-bottom: 40px;">
				<h2>
				<?php echo esc_html__( 'Order Note', 'mailtpl-woocommerce-email-composer' ); ?>
				</h2>
				<p class="note-content"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></p>
			</div>
			<?php
		}
		?>
		<?php
	}

	do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email );
}
