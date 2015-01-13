<?php
namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Inflector;

class InflectorController extends AppController {

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
		parent::beforeFilter($event);

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
			$r = new \ReflectionClass('Cake\Utility\Inflector');
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
