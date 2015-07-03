<?php
/**
 * email header
 *
 * @version	1.0
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
if ( ! defined( 'ABSPATH' ) ) exit; 


$wrapper = "
	background-color:".$settings['body_bg'].";
	width:100%;
	-webkit-text-size-adjust:none !important;
	margin:0;
	padding: 70px 0 70px 0;
";
$border_radius = $settings['template'] == 'boxed' ? '6px' : '0px';
$template_container = "
	-webkit-box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
	box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
	-webkit-border-radius:$border_radius !important;
	border-radius:$border_radius !important;
	background-color: #fafafa;
	border-radius:6px !important;
";
$template_header = "
	background-color: ".$settings['header_bg'].";
	color: #f1f1f1;
	-webkit-border-top-left-radius:$border_radius !important;
	-webkit-border-top-right-radius:$border_radius !important;
	border-top-left-radius:$border_radius !important;
	border-top-right-radius:$border_radius !important;
	border-bottom: 0;
	font-family:Arial;
	font-weight:bold;
	line-height:100%;
	vertical-align:middle;
";
$body_content = "
	background-color: #fafafa;
	-webkit-border-radius:$border_radius !important;
	border-radius:6px !important;
";
$body_content_inner = "
	color: #888888;
	font-family:Arial;
	font-size:14px;
	line-height:150%;
	text-align:left;
";
$header_content_h1 = "
	color: ".$settings['header_text_color'].";
	margin:0;
	padding: 28px 24px;
	display:block;
	font-family:Arial;
	font-size:30px;
	font-weight:bold;
	text-align:".$settings['header_aligment'].";
	line-height: 150%;
";


?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo get_bloginfo('charset');?>" />
        <title><?php echo get_bloginfo('name'); ?></title>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<div id="body" style="<?php echo $wrapper; ?>">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="center" valign="top">
                    	<table border="0" cellpadding="0" cellspacing="0" width="<?php echo $settings['template'] == 'boxed' ? '680px' : '100%';?>" id="template_container" style="<?php echo $template_container; ?>">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Header -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style="<?php echo $template_header; ?>"">
                                        <tr>
                                            <td>
                                            	<h1 style="<?php echo $header_content_h1; ?>" id="logo"><?php
		                                            if( !empty($settings['header_logo']) ) {
			                                            echo '<img src="'.apply_filters( 'mailtpl/templates/header_logo', $settings['header_logo'] ).'" alt="logo"/>';
		                                            } elseif ( !empty( $settings['header_logo_text'] ) ) {
														echo $settings['header_logo_text'];
		                                            } else {
														echo get_bloginfo('name');
		                                            }  ?></h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body">
                                    	<tr>
                                            <td valign="top" style="<?php echo $body_content; ?>">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div style="<?php echo $body_content_inner; ?>">