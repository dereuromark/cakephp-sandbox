<?php

namespace App\Controller;

use App\Dto\RoleProjectionDto;
use App\Dto\UserProjectionDto;
use Sandbox\Dto\SandboxUserProjectionDto;

class MiscController extends AppController {

	/**
	 * @var array<string>
	 */
	protected $types = [
		'1' => 'html encode',
		'2' => 'html decode',
		'3' => 'entity encode',
		'4' => 'entity decode',
		'5' => 'indent',
		'6' => 'outdent',
	];

	/**
	 * Overview
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function convertText() {
		if ($this->Common->isPosted()) {
			$data = $this->request->getData();
			$data['Form']['result'] = $this->_process($data['Form']['text'], $data['Form']['type']);
			if (array_key_exists((string)$data['Form']['type'], $this->types)) {
				$this->Flash->success($this->types[(string)$data['Form']['type']] . ' done');
			} else {
				$this->Flash->warning($this->types[(string)$data['Form']['type']] . ' not successful');
			}
		}

		$types = $this->types;
		$this->set(compact('types'));
	}

	/**
	 * @param string $text
	 * @param string|int|null $type
	 *
	 * @return string
	 */
	protected function _process($text, $type = null) {
		if (!$type) {
			# auto detect
			$type = $this->_autoDetect($text);
			//$data['Form']['type'] = $type;
			//return $text;
		}

		switch ($type) {
			case '1':
				$text = h($text);

				break;
			case '2':
				$text = hDec($text);

				break;
			case '3':
				$text = ent($text);

				break;
			case '4':
				$text = entDec($text);

				break;
			case '5':
				$pieces = explode(NL, $text) ?: [];
				foreach ($pieces as $key => $val) {
					$pieces[$key] = TB . $val;
				}
				$text = implode(NL, $pieces);

				break;
			case '6':
				$pieces = explode(NL, $text) ?: [];
				foreach ($pieces as $key => $val) {
					$pieces[$key] = mb_substr($val, 0, 1) === TB ? mb_substr($val, 1) : $val;
				}
				$text = implode(NL, $pieces);

				break;
		}

		return $text;
	}

	/**
	 * @param string $text
	 *
	 * @return int
	 */
	protected function _autoDetect($text) {
		if (mb_strpos($text, '&gt;') !== false || mb_strpos($text, '&lt;') || mb_strpos($text, '&amp;') || mb_strpos($text, '&quot;')) { // || mb_strpos($text, '&#39;')
			return 2;
		}

		return 1;
	}

	/**
	 * Test DTO projection with BelongsTo association.
	 *
	 * @return void
	 */
	public function dtoProjection(): void {
		$usersTable = $this->fetchTable('Users');

		// Test 1: Simple projection (no associations)
		$simpleUsers = $usersTable->find()
			->projectAs(UserProjectionDto::class)
			->limit(3)
			->all()
			->toArray();

		// Test 2: Projection with BelongsTo (Users -> Roles)
		$usersWithRoles = $usersTable->find()
			->contain(['Roles'])
			->projectAs(UserProjectionDto::class)
			->limit(3)
			->all()
			->toArray();

		// Test 3: Projection with HasMany (Roles -> Users)
		$rolesTable = $this->fetchTable('Roles');
		$rolesWithUsers = $rolesTable->find()
			->contain(['Users'])
			->projectAs(RoleProjectionDto::class)
			->limit(3)
			->all()
			->toArray();

		// Test 4: Compare with Entity hydration
		$usersAsEntities = $usersTable->find()
			->contain(['Roles'])
			->limit(3)
			->all()
			->toArray();

		// Test 5: Compare with disableHydration (raw arrays)
		$usersAsArrays = $usersTable->find()
			->contain(['Roles'])
			->disableHydration()
			->limit(3)
			->all()
			->toArray();

		// Test 6: Projection with enum field (SandboxUsers -> UserStatus enum)
		$sandboxUsersTable = $this->fetchTable('Sandbox.SandboxUsers');
		$sandboxUsers = $sandboxUsersTable->find()
			->projectAs(SandboxUserProjectionDto::class)
			->limit(5)
			->all()
			->toArray();

		// Test 7: Entity hydration with enum (comparison)
		$sandboxUsersAsEntities = $sandboxUsersTable->find()
			->limit(5)
			->all()
			->toArray();

		$this->set(compact(
			'simpleUsers',
			'usersWithRoles',
			'rolesWithUsers',
			'usersAsEntities',
			'usersAsArrays',
			'sandboxUsers',
			'sandboxUsersAsEntities',
		));
	}

}
