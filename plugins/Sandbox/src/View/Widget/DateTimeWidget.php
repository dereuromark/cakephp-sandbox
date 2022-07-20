<?php

namespace Sandbox\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\StringTemplate;
use Cake\View\View;
use Cake\View\Widget\BasicWidget;
use DateTime;
use DateTimeInterface;

/**
 * Class DateTimeWidget
 *
 * Requires bootstrap datetimepicker and moment (localisation) JS dependencies.
 */
class DateTimeWidget extends BasicWidget {

	/**
	 * @var \Cake\View\View
	 */
	protected $view;

	/**
	 * @param \Cake\View\StringTemplate $templates Templates list.
	 * @param \Cake\View\View $view
	 */
	public function __construct(StringTemplate $templates, View $view) {
		parent::__construct($templates);

		$this->view = $view;
	}

	/**
	 * Renders a date time widget.
	 *
	 * @param array<string, mixed> $data Data to render with.
	 * @param \Cake\View\Form\ContextInterface $context The current form context.
	 * @throws \RuntimeException When option data is invalid.
	 * @return string A generated select box.
	 */
	public function render(array $data, ContextInterface $context): string {
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

		$value = $data['val'] && ($data['val'] instanceof DateTimeInterface) ? $data['val']->format($displayFormat) : '';
		if ($value && !empty($data['required'])) {
			$value = (new DateTime())->format($displayFormat);
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
				<div class="input-group-append">
					<span class="input-group-text"><span class="fa fa-calendar"></span>
				</div>
			</div>';
	}

}
