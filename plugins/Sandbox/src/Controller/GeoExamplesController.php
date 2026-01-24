<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Utility\Text;
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

		$this->viewBuilder()->addHelpers(['Geo.GoogleMap', 'Geo.Leaflet']);
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
	 * @return void
	 */
	public function filter() {
		/** @var \Sandbox\Model\Entity\SandboxCity $city */
		$city = $this->fetchTable('Sandbox.SandboxCities')->find()
			->contain(['Countries'])
			->where(['SandboxCities.name' => 'Berlin'])
			->firstOrFail();
		$cities = [$city->id => $city->name . ', ' . $city->country->name . ' (' . $city->lat . ', ' . $city->lng . ')'];

		$type = $this->request->getQuery('spatial') ? 'spatial' : 'distance';

		$sandboxCities = [];
		$sqlQuery = null;
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
			$sandboxCities = $query->all()->toArray();
		}

		$this->set(compact('cities', 'sandboxCities', 'sqlQuery'));
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
