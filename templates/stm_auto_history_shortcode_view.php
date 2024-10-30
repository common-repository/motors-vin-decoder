<?php ob_start(); ?>
<div class="vinshortcodecont">
	<div class="vin_title">
		<?php echo esc_html__( 'Vin Decoder', 'motors-vin-decoder' ); ?>
	</div>
	<div id="stm_motors_vin_decoder">
		<input type="text" class="vin" class="form-control" required
			placeholder="<?php echo esc_html__( 'Enter your VIN to check vehicle details', 'motors-vin-decoder' ); ?>">
		<div class="sample_vin">Try a sample VIN</div>
		<button id="checkVin" class="heading-font stm-template-motorcycle">
			<?php echo esc_html__( 'APPLY', 'motors-vin-decoder' ); ?>
		</button>
		<img src="<?php echo esc_url( plugins_url( '/loader2.gif', __FILE__ ) ); ?>" class="loading"/>
	</div>

	<p id="error_message"><?php echo esc_html__( 'The VIN entered is invalid. Please check and try again.', 'motors-vin-decoder' ); ?></p>
	<div class="" id="stm_vim_history" >
		<div id="request-stm_vim_history">
			<div class="stm-modal-dialog">
				<div class="stm-modal-content">

					<div class="stm_vin_info"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function ajaxpopulate( data ) {

		jQuery('.vin').addClass('success');
		jQuery('#error').removeClass('activeError');
		jQuery('.loading').removeClass('activeLoading');
		jQuery('#stm_sell_a_car_form').removeClass('activeSell');
		jQuery('#stm_motors_vin_decoder span').addClass('activeSpan');

		let html = '<div>';

		let count = 0;
		jQuery.each(data, function (title, colum) {
			let ctr = 0;
			let classeqip = '';
			let _head = '';
			let _class = count === 0 ? 'vc_toggle_active' : '';
			html += '<div class="vc_toggle vs-shortcode" id="vs-shortcode"><div class="vc_toggle_title_short"><h5 class="accordion__title">' + title.toUpperCase() + '</h5></div><div class="row vc_toggle_content ">';
			html += '<div class="stm-single-car-listing-data">';
			html += '<table class="stm-table-main"><tbody>';
			let trin = [];

			count++;
			classeqip = title;

			jQuery.each(colum, function (index, elem) {
				let elemlength =  Object.keys(elem).length;
				for (i = 0; i < elemlength; i=i+2) {
					trin[i] = i;
				}

				jQuery.each(elem, function (key, value) {
					let icon = 'stm-icon-label-reverse';
					if(elem["icons"][key]) icon = elem["icons"][key] ;
					if ((value != '') && (key != 'icons')) {
						if (jQuery.inArray(ctr , trin)> -1)  _head += '<tr>';
						_head += '<td><table class="inner-table  '+ classeqip+'"><tbody><tr><td class="label-td">';
						_head += '<i class="'+icon+'"></i>' + key.split(/(?=[A-Z])/).join(" ").toUpperCase() + '</td>';
						_head += '<td class="heading-font">' + value + '</td></tr></tbody></table></td><td class="divider-td"></td>';
						ctr++;
						if (jQuery.inArray(ctr , trin)> -1)  _head += '</tr>';
					}
				});
			});
			html += _head + '</tbody></table></div></div></div>';
		});
		stm_show_modal(html);
	}

	function stm_show_modal(html) {

		jQuery('.stm_vin_info').html(html);

		jQuery('.vc_toggle, .vc_toggle_').click(function () {
			jQuery(this).toggleClass('vc_toggle_active');
		});

		jQuery('#stm_vim_history').show();

		jQuery('#request-stm_vim_history .vc_toggle ').click(function (event) {
			if (event.target.className !== 'vc_toggle_title' && event.target.className !== 'vc_toggle_icon' && event.target.className !== 'accordion__title') {
				jQuery(this).addClass('vc_toggle_active');
			}
		});
	}

	(function ($) {

		$('.vin').on('input', function () {

			$('.vin').removeClass('error_vin success');
			$('#error').removeClass('activeError');
			$('#stm_motors_vin_decoder').removeClass('activeVin');
			$('#stm_motors_vin_decoder span').removeClass('activeSpan');

			$('.error_message').css('display', 'none');
		});

		document.getElementsByClassName("sample_vin")[0].addEventListener('click', function () {

			$(".vin").val('WBABW33426PX70804');

		});

		function stm_vin_error() {

			$('.vin').addClass('error_vin');
			$('#error').addClass('activeError');
   
			$('#stm_motors_vin_decoder').addClass('activeVin');
			$('.loading').removeClass('activeLoading');
			$('.error_message').css('display', 'block');
			stm_not_obj();
		}

		function stm_not_obj() {
			let html = '<h4 class="errorh4"><?php echo esc_html__( 'Whoops, looks like something went wrong. Please', 'motors-vin-decoder' ); ?> <?php echo esc_html__( 'and try again', 'motors-vin-decoder' ); ?></h4>';
			stm_show_modal(html);
		}
		<?php
		$atts = array();
		array_unshift( $atts, 'vinspecification' );
		if ( 'vinspecification' === $atts[0] || '' === $atts[0] ) {
			?>
			$('#checkVin').click(function (e) {

			e.preventDefault();
			let vin = $('.vin').val();

			if(!vin.trim()) return;

			$('.loading').addClass('activeLoading');
			$('#stm_sell_a_car_form').addClass('activeSell');
			var ajaxurl = '<?php echo esc_url( get_site_url() ); ?>/wp-admin/admin-ajax.php';

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					'vin': vin,
					'shortcode': 'yes',
					'action': 'stm_vin_decoder_ajax_callback',
				},

				success: function (data) {
					var  dataspec = {};
					var dt = [];
					$('#checkVin').text("Recheck");
					if (data == null || data == 'undefined' ) {
						stm_vin_error();
						return;
					}
					if ((typeof data) === "object" && Object.keys(data).length) {
						ajaxpopulate( data );
					} else {
						stm_vin_error();
					}

				},

				error: function () {
					stm_vin_error();
				}
			});
		});
		<?php } elseif ( 'vinhistory' === $atts[0] ) { ?>
			$('#checkVin').click(function (e) {

			$('.loading').addClass('activeLoading');
			$('#stm_sell_a_car_form').addClass('activeSell');

			e.preventDefault();
			let vin = $('.vin').val();
			if(!vin.trim()) return;

			var ajaxurl = '<?php echo esc_url( get_site_url() ); ?>/wp-admin/admin-ajax.php';
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					'vin': vin,
					'action': 'stm_vin_history_ajax',
				},

				success: function (data) {

					$('#checkVin').text("Recheck");

					if (data == null || data == 'undefined' ) {
						stm_not_obj();
						return;
					}
					if (data == null || data == 'undefined' ) {
						stm_not_obj();
						return;
					}
					if ((typeof data) === "object" && Object.keys(data).length) {

						ajaxpopulate(data);

					} else {
						stm_vin_error();
					}
				},
				error: function () {
					stm_vin_error();
				}
			});

		});
		<?php } ?>
	})(jQuery)
	</script>

	<?php
	$output = ob_get_clean();
	?>
