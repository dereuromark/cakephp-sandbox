<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Geo\Geocode\Geocode;

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
		$this->Geocode = new Geocode();
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
				'allow_inconclusive' => $this->request->data['allow_inconclusive'],
				'min_accuracy' => $this->request->data['min_accuracy']
			];
			$this->Geocode->setOptions($settings);

			if (!$country->errors() && $this->Geocode->geocode($address)) {
				$results = $this->Geocode->getResult();
			} else {
				$this->Flash->error(__('formContainsErrors'));
			}
		} else {
			$this->request->data['allow_inconclusive'] = 1;
			$this->request->data['min_accuracy'] = Geocode::ACC_COUNTRY;
		}

		$minAccuracies = $this->Geocode->accuracyTypes();
		$this->set(compact('country', 'results', 'minAccuracies'));
	}

}
