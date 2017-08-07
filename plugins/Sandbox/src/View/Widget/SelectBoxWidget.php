<?php
namespace Sandbox\View\Widget;

use BootstrapUI\View\Helper\OptionsAwareTrait;
use Cake\View\Form\ContextInterface;
use Cake\View\Widget\SelectBoxWidget as CoreSelectBoxWidget;

/**
 * Select Widget
 */
class SelectBoxWidget extends CoreSelectBoxWidget {

	use OptionsAwareTrait;

	/**
	 * Renders a select.
	 *
	 * @param array $data The data to build a select with.
	 * @param \Cake\View\Form\ContextInterface $context The current form context.
	 * @return string
	 */
	public function render(array $data, ContextInterface $context) {
		return parent::render($this->injectClasses('form-control', $data), $context);
	}

}
