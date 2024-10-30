<?php

require_once('stm-admin-header.php');

?>
<form method="post" action="options.php" novalidate="novalidate" novalidate="novalidate" id="vin-decoder-form">
    <?php settings_errors(); ?>

    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a href="#vin-specification"
           class="nav-tab tabA nav-tab-active"><?php echo esc_html__('Vin-Decoder Specification Providers', 'motors-vin-decoder') ?></a>
        <a href="#vin-history"
           class="nav-tab tabA"><?php echo esc_html__('Vin-Decoder History Providers', 'motors-vin-decoder') ?></a>
        <a href="#installation" class="nav-tab tabA"><?php echo esc_html__('Installation', 'motors-vin-decoder') ?></a>
    </nav>

    <div class="tab-content">
        <div id="vin-specification" class="tab-pane active">

            <div class="stm-dashboard-providers-container">
                <div class="stm-dashboard-providers ui-sortable">
                    <div class="stm-dashboard-provider nhtsa" data-provider="nhtsa" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color:#0183c1">


                            <img src="<?php echo esc_url(plugins_url('assets/img/logo-NHTSA-white.svg', dirname(__FILE__))) ?>"
                                 height="60" alt="">
                            <h2><?php echo esc_html__('National Highway Traffic Safety Administration', 'motors-vin-decoder') ?></h2>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state <?php if (get_option('stm_vin_method_name') == 'nhtsa') echo 'active'; ?>">
                                <?php if (get_option('stm_vin_method_name') == 'nhtsa') echo 'Default'; ?>
                            </div>
                            <a href="<?php echo admin_url( 'admin.php?page=stm_vin_decoders_settings-nhtsa' ); ?>" class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>  </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>

                    <div class="stm-dashboard-provider" data-provider="master-check" data-state="not-configured">
                        <div class="stm-dashboard-provider-top"
                             style=" background-color: white; border: 1px solid #dbdbdb">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/logo-footer.png', dirname(__FILE__))) ?>"
                                     height="60" alt="market-check">
                                <h2><?php echo esc_html__('Market-check', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>                          </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>

                    <div class="stm-dashboard-provider" data-provider="google" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color: lightgreen;">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>

                                <img src="<?php echo esc_url(plugins_url('assets/img/vinaudit-usa-v3.3_85.png', dirname(__FILE__))) ?>"
                                     height="60" alt="">
                                <h2><?php echo esc_html__('Vin Audit', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>                          </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>

                    <div class="stm-dashboard-provider" data-provider="vineu" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color: #629662;">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/" class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/logo_negative.svg?id=14aa4ea7', dirname(__FILE__))) ?>"
                                     height="60" alt="">

                                <h2><?php echo esc_html__('VinDecoder.eu', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>  </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>

                    <div class="stm-dashboard-provider" data-provider="israelvin" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color:#2c2d8a">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/israil.jpg', dirname(__FILE__))) ?>"
                                     height="60" alt="">
                                <h2><?php echo esc_html__('Databases of the Ministry of Transportation of Israel', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">

                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>  </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>
                    <div class="stm-dashboard-provider" data-provider="clearvin" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color:#ccc">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/CV-logo.svg', dirname(__FILE__))) ?>"
                                     height="60" alt="">
                                <h2><?php echo esc_html__('Clearvin.com', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>  </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>
                </div>
                <div class="stm-clear"></div>
            </div>


        </div>
        <div id="vin-history" class="tab-pane">

            <div class="stm-dashboard-providers-container">
                <div class="stm-dashboard-providers ui-sortable">

                    <div class="stm-dashboard-provider" data-provider="google" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color: lightgreen;">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/vinaudit-usa-v3.3_85.png', dirname(__FILE__))) ?>"
                                     height="60" alt="">
                                <h2><?php echo esc_html__('Vin Audit', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>                          </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>
                    <div class="stm-dashboard-provider" data-provider="vineu" data-state="not-configured">
                        <div class="stm-dashboard-provider-top" style="background-color: #629662;">
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="provider_link">
                                <div class="titlep"> <?php echo esc_html__('Pro', 'motors-vin-decoder') ?></div>
                                <img src="<?php echo esc_url(plugins_url('assets/img/logo_negative.svg?id=14aa4ea7', dirname(__FILE__))) ?>"
                                     height="60" alt="">
                                <h2><?php echo esc_html__('VinDecoder.eu', 'motors-vin-decoder') ?></h2>
                            </a>
                        </div>
                        <div class="stm-dashboard-provider-bottom">
                            <div class="stm-dashboard-provider-bottom-state"></div>
                            <a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=wpadmin&utm_medium=landing&utm_campaign=2020"
                               class="button button-secondary">
                                <?php echo esc_html__('Settings', 'motors-vin-decoder') ?>  </a>
                        </div>

                        <div class="stm-dashboard-provider-sortable-handle ui-sortable-handle"></div>
                    </div>


                </div>
                <div class="stm-clear"></div>
            </div>


        </div>
        <div id="installation" class="tab-pane">

            <div class="stm-dashboard-providers-container">
                <div class="stm-dashboard-providers ui-sortable">
                    <div class="vintext">
                        <h3>Installation</h3>

                        1. Upload Motors Vin Decoder plugin to the `/wp-content/plugins/` directory <br/>
                        2. Activate the plugin through the 'Plugins' menu in WordPress <br/>
                        3. select provider National Highway Traffic Safety Administration in settings page <br/>
                        4. place shortcode <b>[stm_motors_vin_decoders]</b> to page and post to display Motors Vin Decoder
                        Input Field <br/>
                        <div>
                            <div class="vintext">
                                <h3>Documentation on setup Provider Api</h3>
                               Free version of the plugin uses NHTSA service to decode VIN numbers and provide this information to a user.
                               The service is free, and no extra setup needed.
                            </div>
                            <div class="vintext">
                                <h3>Shortcodes</h3>
                                <div class="sh">Please use following shortcode in pages where you want to display Motors
                                    Vin Decoder Input Field
                                    [<b>stm_motors_vin_decoders</b>]
                                </div>
                                <h3>Elementor</h3>
                                <div class="elsh">For elementor please use Motors Vindecoder Input elementin pages where
                                    you want to display Motors Vin Decoder Input Field
                                    pls see image

                                </div>
                                <div class="elemimage">
                                    <img class="vinimg"
                                         src="<?php echo esc_url(plugins_url('assets/img/elementor_vin.png', dirname(__FILE__))) ?> "
                                    />
                                </div>
                                <h3>WPBakery Page Builder</h3>
                                <div class="elsh">For WPBakery Page Builder please Motors Vindecoder Input module in
                                    pages where you want to display Motors Vin Decoder Input Field
                                    pls see image

                                </div>
                                <div class="elemimage">
                                    <img class="vinimg"
                                         src="<?php echo esc_url(plugins_url('assets/img/wpbakery_vin.png', dirname(__FILE__))) ?> "
                                    />
                                </div>

                                <div class="stm-clear"></div>
                            </div>


                        </div>
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
            e.preventDefault();

            document.querySelector('.nav-tab-active').classList.remove('nav-tab-active');
            document.querySelector('.tab-pane.active').classList.remove('active');

            let clickTab = e.currentTarget;
            let anchor = e.target;
            let activePanId = anchor.getAttribute('href');

            clickTab.classList.add('nav-tab-active');
            document.querySelector(activePanId).classList.add('active');
        }

    })(jQuery)

</script>
