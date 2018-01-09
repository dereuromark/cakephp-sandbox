<?php
/**
 * @var \App\View\AppView $this
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}
?>
<div class="alert alert-danger"><?= $message ?></div>
