<?php
class STM_Full_Report_WP_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'description'                 => 'Share buttons for checking vin report.',
			'customize_selective_refresh' => true,
		);

		parent::__construct( '', 'Stm VIN Button for Listing Car page', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$button_title      = __( 'VIEW VIN REPORT', 'motors-vin-decoder' );
		$vin_history_title = empty( $vin_history_title ) ? $button_title : $vin_history_title;
		$vin_number        = get_post_meta( get_the_ID(), 'vin_number', true );
		echo $args['before_widget'];

		if ( isset( $vin_number ) ) { ?>

			<div class="vin_report_section">

				<div class="single-car-mpg">
					<div class="mpg-unit">

						<div class="mpg-value"><?php echo __( 'VIN', 'motors-vin-decoder' ); ?></div>
						<div class="mpg-label"><?php echo printf( $vin_number ); ?></div>

					</div>
					<button class="report_button stm-button" data-vin="<?php echo esc_attr( $vin_number ); ?>">
						<?php echo __( $vin_history_title, 'motors-vin-decoder' ); ?>
					</button>
				</div>

			</div>

			<?php
			if ( ! has_action( 'wp_footer', 'stm_vin_add_modal' ) ) {
				add_action( 'wp_footer', 'stm_vin_add_modal' );
			}
		}
		
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance                      = $old_instance;
		$instance['vin_history_title'] = $new_instance['vin_history_title'];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'vin_history_title' => '' ) );
		$title    = $instance['vin_history_title'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vin_history_title' ) ); ?>">
				<?php esc_html_e( 'Button Title:', 'motors-vin-decoder' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vin_history_title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'vin_history_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}
}
