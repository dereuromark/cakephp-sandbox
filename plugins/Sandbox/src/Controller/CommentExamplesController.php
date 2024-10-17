<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Sandbox\Model\Entity\SandboxUser;

/**
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 * @property \Comments\Controller\Component\CommentComponent $Comment
 */
class CommentExamplesController extends SandboxAppController {

	protected ?string $defaultTable = 'Sandbox.SandboxPosts';

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->fetchTable('Sandbox.SandboxPosts')->ensureDemoData();

		// Creating demo data
		$user = $this->user();
		// For demo purposes we use Configure instead of session
		Configure::write('Auth.User.id', $user->id);

		// You usually only need one of them per entity type
		$this->loadComponent('Comments.Comment', ['actions' => ['basic']]);
	}

	/**
	 *
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
	}

	/**
	 * @return void
	 */
	public function index() {
		$user = $this->user();

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function basic() {
		$user = $this->user();
		$sandboxPost = $this->fetchTable('Sandbox.SandboxPosts')->find()
			->firstOrFail();

		$this->set(compact('user', 'sandboxPost'));
	}

	/**
	 * @return \Sandbox\Model\Entity\SandboxUser
	 */
	protected function user(): SandboxUser {
		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id() ?: env('REMOTE_ADDR');
		$user = $this->fetchTable('Sandbox.SandboxUsers')->find()
			->where(['email' => $sid . '@example.de'])
			->first();
		if (!$user) {
			$user = $this->fetchTable('Sandbox.SandboxUsers')->newEntity([
				'username' => 'DemoUser',
				'slug' => 'demo-user',
				'email' => $sid . '@example.de',
				'password' => '',
			]);
			if (PHP_SAPI !== 'cli') {
				$this->fetchTable('Sandbox.SandboxUsers')->saveOrFail($user);
			}
		}

		return $user;
	}

}
