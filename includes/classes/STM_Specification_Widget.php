<?php
class STM_Specification_Widget extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'description' => 'Input field for checking Vin for getting Car specification .',
			'customize_selective_refresh' => true,
		);
		parent::__construct('', 'STM Vin Specification', $widget_ops);
	}

	function widget($args, $instance)
	{
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['vin_specification_title'] ) ? 'CHECK CAR FULL REPORT' : $instance['vin_specification_title'], $instance, $this->id_base );
		echo $before_widget;
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_specification_widget_view.php';
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['vin_specification_title'] = $new_instance['vin_specification_title'];
		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'vin_specification_title' => '') );
		$title = $instance['vin_specification_title'];
		?>
        <p><label for="<?php echo esc_attr($this->get_field_id('vin_specification_title')); ?>"><?php esc_html_e('Button Title:', 'motors-vin-decoder-lite'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vin_specification_title')); ?>" name="<?php echo esc_attr($this->get_field_name('vin_specification_title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<?php
	}
}
