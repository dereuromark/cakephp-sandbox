<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/templating'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Icons</h2>

	<p>Tip: Use <a href="https://github.com/dereuromark/cakephp-ide-helper" target="_blank">IdeHelper plugin</a> to get autocomplete for all icons</p>

	<h3>FontAwesome (v4)</h3>
	Configure the icon set to be used in your `app.php`:
	<pre><?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'fa' => \Templating\View\Helper\Icon\FontAwesome4Icon::class,
		],
	],
TEXT;
		echo $this->Format->pre($text);
		?>
	</pre>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('camera-retro'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icons', ['action' => 'iconSets', 'fa4']); ?>
		</p>
	</div>

	<p>
		<?php
		echo $this->Icon->render('camera-retro');
		?>
	</p>

	<p>FontAwesome also has quite powerful options for icons:</p>
	<p>
	<?php
	echo $this->Icon->render('motorcycle', ['rotate' => 90]) . ' (rotated 90 degrees)';
	echo '<br>';
	echo $this->Icon->render('anchor', ['spin' => true]) . ' (spinning)';
	?>
	</p>

	<h3>Boostrap</h3>
	Configure the icon set to be used in your `app.php`:
	<pre><?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'bs' => \Templating\View\Helper\Icon\BootstrapIcon::class,
		],
	],
TEXT;
		echo $this->Format->pre($text);
		?>
	</pre>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('info-circle-fill'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icons', ['action' => 'iconSets', 'bs']); ?>
		</p>
	</div>

	<p>
		<?php
		echo $this->Icon->render('bs:info-circle-fill');
		?>
	</p>


	<h3>Material</h3>

	Configure the icon set to be used in your `app.php`:
	<pre><?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'material' => \Templating\View\Helper\Icon\MaterialIcon::class,
		],
	],
TEXT;
		echo $this->Format->pre($text);
		?>
	</pre>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('search'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icons', ['action' => 'iconSets', 'material']); ?>
		</p>
	</div>

	<p>
		<?php
		echo $this->Icon->render('material:search');
		?>
	</p>

	<link rel="stylesheet" href="/assets/material-symbols/outlined.css"/>


	<h3>Feather</h3>
	<p>Note: This requires a JS snippet for the icons to get transformed.</p>

	Configure the icon set to be used in your `app.php`:
	<pre><?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'feather' => \Templating\View\Helper\Icon\FeatherIcon::class,
		],
	],
TEXT;
		echo $this->Format->pre($text);
		?>
	</pre>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('activity'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icons', ['action' => 'iconSets', 'feather']); ?>
		</p>
	</div>

	<p>
		<?php
		echo $this->Icon->render('feather:activity');
		?>
	</p>

	<script src="/assets/feather-icons/dist/feather.js"></script>
	<script>
		feather.replace();
	</script>

	JS snippet:
	<pre><?php
		$text = <<<TEXT
<script>
	feather.replace();
</script>
TEXT;
		echo $this->Format->pre($text);
		?>
	</pre>

</div>
