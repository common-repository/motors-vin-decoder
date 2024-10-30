<?php
$className = get_called_class();
$settings_key = $className::$settings_key;
require_once  'stm-admin-header.php';
?>

<form method="post" action="options.php" novalidate="novalidate" novalidate="novalidate" id="vin-decoder-form">
    <?php settings_errors(); ?>

    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
          <a href="#vin-specification" class="nav-tab tabA nav-tab-active"><?php $className::provider_setting_title(); ?>
            <?php echo esc_html__('Vin-Decoder Specification Options', 'motors-vin-decoder') ?></a>
          <a href="<?php echo admin_url( 'admin.php?page=stm_vin_decoders_settings' ); ?>" class="nav-tab tabA link" data="link">
          <?php echo esc_html__('Back', 'motors-vin-decoder') ?></a>
     </nav>
    <div class="tab-content">
        <div id="vin-specification" class="tab-pane active ">
            <div class="header-options">
                <h1><?php $className::provider_setting_title(); ?> <?php echo esc_html__('Vin-Decoder Specification Options', 'motors-vin-decoder') ?></h1>
            </div>
            <div class="stm_display_helper stm_display">
                <h2><?php echo esc_html__('API method', 'motors-vin-decoder') ?></h2>
                <div id="wrap">
                    <div class="innerWrap">
                            <div class="inputGroup">
                                <input id="radio_<?php echo esc_attr($settings_key); ?>" name="stm_vin_method_name" type="radio"
                                       value="<?php echo esc_attr($settings_key); ?>" <?php if (get_option('stm_vin_method_name') ==  $settings_key ) echo 'checked'; ?>>
                                <label for="radio_<?php echo esc_attr($settings_key); ?>"
                                       data-id="<?php echo esc_attr($settings_key); ?>"><?php $className::provider_setting_title(); ?> <?php echo esc_html__('Make Default', 'motors-vin-decoder') ?></label>
                            </div>

                    </div>
                </div>
                <h2><?php echo esc_html__('API key', 'motors-vin-decoder') ?></h2>
                <?php $className::provider_setting_page_callback(); ?>
            </div>
        </div>
         <input type="hidden" name="__vin_decoder_settings" value="1">
        <?php echo submit_button() ?>
    </div>
</form>
<script>
    (function ($) {

        $('.active2 select').attr('disabled', 'true');

        $('label[for=radio1], label[for=radio2]').click(function () {

            $('.stm-vin-options-table select').removeAttr('disabled');
            let data_id = $(this).data('id');
            let needle = document.querySelector('.active2');

            if (needle) needle.classList.remove('active2');
            document.querySelectorAll('.stm-vin-options-table')[data_id].classList.toggle('active2');

            $('.active2 select').attr('disabled', 'true');
        });

        let tabs = document.querySelectorAll('.tabA');

        for (let i = 0; i < tabs.length; i++) {
            tabs[i].addEventListener('click', switchTab);
        }

        function switchTab(e) {

            let clickTab = e.currentTarget;
            let anchor = e.target;
            let activePanId = anchor.getAttribute('href');
            let link = anchor.getAttribute('data');

            if (link == 'link'){
               return;
            }

            e.preventDefault();

            document.querySelector('.nav-tab-active').classList.remove('nav-tab-active');
            document.querySelector('.tab-pane.active').classList.remove('active');



            clickTab.classList.add('nav-tab-active');
            document.querySelector(activePanId).classList.add('active');
        }

    })(jQuery)
</script>
