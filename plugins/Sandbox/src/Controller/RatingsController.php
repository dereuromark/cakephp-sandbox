<?php
namespace Sandbox\Controller;

/**
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 * @property \Ratings\Controller\Component\RatingComponent $Rating
 */
class RatingsController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.SandboxPosts';

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		// We fake a user / auth
		$uid = $this->request->session()->read('Tmp.User.id');
		if (!$uid) {
			$uid = time();
			$this->request->session()->write('Tmp.User.id', $uid);
		}

		$this->loadComponent('Ratings.Rating', ['userId' => $uid, 'rateClass' => 'Sandbox.SandboxRatings']);
	}

	/**
	 * @return void
	 */
	public function index() {
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
		$isRated = $this->SandboxPosts->isRatedBy($id, $userId)->first();
		$this->set(compact('isRated'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function unrate($id = null) {
		$this->request->allowMethod('post');
		$uid = $this->request->session()->read('Tmp.User.id');
		if (!$id || !$uid) {
			$this->Flash->error('No ID given. Cannot delete rating.');
			return $this->redirect($this->referer(['action' => 'index']));
		}

		$this->SandboxPosts->removeRating($id, $uid);

		$this->Flash->success('Rating resetted.');
		return $this->redirect($this->referer(['action' => 'index']));
	}

}
