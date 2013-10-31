<?php
if (!empty($countryProvinces)) {
	echo '<option value="">' . Configure::read('Select.default_before') . __($defaultFieldLabel) . Configure::read('Select.default_after') . '</option>';
	foreach ($countryProvinces as $k => $v) {
	echo '<option value="' . $k . '">' . h($v) . '</option>';
	}
} else {
	$default = 0;
	if (isset($defaultValue)) {
		$default = $defaultValue;
	}
	echo '<option value="' . $default . '">' . Configure::read('Select.na_before') . __('noOptionAvailable') . Configure::read('Select.na_after') . '</option>';
}
