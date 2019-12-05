<?php

namespace Sandbox\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\View;
use Cake\View\Widget\BasicWidget;
use DateTime;

/**
 * Class DateTimeWidget
 *
 * Requires bootstrap datetimepicker and moment (localisation) js dependencies.
 */
class DateTimeWidget extends BasicWidget {

	/**
	 * @var \App\View\AppView
	 */
	protected $view;

	/**
	 * @param \Cake\View\StringTemplate $templates Templates list.
	 * @param \Cake\View\View $view
	 */
	public function __construct($templates, View $view) {
		parent::__construct($templates);

		$this->view = $view;
	}

	/**
	 * Renders a date time widget.
	 *
	 * @param array $data Data to render with.
	 * @param \Cake\View\Form\ContextInterface $context The current form context.
	 * @return string A generated select box.
	 * @throws \RuntimeException When option data is invalid.
	 */
	public function render(array $data, ContextInterface $context) {
		$format = 'DD.MM.YYYY HH:mm';
		if (!isset($data['second']) || $data['second']) {
			$format .= ':ss';
		}

		if ($data['type'] === 'date') {
			$format = 'DD.MM.YYYY';
		}
		if ($data['type'] === 'time') {
			$format = 'HH:mm';
			if (!isset($data['second']) || $data['second']) {
				$format .= ':ss';
			}
		}

		$displayFormat = 'd.m.Y H:i:s';
		if (!isset($data['second']) || $data['second']) {
			$displayFormat .= ':s';
		}

		if ($data['type'] === 'date') {
			$displayFormat = 'd.m.Y';
		}
		if ($data['type'] === 'time') {
			$displayFormat = 'H:i';
			if (!isset($data['second']) || $data['second']) {
				$displayFormat .= ':s';
			}
		}

		$value = $data['val'] ? $data['val']->format($displayFormat) : '';
		if ($value && !empty($data['required'])) {
			$value = new DateTime();
		}

		$id = $data['id'];

		$script = '
			jQuery(function() {
				$("#datetimepicker-' . h($id) . '").datetimepicker({
					sideBySide: true,
					showTodayButton: true,
					' . (empty($data['required']) ? 'showClear: true,' : '') . '
					showClose: true,
					calendarWeeks: true,
					format: \'' . $format . '\'
					//locale: \'de\'
				});
			});
		';
		$this->view->Html->scriptBlock($script, ['block' => true]);

		return '
			<div class="input-group date" id="datetimepicker-' . h($id) . '">
				<input type="text" class="form-control" value="' . $value . '" name="' . h($data['name']) . '" />
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
			</div>';
	}

}
