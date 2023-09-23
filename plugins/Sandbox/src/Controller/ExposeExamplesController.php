<?php

namespace Sandbox\Controller;

use Cake\Database\TypeFactory;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenTime;
use Expose\Database\Type\ShortUuidType;

/**
 * @property \Sandbox\Model\Table\ExposedUsersTable $ExposedUsers
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\ExposedUser> paginate($object = null, array $settings = [])
 * @property \Expose\Controller\Component\SuperimposeComponent $Superimpose
 */
class ExposeExamplesController extends SandboxAppController {

	/**
	 * @var array<string, mixed>
	 */
	public array $paginate = [
		'order' => [
			'name' => 'ASC',
		],
		'sortableFields' => [
			'name',
		],
	];

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Sandbox.ExposedUsers';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if ($this->request->getQuery('short') !== null) {
			$this->request->getSession()->write('Expose.short', (bool)$this->request->getQuery('short'));
		}
		if ($this->request->getSession()->read('Expose.short')) {
			TypeFactory::map('binaryuuid', ShortUuidType::class);
		}

		$config = [
			'actions' => [
				'superimposedIndex',
				'superimposedView',
				'superimposedEdit',
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
		if (!$uuid) {
			throw new NotFoundException();
		}

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

	/**
	 * @param string|null $uuid Exposed UUID.
	 *
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 *@return \Cake\Http\Response|null|void
	 */
	public function superimposedEdit($uuid = null) {
		// We can reuse the baked code thanks to the uuid being superimposed over the same key
		$exposedUser = $this->ExposedUsers->get($uuid);

		if ($this->request->is(['post', 'put'])) {
			$exposedUser = $this->ExposedUsers->patchEntity($exposedUser, $this->request->getData(), ['fields' => 'some_field']);
			if (!$exposedUser->getErrors()) {
				$this->Flash->success('OK');

				return $this->redirect(['action' => 'superimposedView', $exposedUser->id]);
			}

			$this->Flash->error('Validation errors');
		}

		$this->set('exposedUser', $exposedUser);
	}

}
