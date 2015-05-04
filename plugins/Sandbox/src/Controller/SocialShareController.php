<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class SocialShareController extends SandboxAppController {

	public $helpers = ['SocialShare.SocialShare'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * PluginExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
	}

}
