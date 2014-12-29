<?php
use App\Controller\AppController;

class InflectorController extends AppController {

	public $uses = array();

	protected $_reflectExceptions = array(
		'_cache',
		'reset',
		'rules',
		'variable',
	);

	/**
	 * InflectorController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * InflectorsController::show()
	 *
	 * @return void
	 */
	public function index() {
		$results = array();
		$string = false;
		if ($this->request->is('post')) {
			$string = $this->request->data['string'];
		} elseif (isset($this->request->query['string'])) {
			$string = $this->request->query['string'];
		}

		if ($string) {
			$r = new ReflectionClass('Inflector');
			foreach ($r->getMethods() as $method) {
				if (in_array($method->name, $this->_reflectExceptions)) {
					continue;
				}
				$methodName = $method->name;
				$results[$method->name] = Inflector::$methodName($string);
			}
		}
		$this->set(compact('string', 'results'));
	}

}
