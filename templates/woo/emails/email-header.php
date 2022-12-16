<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/** 
 * EDIT NOTES FOR MAILTPL WOOMAIL Composer
 *
 * add class to body tag so you can style this specifically 
 * Change width="600" to width 100% for tables
 * Add subtitle option.
 * Add Header image container
 * Add Order Style Class
 */
if ( isset( $email ) && is_object( $email ) && isset( $email->id ) ) {
	$key = $email->id;
} else {
	$key = '';
}


$email_subtitle = Mailtpl_Woomail_Customizer::opt( $key . '_subtitle' );
if ( ! empty( $email_subtitle ) ) {
	$email_subtitle = Mailtpl_Woomail_Composer::filter_subtitle( $email_subtitle, $email );
}
$subtitle_placement = Mailtpl_Woomail_Customizer::opt( 'subtitle_placement' );
$responsive_check = Mailtpl_Woomail_Customizer::opt( 'responsive_mode' );
if ( true == $responsive_check ) {
	$responsive_mode = 'fluid';
} else {
	$responsive_mode = 'normal';
}
$content_width = Mailtpl_Woomail_Customizer::opt( 'content_width' );
if ( empty( $content_width ) ) {
	$content_width = '600';
}
$content_width = str_replace( 'px', '', $content_width );
$order_style = Mailtpl_Woomail_Customizer::opt( 'order_items_style' );
if ( empty( $order_style ) ) {
	$order_style = 'normal';
}
$h2_style = Mailtpl_Woomail_Customizer::opt( 'h2_style' );
if ( empty( $h2_style ) ) {
	$h2_style = 'none';
}
$header_image_maxwidth = Mailtpl_Woomail_Customizer::opt( 'header_image_maxwidth' );
if ( empty( $header_image_maxwidth ) ) {
	$header_image_maxwidth = 'auto';
}
$header_image_maxwidth = str_replace( 'px', '', $header_image_maxwidth );
$header_placement = Mailtpl_Woomail_Customizer::opt( 'header_image_placement' );
if ( empty( $header_placement ) ) {
	$header_placement = 'outside';
}
$header_image_link = Mailtpl_Woomail_Customizer::opt( 'header_image_link' );
$img = get_option( 'woocommerce_email_header_image' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo wp_kses_post( get_bloginfo( 'name', 'display' ) ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" class="mailtpl-woo-wrap order-items-<?php echo esc_attr( $order_style ); ?> k-responsive-<?php echo esc_attr( $responsive_mode ); ?> title-style-<?php echo esc_attr( $h2_style ); ?> email-id-<?php echo esc_attr( $key ); ?>">
		<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<?php if ( 'inside' !== $header_placement ) { ?>
							<table id="template_header_image_container">
								<tr id="template_header_image">
									<td align="center" valign="middle">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header_image_table">
											<tr>
												<td align="center" valign="middle">
													<?php
													if ( $img ) {
														echo '<p style="margin-top:0;">';
														if ( $header_image_link ) {
															echo '<a href="' . esc_url( get_home_url() ) . '" target="_blank" style="display:block; text-decoration: none;">';
														}
														echo '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" width="' . esc_attr( $header_image_maxwidth ) . '" />';
														if ( $header_image_link ) {
															echo '</a>';
														}
														echo '</p>';
													}
													?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<?php } ?>
						<table border="0" cellpadding="0" cellspacing="0" width="<?php echo esc_attr( $content_width ); ?>" id="template_container">
							<tr>
								<td align="center" valign="top">
									<?php if ( 'inside' === $header_placement ) { ?>
										<table id="template_header_image_container">
											<tr id="template_header_image">
												<td align="center" valign="middle">
													<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header_image_table">
														<tr>
															<td align="center" valign="middle">
																<?php
																if ( $img ) {
																	echo '<p style="margin-top:0;">';
																	if ( $header_image_link ) {
																		echo '<a href="' . esc_url( get_home_url() ) . '" target="_blank" style="display:block; text-decoration: none;">';
																	}
																	echo '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" width="' . esc_attr( $header_image_maxwidth ) . '" />';
																	if ( $header_image_link ) {
																		echo '</a>';
																	}
																	echo '</p>';
																}
																?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									<?php } ?>
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
										<tr>
											<td id="header_wrapper">
												<?php if ( 'above' === $subtitle_placement ) { ?>
													<div class="subtitle"><?php echo wp_kses_post( $email_subtitle ); ?></div>
												<?php } ?>
												<h1><?php echo wp_kses_post( $email_heading ); ?></h1>
												<?php if ( 'below' === $subtitle_placement ) { ?>
													<div class="subtitle"><?php echo wp_kses_post( $email_subtitle ); ?></div>
												<?php } ?>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="<?php echo esc_attr( $content_width ); ?>" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top">
															<div id="body_content_inner">
