<?php
namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use ReflectionClass;

class InflectorController extends AppController {

	protected $_reflectExceptions = [
		'_cache',
		'reset',
		'rules',
		'variable',
	];

	/**
	 * InflectorsController::show()
	 *
	 * @return void
	 */
	public function index() {
		$results = [];
		$string = false;
		if ($this->request->is('post')) {
			$string = $this->request->data['string'];
		} elseif (isset($this->request->query['string'])) {
			$string = $this->request->query['string'];
		}

		if ($string) {
			$r = new ReflectionClass('Cake\Utility\Inflector');
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
