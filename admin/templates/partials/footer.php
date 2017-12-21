<?php
/**
 * email footer
 *
 * @version	1.0
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$border_radius = $settings['template'] == 'boxed' ? '6px' : '0px';
$template_footer = "
	border-top:1px solid #E2E2E2;
	background: ".$settings['footer_bg'].";
	-webkit-border-radius:0px 0px $border_radius $border_radius;
	-o-border-radius:0px 0px $border_radius $border_radius;
	-moz-border-radius:0px 0px $border_radius $border_radius;
	border-radius:0px 0px $border_radius $border_radius;
";

$credit = "
	border:0;
	color: ".$settings['footer_text_color'].";
	font-family: Arial;
	font-size: ".$settings['footer_text_size']."px;
	line-height:125%;
	text-align:".$settings['footer_aligment'].";
";
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
            <!-- Footer -->
        	<table border="0" cellpadding="10" cellspacing="0" width="100%" id="template_footer" style="<?php echo $template_footer; ?>">
            	<tr>
                	<td valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" valign="middle" id="credit" style="<?php echo $credit; ?>">
                                
                                	<?php echo apply_filters( 'mailtpl/templates/footer_text', do_shortcode($settings['footer_text'] )); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- End Footer -->
        </td>
    </tr>
            </table>
			<?php if( $settings['footer_powered_by'] != 'off' ): ?>
			    <p id="powered">Powered by <a href="https://wp.timersys.com/email-templates/?utm_source=emails_template_plugin&utm_medium=powered_link&utm_campaign=Email%20Templates">Email Templates Plugin</a></p>
            <?php endif;?>
        </td>
    </tr>
</table>
        </div> <?php if( is_customize_preview() ) wp_footer();?>
    </body>
</html>