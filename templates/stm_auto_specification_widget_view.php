<div class="vinshortcodecont winwidget">
	<div class="vin_title"><?php echo esc_html__( 'Vin Decoder', 'motors-vin-decoder' ); ?></div>
	<p id="stm_motor_vin_desc">
		<span><?php echo esc_html__( 'Enter your VIN to check vehicle details', 'motors-vin-decoder' ); ?></span>
	</p>
	<div id="stm_motors_vin_decoder">
		<span></span>
		<input type="text" class="vinwidget" class="form-control" required
			   placeholder="<?php echo esc_attr__( 'Enter VIN....', 'motors-vin-decoder' ); ?>">
		<button id="checkVinWidget">
			<?php echo esc_attr__( 'APPLY', 'motors-vin-decoder' ); ?>
		</button>
		<img src="<?php echo esc_url( plugins_url( '/loading.gif', __FILE__ ) ); ?>" class="loading"/>
	</div>
  
</div>

<?php
if ( ! has_action( 'wp_footer', 'stm_vin_add_modal_widget_lite' ) ) {
	add_action( 'wp_footer', 'stm_vin_add_modal_widget_lite' );
}

function stm_vin_add_modal_widget_lite() {
	?>
	<div class="modal" id="stm_vim_specification" tabindex="-1" role="dialog" aria-labelledby="stm_vim_specification_label">
		<div id="request-stm_vim_specification">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header modal-header-iconed">
						<i class="stm-moto-icon-trade"></i>
						<h3 class="modal-title"
							id="stm_vim_specification_label"><?php esc_html_e( 'Vin Specification', 'motors-vin-decoder' ); ?></h3>
						<div class="test-drive-car-name"></div>
						<a class="close-history" href="#">×</a>
					</div>
					<div class="stm_vim_specification modal-body"></div>
				</div>
			</div>
		</div>
	</div>
	<img src="<?php echo esc_url( plugins_url( '/loading.gif', __FILE__ ) ); ?>" class="loading2" alt="loading"/>

	<script>

		(function ($) {
			$('#checkVinWidget').click(function (e) {
				
				e.preventDefault();
				let vin = $('.vinwidget').val();

				if(!vin.trim()) return;
				$('body').addClass('activeSell');
				$('.loading2').addClass('activeLoad2');
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
						$('.loading2').removeClass('activeLoad2');
						var  dataspec = {};
						var dt = [];
						$('#checkVinWidget').text("Recheck");
						if (data == null || data == 'undefined' ) {
							stm_not_obj();
							return;
						}
						if ((typeof data) === "object" && Object.keys(data).length) {
						  
							$('body').removeClass('activeSell');

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
						} else {
							stm_not_obj();
						}
					},
					error: function () {
						stm_not_obj();
					}
				});


				function stm_show_modal(html) {

					$('.stm_vim_specification.modal-body').html(html);
					$('body').removeClass('activeSell');
					$('.loading2').removeClass('activeLoad2');


					$('.vc_toggle, .vc_toggle_').click(function () {
						$(this).toggleClass('vc_toggle_active');
					});

					$('#stm_vim_specification').show();
				   

					$('.close-history').click(function () {
						$('#stm_vim_specification').hide();
						$('body').removeClass('showVinHistory');
					});

					$('#request-stm_vim_specification .vc_toggle ').click(function (event) {
						if (event.target.className !== 'vc_toggle_title' && event.target.className !== 'vc_toggle_icon' && event.target.className !== 'accordion__title') {
							$(this).addClass('vc_toggle_active');
						}
					});
				}

				function stm_not_obj() {
					let html = '<h4><?php echo esc_html__( 'Whoops, looks like something went wrong. Please', 'motors-vin-decoder' ); ?>  <?php echo esc_html__( 'and try again', 'motors-vin-decoder' ); ?></h4>';
					stm_show_modal(html);
				}
			});
		})(jQuery);
	</script>
	
	<?php
} ?>
