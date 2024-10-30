<div class="modal"
	id="stm_vim_history"
	tabindex="-1"
	role="dialog"
	aria-labelledby="stm_vim_history_label"
	aria-hidden="true">
	<div id="request-stm_vim_history">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<h3 class="modal-title" id="stm_vim_history_label">
						<?php esc_html_e( 'Vehicle Vin Report', 'motors-vin-decoder' ); ?>
					</h3>
					<a class="close-history" href="#">×</a>
				</div>


				<div class="vin_motors_check_modal_tabs modal-header-iconed">
					<button class="tablinks active"
							onclick="openVinTab(event, 'specifications')"> <?php esc_html_e( 'Vehicle Specifications', 'motors-vin-decoder' ); ?></button>
					<button class="tablinks"
							onclick="openVinTab(event, 'history')"><?php esc_html_e( ' Detailed Vehicle History', 'motors-vin-decoder' ); ?></button>
				</div>

				<div id="specifications" class="motors_vin_tab_content" style="display: block">
					<div class="modal-body-vin-specifications modal-body">
					</div>
				</div>

				<div id="history" class="motors_vin_tab_content">
					<div class="modal-body-history modal-body">
					</div>
				</div>

				<script>
					function openVinTab(evt, vinTypeName) {
						var i, vin_tab_content, tablinks;
						vin_tab_content = document.getElementsByClassName("motors_vin_tab_content");
						for (i = 0; i < vin_tab_content.length; i++) {
							vin_tab_content[i].style.display = "none";
						}
						tablinks = document.getElementsByClassName("tablinks");
						for (i = 0; i < tablinks.length; i++) {
							tablinks[i].className = tablinks[i].className.replace(" active", "");
						}
						document.getElementById(vinTypeName).style.display = "block";
						evt.currentTarget.className += " active";
					}
				</script>

			</div>
		</div>
	</div>
</div>
<img src="<?php echo esc_url( plugins_url( '../templates/loader2.gif', __FILE__ ) ); ?>" class="loading2" alt="loading"/>

<script>

	(function ($) {

		$('.report_button').click(function (e) {

			e.preventDefault();
			var vin = $(this).data('vin');
			$('body').addClass('activeSell');
			$('.loading2').addClass('activeLoad2');

			var reportType = {
				action: '<?php echo ( defined( 'STM_MOTORS_VIN_DECODERS_PRO_FILE' ) ) ? 'stm_vin_history_ajax' : 'stm_vin_decoder_ajax_callback'; ?>',
				shortcode: '<?php echo ( defined( 'STM_MOTORS_VIN_DECODERS_PRO_FILE' ) ) ? 'no' : 'yes'; ?>'
			}

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					'vin': vin,
					'shortcode': reportType.shortcode,
					'action': reportType.action,
				},

				success: function (data) {
					$('.loading2').removeClass('activeLoad2');

					if ((typeof data) === "object" && Object.keys(data).length) {
						var notes = '<div class="vehicle_vin_report_note">';
						var history = '<div class="vehicle_vin_report_main">';
						var newSpecifications = '<div class="vehicle_vin_report_main">';
						$('body').removeClass('activeSell');
						var count = 0;
						$.each(data, function (title, colum) {

							if (title === "specifications") {
								var _vin_item = '';
								newSpecifications += '<div class="vehicle_vin_report_inner">';
								$.each(colum, function (index, elem) {
									$.each(elem, function (key, value) {
										count++;
										_vin_item +=
											'<div class="vehicle_vin_report_single_data_item">' +
											'<div class="title">' + key.split(/(?=[A-Z])/).join(" ").toUpperCase() + '</div>' +
											'<div class="value">' + value + '</div>' +
											'</div>';
									});
								});
								newSpecifications += _vin_item + '</div></div>';
							}

							if (title === "history") {
								var _vin_item = '';
								history += '<div class="vehicle_vin_report_inner">';
								$.each(colum, function (index, elem) {
									$.each(elem, function (key, value) {
										_vin_item +=
											'<div class="vehicle_vin_report_single_data_item">' +
											'<div class="title">' + key.split(/(?=[A-Z])/).join(" ").toUpperCase() + '</div>' +
											'<div class="value">' + value + '</div>' +
											'</div>';
									});
								});
								history += _vin_item + '</div></div>';
							}

							if (title === "Note") {
								var _vin_item = '';
								notes += '<div class="vehicle_vin_report_inner">';
								$.each(colum, function (index, elem) {
									$.each(elem, function (key, value) {
										if (key === "Note") {
											_vin_item +=
												'<div class="title"><b>' + key.split(/(?=[A-Z])/).join(" ").toUpperCase() + '</b></div>' +
												'<div class="value">' + value + '</div>'
										}
									});
								});

								notes += _vin_item + '</div>';
								newSpecifications += notes;
							}

							stm_show_modal(newSpecifications, history, count);
						})
					} else {
						stm_not_obj();
					}
				},
				error: function (data) {
					stm_not_obj();
				}
			});

			function stm_show_modal(specifications, history, count) {

				<?php
				$notice = '';

				if ( defined( 'STM_MOTORS_EXTENDS_PATH' ) ) {

					$vin_notice = stm_me_get_wpcfto_mod( 'motors_vin_decoder_modal_notice' );

					if ( ! empty( $vin_notice ) ) {
						$notice = StmVinDecoderTemplate::load_template( 'motors_vin_check_notice', array( 'vin_notice' => $vin_notice ) );
					}
				}
				?>
				if (typeof (specifications) != 'undefined' && specifications.length > 110) {

					specifications += '<button id="vin_report_btn" class="download-vin-report vin_report_btn stm-button">Download Report PDF</button>';
					$('.modal-body-vin-specifications').html('<?php echo wp_kses_post( $notice ); ?>' + specifications);
					if( count<45 ) {
						count = count * 20;
					}
					else if (count > 45) {
						count = count * 22;
					}

					$('#specifications .vehicle_vin_report_inner').css('max-height', count + 'px');
					$('#specifications .vehicle_vin_report_inner').css('height', 'auto');
					document.getElementsByClassName("download-vin-report")[0].addEventListener('click', download_vin_report);
				} else if (typeof (specifications) != 'undefined' && specifications.length > 104 && specifications.length < 110) {

					$('.modal-body-vin-specifications').html('<?php echo wp_kses_post( $notice ); ?>' + specifications);
					$('.vin_motors_check_modal_tabs').css('display', 'none');
				}

				if (typeof (history) != 'undefined' && history.length > 110) {
					history += '<button id="vin_report_btn" class="download-vin-report vin_report_btn stm-button">Download Report PDF</button>';
					$('.modal-body-history').html('<?php echo wp_kses_post( $notice ); ?>' + history);
					$('#history .vehicle_vin_report_inner').css('height', '150px');
					document.getElementsByClassName("download-vin-report")[1].addEventListener('click', download_vin_report);
				} else {

					<?php

					if ( ! defined( 'STM_MOTORS_VIN_DECODERS_PRO_FILE' ) ) {
						?>
					$('#request-stm_vim_history  .vin_motors_check_modal_tabs').css('display', 'none'); 
						<?php
					}
					?>

					$('.modal-body-history').html('<div class="available-in-pro"><div class="single-car-mpg"><div class="mpg-icon"><i class="fas fa-lock"></i></div></div><h2 class="available-in-pro">Available only in PRO version</h2><p class="available-in-pro">VIN History report is available only in Pro version of VIN Decoder plugin together with a compatible VIN Data Provider Subscription.</p><div class="get-pro"><a href="https://stylemixthemes.com/vin-decoder-plugin/?utm_source=motors-landing&amp;utm_medium=vinhistory&amp;utm_campaign=2021" target="_blank" class="stm-button">Learn More</a></div></div>');
				}

				function download_vin_report() {
					$('#main').css('display', 'none');
					$('#stm_vim_history_label').css('font-size', '20px');
					$('.motors_vin_tab_content').css('overflow', 'hidden');
					$('.download-vin-report').css('display', 'none');
					$('#switcher').css('display', 'none');
					$('.modal-header-iconed').css('padding', '18px 10px 15px 0');
					$('.motors_vin_check_notice').css('display', 'none');
					$('#request-stm_vim_history .modal-content').css('max-height', 'none');
					$('#stm_vim_history .close-history').css('opacity', '0');
					$('#request-stm_vim_history .modal-content').css('margin-top', '0');
					$('#request-stm_vim_history .vin_motors_check_modal_tabs').attr("style", "display: none !important");
					$('#request-stm_vim_history .modal-content').css('border', '0px');
					$('#request-stm_vim_history .modal-body').css('padding', '5px');
					$('.vehicle_vin_report_main').css('padding', '5px');

					var height_report_inner = $('.vehicle_vin_report_inner:visible').height();
					height_report_inner += 10;
					height_report_inner += +'px';

					$('.vehicle_vin_report_main').css('display', 'block');
					$('.vehicle_vin_report_inner').css('height', 'auto');
					$('.vehicle_vin_report_inner').css('display', 'inline-block');
					$('.vehicle_vin_report_inner').css('max-height', 'none');
					$('.vehicle_vin_report_inner').css('width', '100%');


					if (document.querySelector(".vehicle_vin_report_note") != null) {
						$('.vehicle_vin_report_note').css('width', '100%');
						$('.vehicle_vin_report_note').css('padding', '0px 0px 10px 20px');
					}

					var afterPrint = function () {
						$('#switcher').css('display', 'flex');
						$('.motors_vin_tab_content').css('overflow', 'visible');
						$('#stm_vim_history_label').css('font-size', '26px');
						$('.modal-header-iconed').css('padding', '28px 10px 23px 0');
						$('#stm_vim_history .close-history').css('opacity', '1');
						$('#main').css('display', 'block');
						$('.download-vin-report').css('display', 'block');
						$('.motors_vin_check_notice').css('display', 'flex');
						$('.vehicle_vin_report_main').css('padding', '20px');
						$('#specifications .vehicle_vin_report_inner').css('max-height', count + 'px');
						$('#request-stm_vim_history .modal-content').css('margin-top', '10vh');

						<?php
						if ( ! defined( 'STM_MOTORS_VIN_DECODERS_PRO_FILE' ) ) {
							?>
						$('#request-stm_vim_history  .vin_motors_check_modal_tabs').attr("style", "display: none"); 
							<?php
						} else {
							?>
						$('#request-stm_vim_history .vin_motors_check_modal_tabs').attr("style", "display: flex !important"); 
							<?php
						}
						?>

						$('#request-stm_vim_history .modal-content').css('max-height', '80vh');
						$('#request-stm_vim_history .modal-body').css('padding', '25px');
						$('.vehicle_vin_report_main').css('display', 'flex');
						$('.vehicle_vin_report_inner').css('display', 'flex');
						$('.vehicle_vin_report_inner').css('height', height_report_inner);
						$('.vehicle_vin_report_inner').css('max-height', height_report_inner);
						// $('.vehicle_vin_report_inner').css('width','614px');
						$('.vehicle_vin_report_note .vehicle_vin_report_inner').css('width', '90%');

						if (document.querySelector(".vehicle_vin_report_note") != null) {
							$('.vehicle_vin_report_note').css('width', '90%');
							$('.vehicle_vin_report_note').css('padding', '20px');
						}
						$('#main').css('padding', '20px');
					};

					window.onafterprint = afterPrint;
					window.print();

				}

				$('body').removeClass('activeSell');
				$('.loading2').removeClass('activeLoad2');

				$('.vc_toggle, .vc_toggle_').click(function () {
					$(this).toggleClass('vc_toggle_active');
				});

				$('#stm_vim_history').show();
				$('body').addClass('showVinHistory');

				$('.close-history').click(function () {
					$('#stm_vim_history').hide();
					$('body').removeClass('showVinHistory');
				});
			}

			function stm_not_obj() {
				var html = '<h4><?php esc_html_e( 'Whoops, looks like something went wrong. Please', 'motors-vin-decoder' ); ?> <a class="close-history"><?php esc_html_e( 'close', 'motors-vin-decoder' ); ?></a> <?php esc_html_e( 'and try again', 'motors-vin-decoder' ); ?></h4>';
				stm_show_modal(html);
			}
		});
		$('.vc_toggle .row').click(function (event) {
			event.preventDefault();
		});

	})(jQuery)
</script>
