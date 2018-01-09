<?php
/**
 * @var \App\View\AppView $this
 */
if ($states) {
	echo '<option value="">' . Configure::read('Select.defaultBefore') . __('pleaseSelect') . Configure::read('Select.defaultAfter') . '</option>';
	foreach ($states as $k => $v) {
		echo '<option value="' . $k . '">' . h($v) . '</option>';
	}
} else {
	echo '<option value="0">' . Configure::read('Select.naBefore') . __('noOptionAvailable') . Configure::read('Select.naAfter') . '</option>';
}
