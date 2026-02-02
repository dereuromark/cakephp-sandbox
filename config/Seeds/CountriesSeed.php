<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Init seed.
 */
class CountriesSeed extends BaseSeed {

	/**
	 * @return bool
	 */
	public function isIdempotent(): bool {
		return true;
	}

	/**
	 * @return void
	 */
	public function run(): void {
		$file = RESOURCES . 'data/countries.csv';
		$handle = fopen($file, 'r');
		$headers = fgetcsv($handle, null, ',', '"', '\\');
		$nullableFields = ['phone_code', 'zip_regexp', 'address_format', 'timezone'];

		/** @var array<int, true> $existingIds */
		$existingIds = [];
		foreach ($this->fetchAll('SELECT id FROM countries') as $row) {
			$existingIds[(int)$row['id']] = true;
		}

		$newRows = [];
		while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
			$row = array_combine($headers, $data);
			unset($row['continent_id']);
			$row['special'] = '';
			foreach ($nullableFields as $field) {
				if (isset($row[$field]) && $row[$field] === '') {
					$row[$field] = null;
				}
			}

			if (isset($existingIds[(int)$row['id']])) {
				$this->updateRow($row);
			} else {
				$newRows[] = $row;
			}
		}
		fclose($handle);

		if ($newRows) {
			$table = $this->table('countries');
			$table->insert($newRows)->save();
		}
	}

	/**
	 * @param array<string, mixed> $row
	 *
	 * @return void
	 */
	protected function updateRow(array $row): void {
		$id = (int)$row['id'];
		unset($row['id']);

		$sets = [];
		foreach ($row as $key => $value) {
			$sets[] = $key . ' = ' . ($value === null ? 'NULL' : "'" . addslashes((string)$value) . "'");
		}

		$this->execute('UPDATE countries SET ' . implode(', ', $sets) . ' WHERE id = ' . $id);
	}

}
