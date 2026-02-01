<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Database\Driver\Mysql;
use Cake\Utility\Text;
use Doctrine\SqlFormatter\SqlFormatter;
use Exception;
use Geo\Exception\InconclusiveException;
use Geo\Geocoder\Geocoder;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 */
class GeoExamplesController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Data.Countries';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['Geo.GoogleMap', 'Geo.Leaflet', 'Geo.StaticMap']);
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function maps() {
	}

	/**
	 * @return void
	 */
	public function leaflet() {
		$providers = [
			'osm' => [
				'name' => 'OpenStreetMap',
				'url' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
					'maxZoom' => 19,
				],
			],
			'osm_hot' => [
				'name' => 'OpenStreetMap HOT',
				'url' => 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, Tiles by <a href="https://www.hotosm.org/">HOT</a>',
					'maxZoom' => 19,
				],
			],
			'carto_light' => [
				'name' => 'CartoDB Positron (Light)',
				'url' => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
					'subdomains' => 'abcd',
					'maxZoom' => 20,
				],
			],
			'carto_dark' => [
				'name' => 'CartoDB Dark Matter',
				'url' => 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
					'subdomains' => 'abcd',
					'maxZoom' => 20,
				],
			],
			'carto_voyager' => [
				'name' => 'CartoDB Voyager',
				'url' => 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
					'subdomains' => 'abcd',
					'maxZoom' => 20,
				],
			],
			'opentopomap' => [
				'name' => 'OpenTopoMap',
				'url' => 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a>, <a href="https://opentopomap.org">OpenTopoMap</a>',
					'maxZoom' => 17,
				],
			],
			'cyclosm' => [
				'name' => 'CyclOSM (Cycling)',
				'url' => 'https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a>, <a href="https://www.cyclosm.org">CyclOSM</a>',
					'maxZoom' => 20,
				],
			],
			'esri_world' => [
				'name' => 'Esri WorldStreetMap',
				'url' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
				'options' => [
					'attribution' => 'Tiles &copy; Esri',
					'maxZoom' => 18,
				],
			],
			'esri_satellite' => [
				'name' => 'Esri WorldImagery (Satellite)',
				'url' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
				'options' => [
					'attribution' => 'Tiles &copy; Esri',
					'maxZoom' => 18,
				],
			],
			'esri_topo' => [
				'name' => 'Esri WorldTopoMap',
				'url' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
				'options' => [
					'attribution' => 'Tiles &copy; Esri',
					'maxZoom' => 18,
				],
			],
			'stadia_smooth' => [
				'name' => 'Stadia Alidade Smooth',
				'url' => 'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="https://openstreetmap.org">OpenStreetMap</a>',
					'maxZoom' => 20,
				],
			],
			'stadia_dark' => [
				'name' => 'Stadia Alidade Dark',
				'url' => 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png',
				'options' => [
					'attribution' => '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="https://openstreetmap.org">OpenStreetMap</a>',
					'maxZoom' => 20,
				],
			],
		];

		$provider = $this->request->getQuery('provider');
		if (!$provider || !isset($providers[$provider])) {
			$provider = 'osm';
		}

		$this->set(compact('providers', 'provider'));
	}

	/**
	 * Static map images from various providers.
	 *
	 * @return void
	 */
	public function staticMaps() {
		$providers = [
			'geoapify' => [
				'name' => 'Geoapify',
				'styles' => ['osm-bright', 'osm-bright-grey', 'klokantech-basic', 'dark-matter', 'positron'],
				'apiKeyConfigs' => ['StaticMap.geoapify.apiKey'],
			],
			'mapbox' => [
				'name' => 'Mapbox',
				'styles' => ['streets-v12', 'outdoors-v12', 'light-v11', 'dark-v11', 'satellite-v9'],
				'apiKeyConfigs' => ['StaticMap.mapbox.apiKey'],
			],
			'stadia' => [
				'name' => 'Stadia',
				'styles' => ['alidade_smooth', 'alidade_smooth_dark', 'outdoors', 'stamen_toner', 'stamen_terrain'],
				'apiKeyConfigs' => ['StaticMap.stadia.apiKey'],
			],
			'google' => [
				'name' => 'Google',
				'styles' => ['roadmap', 'satellite', 'terrain', 'hybrid'],
				'apiKeyConfigs' => ['StaticMap.google.apiKey', 'GoogleMap.key'],
			],
		];

		// Use GoogleMap.key as fallback for StaticMap.google.apiKey
		if (!Configure::read('StaticMap.google.apiKey') && Configure::read('GoogleMap.key')) {
			Configure::write('StaticMap.google.apiKey', Configure::read('GoogleMap.key'));
		}

		$configuredProviders = [];
		foreach ($providers as $key => $provider) {
			foreach ($provider['apiKeyConfigs'] as $configKey) {
				if (Configure::read($configKey)) {
					$configuredProviders[$key] = $provider;

					break;
				}
			}
		}

		$provider = $this->request->getQuery('provider');
		if (!$provider || !isset($configuredProviders[$provider])) {
			$provider = array_key_first($configuredProviders);
		}

		$style = $this->request->getQuery('style');

		$this->set(compact('providers', 'configuredProviders', 'provider', 'style'));
	}

	/**
	 * @return void
	 */
	public function filter() {
		/** @var \Sandbox\Model\Entity\SandboxCity $city */
		$city = $this->fetchTable('Sandbox.SandboxCities')->find()
			->contain(['Countries'])
			->where(['SandboxCities.name' => 'Berlin'])
			->firstOrFail();
		$cities = [$city->id => $city->name . ', ' . $city->country->name . ' (' . $city->lat . ', ' . $city->lng . ')'];

		// Spatial queries require MySQL with coordinates column
		$spatialAvailable = $this->isSpatialAvailable();
		$spatialInfo = $spatialAvailable ? $this->getSpatialInfo() : null;
		$type = ($this->request->getQuery('spatial') && $spatialAvailable) ? 'spatial' : 'distance';

		$sandboxCities = [];
		$sqlQuery = null;
		$sqlQueryFormatted = null;
		$queryTime = null;
		$explainResult = null;
		if ($this->request->getData('city_id')) {
			$this->fetchTable('Sandbox.SandboxCities')->addBehavior('Geo.Geocoder');
			$city = $this->fetchTable('Sandbox.SandboxCities')->get($this->request->getData('city_id'));
			$search = [
				'lat' => $city->lat,
				'lng' => $city->lng,
				//'sort' => false,
				'distance' => $this->request->getData('distance') ?: 100,
			];
			$query = $this->fetchTable('Sandbox.SandboxCities')
				->find($type, ...$search)
				->where(['SandboxCities.id !=' => $city->id])
				->contain(['Countries'])
				->limit(10);
			$sqlQuery = (string)$query;
			$sqlQueryFormatted = (new SqlFormatter())->format($sqlQuery);

			// Get EXPLAIN output for the query
			if ($spatialAvailable && $this->request->getQuery('spatial')) {
				$explainResult = $this->getExplainResult($sqlQuery);
			}

			$startTime = microtime(true);
			$sandboxCities = $query->all()->toArray();
			$queryTime = (microtime(true) - $startTime) * 1000; // in milliseconds
		}

		$this->set(compact('cities', 'sandboxCities', 'sqlQuery', 'sqlQueryFormatted', 'spatialAvailable', 'spatialInfo', 'queryTime', 'explainResult'));
	}

	/**
	 * Check if spatial queries are available (MySQL with coordinates column).
	 *
	 * @return bool
	 */
	protected function isSpatialAvailable(): bool {
		$connection = $this->fetchTable('Sandbox.SandboxCities')->getConnection();
		$driver = $connection->getDriver();

		// Only MySQL/MariaDB supports POINT columns and SPATIAL indexes
		if (!$driver instanceof Mysql) {
			return false;
		}

		// Check if coordinates column exists
		$schema = $this->fetchTable('Sandbox.SandboxCities')->getSchema();

		return $schema->hasColumn('coordinates');
	}

	/**
	 * Get spatial column information (SRID, index status).
	 *
	 * @return array<string, mixed>
	 */
	protected function getSpatialInfo(): array {
		$connection = $this->fetchTable('Sandbox.SandboxCities')->getConnection();

		// Get column SRID from information schema
		$sridResult = $connection->execute(
			"SELECT SRS_ID FROM INFORMATION_SCHEMA.ST_GEOMETRY_COLUMNS
			WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sandbox_cities' AND COLUMN_NAME = 'coordinates'",
		)->fetchAll('assoc');
		$columnSrid = $sridResult[0]['SRS_ID'] ?? null;

		// Get data SRID from actual data
		$dataSridResult = $connection->execute(
			'SELECT ST_SRID(coordinates) as srid FROM sandbox_cities LIMIT 1',
		)->fetchAll('assoc');
		$dataSrid = $dataSridResult[0]['srid'] ?? null;

		// Check if spatial index exists
		$indexResult = $connection->execute(
			"SHOW INDEX FROM sandbox_cities WHERE Key_name = 'coordinates'",
		)->fetchAll('assoc');
		$hasIndex = !empty($indexResult);
		$indexType = $indexResult[0]['Index_type'] ?? null;

		// Get total row count
		$countResult = $connection->execute('SELECT COUNT(*) as cnt FROM sandbox_cities')->fetchAll('assoc');
		$totalRows = (int)($countResult[0]['cnt'] ?? 0);

		return [
			'columnSrid' => $columnSrid,
			'dataSrid' => $dataSrid,
			'hasIndex' => $hasIndex,
			'indexType' => $indexType,
			'totalRows' => $totalRows,
			'sridConfigured' => $columnSrid !== null,
		];
	}

	/**
	 * Get EXPLAIN result for a query.
	 *
	 * @param string $sql The SQL query to explain.
	 * @return array<string, mixed>|null
	 */
	protected function getExplainResult(string $sql): ?array {
		$connection = $this->fetchTable('Sandbox.SandboxCities')->getConnection();

		try {
			$result = $connection->execute('EXPLAIN ' . $sql)->fetchAll('assoc');
			$citiesExplain = null;
			foreach ($result as $row) {
				if (($row['table'] ?? '') === 'SandboxCities') {
					$citiesExplain = $row;

					break;
				}
			}

			if (!$citiesExplain) {
				return null;
			}

			return [
				'type' => $citiesExplain['type'] ?? 'unknown',
				'key' => $citiesExplain['key'] ?? null,
				'rows' => (int)($citiesExplain['rows'] ?? 0),
				'usingSpatialIndex' => ($citiesExplain['key'] ?? '') === 'coordinates',
			];
		} catch (Exception $e) {
			return null;
		}
	}

	/**
	 * Geocode an address string
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function query() {
		$geocoder = new Geocoder();
		$results = [];
		$country = $this->Countries->newEmptyEntity();

		if ($this->Common->isPosted()) {
			if (PHP_SAPI !== 'cli') {
				$this->Countries->addBehavior('Captcha.Captcha');
			}

			$this->Countries->getValidator()->add('address', [
				'notEmpty' => [
					'rule' => 'notBlank',
					'message' => __('valErrMandatoryField'),
					'last' => true,
				],
			]);
			$country = $this->Countries->patchEntity($country, $this->request->getData());

			$address = $this->request->getData('address');
			$settings = [
				'allowInconclusive' => $this->request->getData('allow_inconclusive'),
				'minAccuracy' => $this->request->getData('min_accuracy'),
			];
			$geocoder->setConfig($settings);

			if (!$country->getErrors()) {
				try {
					$results = $geocoder->geocode($address);

				} catch (InconclusiveException $e) {
					$this->Flash->error(__('Nothing found'));
				} catch (Exception $e) {
					$this->Flash->error('Something went wrong: ' . (Configure::read('debug') ? $e->getMessage() : Text::truncate($e->getMessage(), 60)));
				}
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			$this->request = $this->request->withData('allow_inconclusive', 1);
			$this->request = $this->request->withData('min_accuracy', Geocoder::TYPE_COUNTRY);
		}

		$minAccuracies = $geocoder->accuracyTypes();
		$this->set(compact('country', 'results', 'minAccuracies'));
	}

}
