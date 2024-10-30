<?php
add_filter('motors_wpcfto_header_end_config', function ($conf) {
	$config = array(

        'motors_vin_decoder_header_button_option' =>
            array(
                'label' => esc_html__( 'Show VIN Check button in header', 'motors-vin-decoder' ) ,
                'type' => 'checkbox',
                'description' => 'Show VIN Check button in header',
                'options' => stm_me_wpcfto_pages_list(),
                'dependency' => [
                    'key' => 'header_current_layout',
                    'value' => 'car_dealer||listing_four',
                    'section' => 'general_tab'
                ],
                'submenu' => esc_html__('VIN Check', 'motors-vin-decoder'),
            ),

        'motors_vin_decoder_check_page' =>
			array(
				'label' => esc_html__( 'VIN Check Page', 'motors-vin-decoder' ) ,
				'type' => 'select',
				'description' => 'Choose page for VIN Check button.',
				'options' => stm_me_wpcfto_pages_list(),
				'value' => '2080',
				'dependency' => [
					'key' => 'header_current_layout',
					'value' => 'car_dealer||listing_four',
					'section' => 'general_tab'
				],
				'submenu' => esc_html__('VIN Check', 'motors-vin-decoder'),
			),

		'motors_vin_decoder_modal_notice' =>
			array(
				'label' => esc_html__( 'Notice for VIN Modal windows', 'motors-vin-decoder' ) ,
				'type' => 'textarea',
				'description' => 'Notice for VIN decoder specification and history modal window.',
				'options' => stm_me_wpcfto_pages_list(),
				'value' => 'We are not responsible for errors and data accuracy. All requests are processed by Providers and may return errors such as: «Object», «Null»',
				'dependency' => [
					'key' => 'header_current_layout',
					'value' => 'car_dealer||car_dealer_two||listing||listing_two||listing_three||listing_four||equipment || motorcycle',
					'section' => 'general_tab'
				],
				'submenu' => esc_html__('VIN Check', 'motors-vin-decoder'),
			),

	);

	return array_merge($conf, $config);
}, 90, 1);