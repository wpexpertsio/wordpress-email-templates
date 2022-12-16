<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_mailtpltemplateload_Control' ) ) {
	class WP_Customize_mailtpltemplateload_Control extends WP_Customize_Control {
		public $type = 'mailtpltemplateload';


		public function render_content() {

			$name = 'mailtpl-woomail-prebuilt-template';
			?>

			<div style="padding-bottom: 20px;">
				<span style="color:#0e9cd1"><strong>NEW!</strong></span>
				<h2 style="margin-top:0; padding: 5px 0;">Free Fluid Template</h2>
				Download Here
			</div>
			<span class="customize-control-title">
				<?php _e( 'Load Template', 'mailtpl-woocommerce-email-composer' ); ?>
			</span>
			<div class="mailtpl-template-woomail-load-controls">
				<div id="input_<?php echo $this->id; ?>" class="image-radio-select">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<label class="<?php echo $this->id . $value; ?> image-radio-select-item" data-image-value="<?php echo esc_attr( $value ); ?>">
						<img src="<?php echo esc_url( MAILTPL_WOOMAIL_URL .  $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
					</label>
				<?php endforeach; ?>
				</div>
				<input type="hidden" value="<?php echo esc_attr( $this->value() ); ?>" id="mailtpl-woomail-prebuilt-template" name="mailtpl-woomail-prebuilt-template">
				<?php wp_nonce_field( 'mailtpl-woomail-importing-template', 'mailtpl-woomail-import-template' ); ?>
			</div>
			<div class="mailtpl-woomail-loading"><?php _e( 'Loading and Saving...', 'mailtpl-woocommerce-email-composer' ); ?></div>
			<input type="button" class="button button-primary mailtpl-woomail-button" name="mailtpl-woomail-template-button" value="<?php esc_attr_e( 'Load Template', 'mailtpl-woocommerce-email-composer' ); ?>" />
			<?php
		}
	}
}