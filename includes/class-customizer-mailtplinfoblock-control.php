<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Kwdinfoblock_Control' ) ) {
	class WP_Customize_Kwdinfoblock_Control extends WP_Customize_Control {
		public $type = 'kwdinfoblock';

		public function render_content() {
			?>
			<label>
				<h3 class="customize-control-title test"><?php echo esc_html( $this->label ); ?></h3>
				<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}