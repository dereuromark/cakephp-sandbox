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
		$country = $this->Countries->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$this->Countries->addBehavior('Captcha.Captcha');

			$this->Countries->getValidator()->add('address', [
				'notEmpty' => [
					'rule' => 'notBlank',
					'message' => 'valErrMandatoryField',
					'last' => true
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
			$this->request->data['allow_inconclusive'] = 1;
			$this->request->data['min_accuracy'] = Geocoder::TYPE_COUNTRY;
		}

		$minAccuracies = $geocoder->accuracyTypes();
		$this->set(compact('country', 'results', 'minAccuracies'));
	}

}
