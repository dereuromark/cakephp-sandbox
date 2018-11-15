<?php
namespace Sandbox\Controller;

use Geo\Exception\InconclusiveException;
use Geo\Geocoder\Geocoder;

/**
 * @property \Data\Model\Table\CountriesTable $Countries
 */
class GeoExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Data.Countries';

	/**
	 * @var array
	 */
	public $helpers = ['Geo.GoogleMap'];

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * Geocode an address string
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function query() {
		$geocoder = new Geocoder();
		$results = [];
		$country = $this->Countries->newEntity();

		if ($this->Common->isPosted()) {
			$this->Countries->getValidator()->add('address', [
				'notEmpty' => [
					'rule' => 'notBlank',
					'message' => 'valErrMandatoryField',
					'last' => true
				]]);
			$country = $this->Countries->patchEntity($country, $this->request->getData());

			$address = $this->request->data['address'];
			$settings = [
				'allowInconclusive' => $this->request->data['allow_inconclusive'],
				'minAccuracy' => $this->request->data['min_accuracy']
			];
			$geocoder->setConfig($settings);

			if (!$country->getErrors()) {
				try {
					$results = $geocoder->geocode($address);

				} catch (InconclusiveException $e) {
					$this->Flash->error(__('Nothing found'));
				}
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			$this->request->data['allow_inconclusive'] = 1;
			$this->request->data['min_accuracy'] = Geocoder::TYPE_COUNTRY;
		}

		$minAccuracies = $geocoder->accuracyTypes();
		$this->set(compact('country', 'results', 'minAccuracies'));
	}

}
