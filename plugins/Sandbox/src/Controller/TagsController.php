<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Utility\Hash;

/**
 * @property \Search\Controller\Component\SearchComponent $Search
 * @property \Sandbox\Model\Table\SandboxCategoriesTable $SandboxCategories
 */
class TagsController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Sandbox.SandboxCategories';

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

		$this->loadComponent('Search.Search', [
			'actions' => ['search'],
			'modelClass' => 'Sandbox.SandboxPosts',
		]);
	}

	/**
	 * @return void
	 */
	public function index() {
		$sandboxCategoriesTable = $this->fetchTable();

		/** @var \Sandbox\Model\Entity\SandboxCategory $category */
		$category = $sandboxCategoriesTable->newEmptyEntity();
		if ($this->request->is('post')) {
			$category = $sandboxCategoriesTable->patchEntity($category, $this->request->getData());
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
		$sandboxCategoriesTable = $this->fetchTable();

		$category = $sandboxCategoriesTable->newEmptyEntity();
		if ($this->request->is('post')) {
			$category = $sandboxCategoriesTable->patchEntity($category, $this->request->getData());
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
		$sandboxPostsTable = $this->fetchTable('Sandbox.SandboxPosts');
		$sandboxPostsTable->ensureDemoData();

		$query = $sandboxPostsTable->find('search', search: $this->request->getQuery())->contain(['Tags']);

		$posts = $this->paginate($query);

		$tags = $sandboxPostsTable->Tagged->find()->distinct(['Tags.slug', 'Tags.label'])->contain(['Tags'])->toArray();
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
		$sandboxCategoriesTable = $this->fetchTable();
		$sandboxCategoriesTable->addBehavior('Tags.Tag');
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
			],
		];

		$this->set(compact('tags'));
	}

	/**
	 * @return void
	 */
	public function colors() {
		$sandboxCategoriesTable = $this->fetchTable();
		$sandboxCategoriesTable->addBehavior('Tags.Tag', [
			'inlineColorEditing' => true,
			'taggedCounter' => false,
		]);

		$category = $sandboxCategoriesTable->newEmptyEntity();
		if ($this->request->is('post')) {
			$category = $sandboxCategoriesTable->patchEntity($category, $this->request->getData());
			if (!$category->getErrors()) {
				// We simulate save only
				$this->Flash->success('Tags saved with colors!');

				// Rebuild tag list from entity to show what was parsed
				$tagList = [];
				if ($category->tags) {
					foreach ($category->tags as $tag) {
						$tagString = $tag->label;
						if ($tag->color) {
							$tagString .= '@' . $tag->color;
						}
						$tagList[] = $tagString;
					}
				}
				$category->tag_list = implode(', ', $tagList);
				$this->request = $this->request->withData('tag_list', $category->tag_list);
			} else {
				$this->Flash->error('Could not save tags.');
			}
		} else {
			$category->title = 'My Demo Category';
			$category->tag_list = 'Urgent@red, Feature@blue, Documentation@green';
		}

		// Simulated tags with colors for display
		$tags = [
			[
				'id' => 1,
				'label' => 'Important',
				'slug' => 'important',
				'color' => '#FF5733',
			],
			[
				'id' => 2,
				'label' => 'Feature',
				'slug' => 'feature',
				'color' => '#33C3FF',
			],
			[
				'id' => 3,
				'label' => 'Bug',
				'slug' => 'bug',
				'color' => '#FF3333',
			],
			[
				'id' => 4,
				'label' => 'Documentation',
				'slug' => 'documentation',
				'color' => '#33FF57',
			],
			[
				'id' => 5,
				'label' => 'Enhancement',
				'slug' => 'enhancement',
				'color' => '#9B59B6',
			],
		];

		$this->set(compact('category', 'tags'));
	}

}
