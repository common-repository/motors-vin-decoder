<div class="vin_title"><?php esc_html_e( 'Vin Decoder', 'motors-vin-decoder' ); ?></div>
<p id="stm_motor_vin_desc">
	<span><?php esc_html_e( 'Enter your VIN to Import vehicle details', 'motors-vin-decoder' ); ?></span>
</p>
<div id="stm_motors_vin_decoder">
	<span></span>
	<input type="text" class="vin" class="form-control" required
			placeholder="<?php esc_html_e( 'Enter VIN....', 'motors-vin-decoder' ); ?>">
	<button id="checkVin">
		<?php esc_html_e( 'APPLY', 'motors-vin-decoder' ); ?>
	</button>
	<img src="<?php echo esc_url( plugins_url( '/loading.gif', __FILE__ ) ); ?>" class="loading" />
</div>

<p id="error_message"><?php esc_html_e( 'The VIN entered is invalid. Please check and try again.', 'motors-vin-decoder' ); ?></p>

<script>

	(function ($) {
		$('.vin').on('input', function () {

			$('.vin').removeClass('error_vin success');
			$('#error').removeClass('activeError');
			$('#stm_motors_vin_decoder').removeClass('activeVin');
			$('#stm_motors_vin_decoder span').removeClass('activeSpan');

			$('.error_message').css('display', 'none');
		});

		function stm_vin_error() {

			$('.vin').addClass('error_vin');
			$('#error').addClass('activeError');
			$('.loading').removeClass('activeLoading');
			$('#stm_sell_a_car_form').removeClass('activeSell');
			$('#stm_motors_vin_decoder').addClass('activeVin');

			$('.error_message').css('display', 'block');
		}

		$('#checkVin').click(function (e) {

			e.preventDefault();
			let vin = $('.vin').val();

			if (!vin.trim()) return;

			$('.loading').addClass('activeLoading');
			$('#stm_sell_a_car_form').addClass('activeSell');

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					'vin': vin,
					'action': 'stm_vin_decoder_ajax_callback',
				},

				success: function (data) {

					if ((typeof data) === "object" && Object.keys(data).length) {

						$('.vin').addClass('success');
						$('#error').removeClass('activeError');
						$('.loading').removeClass('activeLoading');
						$('#stm_sell_a_car_form').removeClass('activeSell');
						$('#stm_motors_vin_decoder span').addClass('activeSpan');

						for (let key in data) {
							if (data[key].original_slug === 'engine') {
								data[key].value = parseFloat(data[key].value);
							}

							let value = data[key].value;
							let slug = data[key].original_slug;
							let preSlug = data[key].pre_slug;

							let prefix_s_s = $('[name="stm_s_s_' + slug + '"]');
							let prefix_f_s = $('[name="stm_f_s[' + slug + ']"]');

							if (prefix_s_s.length > 0 || prefix_f_s.length > 0) {

								if (prefix_f_s[0] && prefix_f_s[0].tagName) {
									toChangeValue(prefix_f_s[0], prefix_f_s, value);
								} else {
									toChangeValue(prefix_s_s[0], prefix_s_s, value);
								}
							} else {

								let prefix_pre_f_s = $('[name="stm_f_s[' + preSlug + ']"]');

								if (prefix_pre_f_s[0] && prefix_pre_f_s[0].tagName) {
									toChangeValue(prefix_pre_f_s[0], prefix_pre_f_s, value);
								} else {
									toChangeValue(prefix_pre_f_s[0], prefix_pre_f_s, value);
								}
							}
						}

						$('[name=stm_vin]').val(vin);

					} else {
						stm_vin_error();
					}

					function toChangeValue(tag, selector, value) {
						if (tag && tag.tagName === "INPUT") {
							if (typeof value == 'string' && value.search('/miles/') !== -1) {
								value = value[0] + '' + value[1];
							}
							selector.val(value);
						} else {
							let value_lower = typeof value === 'string' ? value.replace(' ', '-').toLowerCase() : value;

							if (selector.find("option[value='" + value + "']").length) {
								selector.val(value).trigger('change');
							} else {
								let newOption = new Option(value, value_lower, true, true);
								selector.append(newOption).trigger('change');
							}
						}
					}
				},

				error: function () {
					stm_vin_error();
				}
			});
		});
	})(jQuery)
</script>
