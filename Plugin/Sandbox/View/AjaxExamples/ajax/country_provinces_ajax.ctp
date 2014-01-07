<?php
if (!empty($countryProvinces)) {
	echo '<option value="">' . Configure::read('Select.defaultBefore') . __($defaultFieldLabel) . Configure::read('Select.defaultAfter') . '</option>';
	foreach ($countryProvinces as $k => $v) {
	echo '<option value="' . $k . '">' . h($v) . '</option>';
	}
} else {
	$default = 0;
	if (isset($defaultValue)) {
		$default = $defaultValue;
	}
	echo '<option value="' . $default . '">' . Configure::read('Select.naBefore') . __('noOptionAvailable') . Configure::read('Select.naAfter') . '</option>';
}