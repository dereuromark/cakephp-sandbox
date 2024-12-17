<?php

namespace Sandbox\View\Widget;

use Cake\I18n\Time;
use Cake\View\Form\ContextInterface;
use DateTime;

/**
 * Class DateTimeWidget
 *
 * Requires bootstrap clockpicker dependency.
 */
class ClockTimeWidget extends DateTimeWidget {

	/**
	 * Renders a date time widget.
	 *
	 * @param array<string, mixed> $data Data to render with.
	 * @param \Cake\View\Form\ContextInterface $context The current form context.
	 * @throws \RuntimeException When option data is invalid.
	 * @return string A generated select box.
	 */
	public function render(array $data, ContextInterface $context): string {
		if (!empty($data['second'])) {
			$data['type'] = 'time';

			return parent::render($data, $context);
		}

		$value = $data['val'] instanceof Time ? $data['val']->format('H:i') : $data['val'];
		if ($value && !empty($data['required'])) {
			$value = new DateTime();
		}

		$script = '
			jQuery(function() {
				$("#timepicker-' . h($data['id']) . '").clockpicker({
					autoclose: true
				});
			});
		';
		$this->view->Html->scriptBlock($script, ['block' => true]);

		return '
			<div class="input-group date clockpicker" id="timepicker-' . h($data['id']) . '">
				<input type="text" class="form-control" value="' . $value . '" name="' . h($data['name']) . '" />
				<div class="input-group-append">
					<span class="input-group-text"><span class="fa fa-clock-o"></span>
				</div>
			</div>';
	}

}
