<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use App\Test\Factory\CountryFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\GeoExamplesController Test Case
 *
 * @uses \Sandbox\Controller\GeoExamplesController
 */
class GeoExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test query method
	 *
	 * @return void
	 */
	public function testQuery(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'query']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test query method
	 *
	 * @return void
	 */
	public function testFilter(): void {
		$this->disableErrorHandlerMiddleware();

		$country = CountryFactory::new()->save();
		$sandboxCity = $this->fetchTable('Sandbox.SandboxCities')->newEntity([
			'name' => 'Berlin',
			'country_id' => $country->id,
			'lat' => 52.5200,
			'lng' => 13.4050,
		]);
		$this->fetchTable('Sandbox.SandboxCities')->saveOrFail($sandboxCity);

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'filter']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test maps method
	 *
	 * @return void
	 */
	public function testMaps(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'maps']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test leaflet method
	 *
	 * @return void
	 */
	public function testLeaflet(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'leaflet']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test staticMaps method
	 *
	 * @return void
	 */
	public function testStaticMaps(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'staticMaps']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
