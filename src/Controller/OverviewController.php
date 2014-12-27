<?php
namespace Controller;
use App\Controller\AppController;

/**
 * Start page controller.
 */
class OverviewController extends AppController {

	public $uses = array('User');

	public function beforeFilter() {
		$this->Auth->allow('index');
	}

	public function index() {
	}

	public function admin_index() {
	}

}
