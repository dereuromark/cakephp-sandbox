<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;
use Sandbox\Model\Entity\SandboxUser;

/**
 * Showcase for dereuromark/cakephp-reactions.
 *
 * Uses the plugin's "action" strategy so the whole demo stays self-contained on this
 * controller: the helper widget posts back to the current action and the Reactable
 * component turns that POST into a toggle/add/remove in place.
 *
 * Reactions are owned by the demo SandboxUsers via the Sandbox.SandboxReactions table.
 *
 * @property \Reactions\Controller\Component\ReactableComponent $Reactable
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 */
class ReactionExamplesController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Sandbox.SandboxPosts';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->SandboxPosts->ensureDemoData();

		// We fake a user / auth, bound to the session so testers don't affect each other.
		$user = $this->user();
		Configure::write('Auth.User.id', $user->id);

		// In this sandbox reactions are owned by the demo SandboxUsers (not the app users),
		// so we point behavior, component and helper at Sandbox.SandboxReactions.
		if (!$this->SandboxPosts->behaviors()->has('Reactable')) {
			$this->SandboxPosts->addBehavior('Reactions.Reactable', [
				'userId' => $user->id,
				'reactionClass' => 'Sandbox.SandboxReactions',
				'userModelClass' => 'Sandbox.SandboxUsers',
			]);
		}

		// The component turns the widget's POSTs into reaction actions on the same page.
		$this->loadComponent('Reactions.Reactable', [
			'actions' => ['index'],
			'on' => 'startup',
		]);

		$this->viewBuilder()->addHelpers([
			'Reactions.Reactions' => [
				'strategy' => 'action',
				'reactionClass' => 'Sandbox.SandboxReactions',
			],
		]);
	}

	/**
	 * Interactive GitHub-style reaction picker on demo posts.
	 *
	 * @return void
	 */
	public function index(): void {
		$posts = $this->SandboxPosts->find()
			->orderBy(['SandboxPosts.id' => 'ASC'])
			->all()
			->toArray();

		$user = $this->user();

		$this->set(compact('posts', 'user'));
	}

	/**
	 * Read-only showcase of the behavior API (counts, user reactions, finders).
	 *
	 * @return void
	 */
	public function api(): void {
		$user = $this->user();

		/** @var \Sandbox\Model\Entity\SandboxPost $post */
		$post = $this->SandboxPosts->find()
			->orderBy(['SandboxPosts.id' => 'ASC'])
			->firstOrFail();

		/** @var \Reactions\Model\Behavior\ReactableBehavior $reactable */
		$reactable = $this->SandboxPosts->getBehavior('Reactable');

		$counts = $reactable->reactionCounts($post->id);
		$userReactions = $reactable->userReactions($post->id, $user->id);

		/** @var \Sandbox\Model\Entity\SandboxPost|null $withReactions */
		$withReactions = $this->SandboxPosts->find('reactions', id: $post->id)->first();
		$reactedByUser = $this->SandboxPosts->find('reactedBy', userId: $user->id)
			->all()
			->toArray();

		// Demonstrate the optional allow-list guard without persisting anything.
		$allowedError = null;
		try {
			$reactable->setConfig('allowed', ['👍', '👎', '❤️']);
			$reactable->removeReaction([
				'modelId' => $post->id,
				'userId' => $user->id,
				'reaction' => 'not-allowed',
			]);
		} catch (BadRequestException $exception) {
			$allowedError = $exception->getMessage();
		} finally {
			$reactable->setConfig('allowed', null);
		}

		$this->set(compact('post', 'user', 'counts', 'userReactions', 'withReactions', 'reactedByUser', 'allowedError'));
	}

	/**
	 * Clears the demo user's reactions so the picker can be tried again from scratch.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod('post');

		$user = $this->user();

		/** @var \Reactions\Model\Behavior\ReactableBehavior $reactable */
		$reactable = $this->SandboxPosts->getBehavior('Reactable');

		$posts = $this->SandboxPosts->find()->all();
		foreach ($posts as $post) {
			foreach ($reactable->userReactions($post->id, $user->id) as $reaction) {
				$reactable->removeReaction([
					'modelId' => $post->id,
					'userId' => $user->id,
					'reaction' => $reaction,
				]);
			}
		}

		$this->Flash->success('Your demo reactions have been reset.');

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Demo user, bound to the current session to avoid cross-tester side effects.
	 *
	 * @return \Sandbox\Model\Entity\SandboxUser
	 */
	protected function user(): SandboxUser {
		$sid = $this->request->getSession()->id() ?: (string)env('REMOTE_ADDR');
		// Hash into a guaranteed-valid, unique local part (a raw IPv6 REMOTE_ADDR is not a valid email).
		$email = 'demo-' . substr(md5($sid), 0, 12) . '@example.de';
		$users = $this->fetchTable('Sandbox.SandboxUsers');

		/** @var \Sandbox\Model\Entity\SandboxUser|null $user */
		$user = $users->find()
			->where(['email' => $email])
			->first();
		if (!$user) {
			$user = $users->newEntity([
				'username' => 'DemoUser',
				'slug' => 'demo-user',
				'email' => $email,
				'password' => '',
			]);
			$users->saveOrFail($user);
		}

		return $user;
	}

}
