<li class="help-bar-vin">
	<a href="<?php echo esc_url(get_the_permalink($vin_page)); ?>"
	   title="<?php esc_attr_e('Motors Vin Decoder', 'motors-vin-decoder'); ?>">
		<span class="list-label heading-font"><?php esc_html_e('Vin-Check', 'motors-vin-decoder'); ?></span>
		<img src="<?php echo esc_url( plugins_url( 'assets/img/vin-check-btn.svg', dirname(__FILE__) ) ) ?> ">
	</a>
</li>