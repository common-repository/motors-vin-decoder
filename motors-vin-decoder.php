<?php
/**
 * Plugin Name:       Motors Vin Decoder
 * Plugin URI:        https://stylemixthemes.com
 * Description:       Motors VIN Decoder is free plugin to decode your vehicle VIN and check VIN history (mileage/odometer, service records, road accidents and other issues). The data provided by third party providers and government authorities.
 * Version:           1.1
 * Author:            StylemixThemes
 * Author URI:        https://stylemixthemes.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       motors-vin-decoder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( false === get_option( 'stm_vin_method_name' ) && false === update_option( 'stm_vin_method_name', false ) ) {
	add_option( 'stm_vin_method_name', 'nhtsa' );
}

define( 'STM_MOTORS_VIN_DECODERS', '1.1' );
define( 'STM_MOTORS_VIN_DECODERS_FILE', __FILE__ );
define( 'STM_MOTORS_VIN_DECODERS_PATH', dirname( STM_MOTORS_VIN_DECODERS_FILE ) );
define( 'STM_MOTORS_VIN_DECODERS_URL', plugin_dir_url( STM_MOTORS_VIN_DECODERS_FILE ) );

if ( ! is_textdomain_loaded( 'motors-vin-decoder' ) ) {
	load_plugin_textdomain(
		'motors-vin-decoder',
		false,
		'motors-vin-decoder/languages'
	);
}

require_once STM_MOTORS_VIN_DECODERS_PATH . '/includes/autoload.php';

add_action( 'init', 'Motors_Vin_Decoder_Init', 0 );

do_action( 'add_option_stm_vin_settings' );

if ( is_admin() ) {
	require_once STM_MOTORS_VIN_DECODERS_PATH . '/includes/item-announcements.php';
}
