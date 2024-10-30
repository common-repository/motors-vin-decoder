<div class="stm-vin-options-table  nhtsa">
  <p class="stm_vin_desc">
      Free version of the plugin uses NHTSA service to decode VIN numbers and provide this information to a user.
      The service is free, and no extra setup needed.
               <a href="https://www.nhtsa.gov/">NHTSA</a> - National Highway Traffic Safety Administration of US Department of Transportation provides FREE API Service for Car Specifications.
                you can get more information about API <a href="https://vpic.nhtsa.dot.gov/api/Home">Here </a>.
      *NHTSA does not provide VIN History Data
     
   </p>
   
            <?php $my_theme = wp_get_theme();
               settings_fields('vin-decoder-settings_nhtsa');
               if ($my_theme->get( 'Name' ) == 'Motors' || defined('STM_LISTINGS') ){
                     do_settings_sections('stm_vin_decoders_settings_nhtsa');
               }
            ?>
</div>


