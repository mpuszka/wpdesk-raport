<?php
/**
 * Csv main class.
 *
 * @package WPDesk\WpdeskExport
 */

namespace WPDesk\WpdeskExport;

use League\Csv\Writer;
use SplTempFileObject;

/**
 * Csv class
 */
class Csv {
	/**
	 * Csv object
	 *
	 * @var object
	 */
	private $csv;

	/**
	 * Csv columns
	 *
	 * @var array
	 */
	const COLUMNS = [
		'Nazwa Produktu',
		'Kategorie',
		'Wariant',
		'Sku',
		'Cena',
		'Cena bez znizki',
	];

	/**
	 * Constrctor method
	 */
	public function __construct() {
		$this->csv = Writer::createFromFileObject( new SplTempFileObject() );
		$this->csv->insertOne( self::COLUMNS );
	}

	/**
	 * Add new row to csv file method
	 *
	 * @param array $data Row to add.
	 * @return void
	 */
	public function add_row( $data ) {
		$this->csv->insertOne( $data );
	}

	/**
	 * Download csv file method
	 *
	 * @return void
	 */
	public function download() {
		$this->csv->output( 'raport.csv' );
		die;
	}
}
