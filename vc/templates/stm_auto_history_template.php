<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$vin_number = get_post_meta( get_the_ID(), 'vin_number', true );

if ( empty( $vin_history_title ) ) {
	$vin_history_title = __( 'VIEW VIN REPORT', 'motors-vin-decoder' );
}

if ( ! empty( $vin_number ) ) { ?>

	<div class="vin_report_section">

		<div class="single-car-mpg">
			<div class="mpg-unit">

				<div class="mpg-value"><?php echo esc_html__( 'VIN', 'motors-vin-decoder' ); ?></div>
				<div class="mpg-label"><?php echo esc_html( $vin_number ); ?></div>

			</div>
			<button class="report_button stm-button heading-font" data-vin="<?php echo esc_attr( $vin_number ); ?>">
				<?php echo esc_html( $vin_history_title ); ?>
			</button>
		</div>

	</div>

	<?php
	if ( ! has_action( 'wp_footer', 'stm_vin_add_modal' ) ) {
		add_action( 'wp_footer', 'stm_vin_add_modal' );
	}
}
