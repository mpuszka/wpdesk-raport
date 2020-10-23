<?php
/**
 * Product main class.
 *
 * @package WPDesk\WpdeskExport
 */

namespace WPDesk\WpdeskExport;

/**
 * Product class
 */
class Product {

	/**
	 * Arguments for wp query
	 *
	 * @var array
	 */
	const ARGS = [
		'post_type'      => 'product',
		'posts_per_page' => 100,
	];

	/**
	 * Get all products
	 *
	 * @return object
	 */
	public function get_all_products() {
		$products = new \WP_Query( self::ARGS );

		return $products;
	}

	/**
	 * Get numbers of products
	 *
	 * @return int
	 */
	public function get_products_count() {
		return $this->get_all_products()->post_count;
	}

	/**
	 * Get product variations
	 *
	 * @param object $product Product object.
	 * @return array
	 */
	public function get_product_variations( $product ) {
		return $product->get_available_variations();
	}

	/**
	 * Check type of product variation
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function check_product_variations( $product ) {
		return $product->get_type( 'variable' );
	}

	/**
	 * Get product name
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function get_product_name( $product ) {
		return $product->get_name();
	}

	/**
	 * Get product sku method
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function get_sku( $product ) {
		return $product->get_sku();
	}

	/**
	 * Get product sale price method
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function get_sale_price( $product ) {
		return $product->get_sale_price();
	}

	/**
	 * Get product regular price method
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function get_regular_price( $product ) {
		return $product->get_regular_price();
	}

	/**
	 * Get product id method
	 *
	 * @param object $product Product object.
	 * @return integer
	 */
	public function get_product_id( $product ) {
		return $product->get_id();
	}

	/**
	 * Get product categories method
	 *
	 * @param object $product Product object.
	 * @return Wp_Term
	 */
	public function get_product_categories( $product ) {
		$categories = get_the_terms( $this->get_product_id( $product ), 'product_cat' );

		return $categories;
	}

	/**
	 * Get categries names from categories method
	 *
	 * @param object $categories categories array.
	 * @return array
	 */
	public function get_only_categories_names( $categories ) {
		return array_column( $categories, 'name' );
	}

	/**
	 * Merge categories to string method
	 *
	 * @param object $product Product object.
	 * @return string
	 */
	public function product_categories_to_string( $product ) {
		$category              = $this->get_product_categories( $product );
		$categoryNames         = $this->get_only_categories_names( $category );
		$categoryNamesToString = implode( ',', $categoryNames );

		return $categoryNamesToString;
	}
}
