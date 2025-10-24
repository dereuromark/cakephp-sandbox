<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * States seed.
 */
class StatesSeed extends BaseSeed {

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
		$file = RESOURCES . 'data/states.csv';
		$handle = fopen($file, 'r');
		$headers = fgetcsv($handle, null, ',', '"', '\\');
		$rows = [];
		while (($data = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
			$row = array_combine($headers, $data);
			unset($row['ori_name']);

			$rows[] = $row;
		}
		fclose($handle);

		$table = $this->table('states');
		$table->insert($rows)->save();
	}

}
