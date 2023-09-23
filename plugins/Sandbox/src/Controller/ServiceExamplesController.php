<?php

namespace Sandbox\Controller;

use Burzum\CakeServiceLayer\Service\ServiceAwareTrait;

/**
 * @property \Sandbox\Service\Calculator\PostService $Post
 */
class ServiceExamplesController extends SandboxAppController {

	use ServiceAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = '';

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function posts() {
		$posts = [
			'x',
			'y',
			'z',
		];

		// Lets simulate a business class as service "Calculator/PostService"
		$this->loadService('Sandbox.Calculator/Post');
		$result = $this->Post->calculate($posts);

		$this->set(compact('posts', 'result'));
	}

}
