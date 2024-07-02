<?php
/**
 * @var \App\View\AppView $this
 */
$description = 'CakePHP Sandbox App';
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
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

	<?php
	echo $this->element('navigation');
	?>

	<div class="container">

		<div id="header">
		</div>
		<div id="content">

				<?php

	echo $this->Flash->render();
	?>

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

		</div>

			<hr />

		<div id="footer" class="">

			<div style="float: right;">Running on CakePHP <?php echo $this->Configure->version(); ?> / PHP <?php echo substr(phpversion(), 0, 3);?></div>

				Author: dereuromark and <a href="https://github.com/dereuromark/cakephp-sandbox/graphs/contributors">contributors</a> | Code: <a href="https://github.com/dereuromark/cakephp-sandbox">github.com/dereuromark/cakephp-sandbox</a> | <?php
	echo $this->Html->linkReset('Contact', ['controller' => 'Contact', 'action' => 'index']);
	?>
		</div>
	</div>

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
