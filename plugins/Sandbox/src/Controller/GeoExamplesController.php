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
	 * @var string
	 */
	protected ?string $defaultTable = 'Data.Countries';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['Geo.GoogleMap']);
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
	public function filter() {
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
				]]);
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
