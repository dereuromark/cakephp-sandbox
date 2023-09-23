<?php

namespace Sandbox\Controller;

use Cake\Datasource\ModelAwareTrait;

/**
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 * @property \Ratings\Controller\Component\RatingComponent $Rating
 */
class RatingsController extends SandboxAppController {

	use ModelAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Sandbox.SandboxPosts';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		// We fake a user / auth
		$uid = $this->request->getSession()->read('Tmp.User.id');
		if (!$uid) {
			$uid = time();
			$this->request->getSession()->write('Tmp.User.id', $uid);
		}

		$this->loadComponent('Ratings.Rating', ['userId' => $uid, 'rateClass' => 'Sandbox.SandboxRatings']);
	}

	/**
	 * @return void
	 */
	public function index() {
		/** @var \Sandbox\Model\Entity\SandboxPost|null $record */
		$record = $this->SandboxPosts->find()->first();
		if (!$record) {
			$data = [
				'title' => 'First Post',
				'content' => 'A first content',
			];
			$post = $this->SandboxPosts->newEntity($data);
			$record = $this->SandboxPosts->saveOrFail($post);
		}
		$id = $record->id;
		$this->set('post', $record);

		$userId = $this->request->getSession()->read('Tmp.User.id');
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
		$uid = $this->request->getSession()->read('Tmp.User.id');
		if (!$id || !$uid) {
			$this->Flash->error('No ID given. Cannot delete rating.');

			return $this->redirect($this->referer(['action' => 'index']));
		}

		$this->SandboxPosts->removeRating($id, $uid);

		$this->Flash->success('Rating resetted.');

		return $this->redirect($this->referer(['action' => 'index']));
	}

}
