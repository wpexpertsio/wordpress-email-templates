<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
 * @version 3.7.0
 */

/** 
 * EDIT NOTES FOR MAILTPL WOOMAIL Composer
 *
 * Add option tp Move footer out of template container so background can be fullwidth.
 * Change width="600" to width 100% for tables
 * Add subtitle option.
 * Add Header image container
 * Add Order Style Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$footer_placement = Mailtpl_Woomail_Customizer::opt( 'footer_background_placement' );
$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
if ( empty( $footer_placement ) ) {
	$footer_placement = 'inside';
}
$content_width = Mailtpl_Woomail_Customizer::opt( 'content_width' );
if ( empty( $content_width ) ) {
	$content_width = '600';
}
$content_width = str_replace( 'px', '', $content_width );
if ( $responsive_check ) {
	$content_width = '360';
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<?php
									if ( 'inside' == $footer_placement ) {
										do_action( 'Mailtpl_Woomailemail_footer' );
										?>
										<table class="gmail-app-fix" width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td>
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="<?php echo esc_attr( $content_width ); ?>">
														<tr>
															<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
															</td>
															<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
															</td>
															<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									<?php } ?>
								</td>
							</tr>
						</table> <!-- End template container -->
						<?php
						if ( 'outside' == $footer_placement ) {
							do_action( 'Mailtpl_Woomailemail_footer' );
							?>
							<table class="gmail-app-fix" width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<table cellpadding="0" cellspacing="0" border="0" align="center" width="<?php echo esc_attr( $content_width ); ?>">
											<tr>
												<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
												</td>
												<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
												</td>
												<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: <?php echo esc_attr( floor( $content_width / 3 ) ); ?>px;">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
