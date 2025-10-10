<?php

namespace Sandbox\Controller;

use Cake\Event\EventInterface;
use RuntimeException;
use Sandbox\Model\Entity\BitmaskedRecord;
use Sandbox\Model\Enum\Flag;
use Tools\I18n\Date;
use Tools\Model\Entity\Entity;

/**
 * @property \Tools\Controller\Component\RefererRedirectComponent $RefererRedirect
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class ToolsExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();
		$this->loadComponent('Tools.RefererRedirect', [
			'actions' => ['fakeEdit'],
		]);

		$this->loadComponent('Search.Search', [
			'actions' => ['bitmaskSearch'],
			'queryStringWhitelist' => ['type'],
			'modelClass' => 'Sandbox.BitmaskedRecords',
		]);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		// Only to demo the difference of trim vs notrim in CommonComponent
		if ($this->request->getQuery('notrim')) {
			$this->Common->setConfig('notrim', true);
		}
	}

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return void
	 */
	public function trim() {
		$sandboxCategoriesTable = $this->fetchTable('Sandbox.SandboxCategories');
		$sandboxCategory = $sandboxCategoriesTable->newEmptyEntity();

		if ($this->request->getQuery('key')) {
			$key = $this->request->getQuery('key');
			$this->Flash->success(__d('sandbox', 'Query string value is `{0}`', $key));
		}

		if ($this->request->is(['post', 'put'])) {
			$sandboxCategory = $sandboxCategoriesTable->patchEntity($sandboxCategory, $this->request->getData());
			if ($sandboxCategory->hasErrors()) {
				$this->Flash->error(__d('sandbox', 'Posted value is not yet valid, please fix the form.'));
			} else {
				$this->Flash->success(__d('sandbox', 'Posted value is `{0}`', $sandboxCategory->name));
			}
		}

		$this->set(compact('sandboxCategory'));
	}

	/**
	 * @deprecated Standalone now as https://github.com/ADmad/CakePHP-tree
	 * @return void
	 */
	public function tree() {
		$this->viewBuilder()->addHelpers(['Tools.Tree']);

		$sandboxCategoriesTable = $this->fetchTable('Sandbox.SandboxCategories');

		// Example data added:
		/*
		$data = [
			[
				'name' => 'Alpha',
				'description' => 'First One'
			],
			[
				'name' => 'Beta',
				'description' => 'Second One'
			],
			[
				'name' => 'Gamma',
				'description' => 'Third One'
			],
			[
				'name' => 'Delta',
				'description' => 'Forth One'
			],
			[
				'name' => 'Child of 2nd one',
				'parent_id' => 2,
				'description' => 'Fifth One'
			],
			[
				'name' => 'Child of child',
				'parent_id' => 5,
				'description' => 'Sixth One'
			],
			[
				'name' => 'Child of 4th one',
				'parent_id' => 4,
				'description' => 'Seventh One'
			],
		];

		$entities = $sandboxCategoriesTable->newEntities($data);
		foreach ($entities as $entity) {
			// Save entity
			$sandboxCategoriesTable->save($entity);
		}
		*/

		$options = [];
		$tree = $sandboxCategoriesTable->find('threaded', $options);

		$this->set(compact('tree'));
	}

	/**
	 * @return void
	 */
	public function bitmasks() {
		$bitmaskedRecordsTable = $this->fetchTable('Sandbox.BitmaskedRecords');

		$required = (bool)$this->request->getQuery('required');
		$flags = BitmaskedRecord::flags();
		if (!$required) {
			$field = 'flag_optional';
		} else {
			$field = 'flag_required';
		}

		$config = ['field' => $field, 'bits' => $flags, 'mappedField' => 'flags'];
		$bitmaskedRecordsTable->behaviors()->load('Tools.Bitmasked', $config);

		$records = $bitmaskedRecordsTable->find()->all()->toArray();
		// Just to have demo data
		$this->autoSeed($records);

		$bitmaskedRecord = $bitmaskedRecordsTable->newEmptyEntity();
		if ($this->request->is('post')) {
			$bitmaskedRecord = $bitmaskedRecordsTable->patchEntity($bitmaskedRecord, $this->request->getData());

			if ($bitmaskedRecord->getErrors()) {
				$this->Flash->error(__('Form contains errors'));

				$bitmaskedRecord->setError('flags', $bitmaskedRecord->getError($field));

			} else {
				$message = 'Flag value `' . $bitmaskedRecord->$field . '` would now be stored.';
				$this->Flash->success($message);
			}
		}

		$this->set(compact('field', 'records', 'flags', 'bitmaskedRecord', 'required'));
	}

	/**
	 * @return void
	 */
	public function bitmaskSearch() {
		$bitmaskedRecordsTable = $this->fetchTable('Sandbox.BitmaskedRecords');

		$flags = BitmaskedRecord::flags();
		$type = $this->request->getQuery('type') ?: null;
		$config = [
			'field' => 'flag_required',
			'bits' => $flags,
			'mappedField' => 'flags',
			'type' => 'contain', //($type !== 'multiOr' && $type !== 'multiAnd') ? 'contain' : 'exact',
			'containMode' => $type === 'multiAnd' ? 'and' : 'or',
		];
		$bitmaskedRecordsTable->behaviors()->load('Tools.Bitmasked', $config);

		$query = $bitmaskedRecordsTable->find('search', search: $this->request->getQuery());
		$sql = (string)$query;

		$bitmaskedRecords = $this->paginate($query);

		// Just to have demo data
		if (PHP_SAPI !== 'cli' && !$bitmaskedRecords->count()) {
			$records = $bitmaskedRecordsTable->find()->all()->toArray();
			$this->autoSeed($records);
		}

		if ($type !== 'multiOr' && $type !== 'multiAnd') {
			$flags[0] = ' - n/a (no flags) - ';
		}
		$this->set(compact('bitmaskedRecords', 'flags', 'type', 'sql'));
	}

	/**
	 * @return void
	 */
	public function bitmaskEnums() {
		$bitmaskedRecordsTable = $this->fetchTable('Sandbox.BitmaskedRecords');

		$required = (bool)$this->request->getQuery('required');
		if (!$required) {
			$field = 'flag_optional';
		} else {
			$field = 'flag_required';
		}

		$config = ['field' => $field, 'bits' => Flag::class, 'mappedField' => 'flags'];
		$bitmaskedRecordsTable->behaviors()->load('Tools.Bitmasked', $config);

		$records = $bitmaskedRecordsTable->find()->all()->toArray();
		// Just to have demo data
		$this->autoSeed($records);

		$bitmaskedRecord = $bitmaskedRecordsTable->newEmptyEntity();
		if ($this->request->is('post')) {
			$bitmaskedRecord = $bitmaskedRecordsTable->patchEntity($bitmaskedRecord, $this->request->getData());

			if ($bitmaskedRecord->getErrors()) {
				$this->Flash->error(__('Form contains errors'));

				$bitmaskedRecord->setError('flags', $bitmaskedRecord->getError($field));

			} else {
				$message = 'Flag value `' . $bitmaskedRecord->$field . '` would now be stored.';
				$this->Flash->success($message);
			}
		}

		$flags = $bitmaskedRecordsTable->behaviors()->Bitmasked->getConfig('bits');
		$this->set(compact('field', 'records', 'flags', 'bitmaskedRecord', 'required'));
	}

	/**
	 * Slugged behavior and ascii unique URL slugs
	 *
	 * @return void
	 */
	public function slug() {
		$sandboxUsersTable = $this->fetchTable('Sandbox.SandboxUsers');
		$sandboxUsersTable->addBehavior('Tools.Slugged', ['mode' => 'ascii', 'unique' => true]);

		$user = $sandboxUsersTable->newEmptyEntity();

		if ($this->request->is(['post', 'put'])) {
			$sandboxUsersTable->patchEntity($user, $this->request->getData());
			if ($sandboxUsersTable->save($user)) {
				$this->Flash->success('Yeah! Saved!');
			} else {
				$this->Flash->error('Please correct your form.');
			}
		}

		$this->set(compact('user'));
	}

	/**
	 * @return void
	 */
	public function password() {
		$usersTable = $this->fetchTable('Users');
		$usersTable->addBehavior('Tools.Passwordable');

		$user = $usersTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$usersTable->patchEntity($user, $this->request->getData());
			if (!$user->getErrors()) {
				$this->Flash->success('Yeah! Saved!');
			} else {
				$this->Flash->error('Please correct your form.');
			}
		}

		$this->set(compact('user'));
	}

	/**
	 * @return void
	 */
	public function passwordEdit() {
		$usersTable = $this->fetchTable('Users');
		$user = $this->getDemoUser();

		$usersTable->addBehavior('Tools.Passwordable', ['require' => false]);

		if ($this->request->is(['post', 'patch', 'put'])) {
			$usersTable->patchEntity($user, $this->request->getData());
			if (!$user->getErrors()) {
				$this->Flash->success('Yeah! Saved!');
			} else {
				$this->Flash->error('Please correct your form.');
			}
		}

		$this->set(compact('user'));
		$this->render('password');
	}

	/**
	 * @return void
	 */
	public function passwordEditCurrent() {
		$usersTable = $this->fetchTable('Users');
		$user = $this->getDemoUser();

		$usersTable->addBehavior('Tools.Passwordable', ['require' => false, 'current' => true]);

		$data = $this->request->getData();

		if ($this->request->is(['post', 'patch', 'put'])) {
			$usersTable->patchEntity($user, $data);
			if (!$user->getErrors()) {
				$this->Flash->success('Yeah! Saved!');
			} else {
				$this->Flash->error('Please correct your form.');
			}
		}

		$this->set(compact('user'));
	}

	/**
	 * Test validation on marshal and rules on save.
	 *
	 * @return void
	 */
	public function confirmable() {
		$animalsTable = $this->fetchTable('Sandbox.Animals');
		$animalsTable->getValidator()->remove('confirm');
		$animalsTable->addBehavior('Tools.Confirmable');
		// Bug in CakePHP: You need to manually trigger build on the behavior and pass the validator!
		$animalsTable->behaviors()->Confirmable->build($animalsTable->getValidator());

		$animal = $animalsTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$animal = $animalsTable->patchEntity($animal, $this->request->getData());

			// Simulate $Animals->save($animal) call as we dont't want to really save here
			if (!$animal->getErrors()) {
				$this->Flash->success('Yeah, you are allowed to continue!');
			} else {
				$this->Flash->error('Please correct your form content!');
			}
		}

		$this->set(compact('animal'));
	}

	/**
	 * @return void
	 */
	public function datetime() {
		$sandboxUsersTable = $this->fetchTable('Sandbox.SandboxUsers');

		$entity = $sandboxUsersTable->newEmptyEntity();
		$validator = $sandboxUsersTable->getValidator();
		$validator->add('from', 'date');
		$validator->add('to', [
			'date' => [
				'rule' => 'date',
			],
			'validateDate' => [
				'rule' => ['validateDate', ['after' => 'from']],
				'provider' => 'table',
				'message' => '"to" must be after "from"',
			],
		]);

		if ($this->Common->isPosted()) {
			$entity = $sandboxUsersTable->patchEntity($entity, $this->request->getData());
			if ($entity->getErrors()) {
				$this->Flash->error('Not valid');
			} else {
				$this->Flash->success('Valid');
			}
		}

		$this->set(compact('entity'));
	}

	/**
	 * @return void
	 */
	public function progress() {
		$value = (int)$this->request->getQuery('value');
		if ($value < 0 || $value > 1) {
			$value = null;
		}

		$length = (int)$this->request->getQuery('length');
		if ($length < 3 || $length > 60) {
			$length = null;
		}

		$this->set(compact('value', 'length'));
	}

	/**
	 * @return void
	 */
	public function meter() {
		$value = $this->request->getQuery('value');
		$max = (int)$this->request->getQuery('max');
		$min = (int)$this->request->getQuery('min');
		if ($max <= $min) {
			$max = $min = null;
		}

		$length = (int)$this->request->getQuery('length');
		if ($length < 3 || $length > 60) {
			$length = null;
		}

		$overflow = (bool)$this->request->getQuery('overflow');

		$this->set(compact('value', 'max', 'min', 'length', 'overflow'));
	}

	/**
	 * @return void
	 */
	public function formatHelper() {
	}

	/**
	 * Display a dynamic timeline.
	 *
	 * @return void
	 */
	public function timeline() {
		$firstNames = [
			'Anna', 'Ben', 'Clara', 'David', 'Emma', 'Felix', 'Greta', 'Henry', 'Isabel', 'Jonas',
			'Klara', 'Leo', 'Mia', 'Noah', 'Olivia', 'Paul', 'Quentin', 'Rosa', 'Sophia', 'Tim',
		];

		$event = new Entity([
			'name' => 'Some cool event',
			'from' => (new Date())->addDays(3),
			'to' => (new Date())->addDays(6),
		]);
		$attendees = [];
		for ($i = 0; $i < 7; $i++) {
			$randomIndex = array_rand($firstNames);
			$attendees[] = new Entity([
				'name' => $firstNames[$randomIndex],
				'role' => $i % 3 === 0 ? 'speaker' : 'attendee',
				'from' => (new Date())->addDays(3 + mt_rand(-2, 2)),
				'to' => (new Date())->addDays(7 + mt_rand(-1, 2)),
			]);
		}

		$this->set(compact('event', 'attendees'));
	}

	/**
	 * @return void
	 */
	public function redirectTest() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function fakeEdit() {
		$sandboxCategoriesTable = $this->fetchTable('Sandbox.SandboxCategories');
		$sandboxCategoriesTable->getValidator()->add('description', 'notBlank', ['rule' => 'notBlank']);

		$sandboxCategory = $sandboxCategoriesTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$sandboxCategory = $sandboxCategoriesTable->patchEntity($sandboxCategory, $this->request->getData());
			if (!$sandboxCategory->getErrors()) {
				$this->Flash->success('OK');

				return $this->redirect(['action' => 'redirectTest']); // Note the missing query strings here for the default
			}
		}

		$this->set((compact('sandboxCategory')));
	}

	/**
	 * Display a gravatar image.
	 *
	 * @return void
	 */
	public function gravatar() {
		$this->viewBuilder()->addHelpers(['Tools.Gravatar']);
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _diff() {
	}

	/**
	 * @return void
	 */
	public function typography() {
		$this->viewBuilder()->addHelper('Tools.Typography');
	}

	/**
	 * @return \App\Model\Entity\User
	 */
	protected function getDemoUser() {
		$usersTable = $this->fetchTable('Users');

		/** @var \App\Model\Entity\User|null $user */
		$user = $usersTable->find()->where(['username' => 'demo'])->first();
		if ($user) {
			return $user;
		}

		$usersTable->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$data = [
			'username' => 'demo',
			'email' => 'demo@demo.de',
			'pwd' => 'demo123',
		];
		$user = $usersTable->newEntity($data);
		$usersTable->saveOrFail($user);

		$usersTable->removeBehavior('Passwordable');

		return $user;
	}

	/**
	 * @param array<\Sandbox\Model\Entity\BitmaskedRecord> $records
	 *
	 * @return void
	 */
	protected function autoSeed(array $records): void {
		if (PHP_SAPI !== 'cli' && !$records) {
			$bitmaskedRecordsTable = $this->fetchTable('Sandbox.BitmaskedRecords');
			$records = [];
			$records[] = $bitmaskedRecordsTable->newEntity([
				'name' => 'Careful',
				'flag_optional' => BitmaskedRecord::STATUS_FLAGGED,
				'flag_required' => BitmaskedRecord::STATUS_FLAGGED,
			]);
			$records[] = $bitmaskedRecordsTable->newEntity([
				'name' => 'I am promoted',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED,
			]);
			$records[] = $bitmaskedRecordsTable->newEntity([
				'name' => 'I am a bit more important',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT,
			]);
			$records[] = $bitmaskedRecordsTable->newEntity([
				'name' => 'I have no flags',
				'flag_optional' => 0,
				'flag_required' => 0,
			]);
			$records[] = $bitmaskedRecordsTable->newEntity([
				'name' => 'I am everything',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT | BitmaskedRecord::STATUS_FLAGGED,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT | BitmaskedRecord::STATUS_FLAGGED,
			]);

			$bitmaskedRecordsTable->saveManyOrFail($records);

			throw new RuntimeException('Auto Seed done, please refresh page.');
		}
	}

}
