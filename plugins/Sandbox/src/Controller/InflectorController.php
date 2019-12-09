<?php

namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use ReflectionClass;

class InflectorController extends AppController {

	/**
	 * @var string|false
	 */
	public $modelClass = false;

	/**
	 * @var array
	 */
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
			$string = $this->request->getData('string');
		} elseif ($this->request->getQuery('string')) {
			$string = $this->request->getQuery('string');
		}

		if ($string) {
			$r = new ReflectionClass('Cake\Utility\Inflector');
			foreach ($r->getMethods() as $method) {
				if (in_array($method->name, $this->_reflectExceptions, true)) {
					continue;
				}
				$methodName = $method->name;
				$results[$method->name] = Inflector::$methodName($string);
			}
		}
		$this->set(compact('string', 'results'));
	}

}
