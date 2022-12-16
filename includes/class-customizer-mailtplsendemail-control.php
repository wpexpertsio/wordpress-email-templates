<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Kwdsendemail_Control' ) ) {
	class WP_Customize_Kwdsendemail_Control extends WP_Customize_Control {
		public $type = 'kwdsendemail';


		public function render_content() {
			?>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" id="_customize-input-<?php echo $this->id; ?>" <?php $this->input_attrs(); $this->link(); ?>>
			<div style="padding: 10px;"><?php _e( 'Settings must be saved to send preview email.', 'mailtpl-woocommerce-email-composer' ); ?></div>
			<input type="button" class="button button-primary mailtpl-woomail-button" name="mailtpl-woomail-send-email" value="<?php esc_attr_e( 'Send Email', 'mailtpl-woocommerce-email-composer' ); ?>" />
			<div style="padding: 10px;"><?php _e( 'Some emails will not work correctly with the mockup order. It is best to use a real order for sending preview emails.', 'mailtpl-woocommerce-email-composer' ); ?></div>
			<?php
		}
	}
}