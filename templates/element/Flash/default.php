<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 */
$class = 'message';
if (!empty($params['class'])) {
	$class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}

?>
<div class="<?= h($class) ?>"><?= $message; ?></div>
