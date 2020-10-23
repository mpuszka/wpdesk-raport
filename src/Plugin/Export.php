<?php
/**
 * Export main class.
 *
 * @package WPDesk\WpdeskExport
 */

namespace WPDesk\WpdeskExport;

use WPDesk\WpdeskExport\Product;
use WPDesk\WpdeskExport\Csv;

/**
 * Export class
 */
class Export {
	/**
	 * Constant with dashboard position number
	 *
	 * @var int
	 */
	const DASHBOARD_POSITION = 65;

	/**
	 * Constructor method
	 */
	public function __construct() {
		add_action( 'admin_menu', [
			$this,
			'add_plugin_page',
		] );
		add_action( 'admin_init', [
			$this,
			'check_post_form_setting',
		] );
	}

	/**
	 * Add plugin page method
	 *
	 * @return void
	 */
	public function add_plugin_page() {
		add_menu_page(
			'Export Plugin',
			'Export Plugin',
			'manage_options',
			'export-plugin',
			[ $this, 'export_plugin_content' ],
			'dashicons-star-half',
			self::DASHBOARD_POSITION
		);
	}

	/**
	 * Plugin content method
	 *
	 * @return void
	 */
	public function export_plugin_content() {
		$form = file_get_contents( CHECK__PLUGIN_DIR . 'template/form.php' );
		$formNonce = wp_nonce_field( 'export_form', 'export_form_nonce' );
		$message = ( $GLOBALS['exportMessage'] ) ? $GLOBALS['exportMessage'] : '';
		$button = get_submit_button();

		$form = str_replace(
			[ '<%nonce%>', '<%submit%>', '<%message%>' ],
			[ $formNonce, $button, $message ],
			$form
		);

		echo esc_html( $form );
	}

	/**
	 * Submit form method
	 *
	 * @return void
	 */
	public function check_post_form_setting() {

		$nonce = filter_input( INPUT_POST, 'export_form_nonce', FILTER_SANITIZE_STRING );

		if ( ! $nonce ) {
			return;
		}

		if ( false === $this->check_nonce( $nonce ) ) {
			$GLOBALS['exportMessage'] = 'Something goes wrong with form';

			return;
		}

		$productObj = new Product();
		$csv = new Csv();

		if ( 0 === $productObj->get_Products_count() ) {
			$GLOBALS['exportMessage'] = 'No products found';

			return;
		}

		$products = $productObj->get_all_products();

		while ( $products->have_posts() ) :
			$products->the_post();
			global $product;

			$name = $productObj->get_Product_name( $product );
			$category = $productObj->product_categories_to_string( $product );
			$varantion = $productObj->check_product_variations( $product );

			switch ( $varantion ) {
				case 'variable':
					foreach ( $productObj->get_product_variations( $product ) as $variantion ) {
						$var = wc_get_product( $variantion['variation_id'] );
						$variantionName = implode( '/', $var->get_variation_attributes() );
						$sku = $variantion['sku'];
						$salePrice = $variantion['display_price'];
						$regularPrice = $variantion['display_regular_price'];

						$csv->add_row( [
							$name,
							$category,
							$variantionName,
							$sku,
							$salePrice,
							$regularPrice,
						] );
					}
					break;
				default:
					$sku = $productObj->get_sku( $product );
					$salePrice = $productObj->get_sale_price( $product );
					$regularPrice = $productObj->get_regular_price( $product );

					$csv->add_row( [
						$name,
						$category,
						'-',
						$sku,
						$salePrice,
						$regularPrice,
					] );
			}
		endwhile;

		wp_reset_query();

		$csv->download();
	}

	/**
	 * Checking a form nonce
	 *
	 * @param object $data .
	 * @return boolean
	 */
	public function check_nonce( $data ) {
		if ( false === isset( $data ) ) {
			return false;
		}

		if ( false === wp_verify_nonce( $data, 'export_form' ) ) {
			return false;
		}

		return true;
	}
}
