<?php

class Nhtsa_Decoder extends Vin_Decoder
{
    public static $settings_key = "nhtsa";
    private static $arr = [
        "NCSA Body Type", "NCSA Make", "NCSA Model", "Make", "Manufacturer Name", "Model", "Model Year", "Plant City", "Series", "Trim", "Vehicle Type",
        "Plant Country", "Plant Company Name", "Plant State", "Trim2", "Series2", "Note", "Base Price ($)", "Manufacturer Id", "Destination Market",
        "Body Class", "Doors", "Windows", "Wheel Base Type", "Track Width", "Gross Vehicle Weight Rating", "Bed Length (inches)", "Curb Weight (pounds)",
        "Wheel Base (inches)", "Wheel Base (inches) up to", "Gross Combination Weight Rating", "Gross Combination Weight Rating up to", "Gross Vehicle Weight Rating up to",
        "Bed Type", "Cab Type", "Trailer Type Connection", "Trailer Body Type", "Trailer Length (feet)", "Other Trailer Info", "Number of Wheels", "Wheel Size Front (inches)",
        "Wheel Size Rear (inches)", "Entertainment System", "Steering Location", "Number of Seats", "Number of Seat Rows", "Transmission Style", "Transmission Speeds",
        "Drive Type", "Axles", "Axle Configuration", "Brake System Type", "Brake System Description", "Battery Info", "Battery Type", "Number of Battery Cells per Module",
        "Battery Current (Amps)", "Battery Voltage (Volts)", "Battery Energy (KWh)", "EV Drive Unit", "Battery Current (Amps) up to", "Battery Voltage (Volts) up to",
        "Battery Energy (KWh) up to", "Number of Battery Modules per Pack", "Number of Battery Packs per Vehicle", "Charger Level", "Charger Power (KW)",
        "Engine Number of Cylinders", "Displacement (CC)", "Displacement (CI)", "Displacement (L)", "Engine Stroke Cycles", "Engine Model", "Engine Power (KW)",
        "Fuel Type - Primary", "Valve Train Design", "Engine Configuration", "Fuel Type - Secondary", "Fuel Delivery / Fuel Injection Type", "Engine Brake (hp)",
        "Cooling Type", "Engine Brake (hp) up to", "Electrification Level", "Other Engine Info", "Turbo", "Top Speed (MPH)", "Engine Manufacturer",
        "Pretensioner", "Seat Belts Type", "Other Restraint System Info", "Curtain Air Bag Locations", "Seat Cushion Air Bag Locations",
        "Front Air Bag Locations", "Knee Air Bag Locations", "Side Air Bag Locations", "Driver Assist", "Adaptive Cruise Control (ACC)",
        "Adaptive Headlights", "Anti-lock Braking System (ABS)", "Crash Imminent Braking (CIB)", "Blind Spot Detection (BSD)", "Electronic Stability Control (ESC)",
        "Traction Control", "Forward Collision Warning (FCW)", "Lane Departure Warning (LDW)", "Lane Keeping Support (LKS)", "Rear Visibility System (RVS)",
        "Parking Assist", "TPMS", "Active Safety System Note", "Dynamic Brake Support (DBS)", "Pedestrian Automatic Emergency Braking (PAEB)",
        "Auto-Reverse System for Windows and Sunroofs", "Automatic Pedestrian Alerting Sound (for Hybrid and EV only)",
        "Automatic Crash Notification (CAN) / Advanced Automatic Crash Notification (AACN)", "Event Data Recorder (EDR)",
        "Keyless Ignition", "Daytime Running Light (DRL)", "Lower Beam Headlamp Light Source",
        "Semiautomatic Headlamp Beam Switching", "Adaptive Driving Beam (ADB)", "SAE Automation Level",
        "SAE Automation Level up to", "Rear Cross Traffic Alert",
        "NCSA Note", "NCSA Mapping Exception", "NCSA Mapping Exception Approved On",
        "NCSA Mapping Exception Approved By"
    ];
    private $vin;
    private $shortcode;
    private  $icon_arr = [
        "NCSA Body Type"=>"stm-service-icon-body_type", "NCSA Make"=>"stm-service-icon-car-listing", "NCSA Model"=>"stm-service-icon-car-listing",
        "Make"=>"stm-service-icon-car-listing", "Manufacturer Name"=>"stm-service-icon-car-listing", "Model"=>"stm-service-icon-car-listing",
        "Model Year"=>"stm-icon-calendar", "Plant City"=>"stm-icon-ico_mag_map_pin", "Series"=> "stm-service-icon-body_type",
        "Trim"=> "stm-icon-buoy", "Vehicle Type"=> "stm-service-icon-body_type",
        "Plant Country"=>"stm-service-icon-staricon", "Plant Company Name"=>"stm-icon-ico_mag_map_pin", "Plant State"=>"stm-icon-ico_mag_map_pin",
        "Trim2"=> "stm-icon-buoy", "Series2"=> "stm-service-icon-body_type", "Note" =>'stm-icon-author', "Base Price ($)"=>"stm-icon-car_sale",
        "Manufacturer Id", "Destination Market", "Body Class" =>'stm-service-icon-body_type', "Doors", "Windows", "Wheel Base Type"=>'stm-icon-Tire_Wheel',
        "Track Width", "Gross Vehicle Weight Rating", "Bed Length (inches)", "Curb Weight (pounds)",
        "Wheel Base (inches)"=>'stm-icon-Tire_Wheel', "Wheel Base (inches) up to"=>"stm-icon-steering_wheel", "Gross Combination Weight Rating",
        "Gross Combination Weight Rating up to", "Gross Vehicle Weight Rating up to",
        "Bed Type", "Cab Type", "Trailer Type Connection", "Trailer Body Type"=>'stm-service-icon-body_type',
        "Trailer Length (feet)", "Other Trailer Info", "Number of Wheels", "Wheel Size Front (inches)",
        "Wheel Size Rear (inches)"=>'stm-icon-Tire_Wheel', "Entertainment System", "Steering Location"=>"stm-icon-steering_wheel",
        "Number of Seats", "Number of Seat Rows", "Transmission Style"=>"stm-icon-transmission_fill", "Transmission Speeds"=>"stm-icon-transmission_fill",
        "Drive Type", "Axles", "Axle Configuration", "Brake System Type" => "stm-icon-Tire_Wheel_Service2", "Brake System Description" => "stm-icon-Tire_Wheel_Service2",
        "Battery Info"=>"stm-icon-auto_electric", "Battery Type"=>"stm-icon-auto_electric", "Number of Battery Cells per Module"=>"stm-icon-auto_electric",
        "Battery Current (Amps)"=>"stm-icon-auto_electric", "Battery Voltage (Volts)"=>"stm-icon-auto_electric", "Battery Energy (KWh)"=>"stm-icon-auto_electric",
        "EV Drive Unit", "Battery Current (Amps) up to"=>"stm-icon-auto_electric", "Battery Voltage (Volts) up to"=>"stm-icon-auto_electric",
        "Battery Energy (KWh) up to"=>"stm-icon-auto_electric", "Number of Battery Modules per Pack"=>"stm-icon-auto_electric",
        "Number of Battery Packs per Vehicle"=>"stm-icon-auto_electric", "Charger Level", "Charger Power (KW)"=>"stm-icon-auto_electric",
        "Engine Number of Cylinders"=>"stm-icon-engine_fill", "Displacement (CC)"=>"stm-icon-engine_fill",
        "Displacement (CI)", "Displacement (L)", "Engine Stroke Cycles"=>"stm-icon-engine_fill", "Engine Model"=>"stm-icon-engine_fill", "Engine Power (KW)"=>"stm-icon-engine_fill",
        "Fuel Type - Primary"=>"stm-icon-fuel", "Valve Train Design", "Engine Configuration"=>"stm-icon-engine_fill",
        "Fuel Type - Secondary"=>"stm-icon-fuel",  "Fuel Delivery / Fuel Injection Type"=>"stm-icon-fuel",
        "Engine Brake (hp)"=>"stm-icon-engine_fill", "Cooling Type", "Engine Brake (hp) up to"=>"stm-icon-engine_fill",
        "Electrification Level", "Other Engine Info"=>"stm-icon-engine_fill", "Turbo"=>"stm-icon-engine_fill", "Top Speed (MPH)",
        "Engine Manufacturer"=>"stm-icon-engine_fill", "Pretensioner", "Seat Belts Type", "Other Restraint System Info",
        "Curtain Air Bag Locations", "Seat Cushion Air Bag Locations",
        "Front Air Bag Locations", "Knee Air Bag Locations", "Side Air Bag Locations",
        "Driver Assist", "Adaptive Cruise Control (ACC)", "Adaptive Headlights", "Anti-lock Braking System (ABS)" => "stm-icon-Tire_Wheel_Service2",
        "Crash Imminent Braking (CIB)" => "stm-icon-Tire_Wheel_Service2", "Blind Spot Detection (BSD)", "Electronic Stability Control (ESC)",
        "Traction Control", "Forward Collision Warning (FCW)", "Lane Departure Warning (LDW)",
        "Lane Keeping Support (LKS)", "Rear Visibility System (RVS)",
        "Parking Assist", "TPMS", "Active Safety System Note"=>'stm-icon-author', "Dynamic Brake Support (DBS)" => "stm-icon-Tire_Wheel_Service2",
        "Pedestrian Automatic Emergency Braking (PAEB)" => "stm-icon-Tire_Wheel_Service2",
        "Auto-Reverse System for Windows and Sunroofs", "Automatic Pedestrian Alerting Sound (for Hybrid and EV only)",
        "Automatic Crash Notification (CAN) / Advanced Automatic Crash Notification (AACN)", "Event Data Recorder (EDR)",
        "Keyless Ignition", "Daytime Running Light (DRL)", "Lower Beam Headlamp Light Source",
        "Semiautomatic Headlamp Beam Switching", "Adaptive Driving Beam (ADB)", "SAE Automation Level",
        "SAE Automation Level up to", "Rear Cross Traffic Alert",
        "NCSA Note"=>'stm-icon-author', "NCSA Mapping Exception", "NCSA Mapping Exception Approved On",
        "NCSA Mapping Exception Approved By"
    ];
    
    public static function init()
    {
        add_action('admin_menu', array(self::class, 'stm_callback_add_admin_page'));
        add_action('admin_init', array(self::class, 'custom_setting_callback'));
    }
    
    public static function provider_setting_title()
    {
        echo esc_html__('NHSTA', 'motors-vin-decoder');
    }
    
    public static function stm_callback_add_admin_page()
    {
        add_submenu_page(
            'options.php',
            'Nhtsa Check Settings',
            'Nhtsa Check Settings',
            'manage_options',
            'stm_vin_decoders_settings-'.self::$settings_key,
            array(self::class, 'setting_page_callback')
        );
    }
    
    public static function provider_setting_page_callback()
    {
        require_once(STM_MOTORS_VIN_DECODERS_PATH . '/templates/providers/stm_nhtsa_auto_complete_settings_page.php');
    }
    
    public static function custom_setting_callback()
    {
        register_setting('vin-decoder-settings_'.self::$settings_key, 'value');
        add_settings_section('vin-decoder-sidebar-options', __('Nhtsa Api options', 'motors-vin-decoder'), array(self::class, 'stm_check_callback_options'), 'stm_vin_decoders_settings_'.self::$settings_key);
        $terms = stm_listings_attributes_autoComplete_1();
        foreach (self::$arr as $item) {
            add_settings_field($item, $item, array(self::class, 'stm_audit_callback'), 'stm_vin_decoders_settings_'.self::$settings_key, 'vin-decoder-sidebar-options', $argc = array('stm_vin_decoder_' . $item, $terms));
        }
    }
    
    public function stm_vin_check_decoder_request()
    {
        $response = [];
        $responseArr = [];
        
        $response = $this->stm_vin_market_check_decoder_response();
       
        $response = json_decode($response['body']);
        
        if (isset($response->Results)) {
            
            foreach ($response->Results as $val) {
                if (!preg_match("/Error/i", $val->Variable)) {
                    $res[$val->Variable] = $val->Value;
                    if ($val->Value =='Not Applicable' || $val->Value == null)  unset($res[$val->Variable]);
                }
            }
          
            $res['icons'] = $note['icons'] = $this->icon_arr;
            $note['Note']= $res['Note'];
            unset($res['Note']);
            $responseArr['specifications'][0] = $res;
            $responseArr['Note'][0] = $note;
            if ($this->shortcode != 'yes') $responseArr = $this->stm_vin_decoder_request($res);
            wp_send_json($responseArr);
        }
    }
    
    public function stm_vin_market_check_decoder_response()
    {
        
        $args = array(
            'timeout' => 10,
            'headers' => [
                'host' => 'vpic.nhtsa.dot.gov'
            ],
            'httpversion' => '1.1',
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2'
        );
        $api_url = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/' . $this->vin . '?format=json';
       
        return $this->stm_vin_decoder_response($api_url, $args);
    }
    
    public function stm_listing_vin_decoder_request()
    {
        $responseArr = [];
        
        $response = $this->stm_vin_market_check_decoder_response();
        $response = json_decode($response['body']);
        
        if (isset($response->Results)) {
            
            foreach ($response->Results as $val) {
                
                $res[$val->Variable] = $val->Value;
            }
            $i = 0;
            foreach ($res as $key => $value) {
                $key = str_replace(' ', '_', $key);
                $get_option_key = get_option('stm_vin_decoder_' . $key);
                if (!empty($get_option_key)) {
                    $responseArr[$i]['original_name'] = $key;
                    $responseArr[$i]['original_slug'] = $get_option_key;
                    $responseArr[$i]['value'] = $value;
                    $i++;
                }
            }
            
            $temp = ['value' => $this->vin, 'original_name' => 'vin'];
            $responseArr[] = $temp;
            wp_send_json(['status' => true, 'message' => $responseArr]);
        }
        
        wp_send_json(['status' => false, 'message' => 'Request not found']);
    }
    
    public function request_set_vin($vin, $shortcode)
    {
        $this->vin = $vin;
        $this->shortcode = $shortcode;
    }
    
    public function set_api_val(){
        return self::$arr;
    }
    
    public function set_api_credentials (){
        return  null;
    }
    
}