<?php

namespace MenuSandbox\Controller;

use App\Controller\AppController;

/**
 * Showcase for dereuromark/cakephp-menu (the composable menu builder/renderer).
 *
 * The menus are built in the templates (idiomatic, and keeps request/view concerns
 * where they belong). The controller only loads the helper. Every example links to
 * real, existing sandbox pages so there are no dead links and active state lights up
 * as you navigate.
 */
class MenuSandboxController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['Menu.Menu']);
	}

	/**
	 * Real-life navigation: a Bootstrap navbar and a collapsible sidebar of real links,
	 * both with automatic active state.
	 *
	 * @return void
	 */
	public function index(): void {
	}

	/**
	 * Resolvers: visibility and active state driven by request/auth without touching
	 * the menu definition.
	 *
	 * @return void
	 */
	public function resolvers(): void {
	}

	/**
	 * Renderers: the same menu rendered as plain list, Bootstrap 5 markup and JSON.
	 *
	 * @return void
	 */
	public function renderers(): void {
	}

	/**
	 * Advanced: breadcrumbs, array import/export and freeze mode.
	 *
	 * @return void
	 */
	public function advanced(): void {
	}

}
