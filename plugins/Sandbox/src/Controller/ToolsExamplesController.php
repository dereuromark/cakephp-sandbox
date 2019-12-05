<?php

namespace Sandbox\Controller;

/**
 * @property \Sandbox\Model\Table\SandboxCategoriesTable $SandboxCategories
 * @property \Sandbox\Model\Table\BitmaskRecordsTable $BitmaskRecords
 * @property \Sandbox\Model\Table\SandboxUsersTable $SandboxUsers
 * @property \App\Model\Table\UsersTable $Users
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class ToolsExamplesController extends SandboxAppController {

	/**
	 * @var string|bool
	 */
	public $modelClass = false;

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
		$this->helpers[] = 'Tools.Tree';

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
	 * //TODO
	 *
	 * @return void
	 */
	public function _bitmasks() {
		$flags = [
			'1' => 'Apple',
			'2' => 'Peach',
			'4' => 'Banana',
			'8' => 'Lemon',
			'16' => 'Coconut',
		];
		$this->loadModel('Sandbox.BitmaskRecords');
		$this->BitmaskRecords->behaviors()->load('Tools.Bitmasked', ['field' => 'flag', 'bits' => $flags]);

		$records = $this->BitmaskRecords->find('all');

		if ($this->request->is('post')) {
		}

		$this->set(compact('records', 'flags'));
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
	public function progress() {
		$value = $this->request->getQuery('value');
		if ($value < 0 || $value > 1) {
			$value = null;
		}

		$length = $this->request->getQuery('length');
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
		$max = $this->request->getQuery('max');
		$min = $this->request->getQuery('min');
		if ($max <= $min) {
			$max = $min = null;
		}

		$length = $this->request->getQuery('length');
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
			switch ($this->request->data['type']) {
				case 'url':
				case 'tel':
				case 'email':
				case 'geo':
				case 'market':
					$result = str_replace([PHP_EOL, "\n"], ' ', $this->request->data['content']);
					break;
				case 'card':
					$result = $this->request->data['Card'];
					$result['birthday'] = $result['birthday']['year'] . '-' . $result['birthday']['month'] . '-' . $result['birthday']['day'];

					break;
				case 'sms':
					$result = [$this->request->data['Sms']['number'], $this->request->data['Sms']['content']];
					break;
				case 'text':
					$result = $this->request->data['content'];
					break;
				default:
					$result = null;
			}
			$this->set(compact('result'));
		}

		$this->set(compact('types'));
		$this->helpers[] = 'Tools.QrCode';
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
	}

	/**
	 * Display a gravatar image.
	 *
	 * @return void
	 */
	public function gravatar() {
		$this->helpers[] = 'Tools.Gravatar';
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
		$this->Common->loadHelper(['Tools.Typography']);
	}

	/**
	 * @return \App\Model\Entity\User
	 */
	protected function getDemoUser() {
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

}
