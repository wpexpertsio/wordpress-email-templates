<?php
/**
 * Woocommerce integration with settings.
 *
 * @package Mailtpl WooCommerce Email Composer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integration with WooCommerce Settings Page
 */
if ( ! class_exists( 'Mailtpl_Woomail_Woo' ) ) {
	/**
	 * Class Mailtpl Woomail Woo.
	 */
	class Mailtpl_Woomail_Woo {

		/**
		 * The instance Control Var.
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Instance Control
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Add email Customzier setting to normal woocommerce email settings area.
			add_filter( 'woocommerce_email_settings', array( $this, 'add_mail_customizer_to_woocommerce_email_settings' ) );

			// Print email Customzier button in normal woocommerce email settings area.
			add_action( 'woocommerce_admin_field_mailtpl_woomail_open_customizer_button', array( $this, 'print_open_customizer_button' ) );

		}

		/**
		 * Add Open Composer to settings button
		 *
		 * @access public
		 * @param array $settings
		 * @return array
		 */
		public function add_mail_customizer_to_woocommerce_email_settings( $settings ) {

			// Open section
			$settings[] = array(
				'id'    => 'mailtpl_woomail',
				'type'  => 'title',
				'title' => __('Woocommerce Email Composer', 'mailtpl-woocommerce-email-composer'),
			);

			// Add Open Composer button
			$settings[] = array(
				'id'    => 'mailtpl_woomail_open_customizer_button',
				'type'  => 'mailtpl_woomail_open_customizer_button',
			);

			// Close section
			$settings[] = array(
				'id'    => 'mailtpl_woomail',
				'type'  => 'sectionend',
			);

			// Return remaining settings
			return $settings;

		}

		/**
		 * Print Open Composer button
		 *
		 * @access public
		 * @param array $options settings options.
		 * @return void
		 */
		public function print_open_customizer_button( $options ) {
			?>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<?php _e( 'Customize WooCommerce Emails', 'mailtpl-woocommerce-email-composer' ); ?>
				</th>
				<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $options['type'] ) ); ?>">
					<a href="<?php echo esc_url( Mailtpl_Woomail_Customizer::get_customizer_url() ); ?>">
						<button type="button" class="button button-secondary" value="<?php _e( 'Open Woocommerce Email Composer', 'mailtpl-woocommerce-email-composer' ); ?>">
							<?php _e( 'Open Woocommerce Email Editor', 'mailtpl-woocommerce-email-composer' ); ?>
						</button>
					</a>
					<p class="description"><?php printf( __( 'Make Woocommerce Emails match your brand. <a href="%s">Email Templates</a> plugin by <a href="%s">wpexpertsio</a>.', 'mailtpl-woocommerce-email-composer' ), 'https://wordpress.org/plugins/email-templates/', 'https://wpexperts.io/' ); ?></p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Get WooCommerce email settings page URL
		 *
		 * @access public
		 * @return string
		 */
		public static function get_email_settings_page_url() {
			return admin_url( 'admin.php?page=wc-settings&tab=email' );
		}

	}

	Mailtpl_Woomail_Woo::get_instance();

}
