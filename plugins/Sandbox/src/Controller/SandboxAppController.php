<?php

namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Controller\Controller;
use ReflectionClass;
use ReflectionMethod;

class SandboxAppController extends AppController {

	/**
	 * @var string|bool
	 */
	public $modelClass = false;

	/**
	 * @param \Cake\Controller\Controller $Controller
	 * @return array
	 */
	protected function _getActions(Controller $Controller) {
		$class = new ReflectionClass($Controller);
		$methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
		$actions = [];
		foreach ($methods as $method) {
			$actions[] = $method->getName();
		}
		$parentMethods = get_class_methods(get_parent_class($Controller));
		$parentMethods[] = 'index';

		$actions = array_diff($actions, $parentMethods);
		foreach ($actions as $key => $value) {
			if (substr($value, 0, 1) === '_' || substr($value, 0, 6) === 'admin_') {
				unset($actions[$key]);
			}
		}
		return $actions;
	}

}
