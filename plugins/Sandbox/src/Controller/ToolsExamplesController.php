<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Exception\NotFoundException;
use RuntimeException;
use Sandbox\Model\Entity\BitmaskedRecord;
use Shim\Datasource\LegacyModelAwareTrait;
use Tools\View\Icon\IconCollection;

/**
 * @property \Sandbox\Model\Table\SandboxCategoriesTable $SandboxCategories
 * @property \Sandbox\Model\Table\BitmaskedRecordsTable $BitmaskedRecords
 * @property \Sandbox\Model\Table\SandboxUsersTable $SandboxUsers
 * @property \App\Model\Table\UsersTable $Users
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 * @property \Tools\Controller\Component\RefererRedirectComponent $RefererRedirect
 * @property \Search\Controller\Component\SearchComponent $Search
 */
#[\AllowDynamicProperties]
class ToolsExamplesController extends SandboxAppController {

	use ModelAwareTrait;
	use LegacyModelAwareTrait;

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
			'modelClass' => 'Tools.BitmaskedRecords',
		]);
	}

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @deprecated Standalone now as https://github.com/ADmad/CakePHP-tree
	 * @return void
	 */
	public function tree() {
		$this->viewBuilder()->addHelpers(['Tools.Tree']);

		$this->loadModel('Sandbox.SandboxCategories');

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

		$entities = $this->SandboxCategories->newEntities($data);
		foreach ($entities as $entity) {
			// Save entity
			$this->SandboxCategories->save($entity);
		}
		*/

		$options = [];
		$tree = $this->SandboxCategories->find('threaded', $options);

		$this->set(compact('tree'));
	}

	/**
	 * @return void
	 */
	public function bitmasks() {
		$this->loadModel('Sandbox.BitmaskedRecords');

		$required = (bool)$this->request->getQuery('required');
		$flags = BitmaskedRecord::flags();
		if (!$required) {
			$field = 'flag_optional';
		} else {
			$field = 'flag_required';
		}

		$config = ['field' => $field, 'bits' => $flags, 'mappedField' => 'flags'];
		$this->BitmaskedRecords->behaviors()->load('Tools.Bitmasked', $config);

		// Just to have demo data
		$records = $this->BitmaskedRecords->find()->all()->toArray();
		$this->autoSeed($records);

		$bitmaskedRecord = $this->BitmaskedRecords->newEmptyEntity();
		if ($this->request->is('post')) {
			$bitmaskedRecord = $this->BitmaskedRecords->patchEntity($bitmaskedRecord, $this->request->getData());

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
		$this->loadModel('Sandbox.BitmaskedRecords');

		$flags = BitmaskedRecord::flags();
		$type = $this->request->getQuery('type') ?: null;
		$config = [
			'field' => 'flag_required',
			'bits' => $flags,
			'mappedField' => 'flags',
			'type' => 'contain', //($type !== 'multiOr' && $type !== 'multiAnd') ? 'contain' : 'exact',
			'containMode' => $type === 'multiAnd' ? 'and' : 'or',
		];
		$this->BitmaskedRecords->behaviors()->load('Tools.Bitmasked', $config);

		$query = $this->BitmaskedRecords->find('search', search: $this->request->getQuery());
		$sql = (string)$query;

		$bitmaskedRecords = $this->paginate($query);

		// Just to have demo data
		if (!$bitmaskedRecords->count()) {
			$records = $this->BitmaskedRecords->find()->all()->toArray();
			$this->autoSeed($records);
		}

		if ($type !== 'multiOr' && $type !== 'multiAnd') {
			$flags[0] = ' - n/a (no flags) - ';
		}
		$this->set(compact('bitmaskedRecords', 'flags', 'type', 'sql'));
	}

	/**
	 * Slugged behavior and ascii unique URL slugs
	 *
	 * @return void
	 */
	public function slug() {
		$this->loadModel('Sandbox.SandboxUsers');
		$this->SandboxUsers->addBehavior('Tools.Slugged', ['mode' => 'ascii', 'unique' => true]);

		$user = $this->SandboxUsers->newEmptyEntity();

		if ($this->request->is(['post', 'put'])) {
			$this->SandboxUsers->patchEntity($user, $this->request->getData());
			if ($this->SandboxUsers->save($user)) {
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
		$this->loadModel('Users');
		$this->Users->addBehavior('Tools.Passwordable');

		$user = $this->Users->newEmptyEntity();

		if ($this->request->is('post')) {
			$this->Users->patchEntity($user, $this->request->getData());
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
		$this->loadModel('Users');
		$user = $this->getDemoUser();

		$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);

		if ($this->request->is(['post', 'patch', 'put'])) {
			$this->Users->patchEntity($user, $this->request->getData());
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
		$this->loadModel('Users');
		$user = $this->getDemoUser();

		$this->Users->addBehavior('Tools.Passwordable', ['require' => false, 'current' => true]);

		$data = $this->request->getData();

		if ($this->request->is(['post', 'patch', 'put'])) {
			$this->Users->patchEntity($user, $data);
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
		$this->loadModel('Sandbox.Animals');
		$this->Animals->getValidator()->remove('confirm');
		$this->Animals->addBehavior('Tools.Confirmable');
		// Bug in CakePHP: You need to manually trigger build on the behavior and pass the validator!
		$this->Animals->behaviors()->Confirmable->build($this->Animals->getValidator());

		$animal = $this->Animals->newEmptyEntity();

		if ($this->request->is('post')) {
			$animal = $this->Animals->patchEntity($animal, $this->request->getData());

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
		$this->loadModel('Sandbox.SandboxUsers');

		$entity = $this->SandboxUsers->newEmptyEntity();
		$validator = $this->SandboxUsers->getValidator();
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
			$entity = $this->SandboxUsers->patchEntity($entity, $this->request->getData());
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
	public function qr() {
		$types = [
			'text' => 'Text',
			'url' => 'Url',
			'tel' => 'Phone Number',
			'sms' => 'Text message',
			'email' => 'E-Mail',
			'geo' => 'Geo',
			'market' => 'Market',
			'card' => 'Vcard',
		];

		if ($this->request->is('post')) {
			switch ($this->request->getData('type')) {
				case 'url':
				case 'tel':
				case 'email':
				case 'geo':
				case 'market':
					$result = str_replace([PHP_EOL, "\n"], ' ', $this->request->getData('content'));

					break;
				case 'card':
					$result = $this->request->getData('Card');
					$result['birthday'] = $result['birthday']['year'] . '-' . $result['birthday']['month'] . '-' . $result['birthday']['day'];

					break;
				case 'sms':
					$result = [$this->request->getData('Sms.number'), $this->request->getData('Sms.content')];

					break;
				case 'text':
					$result = $this->request->getData('content');

					break;
				default:
					$result = null;
			}
			$this->set(compact('result'));
		}

		$this->set(compact('types'));
		$this->viewBuilder()->addHelpers(['Tools.QrCode']);
	}

	/**
	 * @return void
	 */
	public function formatHelper() {
	}

	/**
	 * @return void
	 */
	public function icons() {
	}

	/**
	 * @param string|null $name
	 *
	 * @return void
	 */
	public function iconSets(?string $name = null) {
		$config = (array)Configure::read('Icon');
		if (!$name || !isset($config['sets'][$name])) {
			throw new NotFoundException('No such icon set');
		}

		$config['sets'] = [
			$name => $config['sets'][$name],
		];

		$icons = (new IconCollection($config))->names();
		$this->set(compact('icons', 'name'));
	}

	/**
	 * Display a dynamic timeline.
	 *
	 * @return void
	 */
	public function timeline() {
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
		$this->loadModel('Sandbox.SandboxCategories');
		$this->SandboxCategories->getValidator()->add('description', 'notBlank', ['rule' => 'notBlank']);

		$sandboxCategory = $this->SandboxCategories->newEmptyEntity();

		if ($this->request->is('post')) {
			$sandboxCategory = $this->SandboxCategories->patchEntity($sandboxCategory, $this->request->getData());
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
		/** @var \App\Model\Entity\User|null $user */
		$user = $this->Users->find()->where(['username' => 'demo'])->first();
		if ($user) {
			return $user;
		}

		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$data = [
			'username' => 'demo',
			'email' => 'demo@demo.de',
			'pwd' => 'demo123',
		];
		$user = $this->Users->newEntity($data);
		$this->Users->saveOrFail($user);

		$this->Users->removeBehavior('Passwordable');

		return $user;
	}

	/**
	 * @param array<\Sandbox\Model\Entity\BitmaskedRecord> $records
	 *
	 * @return void
	 */
	protected function autoSeed(array $records): void {
		if (!$records) {
			$records = [];
			$records[] = $this->BitmaskedRecords->newEntity([
				'name' => 'Careful',
				'flag_optional' => BitmaskedRecord::STATUS_FLAGGED,
				'flag_required' => BitmaskedRecord::STATUS_FLAGGED,
			]);
			$records[] = $this->BitmaskedRecords->newEntity([
				'name' => 'I am promoted',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED,
			]);
			$records[] = $this->BitmaskedRecords->newEntity([
				'name' => 'I am a bit more important',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT,
			]);
			$records[] = $this->BitmaskedRecords->newEntity([
				'name' => 'I have no flags',
				'flag_optional' => 0,
				'flag_required' => 0,
			]);
			$records[] = $this->BitmaskedRecords->newEntity([
				'name' => 'I am everything',
				'flag_optional' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT | BitmaskedRecord::STATUS_FLAGGED,
				'flag_required' => BitmaskedRecord::STATUS_APPROVED | BitmaskedRecord::STATUS_FEATURED | BitmaskedRecord::STATUS_IMPORTANT | BitmaskedRecord::STATUS_FLAGGED,
			]);

			$this->BitmaskedRecords->saveManyOrFail($records);

			throw new RuntimeException('Auto Seed done, please refresh page.');
		}
	}

}
