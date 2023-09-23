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
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
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
