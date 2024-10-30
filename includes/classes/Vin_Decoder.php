<?php

abstract class Vin_Decoder {

	abstract public function request_set_vin( $vin, $shortcode);

	public function stm_vin_decoder_request( $response ) {
		$responseArr = array();
		if ( $response ) {
			$i = 0;
			foreach ( $response as $key => $value ) {
				$key            = str_replace( ' ', '_', $key );
				$get_option_key = get_option( 'stm_vin_decoder_' . $key );
				if ( ! empty( $get_option_key ) ) {
					$responseArr[ $i ]['original_name'] = $key;
					$responseArr[ $i ]['original_slug'] = $get_option_key;
					$get_option_key                     = str_replace( '-', '_pre_', $get_option_key );
					$responseArr[ $i ]['pre_slug']      = $get_option_key;
					$responseArr[ $i ]['value']         = $value;
					$i++;
				}
			}
		}

		return $responseArr;
	}

	public function stm_vin_decoder_response( $api_url, $args ) {
		$response = wp_remote_get( $api_url, $args );

		return $response;
	}

	public static function stm_audit_callback( $args ) {
		$args[0] = self::str_replace( $args[0] );

		if ( ! empty( $args[1] ) && ! empty( $args[0] ) ) {

			$options = '<option value="">' . esc_html__( 'Keep empty', 'motors-vin-decoder' ) . '</option>';

			foreach ( $args[1] as $value ) {
				$options .= '<option value="' . esc_attr( $value['slug'] ) . '"';

				if ( get_option( $args[0] ) == $value['slug'] ) {
					$options .= 'selected';
				}

				$options .= '>' . esc_html( $value['single_name'] ) . '</option>';
			}

			$html = '<select name="' . esc_attr( $args[0] ) . '">' . $options . '</select>';

			echo $html;
		}
	}

	public static function str_replace( $params ) {
		if ( is_string( $params ) ) {
			return str_replace( ' ', '_', $params );
		}
	}

	public static function setting_page_callback() {
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_settings_page.php';
	}

	public static function stm_check_callback_options() {
		echo '';
	}
}
