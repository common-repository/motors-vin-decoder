<?php

add_filter( 'stm_vin_decoder_header_btn', 'main_bar_vin_button_callback' );
add_filter( 'stm_vin_decoder_mobile_menu', 'mobile_menu_vin_button_callback' );

function main_bar_vin_button_callback() {
	if ( defined( 'STM_MOTORS_EXTENDS_PATH' ) ) {
		if ( stm_me_get_wpcfto_mod( 'motors_vin_decoder_header_button_option' ) ) {
			$vin_page = stm_me_get_wpcfto_mod( 'motors_vin_decoder_check_page' );
			return StmVinDecoderTemplate::load_template( 'motors_vin_check_header_button', array( 'vin_page' => $vin_page ) );
		}
	}
}

function mobile_menu_vin_button_callback() {
	if ( defined( 'STM_MOTORS_EXTENDS_PATH' ) ) {
		$vin_page = stm_me_get_wpcfto_mod( 'motors_vin_decoder_check_page' );
		return StmVinDecoderTemplate::load_template( 'motors_vin_check_mobile_menu', array( 'vin_page' => $vin_page ) );
	}
}

function stm_listings_attributes_autoComplete_1( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'where'  => array(),
			'key_by' => '',
		)
	);

	$result = array();
	$data   = array_filter( (array) get_option( 'stm_vehicle_listing_options' ) );

	foreach ( $data as $key => $_data ) {
		$passed = true;
		foreach ( $args['where'] as $_field => $_val ) {
			if ( array_key_exists( $_field, $_data ) && $_data[ $_field ] != $_val ) {
				$passed = false;
				break;
			}
		}

		if ( $passed ) {
			if ( $args['key_by'] ) {
				$result[ $_data[ $args['key_by'] ] ] = $_data;
			} else {
				$result[] = $_data;
			}
		}
	}

	$temp = array(
		array(
			'single_name' => 'Made in',
			'slug'        => 'made_in',
		),

		array(
			'single_name' => 'City Miles',
			'slug'        => 'city_miles',
		),
	);

	$result = array_merge( $result, $temp );

	return apply_filters( 'stm_listings_attributes', $result, $args );
}

function stm_vin_add_modal() {
	echo StmVinDecoderTemplate::load_template( 'motors_vin_modal_template' );
}

function stm_show_vin_history_btn_1() {
	$title = 'CHECK CAR FULL REPORT';
	echo '<div style="margin-bottom: 10px;">';
	require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_history_widget_view.php';
	echo '</div>';
}

add_action( 'stm_single_show_vin_history_btn', 'stm_show_vin_history_btn_1' );

function Motors_Vin_Decoder_Init() {
	new Motors_Vin_Decoder();
	do_action( 'add_option_stm_vin_settings' );
}
