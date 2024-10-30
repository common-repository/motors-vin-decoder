<div class="auto-complete-wrapper">
    <p id="stm_motor_vin_desc">
        <span><?php echo esc_html__('Enter your VIN to Import vehicle details', 'motors-vin-decoder') ?></span>
    </p>
    <p class="stm_admin_listing_auto_complete">
        <input type="text" class="stm_admin_listing_auto_complete" id="listing_entered_vin"
               placeholder="<?php echo esc_attr__('Enter VIN....', 'motors-vin-decoder') ?>">
        <button type="button" class="button button-primary butterbean-add-checkbox"
                id="listing_auto_complete"><?php echo esc_html__('Apply', 'motors-vin-decoder') ?></button>
    </p>
    <p id="error_message"><?php echo esc_html__('The VIN entered is invalid. Please check and try again.', 'motors-vin-decoder') ?></p>
    <p class="notice-fill-text">

        <?php echo esc_html__('To use this option, you need to configure', 'motors-vin-decoder') ?>

        <a href="admin.php?page=stm_vin_decoders_settings-nhtsa" class="notice-vin-fill" target="_blank">
            <?php echo esc_html__('Provider API Settings', 'motors-vin-decoder') ?>
        </a>
    </p>
</div>
<script>
    (function ($) {
        $(document).on('click', '#listing_auto_complete', function (e) {
            e.preventDefault();
            $('#postbox-container-2').addClass('active-opacity');
            let vin = $('#listing_entered_vin').val();
            if (vin) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        vin: vin,
                        action: 'stm_admin_listing_auto_complete_action',
                    },
                    success: function (data) {
                        $('#postbox-container-2').removeClass('active-opacity');
                        isSuccessTrue();
                        if (data.status) {
                            data.message.forEach(function (elem) {
                                if (elem.original_name === 'vin') {
                                    $('input[name=butterbean_stm_car_manager_setting_vin_number]').val(elem.value);
                                } else if (elem.original_name === 'city_miles') {
                                    $('input[name=butterbean_stm_car_manager_setting_city_mpg]').val(elem.value);
                                } else if (elem.original_name === 'highway_miles') {
                                    $('input[name=butterbean_stm_car_manager_setting_highway_mpg]').val(elem.value);
                                } else {
                                    stmSetValues(elem);
                                }
                            });
                        }
                    },
                    error: function () {
                        isErrorTrue();
                    }
                });
            } else {
                isErrorTrue();
            }

            function isErrorTrue() {
                $('#error').addClass('activeError');
                $('#postbox-container-2').removeClass('active-opacity');
                $('.stm_admin_listing_auto_complete').addClass('error_vin');
                $({to: 0}).animate({to: 1}, 2000, function () {
                    $('#error').removeClass('activeError');
                    $('.stm_admin_listing_auto_complete').removeClass('error_vin');
                });
            }

            function isSuccessTrue() {
                $('.stm_admin_listing_auto_complete').addClass('success');
                $({to: 0}).animate({to: 1}, 2000, function () {
                    $('.stm_admin_listing_auto_complete').removeClass('success');
                });
            }

            function stmSetValues(elem) {
                let slug = elem.original_slug, preSlugElement = '', originalSlugElement = '';
                console.log(slug);
                try {
                    originalSlugElement = $("#butterbean-control-" + slug);
                    preSlugElement = $('input[name=butterbean_stm_car_manager_setting_' + slug + ']');
                } catch (e) {
                    console.log(e.message);
                }

                if (preSlugElement.length > 0) {
                    $('input[name=butterbean_stm_car_manager_setting_' + slug + ']').val(elem.value);
                } else if (originalSlugElement.length > 0) {
                    let selector = '#butterbean-control-' + slug;
                    let selectLeft = $(selector + ' .ms-list')[0].querySelectorAll('li');
                    let selectRight = $(selector + ' .ms-list')[1].querySelectorAll('li');
                    selectLeft.forEach(function (value, index) {
                        if (value.innerText === elem.value) {
                            value.style.display = 'none';
                            selectRight[index].style = '';

                            value.classList.add('ms-selected');
                            selectRight[index].classList.add('ms-selected');
                        } else {
                            if (elem.value !== '') {
                                $.ajax({
                                    url: ajaxurl,
                                    dataType: 'json',
                                    context: this,
                                    data: 'term=' + elem.value + '&category='+ slug +'&action=stm_listings_add_category_in',
                                    complete: $.proxy(function (data) {
                                        data = data.responseJSON;
                                        $(selector).find('select').multiSelect('addOption', {
                                            value: data.slug,
                                            text: data.name
                                        });

                                        $(selector).find('select').multiSelect('select', [data.slug]);
                                    })
                                });
                            }
                        }
                    });
                }
            }
        });
    })(jQuery);
</script>
