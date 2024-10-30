<?php

class STM_Vin_Decoder_Shortcodes
{
    
    public $shortcode_use;
    
    function __construct()
    {
        add_shortcode('stm_motors_vin_decoders', array($this, 'stm_motors_vindecoder'));
    }
    
    public function stm_motors_vindecoder($atts)
    {
        
        return $this->form($atts);
    }
    
    public function form($atts)
    {
        include_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_history_shortcode_view.php';
        return $output;
    }
}
