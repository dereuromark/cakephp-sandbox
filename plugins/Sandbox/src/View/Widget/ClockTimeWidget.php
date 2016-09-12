<?php
namespace Sandbox\View\Widget;

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
	 * @param array $data Data to render with.
	 * @param \Cake\View\Form\ContextInterface $context The current form context.
	 * @return string A generated select box.
	 * @throws \RuntimeException When option data is invalid.
	 */
	public function render(array $data, ContextInterface $context) {
		if (!empty($data['second'])) {
			$data['type'] = 'time';
			return parent::render($data, $context);
		}

		$value = $data['val'] ? $data['val']->format('H:i') : '';
		if ($value && !empty($data['required'])) {
			$value = new DateTime();
		}

		return '
            <div class="input-group date clockpicker" id="timepicker-' . h($data['id']) . '">
				<input type="text" class="form-control" value="' . $value . '" name="' . h($data['name']) . '" />
				<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
			</div>

            <script type="text/javascript">
            jQuery(function() {
                $("#timepicker-' . h($data['id']) . '").clockpicker({
                    autoclose: true
                });
            });
            </script>';
	}

}
