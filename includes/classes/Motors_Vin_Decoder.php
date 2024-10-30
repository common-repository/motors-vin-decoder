<?php

class Motors_Vin_Decoder {

	private $provider;
	private $service;
	private $history_provider;
	private $history_service;

	public function __construct() {
		$this->check_provider_options();
		$this->service         = get_option( 'stm_vin_method_name' );
		$this->history_service = get_option( 'stm_vin_method_name_history' );
		$className             = $this->stm_vin_decoder_generate_class_name( $this->service );

		if ( class_exists( $className ) ) {
			$this->provider = new $className();
		}

		$historyClassName = $this->stm_vin_decoder_generate_class_name( $this->history_service );
		if ( class_exists( $historyClassName ) ) {
			$this->history_provider = new $historyClassName();
		}

		$this->init();
	}

	public function check_provider_options() {
		if ( empty( get_option( 'stm_vin_method_name' ) ) ) {
			update_option( 'stm_vin_method_name', 'nhtsa' );
		}
	}

	public static function stm_vin_decoder_generate_class_name( $string ) {
		return str_replace( '-', '', ucwords( $string, '-' ) ) . '_Decoder';
	}

	public function init() {
		add_action( 'init', array( $this, 'stm_vin_decoder_listing_callback' ), 1 );
		add_action( 'stm_vin_auto_complete_require_template', array( $this, 'stm_vin_auto_complete_require_template_callback' ), 9, 1 );
		add_action( 'add_option_stm_vin_settings', array( $this, 'stm_vin_auto_complete_set_settings_callback' ), 9, 1 );
		add_filter( 'stm_change_value', array( $this, 'stm_change_value_callback' ), 9, 2 );

		add_action( 'wp_ajax_stm_admin_listing_auto_complete_action', array( $this, 'stm_admin_listing_auto_complete_callback' ), 90, 1 );
		add_action( 'wp_ajax_stm_vin_decoder_ajax_callback', array( $this, 'stm_vin_decoder_ajax_callback' ), 90, 1 );
		add_action( 'wp_ajax_nopriv_stm_vin_decoder_ajax_callback', array( $this, 'stm_vin_decoder_ajax_callback' ), 90, 1 );

		add_action( 'wp_ajax_stm_vin_history_ajax', array( $this, 'stm_vin_history_ajax_callback' ), 90, 1 );
		add_action( 'wp_ajax_nopriv_stm_vin_history_ajax', array( $this, 'stm_vin_history_ajax_callback' ), 90, 1 );

		add_action( 'widgets_init', array( $this, 'stm_vin_history_template' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'stm_vin_enqueue_style_admin' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'stm_vin_enqueue_style' ) );

		add_action( 'admin_menu', array( $this, 'stm_vin_decoder_add_admin_page' ) );

		add_action( 'init', array( $this, 'stm_add_shortcode' ) );
	}

	public function stm_vin_decoder_add_admin_page() {
		add_menu_page(
			__( 'Motors Vin Decoder', 'motors-vin-decoders' ),
			__( 'Motors Vin Decoder', 'motors-vin-decoders' ),
			'manage_options',
			'stm_vin_decoders_settings',
			array( $this, 'stm_vin_decoders_plugin_create_page' ),
			plugins_url( 'motors-vin-decoder/assets/img/car.png' ),
			110
		);

		if ( ! defined( 'STM_MOTORS_VIN_DECODERS_PRO_PATH ' ) ) {
			add_submenu_page(
				'stm_vin_decoders_settings',
				esc_html__( 'Motors Vin Decoder Upgrade', 'motors-vin-decoders' ),
				'<span style="color: #adff2f;"><span style="font-size: 14px;padding-top: 2px;text-align: left;" class="dashicons dashicons-star-filled stm_go_pro_menu"></span>' . esc_html__( 'Upgrade', 'motors-vin-decoders' ) . '</span>',
				'manage_options',
				'stm_vin_decoders_go_pro',
				array( $this, 'stm_vin_decoders_plugin_create_page_go_pro' )
			);
		}
	}

	public function stm_vin_decoders_plugin_create_page() {
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_settings.php';
	}

	public function stm_vin_decoders_plugin_create_page_go_pro() {
		wp_enqueue_style( 'motors_vindecoder_go_pro_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/gopro.css' );
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_go_pro.php';
	}

	public function stm_vin_decoder_listing_callback() {
		add_action( 'add_meta_boxes', array( $this, 'stm_vin_decoder_add_custom_box' ) );
	}

	public function stm_vin_decoder_add_custom_box() {
		$screens = array( 'listings' );
		add_meta_box( 'auto_complete_wrapper', 'Motors Vin Decoder', array( $this, 'stm_vin_decoder_meta_box_callback' ), $screens, 'normal', 'high' );
	}

	public function stm_vin_decoder_meta_box_callback() {
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_admin_page.php';
	}

	public function stm_admin_listing_auto_complete_callback() {
		$vin       = sanitize_text_field( $_POST['vin'] );
		$shortcode = isset( $_POST['shortcode'] ) ? sanitize_text_field( $_POST['shortcode'] ) : '';
		$this->provider->request_set_vin( $vin, $shortcode );
		$this->provider->stm_listing_vin_decoder_request();
	}

	public function stm_vin_enqueue_style() {
		wp_enqueue_style( 'motors_vindecoder_my_plugin_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/vin-decoder.css' );
		wp_enqueue_style( 'vin_service_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/service-icons.css' );
		wp_enqueue_style( 'vin_stm_stm_icon_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/stm-icon.css' );
		wp_enqueue_style( 'vin_stm_icons_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/icons.css' );
		wp_enqueue_script( 'jquery' );
	}

	public function stm_vin_enqueue_style_admin() {
		wp_enqueue_style( 'motors_vindecoder_my_plugin_style', STM_MOTORS_VIN_DECODERS_URL . '/assets/css/style.css' );
	}

	public function stm_vin_decoder_ajax_callback() {
		$vin       = sanitize_text_field( $_POST['vin'] );
		$shortcode = sanitize_text_field( $_POST['shortcode'] );
		$this->provider->request_set_vin( $vin, $shortcode );
		$this->provider->stm_vin_check_decoder_request();
	}

	public function stm_vin_history_ajax_callback() {
		$vin = sanitize_text_field( $_POST['vin'] );
		$this->history_provider->request_set_vin( $vin );
		$this->history_provider->stm_vin_check_decoder_request();
	}

	public function stm_change_value_callback( $term ) {
		$term = str_replace( '-', ' ', $term );
		$term = ucwords( $term );
		return $term;
	}

	public function stm_vin_auto_complete_set_settings_callback() {

		$vin_decoder_settings = ! empty( $_POST['__vin_decoder_settings'] ) ? sanitize_text_field( $_POST['__vin_decoder_settings'] ) : '';
		$stm_vin_method_name  = ! empty( $_POST['option_page'] ) ? sanitize_text_field( $_POST['option_page'] ) : '';
		$stm_vin_method_name  = explode( 'vin-decoder-settings_', $stm_vin_method_name );
		if ( ! empty( $stm_vin_method_name[1] ) ) {

			$className = $this->stm_vin_decoder_generate_class_name( $stm_vin_method_name[1] );

			if ( class_exists( $className ) ) {
				$provider = new $className();
			}
		}

		if ( $vin_decoder_settings == 1 ) {

			$keys = array( 'stm_vin_method_name', 'stm_vin_method_name_history', 'option_page', 'action', '_wpnonce', '_wp_http_referer' );

			$provider_keys = $provider->set_api_val();
			if ( $provider_keys ) {
				foreach ( $provider_keys as $val ) {
					$val    = str_replace( ' ', '_', $val );
					$keys[] = 'stm_vin_decoder_' . $val;
				}
			}

			$provider_api_credentials = $provider->set_api_credentials();
			if ( $provider_api_credentials ) {
				foreach ( $provider_api_credentials as $val ) {

					$keys[] = $val;
				}
			}

			$keys[] = '__vin_decoder_settings';
			$keys[] = 'submit';

			foreach ( $keys as $key ) {
				if ( ! empty( $_POST[ $key ] ) ) {
					$val = sanitize_text_field( $_POST[ $key ] );
					if ( ! empty( $val ) ) {
						update_option( $key, $val );
					}
				}
			}
		}
	}

	public function stm_vin_auto_complete_require_template_callback() {
		require_once STM_MOTORS_VIN_DECODERS_PATH . '/templates/stm_auto_complete_template.php';
	}

	public function stm_vin_history_template() {
		if ( defined( 'STM_MOTORS_VIN_DECODERS_PRO_PATH' ) ) {
			register_widget( 'STM_History_Widget' );
		}
		register_widget( 'STM_Full_Report_WP_Widget' );
		register_widget( 'STM_Specification_Widget' );
	}

	public function stm_add_shortcode() {
		$shortcode = new STM_Vin_Decoder_Shortcodes();
	}
}
