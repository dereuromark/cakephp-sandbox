<?php

namespace Sandbox\Controller;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class ConventionsController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @see http://groups.google.com/group/cake-php/browse_thread/thread/6908dce4d55c1a5d
	 * //TODO
	 * @return void
	 */
	public function index() {
	}

}
