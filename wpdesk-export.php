<?php
/**
	Plugin Name: Wpdesk Export
	Plugin URI: https://www.wpdesk.net/products/wpdesk-export/
	Description: Wpdesk Export
	Product: Wpdesk Export
	Version: 1.0
	Author: WP Desk
	Author URI: https://www.wpdesk.net/
	Text Domain: wpdesk-export
	Domain Path: /lang/
	Requires PHP: 7.1

	@package \WPDesk\WpdeskExport

	Copyright 2016 WP Desk Ltd.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/* THESE TWO VARIABLES CAN BE CHANGED AUTOMATICALLY */
$plugin_version           = '1.0.0';
$plugin_release_timestamp = '2019-11-29 19:01';

$plugin_name        = 'Wpdesk Export';
$plugin_class_name  = '\WPDesk\WpdeskExport\Plugin';
$plugin_text_domain = 'wpdesk-export';
$product_id         = 'wpdesk-export';
$plugin_file        = __FILE__;
$plugin_dir         = dirname( __FILE__ );

$requirements = [
	'php'     => '7.1',
	'wp'      => '4.5',
	'plugins' => [
		[
			'name'      => 'woocommerce/woocommerce.php',
			'nice_name' => 'WooCommerce',
			'version'   => '3.0',
		],
	],
];

define( 'CHECK__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require __DIR__ . '/vendor_prefixed/wpdesk/wp-plugin-flow/src/plugin-init-php52.php';
