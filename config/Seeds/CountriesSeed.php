<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Init seed.
 */
class CountriesSeed extends BaseSeed {

	/**
	 * Run Method.
	 *
	 * Write your database seeder using this method.
	 *
	 * More information on writing seeds is available here:
	 * https://book.cakephp.org/phinx/0/en/seeding.html
	 *
	 * @return void
	 */
	public function run(): void {
		$file = RESOURCES . 'data/countries.csv';
		$handle = fopen($file, 'r');
		$headers = fgetcsv($handle, null, ',', '"', '\\');
		$rows = [];
		$nullableFields = ['phone_code', 'zip_regexp', 'address_format', 'timezone'];
		while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
			$row = array_combine($headers, $data);
			unset($row['continent_id']);
			$row['special'] = '';
			foreach ($nullableFields as $field) {
				if (isset($row[$field]) && $row[$field] === '') {
					$row[$field] = null;
				}
			}
			$rows[] = $row;
		}
		fclose($handle);

		$table = $this->table('countries');
		$table->truncate();
		$table->insert($rows)->save();
	}

}
