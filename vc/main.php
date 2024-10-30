<?php
add_action('init', 'vc_motors_vin_decoders');

function vc_motors_vin_decoders()
{
    
    if (function_exists('vc_add_params')) {
        vc_map(array(
            'html_template' => STM_MOTORS_VIN_DECODERS_PATH . '/vc/templates/stm_auto_history_template.php',
            "name" => esc_html__('Stm Vin Button for Motors Listing Car details page', 'motors'),
            "base" => "stm_vin_history",
            "content_element" => true,
            'category' => __('STM Vin Decoder', 'motors'),
            "params" => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'motors'),
                    'param_name' => 'vin_history_title',
                ),
            )
        ));

        if ( wp_get_theme()->name != 'Motors' ) {
            vc_map(array(
                'html_template' => STM_MOTORS_VIN_DECODERS_PATH . '/vc/templates/stm_auto_specification_template.php',
                "name" => esc_html__('Stm Vin Decoder Input field', 'motors'),
                "base" => "stm_vin_specification",
                "content_element" => true,
                'category' => __('STM Vin Decoder', 'motors'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'vin_Specification_title',
                    ),
                )
            ));
        }

    }
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Stm_Vin_History_1 extends WPBakeryShortCode
    {
    }
}