<?php

namespace Sandbox\Controller;

use Cake\I18n\FrozenTime;

/**
 * @property \Sandbox\Model\Table\ExposedUsersTable $ExposedUsers
 * @method \Sandbox\Model\Entity\ExposedUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExposeExamplesController extends SandboxAppController {

	/**
	 * @var array
	 */
	public $paginate = [
		'order' => [
			'name' => 'ASC',
		],
		'sortWhitelist' => [
			'name',
		],
	];

	/**
	 * @var string
	 */
	protected $modelClass = 'Sandbox.ExposedUsers';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$config = [
			'actions' => [
				'superimposedIndex',
				'superimposedView',
			],
			'modifyResult' => true,
		];
		$this->loadComponent('Expose.Superimpose', $config);
	}

	/**
	 * List of all examples.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$exposedUsers = $this->ExposedUsers->find('exposedList')->toArray();

		if (!$exposedUsers) {
			// Auto seed based on simple user names
			$exposedUsers = $this->ExposedUsers->newEntities([
				[
					'name' => 'One',
					'created' => new FrozenTime('2019-03-01'),
					'modified' => new FrozenTime('2019-03-01'),
				],
				[
					'name' => 'Two',
					'created' => new FrozenTime('2019-08-01'),
					'modified' => new FrozenTime('2019-08-01'),
				],
				[
					'name' => 'Three',
					'created' => new FrozenTime('2019-10-01'),
					'modified' => new FrozenTime('2019-10-01'),
				],
			]);
			$this->ExposedUsers->saveManyOrFail($exposedUsers);

			return $this->redirect(['action' => 'index']);
		}

		$this->set(compact('exposedUsers'));
	}

	/**
	 * @return void
	 */
	public function users() {
		$exposedUsers = $this->paginate($this->ExposedUsers);

		$this->set(compact('exposedUsers'));
	}

	/**
	 * @param string|null $uuid Exposed UUID.
	 *
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 *@return \Cake\Http\Response|null|void
	 */
	public function view($uuid = null) {
		// Instead of primary key `id` and ->get($id) we work on `uuid` field now for public access
		$field = $this->ExposedUsers->getExposedKey();
		$exposedUser = $this->ExposedUsers->find('exposed', [$field => $uuid])->firstOrFail();

		$this->set('exposedUser', $exposedUser);
	}

	/**
	 * @return void
	 */
	public function superimposedIndex() {
		$exposedUsers = $this->paginate($this->ExposedUsers);

		$this->set(compact('exposedUsers'));
	}

	/**
	 * @param string|null $uuid Exposed UUID.
	 *
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 *@return \Cake\Http\Response|null|void
	 */
	public function superimposedView($uuid = null) {
		// We can reuse the baked code thanks to the uuid being superimposed over the same key
		$exposedUser = $this->ExposedUsers->get($uuid);

		$this->set('exposedUser', $exposedUser);
	}

}