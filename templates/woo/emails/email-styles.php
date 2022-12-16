<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link = wc_hex_is_light( $base ) ? $base : $base_text;
if ( wc_hex_is_light( $body ) ) {
	$link = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
/*
EDIT NOTES
Added overflow:hidden; to template container
Removed border-radius from template header

Remove Top Padding from #body_content table td
ADDED: Body background color to pull from wrapper background
ADDED: light order table styles
ADDED: Separator styles
CHANGED h3 margin from 16px 0 8px to 0 0 8px;
CHANGED address padding from 12px 12px 0 to 12px;
ADDED address > p margin bottom 0;
ADDED Padding left if shipping address
ADDED footer social links
Change footer credits padding to 10px.
ADDED : btn styling.
*/
?>
html, body {
	height:100%;
	position:relative;
}
body.mailtpl-woo-wrap {
margin:0;
padding:0;
}
.k-responsive-fluid #template_container, .k-responsive-fluid #template_header_image, .k-responsive-fluid #template_header, .k-responsive-fluid #template_body, .k-responsive-fluid #template_footer {
	width:100% !important;
	min-width:320px !important;
}
.k-responsive-fluid #wrapper {
	margin: 0 auto !important;
}
.k-responsive-fluid .order_item img {
	float:left;
	padding-right:10px;
	padding-bottom:0;
}
.k-responsive-fluid  #body_content table td td {
min-width:60px;
}
.k-responsive-fluid td.shipping-address-container {
	padding: 0 !important;
}
.k-responsive-fluid #addresses > tbody > tr > td {
	padding-left:0px;
	padding-right:0px;
}
.k-responsive-fluid #addresses > tbody > tr {
	margin-left: 0px;
	margin-right: 0px;
}
#body_content_inner > table {
	border-collapse: collapse;
}
#template_header_image p {
	margin-bottom:0;
}
#template_header_image_container {
	width: 100%;
}
body {
	background-color: <?php echo esc_attr( $bg ); ?>;
}
#wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	background-color: <?php echo esc_attr( $body ); ?>;
	overflow:hidden;
	border-style:solid;
}

#template_header {
	background-color: <?php echo esc_attr( $base ); ?>;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
}

#template_footer td {
	padding: 0;
}

#template_footer #credit {
	border:0;
	color: <?php echo esc_attr( $base_lighter_40 ); ?>;
	font-family: Arial;
	font-size:12px;
	line-height:125%;
	text-align:center;
	padding-left: 0px;
	padding-right: 0px;
}
#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 0px 48px 0;
}

#body_content table td td {
	padding: 12px;
}

#body_content table td th {
	padding: 12px;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
	display:inline;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
}
.address-td {
	padding:12px 12px;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
}
.address-td a {
	display: block;
}
#body_content .address p {
	margin: 0;
}
#addresses > tbody > tr > td {
	padding-left:5px;
	padding-right:5px;
}
#addresses > tbody > tr {
	margin-left: -5px;
	margin-right: -5px;
}
.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}
#header_wrapper {
	padding: 36px 48px;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 0 0 18px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 0px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $link ); ?>;
	font-weight: normal;
	text-decoration: underline;
}
.btn {
	padding: 10px 16px;
	display: inline-block;
	color:white;
	background-color: <?php echo esc_attr( $base ); ?>;
	text-decoration: none;
	font-weight: 600;
	border-style: solid;
	border-width: 0;
}
img {
	border: none;
	display: inline;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	line-height: 100%;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
}
.order_item img {
	display:block;
	padding-bottom:5px;
}
.ft-social-link img {
	width:24px;
	max-width:100%;
	display:inline-block;
}
.ft-social-title {
	font-size: 18px;
	line-height: 24px;
	padding-left: 5px;
}
#template_header_image img {
	max-width:100%;
}
<?php
