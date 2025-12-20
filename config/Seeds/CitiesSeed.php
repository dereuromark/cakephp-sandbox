<?php
declare(strict_types=1);

use Cake\Utility\Hash;
use Migrations\BaseSeed;

/**
 * Init seed.
 */
class CitiesSeed extends BaseSeed {

	/**
	 * @return string[]
	 */
	public function getDependencies(): array {
		return ['CountriesSeed'];
	}

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
		$map = $this->countriesMap();

		$file = RESOURCES . 'data/cities.csv';
		$handle = fopen($file, 'r');
		$headers = fgetcsv($handle, null, ',', '"', '\\');
		$rows = [];
		while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
			$row = array_combine($headers, $data);
			if (empty($map[$row['country_id']])) {
				dd($row);
			}
			$row['country_id'] = $map[$row['country_id']];
			$rows[] = $row;
		}
		$table = $this->table('sandbox_cities');
		$chunks = array_chunk($rows, 1000);
		foreach ($chunks as $chunk) {
			foreach ($chunk as $row) {
				$table->insert([$row]);
			}
			$table->save();
		}
	}

	/**
	 * @return array
	 */
	protected function countriesMap(): array {
		$map = [];

		$countries = $this->fetchAll('SELECT id, iso3 FROM countries');
		$countries = Hash::combine($countries, '{n}.iso3', '{n}.id');

		$file = RESOURCES . 'data/countries.csv';
		$handle = fopen($file, 'r');
		$headers = fgetcsv($handle, null, ',', '"', '\\');
		while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
			$row = array_combine($headers, $data);
			if (empty($countries[$row['iso3']])) {
				continue;
			}
			$map[$row['id']] = $countries[$row['iso3']];
		}
		fclose($handle);

		return $map;
	}

}
