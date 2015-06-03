<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class RatingsController extends SandboxAppController {

	public $modelClass = 'Sandbox.SandboxPosts';

	public $components = ['Ratings.Ratings' => ['userId' => true, 'rateClass' => 'Sandbox.SandboxRatings']];

	public function initialize() {
		parent::initialize();
	}

	public function beforeFilter(Event $event) {

		$this->Auth->allow();
		parent::beforeFilter($event);
	}

	public function index() {
		// We fake a user / auth
		if (!$this->request->session()->read('Tmp.User.id')) {
			$this->request->session()->write('Tmp.User.id', 1);
		}

		//$actions = $this->_getActions($this);
		//$this->set(compact('actions'));

		$record = $this->SandboxPosts->find('first');
		if (!$record) {
			$data = [
				'title' => 'First Post',
				'content' => 'A first content',
			];
			$post = $this->SandboxPosts->newEntity($data);
			$record = $this->SandboxPosts->save($post);
		}
		$id = $record->id;
		$this->set('post', $record);

		$userId = $this->request->session()->read('Tmp.User.id');
		$this->set('isRated', $this->SandboxPosts->isRatedBy($id, $userId));
	}

}
