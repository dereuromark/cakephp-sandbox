<?php

use Migrations\BaseMigration;

class SandboxSpatial extends BaseMigration {

	/**
	 * @return void
	 */
	public function up() {
		// Skip for now

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

		// Step 2: Populate coordinates with POINT(lat lng) for existing rows
		$this->execute("
            UPDATE sandbox_cities
            SET coordinates = ST_GeomFromText(CONCAT('POINT(', lng, ' ', lat, ')'))
        ");

		// Step 3: Alter coordinates to NOT NULL
		$this->execute("
            ALTER TABLE sandbox_cities
            MODIFY COLUMN coordinates POINT NOT NULL
        ");

		// Step 4: Add spatial index
		$this->table('sandbox_cities')
			->addIndex(['coordinates'], ['type' => 'spatial'])
			->update();

		// Step 5: Add triggers to keep coordinates in sync with lat/lng
		$this->execute("
            CREATE TRIGGER before_sandbox_cities_insert
            BEFORE INSERT ON sandbox_cities
            FOR EACH ROW
            SET NEW.coordinates = ST_GeomFromText(CONCAT('POINT(', NEW.lng, ' ', NEW.lat, ')'));
        ");
		$this->execute("
            CREATE TRIGGER before_sandbox_cities_update
            BEFORE UPDATE ON sandbox_cities
            FOR EACH ROW
            SET NEW.coordinates = ST_GeomFromText(CONCAT('POINT(', NEW.lng, ' ', NEW.lat, ')'));
        ");
	}

	/**
	 * @return void
	 */
	public function down() {
		$this->execute('DROP TRIGGER IF EXISTS before_sandbox_cities_insert');
		$this->execute('DROP TRIGGER IF EXISTS before_sandbox_cities_update');
		$this->table('sandbox_cities')
			->removeColumn('coordinates')
			->update();
	}

}
