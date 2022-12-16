<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}
/**
 * This is a customized version of https://github.com/soderlind/class-customizer-toggle-control
 */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Toggleswitch_Control' ) ) {
	class WP_Customize_Toggleswitch_Control extends WP_Customize_Control {
		public $type = 'toggleswitch';

		/**
		 * Enqueue scripts/styles.
		 *
		 * @since 3.4.0
		 */
		public function enqueue() {
			wp_enqueue_script( 'customizer-toggle-switch-control-js', MAILTPL_WOOMAIL_URL . 'assets/js/customizer-toggle-switch-control.js', array( 'jquery' ), MAILTPL_VERSION, true );
			wp_enqueue_style( 'customizer-toggle-switch-control-css', MAILTPL_WOOMAIL_URL . 'assets/css/customizer-toggle-switch-control.css', array(), MAILTPL_VERSION );

			$css = '
				.disabled-control-title {
					color: #a0a5aa;
				}
				input[type=checkbox].tgl-light:checked + .tgl-btn {
					background: #0085ba;
				}
				input[type=checkbox].tgl-light + .tgl-btn {
				  background: #a0a5aa;
				}
				input[type=checkbox].tgl-light + .tgl-btn:after {
				  background: #f7f7f7;
				}

				input[type=checkbox].tgl-ios:checked + .tgl-btn {
				  background: #0085ba;
				}

				input[type=checkbox].tgl-flat:checked + .tgl-btn {
				  border: 4px solid #0085ba;
				}
				input[type=checkbox].tgl-flat:checked + .tgl-btn:after {
				  background: #0085ba;
				}

			';
			wp_add_inline_style( 'customizer-toggle-switch-control-css' , $css );
		}

		/**
		 * Render the control's content.
		 *
		 * @author wpexperts
		 * @version 1.2.0
		 */
		public function render_content() {
			?>
			<label>
				<div style="display:flex;flex-direction: row;justify-content: flex-start; align-items: center;">
					<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle; margin:20px 0;"><?php echo esc_html( $this->label ); ?></span>
					<input id="cb<?php echo $this->instance_number ?>" type="checkbox" class="tgl tgl-light" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
					<label for="cb<?php echo $this->instance_number ?>" class="tgl-btn"></label>
				</div>
				<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}