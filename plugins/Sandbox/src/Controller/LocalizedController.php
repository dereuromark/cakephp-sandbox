<?php

namespace Sandbox\Controller;

use Burzum\CakeServiceLayer\Service\ServiceAwareTrait;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Sandbox\Service\Localized\ValidationService $Validation
 */
class LocalizedController extends SandboxAppController {

	use ServiceAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @return void
	 */
	public function index() {
		$this->loadService('Sandbox.Localized/Validation');
		$available = $this->Validation->getAvailable();

		$this->set(compact('available'));
	}

	/**
	 * @return void
	 */
	public function basic() {
		$this->loadService('Sandbox.Localized/Validation');
		$available = $this->Validation->getAvailable();

		if ($this->request->is('post')) {
		}

		$this->set(compact('available'));
	}

}
