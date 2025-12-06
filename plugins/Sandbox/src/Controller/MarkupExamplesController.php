<?php

namespace Sandbox\Controller;

class MarkupExamplesController extends SandboxAppController {

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
	public function markup() {
	}

	/**
	 * @return void
	 */
	public function markdown() {
		$this->viewBuilder()->addHelper('Markup.Markdown');
	}

	/**
	 * @return void
	 */
	public function bbcode() {
		$this->viewBuilder()->addHelper('Markup.Bbcode');
	}

	/**
	 * Djot markup examples using DjotHelper.
	 *
	 * @return void
	 */
	public function djot() {
		$this->viewBuilder()->addHelper('Markup.Djot');
	}

	/**
	 * Djot markup using DjotView (renders .djot files directly).
	 *
	 * @return void
	 */
	public function djotView() {
		$this->viewBuilder()->setClassName('Markup.Djot');
		$this->viewBuilder()->disableAutoLayout();

		// We as admins know the template is safe and can render raw HTML
		$this->viewBuilder()->setOption('safeMode', false);

		$this->set('title', 'Djot View Demo');
		$this->set('features', ['Fast parsing', 'Safe mode', 'Profile support']);
	}

}
