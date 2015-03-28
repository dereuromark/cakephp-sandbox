<?php
namespace App\Controller;

use Cake\Event\Event;

/**
 * Start page controller.
 */
class OverviewController extends AppController {

	public $uses = ['User'];

	public function beforeFilter(Event $event) {
		$this->Auth->allow('index');
	}

	public function index() {
	}

	public function admin_index() {
	}

}
