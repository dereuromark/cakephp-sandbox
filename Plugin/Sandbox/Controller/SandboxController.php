<?php

class SandboxController extends SandboxAppController {

	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * Overview
	 * 2010-07-24 ms
	 */
	public function index() {
	}


	public function admin_index() {
		$methods = get_class_methods($this);
		$parentMethods = get_class_methods(get_parent_class($this));
		$parentMethods[] = 'index';
		$parentMethods[] = 'admin_index';

		$methods = array_diff($methods, $parentMethods);
		foreach ($methods as $key => $val) {
			if (strpos($val, '_') === 0) {
				unset($methods[$key]);
			}
		}

		$this->set(compact('methods'));
	}

}
