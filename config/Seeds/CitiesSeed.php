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
		$isMysqlWithSpatial = $this->hasSpatialColumn();

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
		fclose($handle);

		if ($isMysqlWithSpatial) {
			// MySQL with spatial column: use raw INSERT to compute coordinates
			$this->insertWithCoordinates($rows);
		} else {
			// SQLite/Postgres or no coordinates column: use standard Phinx insert
			$table = $this->table('sandbox_cities');
			$chunks = array_chunk($rows, 1000);
			foreach ($chunks as $chunk) {
				foreach ($chunk as $row) {
					$table->insert([$row]);
				}
				$table->save();
			}
		}
	}

	/**
	 * Check if we're on MySQL with the coordinates column.
	 *
	 * @return bool
	 */
	protected function hasSpatialColumn(): bool {
		$adapter = $this->getAdapter();
		if ($adapter->getAdapterType() !== 'mysql') {
			return false;
		}

		return $adapter->hasColumn('sandbox_cities', 'coordinates');
	}

	/**
	 * Insert rows with computed coordinates column for MySQL.
	 *
	 * @param array $rows The rows to insert.
	 * @return void
	 */
	protected function insertWithCoordinates(array $rows): void {
		$chunks = array_chunk($rows, 1000);
		foreach ($chunks as $chunk) {
			$values = [];
			foreach ($chunk as $row) {
				$name = addslashes($row['name']);
				$alias = $row['alias'] ? "'" . addslashes($row['alias']) . "'" : 'NULL';
				$values[] = sprintf(
					"('%s', %s, %d, %s, %s, ST_GeomFromText('POINT(%s %s)'))",
					$name,
					$alias,
					$row['country_id'],
					$row['lat'],
					$row['lng'],
					$row['lng'],
					$row['lat'],
				);
			}
			$sql = 'INSERT INTO sandbox_cities (name, alias, country_id, lat, lng, coordinates) VALUES ' . implode(', ', $values);
			$this->execute($sql);
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
