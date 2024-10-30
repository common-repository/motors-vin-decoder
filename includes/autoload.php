<?php
if ( ! defined( 'ABSPATH' ) ) exit;



if ( did_action( 'elementor/loaded' ) ) {
    require( STM_MOTORS_VIN_DECODERS_PATH . '/elementor/motors-vin-decoder.php' );
}

require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/Vin_Decoder.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/Motors_Vin_Decoder.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/STM_History_Widget.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/STM_Full_Report_WP_Widget.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/STM_Specification_Widget.php';

require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/Vin_History_Decoder.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/STM_Vin_Decoder_Shortcodes.php';

require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/providers/Nhtsa_Check_Decoder.php' ;
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/classes/StmVinDecoderTemplate.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/vin-decoder-conf.php';

require_once STM_MOTORS_VIN_DECODERS_PATH . '/vc/main.php';
require_once STM_MOTORS_VIN_DECODERS_PATH  . '/includes/functions.php';

/* Init */
Nhtsa_Decoder::init();

