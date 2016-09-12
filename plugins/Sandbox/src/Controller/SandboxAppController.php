<?php
namespace Sandbox\Controller;

use App\Controller\AppController;
use Cake\Controller\Controller;

class SandboxAppController extends AppController {

	/**
	 * SandboxAppController::_getActions()
	 *
	 * @param \Cake\Controller\Controller $Controller
	 * @return array
	 */
	protected function _getActions(Controller $Controller) {
		$actions = get_class_methods($Controller);
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
