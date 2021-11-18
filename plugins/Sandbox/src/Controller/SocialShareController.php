<?php

namespace Sandbox\Controller;

class SocialShareController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['SocialShare.SocialShare']);
	}

	/**
	 * @return void
	 */
	public function index() {
	}

}
