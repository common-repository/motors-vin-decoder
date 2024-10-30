<button class="report_button stm-button" data-vin="<?php echo esc_attr( get_post_meta( get_the_ID(), 'vin_number', true ) ); ?>">
	<?php echo esc_html__( $title, 'motors-vin-decoder' ); ?>
</button>

<?php
if ( ! has_action( 'wp_footer', 'stm_vin_add_modal_widget' ) ) {
	add_action( 'wp_footer', 'stm_vin_add_modal_widget' );
}

function stm_vin_add_modal_widget() {
	?>
	<div class="modal" id="stm_vim_history" tabindex="-1" role="dialog" aria-labelledby="stm_vim_history_label">
		<div id="request-stm_vim_history">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-header-iconed">
						<i class="stm-moto-icon-trade"></i>
						<h3 class="modal-title"
							id="stm_vim_history_label"><?php esc_html_e( 'Vin History', 'motors-vin-decoder' ); ?></h3>
						<div class="test-drive-car-name"><?php echo esc_html__( stm_generate_title_from_slugs( get_the_id() ) ); ?></div>
						<a class="close-history" href="#">×</a>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
	</div>
	<img src="<?php echo plugins_url( '/loader.gif', __FILE__ ); ?>" class="loading2" alt="loading"/>

	<script>

		(function ($) {

			$('.report_button').click(function (e) {

				e.preventDefault();
				let vin = $(this).data('vin');
				$('body').addClass('activeSell');
				$('.loading2').addClass('activeLoad2');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						'vin': vin,
						'action': 'stm_vin_history_ajax',
					},

					success: function (data) {
						$('.loading2').removeClass('activeLoad2');

						if ((typeof data) === "object" && Object.keys(data).length) {
							let html = '<div>';
							$('body').removeClass('activeSell');
							let count = 0;
							$.each(data, function (title, colum) {
								let _head = '';
								let _class = count === 0 ? 'vc_toggle_active' : '';
								html += '<div class="vc_toggle vc_toggle_ ' + _class + '"><div class="vc_toggle_title"><h5 class="accordion__title">' + title.toUpperCase() + '</h5><i class="vc_toggle_icon"></i></div><div class="row vc_toggle_content ">';
								count++;
								$.each(colum, function (index, elem) {
									$.each(elem, function (key, value) {
										_head += '<div class="col-md-4 col-sm-4"><h6 style="margin-bottom: 2px">' + key.split(/(?=[A-Z])/).join(" ").toUpperCase() + '</h6><p style="margin-bottom: 20px">' + value + '</p></div>';
									});
								});
								html += _head + '</div></div>';
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

					$('.modal-body').html(html);
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

					$('#request-stm_vim_history .vc_toggle ').click(function (event) {
						if (event.target.className !== 'vc_toggle_title' && event.target.className !== 'vc_toggle_icon' && event.target.className !== 'accordion__title') {
							$(this).addClass('vc_toggle_active');
						}
					});
				}

				function stm_not_obj() {
					let html = '<h4><?php echo esc_html__( 'Whoops, looks like something went wrong. Please', 'motors-vin-decoder' ); ?> <a class="close-history"><?php echo esc_html__( 'close', 'motors-vin-decoder' ); ?></a> <?php echo esc_html__( 'and try again', 'motors-vin-decoder' ); ?></h4>';
					stm_show_modal(html);
				}
			});
		})(jQuery);
	</script>

	<?php
} ?>
