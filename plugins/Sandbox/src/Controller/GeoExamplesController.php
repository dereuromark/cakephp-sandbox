<?php
namespace Sandbox\Controller;

use Aura\Intl\Exception;
use Cake\Event\Event;
use Geo\Exception\InconclusiveException;
use Geo\Geocoder\Geocoder;

class GeoExamplesController extends SandboxAppController {

	public $modelClass = 'Data.Countries';

	public $helpers = ['Geo.GoogleMap'];

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter($event);
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * Geocode an address string
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function query() {
		$this->Geocoder = new Geocoder();
		$results = [];
		$country = $this->Countries->newEntity();

		if ($this->Common->isPosted()) {
			$this->Countries->validator()->add('address', [
				'notEmpty' => [
					'rule' => 'notBlank',
					'message' => 'valErrMandatoryField',
					'last' => true
				]]);
			$country = $this->Countries->patchEntity($country, $this->request->data);

			$address = $this->request->data['address'];
			$settings = [
				'allowInconclusive' => $this->request->data['allow_inconclusive'],
				'minAccuracy' => $this->request->data['min_accuracy']
			];
			$this->Geocoder->config($settings);

			if (!$country->errors()) {
				try {
					$results = $this->Geocoder->geocode($address);

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

		$minAccuracies = $this->Geocoder->accuracyTypes();
		$this->set(compact('country', 'results', 'minAccuracies'));
	}

}
