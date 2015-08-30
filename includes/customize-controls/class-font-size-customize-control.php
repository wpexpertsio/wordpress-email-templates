<?php
class WP_Font_Size_Customize_Control extends WP_Customize_Control {
	public $type = 'mailtpl_font_size';
	/**
	 * Render the control's content.
	 */
	public function render_content() {
		$id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type;

		?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="font_value"><?php echo esc_attr( $this->value() ); ?></div>
				<input <?php $this->link(); ?> type="range" min="1" max="100" step="1" value="<?php echo esc_attr( $this->value() ); ?>" class="mailtpl_range" />
				<?php if ( ! empty( $this->description ) ) : ?>
					<p><span class="description customize-control-description"><?php echo $this->description; ?></span></p>
				<?php endif; ?>
			</label>
		</li><?php
	}
}