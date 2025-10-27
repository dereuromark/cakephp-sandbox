<?php

namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Controller\Controller;
use ReflectionClass;
use ReflectionMethod;

class SandboxAppController extends AppController {

	/**
	 * @param \Cake\Controller\Controller $Controller
	 * @return array<string>
	 */
	protected function _getActions(Controller $Controller): array {
		$class = new ReflectionClass($Controller);
		$methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
		$actions = [];
		foreach ($methods as $method) {
			$actions[] = $method->getName();
		}
		$parentClass = get_parent_class($Controller);
		if ($parentClass === false) {
			$parentClass = $Controller;
		}
		$parentMethods = get_class_methods($parentClass);
		$parentMethods[] = 'index';
		$parentMethods[] = 'loadModel';
		$parentMethods[] = 'fetchModel';
		$parentMethods[] = 'modelFactory';
		$parentMethods[] = 'setModelType';
		$parentMethods[] = 'getModelType';

		$actions = array_diff($actions, $parentMethods);
		foreach ($actions as $key => $value) {
			if (substr($value, 0, 1) === '_' || substr($value, 0, 6) === 'admin_') {
				unset($actions[$key]);
			}
		}

		return $actions;
	}

}
