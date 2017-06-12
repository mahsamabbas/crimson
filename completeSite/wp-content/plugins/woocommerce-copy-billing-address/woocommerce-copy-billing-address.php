<?php
/**
 * Plugin Name: WooCommerce Copy Billing Address
 * Plugin URI: http://axisthemes.com/plugins/woocommerce-copy-billing-address
 * Description: WooCommerce extension to allow customer to copy billing address to shipping address during the checkout process.
 * Version: 21.0.1
 * Author: AxisThemes
 * Author URI: http://axisthemes.com/
 * License: GPLv3 or later
 * Text Domain: woocommerce-copy-billing-address
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Copy_Billing_Address' ) ) :

/**
 * WC_Copy_Billing_Address class.
 */
class WC_Copy_Billing_Address {

	/**
	 * Plugin version.
	 * @var string
	 */
	const VERSION = '21.0.1';

	/**
	 * Instance of this class.
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks with WooCommerce is installed.
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/woocommerce-copy-billing-address/woocommerce-copy-billing-address-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/woocommerce-copy-billing-address-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-copy-billing-address' );

		load_textdomain( 'woocommerce-copy-billing-address', WP_LANG_DIR . '/woocommerce-copy-billing-address/woocommerce-copy-billing-address-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-copy-billing-address', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function frontend_scripts() {
		$suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$assets_path = str_replace( array( 'http:', 'https:' ), '', self::plugin_url() ) . '/assets/';

		// Register styles.
		wp_register_style( 'woocommerce-copy-billing-address', $assets_path . 'css/wc-copy-billing-address.css', array(), self::VERSION );

		// Register scripts.
		wp_register_script( 'jquery-tiptip', $assets_path . 'js/jquery-tiptip/jquery.tipTip' . $suffix . '.js', array( 'jquery' ), self::VERSION, true );
		wp_register_script( 'woocommerce-copy-billing-address', $assets_path . 'js/frontend/wc-copy-billing-address' . $suffix . '.js', array( 'jquery', 'jquery-tiptip' ), self::VERSION, true );
		wp_localize_script( 'woocommerce-copy-billing-address', 'woocommerce_copy_billing_address', array(
			'copy_title'   => __( 'Copy billing address', 'woocommerce-copy-billing-address' ),
			'copy_billing' => __( 'Copy billing information to shipping information? This will remove any currently entered shipping information.', 'woocommerce-copy-billing-address' ),
		) );

		// Enqueue checkout scripts.
		if ( is_checkout() && true === WC()->cart->needs_shipping_address() ) {
			wp_enqueue_style( 'woocommerce-copy-billing-address' );
			wp_enqueue_script( 'woocommerce-copy-billing-address' );
		}
	}

	/**
	 * WooCommerce fallback notice.
	 * @return string
	 */
	public function woocommerce_missing_notice() {
		echo '<div class="error notice is-dismissible"><p>' . sprintf( __( 'WooCommerce Copy Billing Address depends on the last version of %s or later to work!', 'woocommerce-copy-billing-address' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __( 'WooCommerce 2.3', 'woocommerce-copy-billing-address' ) . '</a>' ) . '</p></div>';
	}
}

add_action( 'plugins_loaded', array( 'WC_Copy_Billing_Address', 'get_instance' ) );

endif;
