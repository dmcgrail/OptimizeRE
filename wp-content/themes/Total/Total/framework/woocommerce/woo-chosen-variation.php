<?php
/**
 * Alter default WooCommerce columns/pagination
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.38
 */


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'WC_Chosen_Variation_Dropdowns' ) ) {

		class WC_Chosen_Variation_Dropdowns {

			function __construct() {
				add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			}

			function register_scripts() {
				if ( apply_filters( 'woocommerce_is_product_chosen_dropdown', is_singular( 'product' ) ) ) {
					global $woocommerce;
					$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
					wp_register_script( 'ajax-chosen', $woocommerce->plugin_url() . '/assets/js/chosen/ajax-chosen.jquery'.$suffix.'.js', array('jquery', 'chosen'), $woocommerce->version );
					wp_register_script( 'chosen', $woocommerce->plugin_url() . '/assets/js/chosen/chosen.jquery'.$suffix.'.js', array('jquery'), $woocommerce->version );
					wp_enqueue_script( 'ajax-chosen' );
					wp_enqueue_script( 'chosen' );
					wp_enqueue_style( 'woocommerce_chosen_styles', $woocommerce->plugin_url() . '/assets/css/chosen.css' );

					// Get options and build options string
					$options = array();
					$new_options = array();
					$js_options = '';
					$options['disable_search'] = 'true';

					if ( ! empty( $options ) ) {
						foreach ( $options as $key => $value ) {
							$new_options[] = $key . ': ' . $value;
						}
						$js_options = '{' . implode( ',', $new_options ) . '}';
					}

					$woocommerce->add_inline_js( "
						jQuery('.variations select').chosen(" . $js_options . ");
					" );
				}
			}
		}

		$GLOBALS['wc_chosen_variation_dropdowns'] = new WC_Chosen_Variation_Dropdowns();
	}
}