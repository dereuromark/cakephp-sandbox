<?php
namespace Sandbox\Controller;

/**
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 */
class RatingsController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.SandboxPosts';

	/**
	 * @var array
	 */
	public $components = ['Ratings.Ratings' => ['userId' => true, 'rateClass' => 'Sandbox.SandboxRatings']];

	/**
	 * @return void
	 */
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
