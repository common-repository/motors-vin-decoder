<?php

abstract class Vin_History_Decoder
{
	public abstract function request_set_vin($vin);

	public function stm_vin_decoder_response($api_url,$args)
	{
		$response = wp_remote_get( $api_url , $args );

		return $response;
	}

	public static function stm_check_callback_options()
	{
		echo '';
	}

  public static function setting_page_callback()
  {
    require_once(STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_settings_history_page.php');
  }
}
