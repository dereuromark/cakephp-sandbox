<?php

use Migrations\BaseMigration;

/**
 * Adds spatial coordinates column with POINT type and SPATIAL index.
 *
 * This migration is MySQL-only as POINT columns and SPATIAL indexes
 * are not supported by SQLite/Postgres in the same way.
 */
class SandboxSpatial extends BaseMigration {

	/**
	 * @return void
	 */
	public function up(): void {
		// Only run on MySQL - POINT columns and SPATIAL indexes are MySQL-specific
		if (!$this->isMysql()) {
			return;
		}

		// Step 1: Add coordinates column as nullable
		$this->table('sandbox_cities')
			->changeColumn('lat', 'float', [
				'comment' => 'latitude',
				'default' => null,
				'null' => false,
				'precision' => 10,
				'scale' => 6,
			])
			->changeColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => false,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('coordinates', 'point', ['null' => true])
			->update();

		// Step 2: Populate coordinates with POINT(lng lat) for existing rows
		$this->execute("
			UPDATE sandbox_cities
			SET coordinates = ST_GeomFromText(CONCAT('POINT(', lng, ' ', lat, ')'))
		");

		// Step 3: Alter coordinates to NOT NULL with SRID 0 (required for SPATIAL index to be used)
		// Note: SRID 0 indicates a Cartesian coordinate system. For proper geographic calculations
		// with ST_Distance_Sphere, SRID 4326 (WGS84) could be used, but SRID 0 works for our use case.
		$this->execute("
			ALTER TABLE sandbox_cities
			MODIFY COLUMN coordinates POINT NOT NULL SRID 0
		");

		// Step 4: Add spatial index (using raw SQL as Phinx doesn't create proper SPATIAL index)
		$this->execute('ALTER TABLE sandbox_cities ADD SPATIAL INDEX coordinates (coordinates)');

		// Note: Triggers removed due to MySQL SUPER privilege requirement with binary logging.
		// Coordinate sync is handled in SandboxCitiesTable::beforeSave() instead.
	}

	/**
	 * @return void
	 */
	public function down(): void {
		if (!$this->isMysql()) {
			return;
		}

		$this->execute('ALTER TABLE sandbox_cities DROP INDEX coordinates');
		$this->table('sandbox_cities')
			->removeColumn('coordinates')
			->update();
	}

	/**
	 * Check if running on MySQL/MariaDB.
	 *
	 * @return bool
	 */
	protected function isMysql(): bool {
		return $this->getAdapter()->getAdapterType() === 'mysql';
	}

}
