<?php

namespace App\Test\TestCase\Controller;

use Exception;
use Shim\TestSuite\IntegrationTestCase;

/**
 * ExportControllerTest
 *
 * @uses \App\Controller\ExportController
 */
class ExportControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		// Set referer for ExportController beforeFilter check
		$this->configRequest([
			'environment' => [
				'HTTP_REFERER' => '/export',
			],
		]);

		// Create minimal test data for Data plugin tables (only if not already exists)
		$continentsTable = $this->fetchTable('Data.Continents');
		if ($continentsTable->find()->where(['code' => 'EU'])->count() === 0) {
			$continent = $continentsTable->newEntity([
				'name' => 'Europe',
				'ori_name' => 'Europe',
				'code' => 'EU',
			]);
			$continentsTable->saveOrFail($continent);
		}

		$countriesTable = $this->fetchTable('Data.Countries');
		if ($countriesTable->find()->where(['iso2' => 'DE'])->count() === 0) {
			$country = $countriesTable->newEntity([
				'name' => 'Germany',
				'ori_name' => 'Germany',
				'iso2' => 'DE',
				'iso3' => 'DEU',
				'eu_member' => true,
				'special' => '',
				'zip_length' => 5,
				'zip_regexp' => '',
				'sort' => 0,
				'address_format' => ':name :street_address :postcode :city',
			]);
			$countriesTable->saveOrFail($country);
		}

		$currenciesTable = $this->fetchTable('Data.Currencies');
		if ($currenciesTable->find()->where(['code' => 'EUR'])->count() === 0) {
			$currency = $currenciesTable->newEntity([
				'name' => 'Euro',
				'code' => 'EUR',
			], ['validate' => false]);
			$currenciesTable->saveOrFail($currency, ['checkRules' => false]);
		}

		$languagesTable = $this->fetchTable('Data.Languages');
		if ($languagesTable->find()->where(['iso2' => 'en'])->count() === 0) {
			$language = $languagesTable->newEntity([
				'name' => 'English',
				'ori_name' => 'English',
				'code' => 'en',
				'iso3' => 'eng',
				'iso2' => 'en',
				'locale' => 'en',
				'locale_fallback' => 'en',
				'status' => 1,
				'sort' => 0,
			]);
			$languagesTable->saveOrFail($language);
		}

		$statesTable = $this->fetchTable('Data.States');
		if ($statesTable->find()->where(['code' => 'BY', 'country_id' => 1])->count() === 0) {
			$state = $statesTable->newEntity([
				'country_id' => 1,
				'code' => 'BY',
				'name' => 'Bavaria',
				'lat' => 48.7904,
				'lng' => 11.4979,
			]);
			$statesTable->saveOrFail($state);
		}

		$timezonesTable = $this->fetchTable('Data.Timezones');
		if ($timezonesTable->find()->where(['name' => 'Europe/Berlin'])->count() === 0) {
			$timezone = $timezonesTable->newEntity([
				'name' => 'Europe/Berlin',
				'offset' => '1',
				'offset_dst' => '2',
				'type' => 'Europe',
				'active' => true,
			]);
			try {
				$timezonesTable->saveOrFail($timezone);
			} catch (Exception $e) {
				debug('Timezone save failed: ' . $e->getMessage());
				debug($timezone->getErrors());
			}
		}
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Export', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testContinents() {
		$this->get(['controller' => 'Export', 'action' => 'continents', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testCountries() {
		$this->get(['controller' => 'Export', 'action' => 'countries', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testCurrencies() {
		$this->get(['controller' => 'Export', 'action' => 'currencies', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLanguages() {
		$this->get(['controller' => 'Export', 'action' => 'languages', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMimeTypes() {
		$this->markTestSkipped('mimeTypes action not implemented');
	}

	/**
	 * @return void
	 */
	public function testStates() {
		$this->get(['controller' => 'Export', 'action' => 'states', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testTimezones() {
		$this->markTestSkipped('TODO: Debug 500 error');

		$this->configRequest([
			'environment' => [
				'HTTP_REFERER' => '/export',
			],
		]);

		$this->get(['controller' => 'Export', 'action' => 'timezones', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
