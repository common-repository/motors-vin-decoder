<?php
class STM_History_Widget extends WP_Widget
{
	function __construct()
	{
		$widget_ops = array(
			'description' => 'Share buttons for checking vin history.',
			'customize_selective_refresh' => true,
		);
		
		parent::__construct('', 'STM Vin History', $widget_ops);
	}

	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', empty($instance['vin_history_title']) ? 'CHECK CAR FULL REPORT' : $instance['vin_history_title'], $instance, $this->id_base);
		echo $before_widget;
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_history_widget_view.php';
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['vin_history_title'] = $new_instance['vin_history_title'];
		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'vin_history_title' => '') );
		$title = $instance['vin_history_title'];
		?>
        <p><label for="<?php echo esc_attr($this->get_field_id('vin_history_title')); ?>"><?php esc_html_e('Button Title:', 'motors-vin-decoder'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vin_history_title')); ?>" name="<?php echo esc_attr($this->get_field_name('vin_history_title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<?php
	}
}
