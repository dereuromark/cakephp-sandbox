<?php
namespace Sandbox\Controller;

use Cake\Core\Configure;

/**
 * @property \Sandbox\Model\Table\SandboxCategoriesTable $SandboxCategories
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
		$uid = $this->request->session()->read('Tmp.User.id');
		if (!$uid) {
			$uid = time();
			$this->request->session()->write('Tmp.User.id', $uid);
		}
	}

	/**
	 * @return void
	 */
	public function index() {
		$this->loadModel('Sandbox.SandboxCategories');

		$category = $this->SandboxCategories->newEntity();
		if ($this->request->is('post')) {
			$category = $this->SandboxCategories->patchEntity($category, $this->request->data);
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

		$category = $this->SandboxCategories->newEntity();
		if ($this->request->is('post')) {
			$category = $this->SandboxCategories->patchEntity($category, $this->request->data);
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
	public function cloud() {
		Configure::write('Tags', [
			'taggedCounter' => false,
			'tagsCounter' => false,
		]);
		$this->loadModel('Sandbox.SandboxCategories');
		$this->SandboxCategories->addBehavior('Tags.Tag');
		$this->ensureDemoData();

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

}
