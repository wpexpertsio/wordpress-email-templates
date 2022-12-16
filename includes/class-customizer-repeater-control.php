<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}
/**
 * This is a customized version of https://github.com/cristian-ungureanu/customizer-repeater
 */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Repeater_Control' ) ) {
	class WP_Customize_Repeater_Control extends WP_Customize_Control {

		public $id;
		private $boxtitle = array();
		private $add_field_label = array();
		private $customizer_icon_container = '';
		private $allowed_html = array();
		public $customizer_repeater_image_control = false;
		public $customizer_repeater_icon_control = false;
		public $customizer_repeater_icon_color = false;
		public $customizer_repeater_title_control = false;
		public $customizer_repeater_link_control = false;



		/*Class constructor*/
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
			/*Get options from customizer.php*/
			$this->add_field_label = esc_html__( 'Add new field', 'mailtpl-woocommerce-email-composer' );
			if ( ! empty( $args['add_field_label'] ) ) {
				$this->add_field_label = $args['add_field_label'];
			}

			$this->boxtitle = esc_html__( 'Customizer Repeater', 'mailtpl-woocommerce-email-composer' );
			if ( ! empty ( $args['item_name'] ) ) {
				$this->boxtitle = $args['item_name'];
			} elseif ( ! empty( $this->label ) ) {
				$this->boxtitle = $this->label;
			}

			if ( ! empty( $args['customizer_repeater_image_control'] ) ) {
				$this->customizer_repeater_image_control = $args['customizer_repeater_image_control'];
			}

			if ( ! empty( $args['customizer_repeater_icon_control'] ) ) {
				$this->customizer_repeater_icon_control = $args['customizer_repeater_icon_control'];
			}
			if ( ! empty( $args['customizer_repeater_icon_color'] ) ) {
				$this->customizer_repeater_icon_color = $args['customizer_repeater_icon_color'];
			}

			if ( ! empty( $args['customizer_repeater_title_control'] ) ) {
				$this->customizer_repeater_title_control = $args['customizer_repeater_title_control'];
			}

			if ( ! empty( $args['customizer_repeater_link_control'] ) ) {
				$this->customizer_repeater_link_control = $args['customizer_repeater_link_control'];
			}

			if ( ! empty( $id ) ) {
				$this->id = $id;
			}


			$allowed_array1 = wp_kses_allowed_html( 'post' );
			$allowed_array2 = array(
				'input' => array(
					'type'        => array(),
					'class'       => array(),
					'placeholder' => array()
				)
			);

			$this->allowed_html = array_merge( $allowed_array1, $allowed_array2 );
		}

		/*Enqueue resources for the control*/
		public function enqueue() {

			wp_enqueue_style( 'customizer-icon-select', MAILTPL_WOOMAIL_URL . 'assets/css/customizer-icon-select.css', array(), MAILTPL_VERSION );

			wp_enqueue_style( 'customizer-repeater-control', MAILTPL_WOOMAIL_URL . 'assets/css/customizer-repeater-control.css', array(), MAILTPL_VERSION );

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script( 'customizer-repeater-control',  MAILTPL_WOOMAIL_URL . 'assets/js/customizer-repeater-control.js', array('jquery', 'jquery-ui-draggable', 'wp-color-picker' ), MAILTPL_VERSION, true  );

		}
		public function customizer_repeater_sanitize( $input ) {
			$input_decoded = json_decode($input,true);

			if(!empty($input_decoded)) {
				foreach ($input_decoded as $boxk => $box ){
					foreach ($box as $key => $value){

							$input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );

					}
				}
				return json_encode($input_decoded);
			}
			return $input;
		}


		public function render_content() {

			/*Get default options*/
			$this_default = json_decode( $this->setting->default );

			/*Get values (json format)*/
			$values = $this->value();

			/*Decode values*/
			$json = json_decode( $values );

			if ( ! is_array( $json ) ) {
				$json = array( $values );
			} ?>

	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <div class="customizer-repeater-general-control-repeater customizer-repeater-general-control-droppable">
				<?php
				if ( ( count( $json ) == 1 && '' === $json[0] ) || empty( $json ) ) {
					if ( ! empty( $this_default ) ) {
						$this->iterate_array( $this_default ); ?>
	                    <input type="hidden"
	                           id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
	                           class="customizer-repeater-colector"
	                           value="<?php echo esc_textarea( json_encode( $this_default ) ); ?>"/>
						<?php
					} else {
						$this->iterate_array(); ?>
	                    <input type="hidden"
	                           id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
	                           class="customizer-repeater-colector"/>
						<?php
					}
				} else {
					$this->iterate_array( $json ); ?>
	                <input type="hidden" id="customizer-repeater-<?php echo esc_attr( $this->id ); ?>-colector" <?php esc_attr( $this->link() ); ?>
	                       class="customizer-repeater-colector" value="<?php echo esc_textarea( $this->value() ); ?>"/>
					<?php
				} ?>
	        </div>
	        <button type="button" class="button add_field customizer-repeater-new-field">
				<?php echo esc_html( $this->add_field_label ); ?>
	        </button>
			<?php
		}

		private function iterate_array( $array = array() ) {
			/*Counter that helps checking if the box is first and should have the delete button disabled*/
			$it = 0;
			if ( ! empty( $array ) ) {
				foreach( $array as $icon ) { ?>
	                <div class="customizer-repeater-general-control-repeater-container customizer-repeater-draggable">
	                    <div class="customizer-repeater-customize-control-title-box">
							<?php echo esc_html( $this->boxtitle ) ?>
	                    </div>
	                    <div class="customizer-repeater-box-content-hidden">
							<?php
							$id = $image_url = $icon_value = $title = $subtitle = $choice = $icon_color = $link2 = $link = $shortcode = $repeater = $color = $color2 = '';
							if( ! empty( $icon->id ) ) {
								$id = $icon->id;
							}
							if ( ! empty( $icon->choice ) ) {
								$choice = $icon->choice;
							}
							if ( ! empty( $icon->image_url ) ) {
								$image_url = $icon->image_url;
							}
							if ( ! empty($icon->icon_value ) ) {
								$icon_value = $icon->icon_value;
							}
							if ( ! empty( $icon->icon_color ) ) {
								$icon_color = $icon->icon_color;
							}
							if ( ! empty($icon->title ) ) {
								$title = $icon->title;
							}
							if ( ! empty( $icon->link ) ){
								$link = $icon->link;
							}

							if($this->customizer_repeater_image_control == true && $this->customizer_repeater_icon_control == true) {
								$this->icon_type_choice( $choice );
							}
							if($this->customizer_repeater_image_control == true){
								$this->image_control( $image_url, $choice );
							}
							if ( $this->customizer_repeater_icon_control == true ){
								$this->icon_picker_control( $icon_value, $choice );
							}
							if ( $this->customizer_repeater_icon_color == true ){
								$this->icon_color_choice( $icon_color, $choice );
							}
							if($this->customizer_repeater_title_control==true){
								$this->input_control(array(
									'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Title','mailtpl-woocommerce-email-composer' ), $this->id, 'customizer_repeater_title_control' ),
									'class' => 'customizer-repeater-title-control',
									'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_title_control' ),
								), $title);
							}
							if($this->customizer_repeater_link_control){
								$this->input_control(array(
									'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Link','mailtpl-woocommerce-email-composer' ), $this->id, 'customizer_repeater_link_control' ),
									'class' => 'customizer-repeater-link-control',
									'sanitize_callback' => 'esc_url_raw',
									'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_link_control' ),
								), $link);
							}
							?>

	                        <input type="hidden" class="social-repeater-box-id" value="<?php if ( ! empty( $id ) ) {
								echo esc_attr( $id );
							} ?>">
	                        <button type="button" class="social-repeater-general-control-remove-field" <?php if ( $it == 0 ) {
								echo 'style="display:none;"';
							} ?>>
								<?php esc_html_e( 'Delete field', 'mailtpl-woocommerce-email-composer' ); ?>
	                        </button>

	                    </div>
	                </div>

					<?php
					$it++;
				}
			} else { ?>
	            <div class="customizer-repeater-general-control-repeater-container">
	                <div class="customizer-repeater-customize-control-title-box">
						<?php echo esc_html( $this->boxtitle ) ?>
	                </div>
	                <div class="customizer-repeater-box-content-hidden">
						<?php
						if ( $this->customizer_repeater_image_control == true && $this->customizer_repeater_icon_control == true ) {
							$this->icon_type_choice();
						}
						if ( $this->customizer_repeater_image_control == true ) {
							$this->image_control();
						}
						if ( $this->customizer_repeater_icon_control == true ) {
							$this->icon_picker_control();
						}
						if ( $this->customizer_repeater_icon_color == true ) {
							$this->icon_color_choice();
						}
						
						if ( $this->customizer_repeater_title_control == true ) {
							$this->input_control( array(
								'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Title','mailtpl-woocommerce-email-composer' ), $this->id, 'customizer_repeater_title_control' ),
								'class' => 'customizer-repeater-title-control',
								'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_title_control' ),
							) );
						}
						
						if ( $this->customizer_repeater_link_control == true ) {
							$this->input_control( array(
								'label' => apply_filters('repeater_input_labels_filter', esc_html__( 'Link','mailtpl-woocommerce-email-composer' ), $this->id, 'customizer_repeater_link_control' ),
								'class' => 'customizer-repeater-link-control',
								'type'  => apply_filters('customizer_repeater_input_types_filter', '', $this->id, 'customizer_repeater_link_control' ),
							) );
						}
						?>
	                    <input type="hidden" class="social-repeater-box-id">
	                    <button type="button" class="social-repeater-general-control-remove-field button" style="display:none;">
							<?php esc_html_e( 'Delete field', 'mailtpl-woocommerce-email-composer' ); ?>
	                    </button>
	                </div>
	            </div>
				<?php
			}
		}

		private function input_control( $options, $value='' ){ ?>

			<?php
			if( !empty($options['type']) ){
				switch ($options['type']) {
					case 'textarea':?>
	                    <span class="customize-control-title"><?php echo esc_html( $options['label'] ); ?></span>
	                    <textarea class="<?php echo esc_attr( $options['class'] ); ?>" placeholder="<?php echo esc_attr( $options['label'] ); ?>"><?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?></textarea>
						<?php
						break;
					case 'color':
						$style_to_add = '';
						if( $options['choice'] !== 'customizer_repeater_icon' ){
							$style_to_add = 'display:none';
						}?>
	                    <span class="customize-control-title" <?php if( !empty( $style_to_add ) ) { echo 'style="'.esc_attr( $style_to_add ).'"';} ?>><?php echo esc_html( $options['label'] ); ?></span>
	                    <div class="<?php echo esc_attr($options['class']); ?>" <?php if( !empty( $style_to_add ) ) { echo 'style="'.esc_attr( $style_to_add ).'"';} ?>>
	                        <input type="text" value="<?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?>" class="<?php echo esc_attr($options['class']); ?>" />
	                    </div>
						<?php
						break;
				}
			} else { ?>
	            <span class="customize-control-title"><?php echo esc_html( $options['label'] ); ?></span>
	            <input type="text" value="<?php echo ( !empty($options['sanitize_callback']) ?  call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr($value) ); ?>" class="<?php echo esc_attr($options['class']); ?>" placeholder="<?php echo esc_attr( $options['label'] ); ?>"/>
				<?php
			}
		}

		private function icon_picker_control($value = '', $show = ''){
			?>
	        <div class="social-repeater-general-control-icon" <?php if( $show === 'customizer_repeater_image' || $show === 'customizer_repeater_none' ) { echo 'style="display:none;"'; } ?>>
	            <span class="customize-control-title">
	                <?php esc_html_e('Choose a Bundled Icon','mailtpl-woocommerce-email-composer'); ?>
	            </span>
	            <div class="icon-input-group">
	            	<select class="mailtpl-icon-select">
	            		<?php
	            		$icons = $this->icon_list();
	            		foreach( $icons as $icon ){
	            			if( $value == $icon ) {
	            				echo '<option selected value="'.$icon.'">'.$icon.'</option>';
	            			} else {
								echo '<option value="'.$icon.'">'.$icon.'</option>';
							}
						} ?>
	            	</select>
	            </div>
	        </div>
			<?php
		}

		private function image_control($value = '', $show = ''){ ?>
	        <div class="customizer-repeater-image-control" <?php if( $show === 'customizer_repeater_icon' || $show === 'customizer_repeater_none' || empty( $show ) ) { echo 'style="display:none;"'; } ?>>
	            <span class="customize-control-title">
	                <?php esc_html_e('Custom Upload Icon','mailtpl-woocommerce-email-composer')?>
	            </span>
	            <input type="text" class="widefat custom-media-url" value="<?php echo esc_attr( $value ); ?>">
	            <input type="button" class="button button-secondary customizer-repeater-custom-media-button" value="<?php esc_attr_e( 'Upload Image','mailtpl-woocommerce-email-composer' ); ?>" />
	        </div>
			<?php
		}

		private function icon_type_choice($value='customizer_repeater_icon'){ ?>
	        <span class="customize-control-title">
	            <?php esc_html_e('Social Image Source','mailtpl-woocommerce-email-composer');?>
	        </span>
	        <select class="customizer-repeater-image-choice">
	            <option value="customizer_repeater_icon" <?php selected($value,'customizer_repeater_icon');?>><?php esc_html_e('Bundled Icon','mailtpl-woocommerce-email-composer'); ?></option>
	            <option value="customizer_repeater_image" <?php selected($value,'customizer_repeater_image');?>><?php esc_html_e('Custom Upload Icon','mailtpl-woocommerce-email-composer'); ?></option>
	            <option value="customizer_repeater_none" <?php selected($value,'customizer_repeater_none');?>><?php esc_html_e('None','mailtpl-woocommerce-email-composer'); ?></option>
	        </select>
			<?php
		}
		private function icon_color_choice($value='black', $show = '' ){ ?>
			<div class="customizer-repeater-icon-color-control" <?php if( $show === 'customizer_repeater_image' || $show === 'customizer_repeater_none' ) { echo 'style="display:none;"'; } ?>>
				<span class="customize-control-title">
					<?php esc_html_e('Bundled Icon Color','mailtpl-woocommerce-email-composer');?>
				</span>
				<select class="customizer-repeater-icon-color">
					<option value="black" <?php selected($value,'black');?>><?php esc_html_e('Black','mailtpl-woocommerce-email-composer'); ?></option>
					<option value="white" <?php selected($value,'white');?>><?php esc_html_e('White','mailtpl-woocommerce-email-composer'); ?></option>
					<option value="gray" <?php selected($value,'gray');?>><?php esc_html_e('Gray','mailtpl-woocommerce-email-composer'); ?></option>
				</select>
	    	</div>
			<?php
		}

		private function icon_list(){ 
			return array(
				'mailtpl-woomail-twitter',
				'mailtpl-woomail-facebook',
				'mailtpl-woomail-linkedin',
				'mailtpl-woomail-link',
				'mailtpl-woomail-google-plus',
				'mailtpl-woomail-rss',
				'mailtpl-woomail-youtube',
				'mailtpl-woomail-instagram',
				'mailtpl-woomail-tumblr',
				'mailtpl-woomail-dribbble',
				'mailtpl-woomail-vimeo',
				'mailtpl-woomail-digg',
				'mailtpl-woomail-stumbleupon',
				'mailtpl-woomail-vk',
				'mailtpl-woomail-pinterest',
				'mailtpl-woomail-whatsapp',
			);
		}
	}
}
