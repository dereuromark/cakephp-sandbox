<?php
/**
 * @var \App\View\AppView $this
 */
$description = 'CakePHP Sandbox App';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo h($description); ?>:
		<?php echo $this->fetch('title'); ?>
	</title>

<?php
echo $this->Html->meta('icon');
echo $this->fetch('meta');
if (PHP_SAPI !== 'cli') {
	echo $this->AssetCompress->css('css-combined');
}
echo $this->fetch('css');
?>
</head>
<body>

	<?php echo $this->element('navigation'); ?>

	<main class="container">

		<?php echo $this->Flash->render(); ?>

		<div class="row">
			<div class="col-12">
			<?php
				$content = $this->fetch('content');
				if (preg_match('#^\s*<nav #', $content)) {
					$content = '<div class="row">' . $content . '</div>';
				}
				echo $content;
			?>
			</div>
		</div>

		<hr>

		<footer class="d-flex flex-wrap justify-content-between align-items-center py-2">
			<div>
				Author: dereuromark and <a href="https://github.com/dereuromark/cakephp-sandbox/graphs/contributors">contributors</a> |
				Code: <a href="https://github.com/dereuromark/cakephp-sandbox">github.com/dereuromark/cakephp-sandbox</a> |
				<?php echo $this->Html->linkReset('Contact', ['controller' => 'Contact', 'action' => 'index']); ?>
			</div>
			<div class="text-muted">Running on CakePHP <?php echo $this->Configure->version(); ?> / <?php echo function_exists('frankenphp_handle_request') ? 'FrankenPHP' : 'PHP'; ?> <?php echo substr(phpversion(), 0, 3); ?><?php
			// Check for worker mode marker file
			$workerMarkerFile = sys_get_temp_dir() . '/frankenphp_worker_' . getmypid();
			if (file_exists($workerMarkerFile)) {
				echo ' <span class="fa-solid fa-bolt text-warning" title="Worker Mode: PHP stays in memory for faster responses" style="cursor: help;"></span>';
			}
			?></div>
		</footer>

	</main>

<?php if (!$this->Configure->read('debug')) {
	echo $this->element('stats');
} ?>

<?php echo $this->element('Feedback.sidebar');?>

<?php
if (PHP_SAPI !== 'cli') {
	echo $this->AssetCompress->script('js-combined');
}
?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('postLink') ?>
</body>
</html>
