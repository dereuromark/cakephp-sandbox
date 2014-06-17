<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

/**
 * Start page controller.
 */
class CarbonController extends SandboxAppController {

	public $uses = array();

	public function beforeFilter() {
		$this->Auth->allow('index');
	}

	public function index() {
	}

}
