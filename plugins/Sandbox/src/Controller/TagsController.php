<?php
namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * @property \Sandbox\Model\Table\SandboxCategoriesTable $SandboxCategories
 * @property \Sandbox\Model\Table\SandboxPostsTable $SandboxPosts
 * @property \Search\Controller\Component\PrgComponent $Prg
 */
class TagsController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.SandboxCategories';

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		// We fake a user / auth
		$uid = $this->request->getSession()->read('Tmp.User.id');
		if (!$uid) {
			$uid = time();
			$this->request->getSession()->write('Tmp.User.id', $uid);
		}

		$this->loadComponent('Search.Prg', [
			'actions' => ['search'],
			'modelClass' => 'Sandbox.SandboxPosts',
		]);
	}

	/**
	 * @return void
	 */
	public function index() {
		$this->loadModel('Sandbox.SandboxCategories');

		/** @var \Sandbox\Model\Entity\SandboxCategory $category */
		$category = $this->SandboxCategories->newEmptyEntity();
		if ($this->request->is('post')) {
			$category = $this->SandboxCategories->patchEntity($category, $this->request->getData());
			// Save here
		} else {
			$category->title = 'My title';
			$category->tag_list = 'Foo, Bar';
		}

		$this->set(compact('category'));
	}

	/**
	 * @return void
	 */
	public function select() {
		Configure::write('Tags.strategy', 'array');
		$this->loadModel('Sandbox.SandboxCategories');

		$category = $this->SandboxCategories->newEmptyEntity();
		if ($this->request->is('post')) {
			$category = $this->SandboxCategories->patchEntity($category, $this->request->getData());
			// Save here
		} else {
			$category->title = 'My title';
			$category->tag_list = ['One', 'Two', 'Four'];
		}

		$this->set(compact('category'));
	}

	/**
	 * @return void
	 */
	public function search() {
		$this->loadModel('Sandbox.SandboxPosts');
		$this->ensurePostsDemoData();

		$query = $this->SandboxPosts->find('search', ['search' => $this->request->getQuery()])->contain(['Tags']);

		$posts = $this->paginate($query);

		$tags = $this->SandboxPosts->Tagged->find()->distinct(['Tags.slug', 'Tags.label'])->contain(['Tags'])->toArray();
		$tags = Hash::combine($tags, '{n}.tag.slug', '{n}.tag.label');

		$this->set(compact('posts', 'tags'));
	}

	/**
	 * @return void
	 */
	public function cloud() {
		Configure::write('Tags', [
			'taggedCounter' => false,
			'tagsCounter' => false,
		]);
		$this->loadModel('Sandbox.SandboxCategories');
		$this->SandboxCategories->addBehavior('Tags.Tag');
		//$this->ensureDemoData();

		// Simulated data
		$tags = [
			[
				'id' => 1,
				'weight' => 12,
				'counter' => 2,
				'tag' => [
					'id' => 1,
					'label' => 'Foo',
					'slug' => 'Foo',
				],
			],
			[
				'id' => 2,
				'weight' => 20,
				'counter' => 4,
				'tag' => [
					'id' => 2,
					'label' => 'Bar',
					'slug' => 'Bar',
				],
			],
			[
				'id' => 3,
				'weight' => 8,
				'counter' => 3,
				'tag' => [
					'id' => 3,
					'label' => 'X Y Z',
					'slug' => 'X-Y-Z',
				],
			]
		];

		$this->set(compact('tags'));
	}

	/**
	 * TODO
	 *
	 * @return void
	 */
	protected function ensureDemoData() {
		//$result = $this->SandboxCategories->Tags->find()->toArray();

		$categories = $this->SandboxCategories->find()->all()->toArray();
		foreach ($categories as $category) {

		}
	}

	/**
	 * @return void
	 */
	protected function ensurePostsDemoData() {
		$hasRecords = (bool)$this->SandboxPosts->find()->where(['title' => 'Awesome Post'])->first();
		if ($hasRecords) {
			return;
		}

		$posts = [
			[
				'title' => 'Awesome Post',
				'content' => '...',
				'tag_list' => 'Shiny, New, Interesting',
			],
			[
				'title' => 'Fun Story',
				'content' => '...',
				'tag_list' => 'Hip, Motivating',
			],
			[
				'title' => 'Older Post',
				'content' => '...',
				'tag_list' => 'Detailed, Legacy, Motivating, Long',
			],
			[
				'title' => 'Just a Post',
				'content' => '...',
			],
		];

		$postEntities = $this->SandboxPosts->newEntities($posts);

		$this->SandboxPosts->saveMany($postEntities);
	}

}
