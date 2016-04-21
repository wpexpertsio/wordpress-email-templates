<?php
class WP_Font_Size_Customize_Control extends WP_Customize_Control {
	public $type = 'mailtpl_font_size';
	/**
	 * Render the control's content.
	 */
	public function render_content() {
		$range_min = '1';
		$range_max = '100';
		if( $this->id == 'mailtpl_body_size' ) {
			$range_min = '320';
			$range_max = '1280';
		}
		?>	<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="font_value"><?php echo esc_attr( $this->value() ); ?></div>
				<input <?php $this->link(); ?> type="range" min="<?php echo $range_min;?>" max="<?php echo $range_max;?>" step="1" value="<?php echo esc_attr( $this->value() ); ?>" class="mailtpl_range" />
				<?php if ( ! empty( $this->description ) ) : ?>
					<p><span class="description customize-control-description"><?php echo $this->description; ?></span></p>
				<?php endif; ?>
			</label>
		<?php
	}
}