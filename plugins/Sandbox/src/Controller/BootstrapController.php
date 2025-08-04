<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;
use Shim\Datasource\LegacyModelAwareTrait;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
#[\AllowDynamicProperties]
class BootstrapController extends SandboxAppController {

	use ModelAwareTrait;
	use LegacyModelAwareTrait;

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Sandbox.Animals';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$helpers = [
			'Flash' => ['className' => 'BootstrapUI.Flash'],
			'Breadcrumbs' => ['className' => 'BootstrapUI.Breadcrumbs'],
			'Form' => ['className' => 'BootstrapUI.Form'],
			//'Html' => ['className' => 'BootstrapUI.Html'],
			//'Paginator' => ['className' => 'BootstrapUI.Paginator'],
		];
		$this->viewBuilder()->addHelpers($helpers);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return void
	 */
	public function beforeFilter(EventInterface $event) {
		//$this->components()->unload('Flash');
		//$this->loadComponent('Flash');

		parent::beforeFilter($event);
	}

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return void
	 */
	public function form() {
		$animal = $this->Animals->newEmptyEntity();

		if ($this->request->is('post')) {
			foreach ($this->request->getData() as $field => $value) {
				$animal->setError($field, 'A demo error');
			}
		}

		$this->set(compact('animal'));
	}

	/**
	 * @return void
	 */
	public function localized() {
		$animal = $this->Animals->newEmptyEntity();

		// This hack is needed to prevent the forms from being autofilled with todays date
		//$this->request->data['discovered'] = '';
		//$this->request->data['published'] = '';
		//$this->request->data['time'] = '';

		$this->set(compact('animal'));
	}

	/**
	 * @return void
	 */
	public function time() {
		$animal = $this->Animals->newEmptyEntity();

		// This hack is needed to prevent the forms from being autofilled with todays date
		$animal->set('time', '');
		$animal->set('time_with_seconds', '');

		$this->set(compact('animal'));
	}

	/**
	 * Show how posted forms behave and how to set default values.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function formPost() {
		$animal = $this->Animals->newEmptyEntity();

		if ($this->request->is(['post', 'put'])) {
			// Save form data
			if (Configure::read('saveForReal')) {
				$this->Flash->success('Saved and redirected');

				return $this->redirect(['action' => 'formPost']);
			}
			$this->Flash->error('Not saved - for demo purposes');

		} else {
			// Here we can set the form defaults, including the ones coming from DB
			$animal->set('multiple_checkboxes', [1, 3, 5]);
			$animal->set('multiple_selects', [2, 4]);
		}

		$this->set(compact('animal'));
	}

	/**
	 * Show flash message output.
	 *
	 * @param string|null $type
	 * @return \Cake\Http\Response|null|void
	 */
	public function flash($type = null) {
		$types = ['error', 'warning', 'success', 'info'];
		$this->set(compact('types'));

		if (!$type || !in_array($type, $types, true) && $type !== 'html') {
			$type = 'error';
		}
		if ($type === 'html') {
			$type = '<b>Success</b> in HTML';
			$this->Flash->success('I am a message of type ' . $type . '.', ['escape' => false]);
		} else {
			$this->Flash->{$type}('I am a message of type ' . $type . '.');
		}
	}

	/**
	 * Show post links
	 *
	 * @param string|null $type
	 * @return \Cake\Http\Response|null|void
	 */
	public function postLink($type = null) {
	}

}
