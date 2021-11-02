<?php

namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use ReflectionClass;

class InflectorController extends AppController {

	/**
	 * @var array<string>
	 */
	protected $_reflectExceptions = [
		'_cache',
		'reset',
		'rules',
		'variable',
	];

	/**
	 * @return void
	 */
	public function index() {
		$results = [];
		$string = null;
		if ($this->request->is('post')) {
			$string = $this->request->getData('string');
		} elseif ($this->request->getQuery('string')) {
			$string = $this->request->getQuery('string');
		}

		if ($string) {
			$r = new ReflectionClass(Inflector::class);
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
